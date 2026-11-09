import { supabase } from './supabase-test';

const adminOrders = document.getElementById('admin-orders');

if (adminOrders) {
    supabase
        .channel('admin-orders')
        .on(
            'postgres_changes',
            {
                event: '*',
                // schema: 'laravel',
                schema: 'laravel_test',
                table: 'orders',
            },
            () => {
                window.location.reload();
            }
        )
        .subscribe();
}