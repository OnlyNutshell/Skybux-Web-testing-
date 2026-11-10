import { supabase } from './supabase-test';

const adminOrders = document.getElementById('admin-orders');

const status = document.getElementById('liveOrderStatus');
const indicator = document.getElementById('liveOrderIndicator');
const statusText = document.getElementById('liveOrderText');

if (adminOrders && status && indicator && statusText) {

    let isReloading = false;

    function setStatus(type, text) {
        const styles = {
            live: 'bg-emerald-50 text-emerald-700',
            syncing: 'bg-sky-50 text-sky-700',
            connecting: 'bg-amber-50 text-amber-700',
            offline: 'bg-red-50 text-red-700',
        };

        status.className =
            `inline-flex items-center w-fit gap-2 rounded-lg px-3 py-1.5 text-xs font-semibold ${styles[type]} self-end md:self-auto`;

        indicator.className = 'size-2 rounded-full bg-current';

        if (type === 'syncing' || type === 'connecting') {
            indicator.classList.add('animate-pulse');
        }

        statusText.textContent = text;
    }

    const channel = supabase
        .channel('admin-orders')
        .on(
            'postgres_changes',
            {
                event: '*',
                schema: 'laravel_test',
                table: 'orders',
            },
            () => {
                if (isReloading) return;

                isReloading = true;

                setStatus('syncing', 'Memperbarui pesanan...');

                window.location.reload();
            }
        )
        .subscribe((status, error) => {

            if (status === 'SUBSCRIBED') {
                setStatus('live', 'Live Orders');
            }

            else if (
                status === 'CHANNEL_ERROR' ||
                status === 'TIMED_OUT' ||
                status === 'CLOSED'
            ) {
                setStatus('offline', 'Koneksi terputus');
            }

        });
}