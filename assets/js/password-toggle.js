const setupPasswordToggles = () => {
    const passwordFields = document.querySelectorAll('input[type="password"]');
    
    passwordFields.forEach(field => {
        const wrapper = document.createElement('div');
        wrapper.className = 'password-input-wrapper';
        field.parentNode.insertBefore(wrapper, field);
        wrapper.appendChild(field);

        const toggleButton = document.createElement('button');
        toggleButton.type = 'button';
        toggleButton.className = 'password-toggle-btn';
        toggleButton.innerHTML = '<ion-icon name="eye-outline" class="text-xl"></ion-icon>';
        
        // Ngăn sự kiện click lan ra ngoài
        toggleButton.addEventListener('mousedown', (e) => {
            e.preventDefault();
            e.stopPropagation();
        });
        
        // Toggle password
        toggleButton.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            
            const type = field.getAttribute('type');
            field.setAttribute('type', type === 'password' ? 'text' : 'password');
            toggleButton.innerHTML = `<ion-icon name="${type === 'password' ? 'eye-off-outline' : 'eye-outline'}" class="text-xl"></ion-icon>`;
            
            // Animation
            toggleButton.classList.add('animate-pulse');
            setTimeout(() => toggleButton.classList.remove('animate-pulse'), 300);
            
            field.focus();
        });

        wrapper.appendChild(toggleButton);
    });
};

// Thêm CSS để fix vị trí
const passwordStyles = `
    .password-input-wrapper {
        width: 100%;
    }
    .password-input-wrapper input {
        padding-right: 4rem !important;
    }
    .password-input-wrapper button:focus {
        outline: none;
    }
`;

const styleSheet = document.createElement('style');
styleSheet.textContent = passwordStyles;
document.head.appendChild(styleSheet);

// Thêm tooltip cho password requirements
const setupPasswordHints = () => {
    const passwordInputs = document.querySelectorAll('input[name="password"]');
    
    passwordInputs.forEach(input => {
        const hint = document.createElement('div');
        hint.className = 'password-hint hidden absolute -bottom-24 left-0 right-0 bg-white/10 backdrop-blur-md p-2 rounded text-xs text-white/90 space-y-1';
        hint.innerHTML = `
            <div class="flex items-center space-x-1">
                <ion-icon name="information-circle-outline"></ion-icon>
                <span>Mật khẩu phải có:</span>
            </div>
            <ul class="list-disc list-inside pl-2 space-y-0.5">
                <li>Ít nhất 8 ký tự</li>
                <li>Bao gồm chữ và số</li>
            </ul>
        `;
        
        input.parentElement.appendChild(hint);
        
        // Show/hide hint
        input.addEventListener('focus', () => hint.classList.remove('hidden'));
        input.addEventListener('blur', () => hint.classList.add('hidden'));
    });
};

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    setupPasswordToggles();
    setupPasswordHints();
});
