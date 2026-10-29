
const RATE = 170;
const ROBUX_STEP = 5;

const rupiahInput = document.getElementById('rupiah');
const robuxInput = document.getElementById('robux');

if (rupiahInput && robuxInput) {
    // Rupiah -> Robux
    rupiahInput.addEventListener('input', () => {
        if (rupiahInput.value === '') {
            robuxInput.value = '';
            return;
        }

        const rupiah = Number(rupiahInput.value);

        if (!Number.isFinite(rupiah) || rupiah < 0) {
            robuxInput.value = '';
            return;
        }

        const robux = Math.floor(
            rupiah / (RATE * ROBUX_STEP)
        ) * ROBUX_STEP;

        robuxInput.value = robux;
    });

    // Sesuaikan Rupiah setelah selesai mengetik
    rupiahInput.addEventListener('blur', () => {
        if (rupiahInput.value === '' || robuxInput.value === '') {
            return;
        }

        rupiahInput.value = Number(robuxInput.value) * RATE;
    });

    // Robux -> Rupiah saat mengetik
    robuxInput.addEventListener('input', () => {
        if (robuxInput.value === '') {
            rupiahInput.value = '';
            return;
        }

        const robux = Number(robuxInput.value);

        if (!Number.isFinite(robux) || robux < 0) {
            rupiahInput.value = '';
            return;
        }

        // Hitung sementara tanpa mengubah input Robux
        const roundedRobux =
            Math.floor(robux / ROBUX_STEP) * ROBUX_STEP;

        rupiahInput.value = roundedRobux * RATE;
    });

    // Bulatkan Robux setelah selesai mengetik
    robuxInput.addEventListener('blur', () => {
        if (robuxInput.value === '') {
            rupiahInput.value = '';
            return;
        }

        const robux = Number(robuxInput.value);

        if (!Number.isFinite(robux) || robux < 0) {
            robuxInput.value = '';
            rupiahInput.value = '';
            return;
        }

        const roundedRobux =
            Math.floor(robux / ROBUX_STEP) * ROBUX_STEP;

        robuxInput.value = roundedRobux;
        rupiahInput.value = roundedRobux * RATE;
    });
}
