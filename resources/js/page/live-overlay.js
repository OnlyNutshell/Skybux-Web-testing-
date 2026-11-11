import { supabase } from '../supabase-test';

const card = document.getElementById('alert-card');

if (!card) {
    console.error('Alert card tidak ditemukan!');
} else {
    const title = document.getElementById('alert-title');
    const username = document.getElementById('alert-username');
    const amount = document.getElementById('alert-amount');
    const description = document.getElementById('alert-description');

    let hideTimer;
    let audioEnabled = false;
    let audioContext;

    document.addEventListener('click', async () => {
        if (audioEnabled) return;

        try {
            audioContext = new (
                window.AudioContext || window.webkitAudioContext
            )();

            await audioContext.resume();
            audioEnabled = true;
        } catch (error) {
            console.error('Audio error:', error);
        }
    }, { once: true });

    function playSound() {
        if (!audioEnabled || !audioContext) return;

        const oscillator = audioContext.createOscillator();
        const gain = audioContext.createGain();

        oscillator.connect(gain);
        gain.connect(audioContext.destination);

        oscillator.frequency.value = 880;
        oscillator.type = 'sine';

        gain.gain.setValueAtTime(0.15, audioContext.currentTime);
        gain.gain.exponentialRampToValueAtTime(
            0.001,
            audioContext.currentTime + 0.35
        );

        oscillator.start();
        oscillator.stop(audioContext.currentTime + 0.35);
    }

    function showAlert(data) {
        clearTimeout(hideTimer);

        const done = data.type === 'done';

        if (title) {
            title.textContent = done
                ? 'ROBUX DIKIRIM !'
                : 'ORDER BARU !';
        }

        if (username) {
            username.textContent = `${data.username || '-'}`;
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

        playSound();

        hideTimer = setTimeout(() => {
            card.classList.remove('opacity-100', 'translate-y-0');
            card.classList.add('opacity-0', '-translate-y-8');
        }, 3500);
    }

    // TEST MANUAL
    window.testSkybuxAlert = function(type = 'order') {
        showAlert({
            type,
            username: 'Player123',
            amount: 100
        });
    };

    // REALTIME SUPABASE
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

    window.addEventListener('beforeunload', () => {
        supabase.removeChannel(channel);
    });
}