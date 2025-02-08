<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src='https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js'></script>
</head>
<body class="font-['Poppins']">
    <section>
        <div class="form-box w-[400px] glass-effect p-8 rounded-2xl relative">
            <div class="form-value">
                <form id="registerForm" action="" method="POST">
                    <h2 class="text-3xl font-bold text-white text-center mb-8">Đăng ký</h2>
                    
                    <div class="inputbox relative mb-8 border-b-2 border-white group">
                        <ion-icon name="person-outline" class="absolute right-2 top-1/2 -translate-y-1/2 text-white text-xl"></ion-icon>
                        <input type="text" name="username" required 
                            class="w-full h-12 bg-transparent border-none outline-none text-white px-4 peer"
                            placeholder=" "
                            pattern="^[a-zA-Z0-9][a-zA-Z0-9_]{2,19}$"
                            title="Tên đăng nhập phải từ 3-20 ký tự, chỉ chứa chữ, số và dấu _">
                        <label class="absolute left-4 top-1/2 -translate-y-1/2 text-white pointer-events-none transition-all duration-300 peer-focus:-top-1 peer-focus:text-sm">
                            Tên đăng nhập
                        </label>
                    </div>

                    <div class="inputbox relative mb-8 border-b-2 border-white group">
                        <ion-icon name="mail-outline" class="absolute right-2 top-1/2 -translate-y-1/2 text-white text-xl"></ion-icon>
                        <input type="text" name="contact" required 
                            class="w-full h-12 bg-transparent border-none outline-none text-white px-4 peer"
                            placeholder=" ">
                        <label class="absolute left-4 top-1/2 -translate-y-1/2 text-white pointer-events-none transition-all duration-300 peer-focus:-top-1 peer-focus:text-sm">
                            Email hoặc Số điện thoại
                        </label>
                    </div>

                    <div class="inputbox relative mb-8 border-b-2 border-white group">
                        <ion-icon name="lock-closed-outline" class="absolute right-2 top-1/2 -translate-y-1/2 text-white text-xl"></ion-icon>
                        <input type="password" name="password" required 
                            class="w-full h-12 bg-transparent border-none outline-none text-white px-4 peer"
                            placeholder=" ">
                        <label class="absolute left-4 top-1/2 -translate-y-1/2 text-white pointer-events-none transition-all duration-300 peer-focus:-top-1 peer-focus:text-sm">
                            Mật khẩu
                        </label>
                    </div>

                    <div class="inputbox relative mb-8 border-b-2 border-white group">
                        <ion-icon name="lock-closed-outline" class="absolute right-2 top-1/2 -translate-y-1/2 text-white text-xl"></ion-icon>
                        <input type="password" name="confirm_password" required 
                            class="w-full h-12 bg-transparent border-none outline-none text-white px-4 peer"
                            placeholder=" ">
                        <label class="absolute left-4 top-1/2 -translate-y-1/2 text-white pointer-events-none transition-all duration-300 peer-focus:-top-1 peer-focus:text-sm">
                            Xác nhận mật khẩu
                        </label>
                    </div>

                    <button type="submit" class="w-full h-10 rounded-full bg-white hover:bg-opacity-90 text-[#342955] font-semibold transition-all duration-300 hover:-translate-y-1">
                        Đăng ký
                    </button>

                    <div class="text-center text-white mt-6">
                        <p>Đã có tài khoản? 
                            <a href="login.php" class="font-semibold hover:underline">Đăng nhập</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="assets/js/effects.js"></script>
    <script src="assets/js/password-toggle.js"></script>
    <script src="assets/js/validation.js"></script>
    <script>
        handleFormSubmit('registerForm', 'Đăng ký thành công! Chuyển hướng đến trang đăng nhập...');
    </script>
</body>
</html>
