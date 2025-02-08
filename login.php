<?php
$config = require_once 'config/config.php';
$googleClientId = $config['social']['google']['client_id'];
$currentDomain = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src='https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js'></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>
<body class="font-['Poppins']">
    <section>
        <div class="form-box w-[400px] glass-effect p-8 rounded-2xl relative">
            <div class="form-value">
                <form id="loginForm" action="auth/login_process.php" method="POST">
                    <h2 class="text-3xl font-bold text-white text-center mb-8">Đăng nhập</h2>
                    
                    <div class="inputbox relative mb-8 border-b-2 border-white group">
                        <ion-icon name="person-outline" class="absolute right-2 top-1/2 -translate-y-1/2 text-white text-xl"></ion-icon>
                        <input type="text" name="contact" required class="w-full h-12 bg-transparent border-none outline-none text-white px-4 peer" placeholder=" ">
                        <label class="absolute left-4 top-1/2 -translate-y-1/2 text-white pointer-events-none transition-all duration-300 peer-focus:-top-1 peer-focus:text-sm">
                            Tên đăng nhập/Email/SĐT
                        </label>
                    </div>

                    <div class="inputbox relative mb-8 border-b-2 border-white group">
                        <ion-icon name="lock-closed-outline" class="absolute right-2 top-1/2 -translate-y-1/2 text-white text-xl"></ion-icon>
                        <input type="password" name="password" required 
                            class="w-full h-12 bg-transparent border-none outline-none text-white px-4 peer"
                            placeholder=" ">
                        <label class="absolute left-4 top-1/2 -translate-y-1/2 text-white pointer-events-none transition-all duration-300 peer-focus:-top-1 peer-focus:text-sm peer-[:not(:placeholder-shown)]:-top-1 peer-[:not(:placeholder-shown)]:text-sm">
                            Mật khẩu
                        </label>
                    </div>

                    <div class="flex justify-between items-center text-white text-sm mb-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="mr-2 cursor-pointer">
                            <span>Ghi nhớ đăng nhập</span>
                        </label>
                        <a href="forgot-password.php" class="hover:underline">Quên mật khẩu?</a>
                    </div>
                    
                    <button type="submit" class="w-full h-10 rounded-full bg-white hover:bg-opacity-90 text-[#342955] font-semibold transition-all duration-300 hover:-translate-y-1">
                        Đăng nhập
                    </button>
                    
                    <div class="relative flex items-center gap-4 my-4">
                        <hr class="flex-grow border-white/30">
                        <span class="text-white/70">hoặc</span>
                        <hr class="flex-grow border-white/30">
                    </div>

                    <div id="g_id_onload"
                        data-client_id="<?php echo htmlspecialchars($googleClientId); ?>"
                        data-context="signin"
                        data-ux_mode="popup"
                        data-login_uri="<?php echo $currentDomain; ?>/auth/google-callback.php"
                        data-auto_prompt="false">
                    </div>
                    <div class="g_id_signin w-full flex justify-center"
                        data-type="standard"
                        data-size="large"
                        data-theme="outline"
                        data-text="signin_with"
                        data-shape="rectangular"
                        data-logo_alignment="left">
                    </div>

                    <div class="text-center text-white mt-6 space-y-2">
                        <a href="forgot-password.php" class="block hover:underline text-sm">Quên mật khẩu?</a>
                        <p>Chưa có tài khoản? 
                            <a href="register.php" class="font-semibold hover:underline">Đăng ký</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="assets/js/validation.js"></script>
    <script src="assets/js/password-toggle.js"></script>
    <script>
        handleFormSubmit('loginForm', 'Đăng nhập thành công! Đang chuyển hướng...');
        
        function handleCredentialResponse(response) {
            if (response.credential) {
                showToast("Đăng nhập Google thành công!", "success");
                setTimeout(() => window.location.href = 'dashboard.php', 1500);
            } else {
                showToast("Đăng nhập Google thất bại!", "error");
            }
        }
    </script>
</body>
</html>
