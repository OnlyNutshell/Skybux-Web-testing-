const rupiahInput = document.getElementById('rupiah');
const robuxInput = document.getElementById('robux');

const totalRobux = document.getElementById('total-robux');
const totalHarga = document.getElementById('total-harga');

export function updateSelectedItem() {
    const robux = Number(robuxInput.value) || 0;

    const price = Number(
        rupiahInput.value.replace(/\D/g, '')
    ) || 0;

    totalRobux.textContent = robux;
    totalHarga.textContent = price.toLocaleString('id-ID');
}