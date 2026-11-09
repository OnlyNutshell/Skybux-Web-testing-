
import QRCode from 'qrcode';
import { convertQRIS } from '../qris-core/index.ts';
import '../component/preview-img.js'
import '../component/timer.js'
import '../component/loading-payment-proff.js'

// Payload QRIS statis milik Skybux
const staticQris = '00020101021126610016ID.CO.SHOPEE.WWW01189360091800236871100208236871100303UMI51440014ID.CO.QRIS.WWW0215ID10265956808140303UMI5204594753033605802ID5909SKY ROBUX6005DEPOK61051645562070703A01630462DB';

const paymentData = document.getElementById('payment-data');
const canvas = document.getElementById('qr');
const error = document.getElementById('qr-error');
const downloadButton = document.getElementById('download-qr');

async function generatePaymentQR() {
    if (!paymentData || !canvas) return;
    
    try {
        // Ambil nominal dari data order Supabase yang dikirim Laravel
        const amount = Number(paymentData.dataset.amount);

        if (!Number.isSafeInteger(amount) || amount < 1000) {
            throw new Error('Nominal pembayaran tidak valid.');
        }
        
        // Ubah QRIS statis menjadi QRIS dinamis
        const dynamicQris = convertQRIS(staticQris, { amount });
        
        console.log('Amount:', amount);
        console.log('Static QRIS:', staticQris);
        console.log('Dynamic QRIS:', dynamicQris);
        
        if (typeof dynamicQris !== 'string') {
            throw new Error('Format QRIS tidak valid.');
        }

        // Tampilkan QR secara otomatis
        await QRCode.toCanvas(canvas, dynamicQris, {
            width: 240,
            margin: 2,
        });

    } catch (e) {
        console.error('QRIS Error:', e);

        if (error) {
            error.textContent = e.message || 'Gagal membuat QRIS.';
            error.classList.remove('hidden');
        }
    }
}

// Tombol download QR
downloadButton?.addEventListener('click', () => {
    if (!canvas) return;

    const link = document.createElement('a');
    link.download = 'qris-payment.png';
    link.href = canvas.toDataURL('image/png');
    link.click();
});

// Jalankan otomatis saat halaman pembayaran dibuka
generatePaymentQR();
