import { verifiedAccount } from '../component/validate-account.js';

const checkoutButton = document.getElementById('checkout');
const robuxInput = document.getElementById('robux');

const csrfToken = document.querySelector(
    'meta[name="csrf-token"]'
).content;

checkoutButton.addEventListener('click', async () => {
    if (!verifiedAccount) {
        alert('Silakan cari dan verifikasi akun Roblox terlebih dahulu.');
        return;
    }

    console.log(robuxInput)
    console.log(verifiedAccount)

    const robux = Number(
        robuxInput.value.replace(/\D/g, '')
    );

    if (!Number.isInteger(robux) || robux < 5 || robux % 5 !== 0) {
        alert('Jumlah Robux tidak valid.');
        return;
    }

    checkoutButton.disabled = true;
    checkoutButton.textContent = 'Memproses...';

    try {
        const response = await fetch('/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                username: verifiedAccount.username,
                robux: robux,
            }),
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Checkout gagal.');
        }

        console.log(data.redirect)

        window.location.href = data.redirect;

    } catch (error) {
        alert(error.message || 'Terjadi kesalahan.');

        checkoutButton.disabled = false;
        checkoutButton.textContent = 'Checkout';
    }
});
