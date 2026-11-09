import { supabase } from './supabase-test';

const stockElement = document.getElementById('stock');

if (stockElement) {
    async function loadStock() {
        const { data, error } = await supabase
            .from('stocks')
            .select('total')
            .eq('product', 'robux')
            .single();

        if (error) {
            console.error('Supabase Error:', error);
            stockElement.textContent = 'Gagal memuat';
            return;
        }

        stockElement.textContent =
            "Stock Tersedia";
    }

    // Ambil stok pertama kali
    loadStock();

    // Dengarkan perubahan stok
    supabase
        .channel('stock-realtime')
        .on(
            'postgres_changes',
            {
                event: '*',
                schema: 'laravel_test',
                // schema: 'laravel',
                table: 'stocks',
                filter: 'product=eq.robux',
            },
            (payload) => {
                if (payload.new?.total !== undefined) {
                    stockElement.textContent =
                        "Stock Tersedia";
                }
            }
        )
        .subscribe((status) => {
            console.log('Stock Realtime:', status);
        });
}
