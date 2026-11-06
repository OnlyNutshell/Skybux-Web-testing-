const timer = document.getElementById('payment-timer');

if (timer) {
    console.log('Expires At:', timer.dataset.expiresAt);
console.log('Parsed Date:', new Date(timer.dataset.expiresAt));
console.log('Current Time:', new Date());
    const expiresAt = new Date(timer.dataset.expiresAt).getTime();

    function updateTimer() {
        const remaining = Math.max(
            0,
            Math.floor((expiresAt - Date.now()) / 1000)
        );

        const minutes = Math.floor(remaining / 60);
        const seconds = remaining % 60;

        timer.textContent =
            `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

        if (remaining <= 0) {
            clearInterval(interval);
        }
    }

    const interval = setInterval(updateTimer, 1000);

    updateTimer();
}