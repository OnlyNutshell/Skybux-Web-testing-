
import { createIcons, icons } from 'lucide';

const form = document.getElementById('checkoutForm');
const modal = document.getElementById('checkoutModal');

const checkoutButton = document.getElementById('checkoutButton');
const agreeButton = document.getElementById('agreeButton');

const closeModal = document.getElementById('closeModal');
const cancelModal = document.getElementById('cancelModal');

const qrisAccordion = document.getElementById('qrisAccordion');
const qrisRadio = document.getElementById('qrisRadio');

const ageAgreement = document.getElementById('ageAgreement');
const ruleAgreement = document.getElementById('ruleAgreement');
const agreementError = document.getElementById('agreementError');

const whatsappInput = document.getElementById('whatsapp');
const whatsappError = document.getElementById('whatsappError');

const paymentRadios = document.querySelectorAll(
    'input[name="payment_method"]'
);

const whatsappIcon = document.getElementById('whatsappIcon');
const tiktokInput = document.getElementById('tiktok');

let approved = false;
let whatsappTouched = false;


// ==========================================
// VALIDASI WHATSAPP
// ==========================================

function validateWhatsapp() {
    const value = whatsappInput.value;

    let error = '';

    if (value.length === 0) {
        error = 'Nomor WhatsApp wajib diisi.';
    } else if (!value.startsWith('08')) {
        error = 'Nomor WhatsApp harus diawali 08.';
    } else if (value.length < 10) {
        error = 'Nomor WhatsApp minimal 10 digit.';
    } else if (value.length > 15) {
        error = 'Nomor WhatsApp maksimal 15 digit.';
    }

    const isValid = error === '';
    const showError = whatsappTouched && !isValid;

    // Ikon WhatsApp
    if (isValid && whatsappTouched) {
        whatsappIcon.innerHTML = `
            <i data-lucide="check-circle-2"
            class="size-5 text-emerald-500"></i>
        `;
        whatsappIcon.classList.remove('hidden');
    } else if (showError) {
        whatsappIcon.innerHTML = `
            <i data-lucide="alert-circle"
            class="size-5 text-red-500"></i>
        `;
        whatsappIcon.classList.remove('hidden');
    } else {
        whatsappIcon.innerHTML = '';
        whatsappIcon.classList.add('hidden');
    }

    createIcons({ icons });

    whatsappInput.classList.toggle('border-red-500', showError);
    whatsappInput.classList.toggle('focus:border-red-500', showError);
    whatsappInput.classList.toggle('focus:ring-red-500/20', showError);

    whatsappInput.classList.toggle('border-slate-300', !showError);
    whatsappInput.classList.toggle('focus:border-sky-500', !showError);
    whatsappInput.classList.toggle('focus:ring-sky-500/20', !showError);

    whatsappError.textContent = showError ? error : '';
    whatsappError.classList.toggle('hidden', !showError);

    updateCheckoutButton();

    return isValid;
}


// ==========================================
// VALIDASI METODE PEMBAYARAN
// ==========================================

function validatePayment() {
    return [...paymentRadios].some(radio => radio.checked);
}


// ==========================================
// STATUS TOMBOL CHECKOUT
// ==========================================

function updateCheckoutButton() {
    const whatsappValid = /^08[0-9]{8,13}$/.test(
        whatsappInput.value
    );

    const paymentValid = validatePayment();

    const canCheckout = whatsappValid && paymentValid;

    checkoutButton.disabled = !canCheckout;

    checkoutButton.classList.toggle('opacity-50', !canCheckout);
    checkoutButton.classList.toggle('cursor-not-allowed', !canCheckout);
}


// ==========================================
// EVENT WHATSAPP
// ==========================================

whatsappInput.addEventListener('input', function () {
    whatsappTouched = true;

    this.value = this.value.replace(/\D/g, '').slice(0, 15);

    validateWhatsapp();
});

whatsappInput.addEventListener('blur', function () {
    if (this.value.length > 0) {
        whatsappTouched = true;
        validateWhatsapp();
    }
});


// ==========================================
// EVENT RADIO PEMBAYARAN
// ==========================================

paymentRadios.forEach(radio => {
    radio.addEventListener('change', function () {
        updateCheckoutButton();
    });
});


// ==========================================
// KONDISI AWAL
// ==========================================

checkoutButton.disabled = true;
checkoutButton.classList.add('opacity-50', 'cursor-not-allowed');


// ==========================================
// VALIDASI SELURUH FORM
// ==========================================

function validateCheckout() {
    const requiredFields = form.querySelectorAll(
        'input[required], select[required], textarea[required]'
    );

    const invalidFields = [...requiredFields].filter(
        field => !field.checkValidity()
    );

    const whatsappValid = validateWhatsapp();
    const paymentValid = validatePayment();

    if (!whatsappValid) {
        whatsappTouched = true;
        validateWhatsapp();
    }

    if (invalidFields.length === 0 && whatsappValid && paymentValid) {
        return true;
    }

    invalidFields.forEach(field => {
        const accordion = field.closest('details');

        if (accordion) {
            accordion.open = true;
        }

        field.classList.add('border-red-500');
    });

    let firstInvalid;

    if (!whatsappValid) {
        firstInvalid = whatsappInput;
    } else if (!paymentValid) {
        firstInvalid = paymentRadios[0];
    } else {
        firstInvalid = invalidFields[0];
    }

    if (!firstInvalid) return false;

    const accordion = firstInvalid.closest('details');

    if (accordion) {
        accordion.open = true;
    }

    requestAnimationFrame(() => {
        firstInvalid.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

        firstInvalid.focus();

        if (
            firstInvalid !== whatsappInput &&
            !paymentRadios.includes(firstInvalid)
        ) {
            firstInvalid.reportValidity();
        }
    });

    return false;
}


// ==========================================
// BUKA MODAL
// ==========================================

function openModal() {
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.body.classList.add('overflow-hidden');
}


// ==========================================
// TUTUP MODAL
// ==========================================

function hideModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');

    document.body.classList.remove('overflow-hidden');
}

closeModal.addEventListener('click', hideModal);
cancelModal.addEventListener('click', hideModal);


// ==========================================
// TOMBOL CHECKOUT
// ==========================================

checkoutButton.addEventListener('click', function () {
    if (!validateCheckout()) {
        return;
    }

    openModal();
});


// ==========================================
// PERSETUJUAN CHECKBOX
// ==========================================

agreeButton.addEventListener('click', function () {
    if (agreeButton.disabled) return;

    const unchecked = [ageAgreement, ruleAgreement].filter(
        checkbox => !checkbox.checked
    );

    if (unchecked.length > 0) {
        agreementError.classList.remove('hidden');

        const firstUnchecked = unchecked[0];
        const label = firstUnchecked.closest('label');

        label.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

        label.classList.remove('shake');
        void label.offsetWidth;
        label.classList.add('shake');

        return;
    }

    agreementError.classList.add('hidden');

    if (!validateCheckout()) {
        hideModal();
        return;
    }

    agreeButton.disabled = true;

    agreeButton.innerHTML = `
        <i data-lucide="loader-circle" class="size-4"></i>
        <span>Memproses Pesanan...</span>
    `;

    createIcons({ icons });

    approved = true;
    form.requestSubmit();
});


// ==========================================
// CEGAH SUBMIT TANPA PERSETUJUAN
// ==========================================

form.addEventListener('submit', function (e) {
    if (approved) {
        return;
    }

    e.preventDefault();

    if (validateCheckout()) {
        openModal();
    }
});


// ==========================================
// EVENT CHECKBOX AGREEMENT
// ==========================================

[ageAgreement, ruleAgreement].forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        if (ageAgreement.checked && ruleAgreement.checked) {
            agreementError.classList.add('hidden');
        }
    });
});
