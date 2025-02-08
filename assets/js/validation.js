const PATTERNS = {
    username: /^[a-zA-Z0-9][a-zA-Z0-9_]{2,19}$/, // Bắt đầu bằng chữ/số, cho phép dấu _, 3-20 ký tự
    email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
    phone: /^(0|84|\+84)([0-9]{9})$/,
    password: /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{8,}$/
};

const TOAST_ICONS = {
    success: '<ion-icon name="checkmark-circle" class="text-2xl mr-2"></ion-icon>',
    error: '<ion-icon name="alert-circle" class="text-2xl mr-2"></ion-icon>',
    warning: '<ion-icon name="warning" class="text-2xl mr-2"></ion-icon>',
    info: '<ion-icon name="information-circle" class="text-2xl mr-2"></ion-icon>'
};

const TOAST_COLORS = {
    success: 'bg-green-500',
    error: 'bg-red-500',
    warning: 'bg-yellow-500',
    info: 'bg-blue-500'
};

const NOTIFICATION_ICONS = {
    success: {
        icon: '<ion-icon name="happy-outline"></ion-icon>',
        emoji: '🎉'
    },
    error: {
        icon: '<ion-icon name="sad-outline"></ion-icon>',
        emoji: '😅'
    },
    warning: {
        icon: '<ion-icon name="alert-outline"></ion-icon>',
        emoji: '⚠️'
    },
    info: {
        icon: '<ion-icon name="information-circle-outline"></ion-icon>',
        emoji: '💡'
    },
    loading: {
        icon: '<ion-icon name="reload-outline" class="animate-spin"></ion-icon>',
        emoji: '⌛'
    }
};

const VALIDATION_MESSAGES = {
    username: {
        pattern: 'Tên đăng nhập phải:',
        rules: [
            'Bắt đầu bằng chữ cái hoặc số',
            'Chỉ chứa chữ cái, số và dấu gạch dưới',
            'Độ dài từ 3-20 ký tự'
        ]
    },
    password: {
        pattern: 'Mật khẩu phải:',
        rules: [
            'Ít nhất 8 ký tự',
            'Bao gồm cả chữ và số',
            'Có thể chứa ký tự đặc biệt @$!%*#?&'
        ]
    }
};

// Thêm hàm showInputError
function showInputError(input, message) {
    // Xóa error message cũ nếu có
    const existingError = input.parentElement.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }

    // Thêm class error cho input
    input.classList.add('error');
    
    // Tạo error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message text-red-500 text-sm mt-1 flex items-center';
    errorDiv.innerHTML = `
        <ion-icon name="alert-circle" class="mr-1"></ion-icon>
        <span>${message}</span>
    `;
    
    // Thêm error message vào sau input
    input.parentElement.appendChild(errorDiv);
}

function showLoading(button) {
    if (!button) return '';
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = `
        <div class="flex items-center justify-center gap-2">
            ${NOTIFICATION_ICONS.loading.icon}
            <span class="loading-text">Đang xử lý</span>
        </div>
    `;
    startLoadingAnimation();
    return originalText;
}

function startLoadingAnimation() {
    const loadingText = document.querySelector('.loading-text');
    if (!loadingText) return;
    
    let dots = 0;
    const interval = setInterval(() => {
        dots = (dots + 1) % 4;
        loadingText.textContent = 'Đang xử lý' + '.'.repeat(dots);
    }, 500);

    return () => clearInterval(interval);
}

function resetButton(button, originalText) {
    button.disabled = false;
    button.innerHTML = originalText;
}

function showToast(message, type = 'success') {
    const existingToasts = document.querySelectorAll('.toast');
    existingToasts.forEach(toast => toast.remove());

    const toast = document.createElement('div');
    toast.className = `toast fixed top-4 right-4 p-4 rounded-lg shadow-lg 
        ${TOAST_COLORS[type]} text-white flex items-center min-w-[300px] z-50 
        animate-bounce-in`;
    
    toast.innerHTML = `
        <div class="flex items-center gap-3 text-lg">
            ${NOTIFICATION_ICONS[type].icon}
            <span class="mr-2">${NOTIFICATION_ICONS[type].emoji}</span>
            <p class="text-sm font-medium">${message}</p>
        </div>
    `;
    
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('animate-fade-out');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Thêm hàm hiển thị validation hint
function showValidationHint(input, type) {
    const messages = VALIDATION_MESSAGES[type];
    if (!messages) return;

    const hint = document.createElement('div');
    hint.className = 'validation-hint hidden absolute -bottom-32 left-0 right-0 bg-black/80 backdrop-blur-sm p-3 rounded-lg text-xs text-white space-y-1 z-50';
    hint.innerHTML = `
        <div class="font-medium">${messages.pattern}</div>
        <ul class="list-disc list-inside space-y-0.5 text-white/90">
            ${messages.rules.map(rule => `<li>${rule}</li>`).join('')}
        </ul>
    `;
    
    input.parentElement.appendChild(hint);
    
    // Show/hide hint
    input.addEventListener('focus', () => hint.classList.remove('hidden'));
    input.addEventListener('blur', () => hint.classList.add('hidden'));
}

function validateForm(form) {
    console.group('Form Validation Started');
    console.log('Form ID:', form.id);

    const validations = {
        username: {
            pattern: PATTERNS.username,
            message: 'Tên người dùng từ 3-20 ký tự, chỉ chữ, số và dấu _ ' + NOTIFICATION_ICONS.info.emoji
        },
        contact: {
            pattern: value => PATTERNS.email.test(value) || PATTERNS.phone.test(value),
            message: 'Email hoặc số điện thoại không hợp lệ ' + NOTIFICATION_ICONS.error.emoji
        },
        password: {
            pattern: PATTERNS.password,
            message: 'Mật khẩu ít nhất 8 ký tự, bao gồm chữ và số ' + NOTIFICATION_ICONS.warning.emoji
        }
    };

    let isValid = true;
    const data = {};
    const errors = [];

    // Clear previous errors
    form.querySelectorAll('.error-message').forEach(el => el.remove());

    // Validate each input
    form.querySelectorAll('input[required]').forEach(input => {
        const fieldName = input.name;
        const value = input.value.trim();
        data[fieldName] = value;

        console.group(`Validating ${fieldName}`);
        console.log('Value:', value);

        if (validations[fieldName]) {
            const validation = validations[fieldName];
            const isFieldValid = typeof validation.pattern === 'function' 
                ? validation.pattern(value)
                : validation.pattern.test(value);

            console.log('Pattern:', validation.pattern);
            console.log('Is Valid:', isFieldValid);

            if (!isFieldValid) {
                isValid = false;
                errors.push({
                    field: fieldName,
                    value: value,
                    message: validation.message
                });
                showInputError(input, validation.message);
            }
        }
        console.groupEnd();
    });

    // Add real-time validation
    form.querySelectorAll('input[required]').forEach(input => {
        const fieldName = input.name;
        if (VALIDATION_MESSAGES[fieldName]) {
            showValidationHint(input, fieldName);
        }

        // Real-time validation on input
        input.addEventListener('input', () => {
            const value = input.value.trim();
            if (validations[fieldName]) {
                const isValid = typeof validations[fieldName].pattern === 'function' 
                    ? validations[fieldName].pattern(value)
                    : validations[fieldName].pattern.test(value);
                
                input.classList.toggle('valid', isValid);
                input.classList.toggle('invalid', !isValid);
            }
        });
    });

    // Check password confirmation if exists
    const password = form.querySelector('input[name="password"]');
    const confirmPassword = form.querySelector('input[name="confirm_password"]');
    if (password && confirmPassword && password.value !== confirmPassword.value) {
        console.group('Password Confirmation Check');
        console.log('Password:', password.value);
        console.log('Confirm Password:', confirmPassword.value);
        console.log('Match:', password.value === confirmPassword.value);

        if (password.value !== confirmPassword.value) {
            isValid = false;
            errors.push({
                field: 'confirm_password',
                message: 'Mật khẩu không khớp'
            });
            showInputError(confirmPassword, 'Mật khẩu không khớp ' + NOTIFICATION_ICONS.error.emoji);
        }
        console.groupEnd();
    }

    console.log('Validation Summary:', {
        isValid,
        data,
        errors
    });
    console.groupEnd();

    return { isValid, data, errors };
}

// Sửa lại hàm handleFormSubmit
async function handleFormSubmit(formId, successMsg) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const button = e.submitter;
        const originalText = showLoading(button);

        try {
            const { isValid, data } = validateForm(form);
            
            if (isValid) {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();
                
                if (result.success) {
                    showToast(result.message, 'success');
                    setTimeout(() => {
                        window.location.href = result.redirect;
                    }, 1500);
                } else {
                    showToast(result.message, 'error');
                }
            }
        } catch (error) {
            showToast('Có lỗi xảy ra!', 'error');
        } finally {
            resetButton(button, originalText);
        }
    });
}

// Thêm hàm để khôi phục thông tin đăng nhập đã lưu
function restoreRememberedUser() {
    const rememberedUser = localStorage.getItem('rememberedUser');
    if (rememberedUser) {
        const { contact, timestamp } = JSON.parse(rememberedUser);
        const daysSinceStored = (new Date().getTime() - timestamp) / (1000 * 60 * 60 * 24);
        
        // Tự động xóa sau 30 ngày
        if (daysSinceStored > 30) {
            localStorage.removeItem('rememberedUser');
            return;
        }

        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            const contactInput = loginForm.querySelector('input[name="contact"]');
            const rememberCheckbox = loginForm.querySelector('input[name="remember"]');
            if (contactInput) contactInput.value = contact;
            if (rememberCheckbox) rememberCheckbox.checked = true;
        }
    }
}

// Thêm khởi tạo
document.addEventListener('DOMContentLoaded', restoreRememberedUser);

// Add to style.css or keep here
const styles = `
    @keyframes bounce-in {
        0% { transform: translateY(-100%); opacity: 0; }
        50% { transform: translateY(10%); }
        100% { transform: translateY(0); opacity: 1; }
    }
    .animate-bounce-in {
        animation: bounce-in 0.5s ease-out;
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
`;

// Thêm CSS cho error states
const errorStyles = `
    .error {
        border-color: rgb(239, 68, 68) !important;
    }
    
    .error-message {
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;

// Add styles to document
const styleSheet = document.createElement("style");
styleSheet.textContent = styles;
document.head.appendChild(styleSheet);

// Thêm styles vào document
const errorStyleSheet = document.createElement("style");
errorStyleSheet.textContent = errorStyles;
document.head.appendChild(errorStyleSheet);

// Thêm debug helpers
window.debugForm = {
    validateInput: (value, type) => {
        console.group('Debug Input');
        console.log('Testing value:', value);
        console.log('Pattern:', PATTERNS[type]);
        const result = PATTERNS[type].test(value);
        console.log('Result:', result);
        console.groupEnd();
        return result;
    },
    showPatterns: () => console.table(PATTERNS),
    clearStorage: () => {
        localStorage.clear();
        console.log('Local storage cleared');
    }
};