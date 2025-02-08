<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="min-h-screen gradient-bg flex items-center justify-center p-4">
    <div class="bg-blur bg-blur-1"></div>
    <div class="bg-blur bg-blur-2"></div>
    <div class="w-full max-w-md glass-effect p-8 rounded-2xl relative overflow-hidden">
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        
        <h2 class="text-3xl font-bold text-shadow text-[#342955] text-center mb-8 relative z-10">Đăng nhập</h2>
        <form action="" method="POST" class="relative z-10">
            <div class="space-y-6">
                <div class="group">
                    <label class="text-[#342955] font-medium block mb-2">Email</label>
                    <input type="email" name="email" 
                        class="glass-input w-full px-4 py-3 rounded-lg focus:outline-none text-[#342955] placeholder-[#342955]/60 transition-all duration-300 hover:shadow-lg"
                        placeholder="Email của bạn" required>
                </div>
                <div class="group">
                    <label class="text-[#342955] font-medium block mb-2">Mật khẩu</label>
                    <input type="password" name="password" 
                        class="glass-input w-full px-4 py-3 rounded-lg focus:outline-none text-[#342955] placeholder-[#342955]/60 transition-all duration-300 hover:shadow-lg"
                        placeholder="Mật khẩu của bạn" required>
                </div>
                <button type="submit" 
                    class="btn-primary w-full py-3 text-white rounded-lg shadow-lg hover:shadow-xl">
                    Đăng nhập
                </button>
                <p class="text-[#342955]/90 text-center">
                    Chưa có tài khoản? 
                    <a href="register.php" class="text-[#583399] hover:text-[#7c4dff] font-medium">Đăng ký</a>
                </p>
            </div>
        </form>
    </div>
    <script src="assets/js/effects.js"></script>
</body>
</html>
