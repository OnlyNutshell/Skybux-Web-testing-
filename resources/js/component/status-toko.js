// const storeClosedNotice = document.getElementById('storeClosedNotice');
// const storeStatusText = document.getElementById('storeStatusText');
// const checkoutButton = document.getElementById('checkout');

// const purchaseSection = document.getElementById('purchaseSection');

// function setStoreStatus(isOpen) {
//     if (!storeClosedNotice || !checkoutButton) return;

//     storeClosedNotice.classList.toggle('hidden', isOpen);

//     checkoutButton.disabled = !isOpen;

//     if (isOpen) {
//         checkoutButton.textContent = 'Checkout';
//         checkoutButton.classList.remove('opacity-50', 'cursor-not-allowed');
//         checkoutButton.classList.add('cursor-pointer');
//     } else {
//         checkoutButton.textContent = 'Toko Sedang Tutup';
//         checkoutButton.classList.add('opacity-50', 'cursor-not-allowed');
//         checkoutButton.classList.remove('cursor-pointer');
//     }

//     if (storeStatusText) {
//         storeStatusText.textContent = isOpen ? 'TOKO BUKA' : 'TOKO TUTUP';
//     }
// }

// // Sementara untuk preview frontend:
// setStoreStatus(false);