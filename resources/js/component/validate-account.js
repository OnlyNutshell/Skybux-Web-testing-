const form = document.getElementById('searchForm');
const input = document.getElementById('username');
const button = document.getElementById('searchButton');
const statusBox = document.getElementById('status');
const choicesWrapper = document.getElementById('choicesWrapper');
const choices = document.getElementById('accountChoices');
const profile = document.getElementById('profile');

const configElement = document.getElementById('roblox-config');

export let verifiedAccount = null;

const robloxChecker = {
    searchUrl: configElement.dataset.searchUrl,
    userUrl: configElement.dataset.userUrl
};

        const csrfToken = document.querySelector(
            'meta[name="csrf-token"]'
        ).content;

        function showStatus(message, type = 'info') {
            statusBox.textContent = message;
            statusBox.classList.remove('hidden');

            statusBox.classList.toggle(
                'text-rose-300',
                type === 'error'
            );
        }

        function resetResults() {
            statusBox.classList.add('hidden');
            choicesWrapper.classList.add('hidden');
            profile.classList.add('hidden');
            profile.classList.remove('flex');

            choices.replaceChildren();

            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = 'Pilih akun...';
            choices.appendChild(placeholder);
        }

        async function requestJson(url, options = {}) {
            const response = await fetch(url, {
                ...options,
                headers: {
                    Accept: 'application/json',
                    ...(options.headers || {}),
                },
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(
                    data.message || 'Terjadi kesalahan pada server.'
                );
            }

            return data;
        }

        function addChoice(user) {
            const option = document.createElement('option');

            option.value = user.id;
            option.textContent =
                `${user.name} (@${user.name}) — ID ${user.id}`;

            choices.appendChild(option);
        }

        
async function loadProfile(userId) {
    verifiedAccount = null;

    profile.classList.add('hidden');
    showStatus('Mengambil detail profil...');

    const data = await requestJson(
        `${robloxChecker.userUrl}/${encodeURIComponent(userId)}`
    );

    const user = data.user;

    const avatarImage = document.getElementById('avatarImage');

    verifiedAccount = {
        id: user.id,
        username: user.name,
        displayName: user.displayName,
        avatarImage: null,
    };

    document.getElementById('displayName').textContent =
        user.displayName;

    document.getElementById('usernameResult').textContent =
        `@${user.name}`;

    document.getElementById('userId').textContent = user.id;

    document.getElementById('profileLink').href = user.profileUrl;

    avatarImage.removeAttribute('src');
    avatarImage.classList.add('hidden');

    profile.classList.remove('hidden');
    profile.classList.add('flex');
    showStatus('Profil berhasil ditemukan.');

    try {
        const avatarData = await requestJson(
            `${robloxChecker.userUrl}/${encodeURIComponent(userId)}/avatar`
        );

        if (avatarData.imageUrl) {
            avatarImage.src = avatarData.imageUrl;
            avatarImage.classList.remove('hidden');

            verifiedAccount.avatarImage = avatarData.imageUrl;
        }
    } catch (error) {
        console.error('Gagal memuat avatar:', error);
    }

    console.log('VERIFIED ACCOUNT:', verifiedAccount);
}



const usernameInput = document.getElementById('username');

let searchTimer;
let activeController = null;

function setStatus(message) {
    statusBox.textContent = message;
    statusBox.classList.toggle('hidden', !message);
}

function resetSearchResults() {
    choicesWrapper.classList.add('hidden');
    choices.replaceChildren();

    const option = document.createElement('option');
    option.value = '';
    option.textContent = 'Pilih akun...';
    choices.appendChild(option);

    profile.classList.add('hidden');
}

usernameInput.addEventListener('input', () => { 
    verifiedAccount = null;

    clearTimeout(searchTimer);

    // Batalkan pencarian sebelumnya jika masih berjalan.
    if (activeController) {
        activeController.abort();
        activeController = null;
    }

    resetSearchResults();

    const username = usernameInput.value.trim();

    if (username.length < 3) {
        setStatus('Ketik minimal 3 karakter.');
        return;
    }

    setStatus('Menunggu input...');

    searchTimer = setTimeout(async () => {
        const controller = new AbortController();
        activeController = controller;

        setStatus('Mencari akun Roblox...');

        try {
            const response = await fetch(
                robloxChecker.searchUrl,
                {
                    method: 'POST',
                    signal: controller.signal,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                    body: JSON.stringify({ username }),
                }
            );

            const data = await response.json();

            if (!response.ok) {
                throw new Error(
                    data.message || 'Pencarian gagal.'
                );
            }

            // Abaikan hasil jika input sudah berubah.
            if (usernameInput.value.trim() !== username) return;

            if (data.status === 'found') {
                setStatus('Username ditemukan.');
                await loadProfile(data.user.id);
                return;
            }

            if (data.status === 'choices' && data.users.length) {
                data.users.forEach(addChoice);
                choicesWrapper.classList.remove('hidden');
                setStatus('Pilih akun yang sesuai.');
                return;
            }

            setStatus('Akun tidak ditemukan.');
        } catch (error) {
            if (error.name === 'AbortError') return;

            setStatus(error.message || 'Terjadi kesalahan.');
        } finally {
            if (activeController === controller) {
                activeController = null;
            }
        }
    }, 500);
});

choices.addEventListener('change', async () => {
    if (!choices.value) return;

    try {
        await loadProfile(choices.value);
    } catch (error) {
        setStatus(error.message || 'Gagal memuat profil.');
    }
});
