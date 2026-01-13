// Font Size Management Script
document.addEventListener('DOMContentLoaded', function () {
    // Font Size Adjustment
    const fontSizeButtons = document.querySelectorAll('.font-size-btn');
    const savedFontSize = localStorage.getItem('fontSize') || 'medium';
    const body = document.body;

    // Apply saved font size
    body.classList.add(`font-${savedFontSize}`);
    fontSizeButtons.forEach(btn => {
        if (btn.dataset.size === savedFontSize) {
            btn.classList.add('active');
        }
    });

    // Font size button handlers
    fontSizeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const size = this.dataset.size;

            // Remove all font size classes
            body.classList.remove('font-small', 'font-medium', 'font-large');

            // Add new font size class
            body.classList.add(`font-${size}`);

            // Update active button
            fontSizeButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Save preference
            localStorage.setItem('fontSize', size);
        });
    });
});
