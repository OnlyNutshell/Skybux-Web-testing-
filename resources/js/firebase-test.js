import { ref, onValue } from 'firebase/database';
import { database } from './firebase';

const stockRef = ref(database, 'stock');
const totalStock = document.getElementById('stock')

onValue(stockRef, (snapshot) => {
    const stock = snapshot.val();

    totalStock.textContent = stock['robux']
    console.log('Firebase Stock:', stock);
});