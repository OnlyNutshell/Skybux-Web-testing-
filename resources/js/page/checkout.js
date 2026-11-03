
// import QRCode from 'qrcode';
// import { convertQRIS } from './qris-core/index.ts';

// // Masukkan payload QRIS asli yang sudah lu ekstrak.
// // Jangan memakai teks yang hanya disalin dari gambar tanpa validasi.
// const staticQris = '00020101021126610016ID.CO.SHOPEE.WWW01189360091800236871100208236871100303UMI51440014ID.CO.QRIS.WWW0215ID10265956808140303UMI5204594753033605802ID5909SKY ROBUX6005DEPOK61051645562070703A01630462DB';

// const button = document.getElementById('generate');
// const amountInput = document.getElementById('amount');
// const result = document.getElementById('result');
// const error = document.getElementById('error');

// button.addEventListener('click', async () => {
//     error.textContent = '';

//     try {
//         const amount = Number(amountInput.value);

//         if (!Number.isSafeInteger(amount) || amount < 1000) {
//             throw new Error('Nominal tidak valid.');
//         }

//         const dynamicQris = convertQRIS(staticQris, { amount });

//         // Periksa bentuk nilai kembalian pada converter yang disalin.
//         // README mendeskripsikan hasilnya sebagai payload QRIS.
//         if (typeof dynamicQris !== 'string') {
//             throw new Error(
//                 'Periksa bentuk return convertQRIS() pada modul.'
//             );
//         }

//         await QRCode.toCanvas(
//             document.getElementById('qr'),
//             dynamicQris,
//             { width: 240, margin: 2 }
//         );

//         document.getElementById('total').textContent =
//             `Rp${amount.toLocaleString('id-ID')}`;

//         result.classList.remove('hidden');
//     } catch (e) {
//         error.textContent = e.message || 'Gagal membuat QR.';
//         result.classList.add('hidden');
//     }
// });
