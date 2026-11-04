
import { updateSelectedItem } from './checkout-sruk.js';

const rupiahInput = document.getElementById('rupiah');
const robuxInput = document.getElementById('robux');
const cards = document.querySelectorAll('[data-card]');

let selectedItem = {
    robux: null,
    price: null
};

function parseRupiah(value) {
    return Number(value.replace(/\D/g, ''));
}

// Mengatur tampilan dan state card saja
function setSelectedCard(card) {
    cards.forEach(item => {
        item.classList.remove('bg-sky-600');
        item.classList.add('bg-white', 'border-black');
    });

    if (!card) {
        selectedItem = {
            robux: null,
            price: null
        };
        return;
    }

    selectedItem = {
        robux: Number(card.dataset.robux),
        price: Number(card.dataset.price)
    };

    card.classList.add('bg-sky-600');
    card.classList.remove('bg-white', 'border-black');
}

// Dipanggil ketika user mengklik card
export function selectCard(card) {
    if (!card) {
        setSelectedCard(null);
        updateSelectedItem();
        return;
    }

    const robux = Number(card.dataset.robux);
    const price = Number(card.dataset.price);

    rupiahInput.value = price.toLocaleString('id-ID');
    robuxInput.value = robux;

    setSelectedCard(card);
    updateSelectedItem();
}

// Dipanggil oleh rate-converter
// Tidak mengubah input!
export function syncSelectedCard() {
    if (!robuxInput.value || !rupiahInput.value) {
        setSelectedCard(null);
        return;
    }

    const robux = Number(robuxInput.value);
    const price = parseRupiah(rupiahInput.value);

    const card = [...cards].find(item =>
        Number(item.dataset.robux) === robux &&
        Number(item.dataset.price) === price
    );

    setSelectedCard(card || null);
}

// Event klik card
cards.forEach(card => {
    card.addEventListener('click', () => {
        selectCard(card);
    });
});

export function getSelectedItem() {
    return selectedItem;
}
