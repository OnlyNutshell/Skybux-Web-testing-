
import { updateSelectedItem } from './checkout-sruk.js';
import { syncSelectedCard } from './selected-robux.js';

const RATE = 160;
const ROBUX_STEP = 5;
const DEBOUNCE_DELAY = 1000;
const ANIMATION_DELAY = 200;
const MIN_ROBUX = 10;

const rupiahInput = document.getElementById('rupiah');
const robuxInput = document.getElementById('robux');

let rupiahDebounce = null;
let robuxDebounce = null;

const animationTimers = new WeakMap();

export function formatRupiah(value) {
    return Number(value).toLocaleString('id-ID');
}

function parseNumber(value) {
    return Number(value.replace(/\D/g, '')) || 0;
}

// Format Rupiah tanpa mengganggu posisi cursor
function formatRupiahLive(input) {
    const cursor = input.selectionStart ?? input.value.length;

    const digitsBeforeCursor = input.value
        .slice(0, cursor)
        .replace(/\D/g, '').length;

    const rawValue = input.value.replace(/\D/g, '');

    const formatted = rawValue
        ? Number(rawValue).toLocaleString('id-ID')
        : '';

    input.value = formatted;

    let newCursor = 0;
    let digitCount = 0;

    while (
        newCursor < formatted.length &&
        digitCount < digitsBeforeCursor
    ) {
        if (/\d/.test(formatted[newCursor])) {
            digitCount++;
        }

        newCursor++;
    }

    input.setSelectionRange(newCursor, newCursor);
}

function refresh() {
    updateSelectedItem();
    syncSelectedCard();
}

// Animasi input hasil konversi
function animateValue(input, callback) {
    clearTimeout(animationTimers.get(input));

    input.classList.add('is-hidden');

    const timer = setTimeout(() => {
        // Ubah nilai setelah fade-out selesai
        callback();

        // Munculkan kembali setelah browser memproses perubahan
        requestAnimationFrame(() => {
            input.classList.remove('is-hidden');
        });

        animationTimers.delete(input);
    }, ANIMATION_DELAY);

    animationTimers.set(input, timer);
}

// RUPIAH -> ROBUX
function convertRupiah() {
    const rupiah = parseNumber(rupiahInput.value);

    const robux = Math.floor(
        rupiah / (RATE * ROBUX_STEP)
    ) * ROBUX_STEP;

    const finalRobux = Math.max(robux, MIN_ROBUX);

    rupiahInput.value = formatRupiah(finalRobux * RATE);
    robuxInput.value = finalRobux;

    refresh();
}

// ROBUX -> RUPIAH
function convertRobux() {
    const robux = parseNumber(robuxInput.value);

    const roundedRobux = Math.floor(
        robux / ROBUX_STEP
    ) * ROBUX_STEP;

    const finalRobux = Math.max(roundedRobux, MIN_ROBUX);

    robuxInput.value = finalRobux;

    rupiahInput.value = formatRupiah(
        finalRobux * RATE
    );

    refresh();
}

if (rupiahInput && robuxInput) {

    // =========================
    // RUPIAH -> ROBUX
    // =========================

    rupiahInput.addEventListener('input', () => {
        clearTimeout(rupiahDebounce);
        clearTimeout(robuxDebounce);

        const rawValue = rupiahInput.value.replace(/\D/g, '');

        if (rawValue === '') {
            robuxInput.value = '';
            refresh();
            return;
        }

        formatRupiahLive(rupiahInput);

        refresh();

        rupiahDebounce = setTimeout(() => {
            animateValue(robuxInput, convertRupiah);
        }, DEBOUNCE_DELAY);
    });

    rupiahInput.addEventListener('blur', () => {
        clearTimeout(rupiahDebounce);

        if (rupiahInput.value === '') {
            refresh();
            return;
        }

        animateValue(robuxInput, convertRupiah);
    });


    // =========================
    // ROBUX -> RUPIAH
    // =========================

    robuxInput.addEventListener('input', () => {
        clearTimeout(rupiahDebounce);
        clearTimeout(robuxDebounce);

        const rawValue = robuxInput.value.replace(/\D/g, '');

        if (rawValue === '') {
            rupiahInput.value = '';
            refresh();
            return;
        }

        refresh();

        robuxDebounce = setTimeout(() => {
            animateValue(rupiahInput, convertRobux);
        }, DEBOUNCE_DELAY);
    });

    robuxInput.addEventListener('blur', () => {
        clearTimeout(robuxDebounce);

        if (robuxInput.value === '') {
            refresh();
            return;
        }

        animateValue(rupiahInput, convertRobux);
    });
}
