import { createIcons, icons } from 'lucide';

const proofForm = document.getElementById('proofForm');
const uploadButton = document.getElementById('uploadProofButton');

if (proofForm && uploadButton) {
    proofForm.addEventListener('submit', function (e) {

        if (uploadButton.disabled) {
            e.preventDefault();
            return;
        }

        console.log('kontol')

        uploadButton.disabled = true;

        uploadButton.innerHTML = `
            <i data-lucide="loader-circle" class="size-4 animate-spin"></i>
            <span>Mengupload Bukti...</span>
        `;

        createIcons({ icons });

    });
}