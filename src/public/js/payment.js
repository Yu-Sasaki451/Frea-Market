(() => {
    const init = () => {
        const select = document.getElementById('paymentSelect');
        const preview = document.getElementById('paymentPreview');

        if (!select || !preview) return;

        const NBSP = '\u00A0';

        const update = () => {
        if (select.value) {
            preview.textContent = select.options[select.selectedIndex].text;
        } else {
            preview.textContent = NBSP;
        }
        };

        select.addEventListener('change', update);
        update();
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
