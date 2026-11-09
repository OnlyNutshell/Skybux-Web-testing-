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

    let approved = false;


    // Validasi seluruh required form
    function validateCheckout() {
    const requiredFields = form.querySelectorAll(
        'input[required], select[required], textarea[required]'
    );

    const invalidFields = [...requiredFields].filter(
        field => !field.checkValidity()
    );

    if (invalidFields.length === 0) {
        return true;
    }

    // Buka semua accordion yang memiliki input invalid
    invalidFields.forEach(field => {
        const accordion = field.closest('details');

        if (accordion) {
            accordion.open = true;
        }

        // Tandai input yang belum valid
        field.classList.add('border-red-500');
    });

    // Fokus ke input invalid pertama
    const firstInvalid = invalidFields[0];

    requestAnimationFrame(() => {
        firstInvalid.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

        firstInvalid.reportValidity();
    });

    return false;
}


    // Buka modal
    function openModal() {

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');
    }


    // Tutup modal
    function hideModal() {

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');
    }


    // Tombol checkout
    checkoutButton.addEventListener('click', function () {

        // 1. Validasi dahulu
        if (!validateCheckout()) {
            return;
        }

        // 2. Kalau valid, baru tampilkan popup
        openModal();

    });


    // Tutup popup
    closeModal.addEventListener('click', hideModal);
    cancelModal.addEventListener('click', hideModal);


    // Persetujuan
    agreeButton.addEventListener('click', function () {

    if (agreeButton.disabled) return;

    // Cari checkbox yang belum dicentang
    const unchecked = [ageAgreement, ruleAgreement].filter(
        checkbox => !checkbox.checked
    );

    if (unchecked.length > 0) {
        agreementError.classList.remove('hidden');

        // Prioritaskan checkbox pertama yang belum dicentang
        const firstUnchecked = unchecked[0];
        const label = firstUnchecked.closest('label');

        label.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

        // Trigger ulang animasi shake
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


    // Cegah form dikirim tanpa melewati popup
    form.addEventListener('submit', function (e) {

        if (approved) {
            return;
        }

        e.preventDefault();

        if (validateCheckout()) {
            openModal();
        }

    });


    // Hilangkan pesan error saat checkbox dicentang
    [ageAgreement, ruleAgreement].forEach(checkbox => {

        checkbox.addEventListener('change', function () {

            if (ageAgreement.checked && ruleAgreement.checked) {
                agreementError.classList.add('hidden');
            }

        });

    });
