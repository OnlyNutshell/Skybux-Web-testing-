const rupiahInput = document.getElementById('rupiah');
const robuxInput = document.getElementById('robux');
const cards = document.querySelectorAll('[data-card]');

// Menyimpan data card yang sedang terpilih
let selectedItem = {
    robux: null,
    price: null
};


// Fungsi memilih card
export function selectCard(card) {

    cards.forEach(item => {
        item.classList.remove(
            'bg-sky-600'
        );
        item.classList.add(
            'bg-white',
            'border-black'
        );
    });

    if (!card) {
        selectedItem = {
            robux: null,
            price: null
        };

        return;
    }

    const robux = Number(card.dataset.robux);
    const price = Number(card.dataset.price);

    robuxInput.value = robux;
    rupiahInput.value = price;

    selectedItem = {
        robux: robux,
        price: price
    };

    card.classList.add(
        'bg-sky-600'
    );

    card.classList.remove(
        'bg-white',
        'border-black'
    );
}


// Fungsi mencari card berdasarkan input
export function findCard(type, value) {

    const card = [...cards].find(item => {
        return Number(item.dataset[type]) === Number(value);
    });

    selectCard(card || null);
}


// Event input Robux
robuxInput.addEventListener('input', function () {

    if (this.value === '') {
        selectCard(null);
        return;
    }

    findCard('robux', this.value);
});

rupiahInput.addEventListener('input', function () {

    if (this.value === '') {
        selectCard(null);
        return;
    }

    findCard('price', this.value);
});


cards.forEach(card => {

    card.addEventListener('click', function () {
        selectCard(this);
    });

});

function getSelectedItem() {
    return selectedItem;
}

document.getElementById('checkout').addEventListener('click', () => {

    const item = getSelectedItem();

    if (!item.robux) {
        alert('Pilih Robux terlebih dahulu!');
        return;
    }

    console.log('Robux:', item.robux);
    console.log('Harga:', item.price);

});