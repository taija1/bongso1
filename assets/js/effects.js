
// Glassmorphism mouse movement effect
const handleMouseMove = (e) => {
    const cards = document.querySelectorAll('.glass-effect');
    cards.forEach(card => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        card.style.setProperty('--mouse-x', `${x}px`);
        card.style.setProperty('--mouse-y', `${y}px`);
    });
};

// Input focus effects
const setupInputEffects = () => {
    const inputs = document.querySelectorAll('.glass-input');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement.classList.add('input-focused');
        });
        input.addEventListener('blur', () => {
            input.parentElement.classList.remove('input-focused');
        });
    });
};

// Initialize effects
document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('mousemove', handleMouseMove);
    setupInputEffects();
});