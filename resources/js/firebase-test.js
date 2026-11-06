import { doc, onSnapshot } from 'firebase/firestore';
import { db } from './firebase';

const stockElement = document.getElementById('stock');

const stockRef = doc(db, 'Stock', 'robux');

onSnapshot(stockRef, (snapshot) => {
    if (!snapshot.exists()) {
        stockElement.textContent = 'Tidak tersedia';
        return;
    }

    const stock = snapshot.data();

    stockElement.textContent =
        stock.total.toLocaleString('id-ID');

}, (error) => {
    console.error('Firestore Error:', error);

    stockElement.textContent = 'Gagal memuat';
});