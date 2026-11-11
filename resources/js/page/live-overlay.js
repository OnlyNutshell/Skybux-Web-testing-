
import { supabase } from '../supabase-test';

// ========================================
// ELEMENTS
// ========================================

const card = document.getElementById('alert-card');

if (!card) {
    console.error('Alert card tidak ditemukan!');
} else {
    const title = document.getElementById('alert-title');
    const username = document.getElementById('alert-username');
    const amount = document.getElementById('alert-amount');
    const description = document.getElementById('alert-description');

    let hideTimer;
    let currentSource = null;

    // ========================================
    // AUDIO ENGINE
    // ========================================

    const AudioContextClass =
        window.AudioContext || window.webkitAudioContext;

    const audioContext = AudioContextClass
        ? new AudioContextClass()
        : null;

    let sounds = {
        order: null,
        done: null
    };

    async function loadSound(url) {
        try {
            const response = await fetch(url);

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            const buffer = await response.arrayBuffer();

            return await audioContext.decodeAudioData(buffer);
        } catch (error) {
            console.error(`Gagal memuat ${url}:`, error);
            return null;
        }
    }

    async function setupSounds() {
        if (!audioContext) {
            console.error('Web Audio API tidak tersedia!');
            return;
        }

        const [order, done] = await Promise.all([
            loadSound('/sound/order-masuk.mpeg'),
            loadSound('/sound/order-selesai.mpeg')
        ]);

        sounds.order = order;
        sounds.done = done;

        console.log('Skybux audio loaded:', {
            order: !!order,
            done: !!done
        });

        if (audioContext.state === 'suspended') {
            audioContext.resume().catch(error => {
                console.warn('Audio resume gagal:', error);
            });
        }
    }

    function playSound(type) {
        if (!audioContext || audioContext.state !== 'running') {
            console.warn('AudioContext belum aktif:', audioContext?.state);
            return;
        }

        const buffer = sounds[type];

        if (!buffer) {
            console.warn(`Audio ${type} belum tersedia!`);
            return;
        }

        try {
            if (currentSource) {
                currentSource.stop();
                currentSource.disconnect();
            }

            const source = audioContext.createBufferSource();

            source.buffer = buffer;
            source.connect(audioContext.destination);
            source.start(0);

            currentSource = source;

            source.onended = () => {
                if (currentSource === source) {
                    currentSource = null;
                }
                source.disconnect();
            };
        } catch (error) {
            console.error('Gagal memutar audio:', error);
        }
    }

    setupSounds();

    // ========================================
    // ALERT
    // ========================================

    function showAlert(data) {
        clearTimeout(hideTimer);

        const done = data.type === 'done';

        if (title) {
            title.textContent = done
                ? 'ROBUX DIKIRIM !'
                : 'ORDER BARU !';
        }

        if (username) {
            username.textContent = data.username || '-';
        }

        if (amount) {
            amount.textContent =
                `${Number(data.amount || 0).toLocaleString('id-ID')} Robux`;
        }

        if (description) {
            description.textContent = done
                ? 'Pesanan berhasil diselesaikan. Terima kasih!'
                : 'Pesanan masuk, mohon ditunggu yaaaaaa!';
        }

        card.classList.remove('opacity-0', '-translate-y-8');
        card.classList.add('opacity-100', 'translate-y-0');

        playSound(done ? 'done' : 'order');

        hideTimer = setTimeout(() => {
            card.classList.remove('opacity-100', 'translate-y-0');
            card.classList.add('opacity-0', '-translate-y-8');
        }, 3500);
    }

    // ========================================
    // MANUAL TEST
    // ========================================

    window.testSkybuxAlert = function(type = 'order') {
        showAlert({
            type,
            username: 'Player123',
            amount: 100
        });
    };

    // ========================================
    // SUPABASE REALTIME
    // ========================================

    const channel = supabase
        .channel('skybux-live-events')
        .on(
            'postgres_changes',
            {
                event: 'INSERT',
                schema: 'laravel_test',
                table: 'live_order_events'
            },
            (payload) => {
                console.log('LIVE EVENT:', payload);

                const event = payload.new;

                showAlert({
                    type: event.event_type === 'done' ? 'done' : 'order',
                    username: event.roblox_username,
                    amount: event.robux_amount
                });
            }
        )
        .subscribe((status, error) => {
            console.log('Skybux Live:', status);

            if (error) {
                console.error('Realtime Error:', error);
            }
        });

    // ========================================
    // CLEANUP
    // ========================================

    window.addEventListener('beforeunload', () => {
        supabase.removeChannel(channel);

        if (currentSource) {
            try {
                currentSource.stop();
            } catch {}
        }

        audioContext?.close();
    });
}
