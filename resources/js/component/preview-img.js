
const proofInput = document.getElementById('payment-proof');
const proofInfo = document.getElementById('proof-info');
const proofName = document.getElementById('proof-name');
const proofSize = document.getElementById('proof-size');

const previewButton = document.getElementById('preview-proof');
const removeButton = document.getElementById('remove-proof');

const modal = document.getElementById('proof-modal');
const previewImage = document.getElementById('proof-preview-image');
const closeModal = document.getElementById('close-proof-modal');

let previewUrl = null;

function clearProof() {
    proofInput.value = '';
    proofInfo.classList.add('hidden');

    if (previewUrl) {
        URL.revokeObjectURL(previewUrl);
        previewUrl = null;
    }

    previewImage.src = '';
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

proofInput.addEventListener('change', () => {
    const file = proofInput.files[0];

    if (!file) return;

    if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
        alert('Format file harus JPG, PNG, atau WEBP.');
        clearProof();
        return;
    }

    if (file.size > 5 * 1024 * 1024) {
        alert('Ukuran file maksimal 5 MB.');
        clearProof();
        return;
    }

    if (previewUrl) {
        URL.revokeObjectURL(previewUrl);
    }

    previewUrl = URL.createObjectURL(file);

    proofName.textContent = file.name;
    proofSize.textContent =
        (file.size / 1024 / 1024).toFixed(2) + ' MB · Siap diunggah';

    proofInfo.classList.remove('hidden');

    if (window.lucide) lucide.createIcons();
});

// Buka preview hanya ketika diklik
previewButton.addEventListener('click', () => {
    if (!previewUrl) return;

    previewImage.src = previewUrl;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
});

// Tutup modal
closeModal.addEventListener('click', () => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
});

// Klik area luar modal
modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
});

// Hapus file
removeButton.addEventListener('click', clearProof);
