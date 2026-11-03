document.querySelectorAll('[data-tooltip]').forEach(wrapper => {

    const button = wrapper.querySelector('button');
    const tooltip = wrapper.querySelector('[data-tooltip-content]');

    if (!button || !tooltip) return;

    const GAP = 12;
    const MARGIN = 12;

    function positionTooltip() {

        // Reset posisi
        tooltip.style.top = '';
        tooltip.style.bottom = '';
        tooltip.style.left = '';
        tooltip.style.right = '';
        tooltip.style.transform = '';

        // Default: atas dan tengah
        tooltip.style.bottom = 'calc(100% + 12px)';
        tooltip.style.left = '50%';
        tooltip.style.transform = 'translateX(-50%)';

        let rect = tooltip.getBoundingClientRect();
        const buttonRect = button.getBoundingClientRect();

        const spaceAbove = buttonRect.top;
        const spaceBelow = window.innerHeight - buttonRect.bottom;

        // Deteksi overflow vertikal
        if (
            rect.top < MARGIN &&
            spaceBelow > spaceAbove
        ) {
            tooltip.style.bottom = '';
            tooltip.style.top = 'calc(100% + 12px)';
        }

        // Hitung ulang posisi
        rect = tooltip.getBoundingClientRect();

        // Deteksi overflow horizontal
        if (rect.left < MARGIN) {

            tooltip.style.left = '0';
            tooltip.style.right = 'auto';
            tooltip.style.transform = 'none';

        } else if (rect.right > window.innerWidth - MARGIN) {

            tooltip.style.left = 'auto';
            tooltip.style.right = '0';
            tooltip.style.transform = 'none';

        }

    }

    function showTooltip() {

        tooltip.classList.remove('invisible', 'opacity-0');

        positionTooltip();

        tooltip.classList.add('visible', 'opacity-100');

    }

    function hideTooltip() {

        tooltip.classList.add('invisible', 'opacity-0');

        tooltip.classList.remove('visible', 'opacity-100');

    }

    wrapper.addEventListener('mouseenter', showTooltip);
    wrapper.addEventListener('mouseleave', hideTooltip);

    button.addEventListener('focus', showTooltip);
    button.addEventListener('blur', hideTooltip);

    window.addEventListener('resize', () => {

        if (tooltip.classList.contains('visible')) {
            positionTooltip();
        }

    });

});