<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-700 to-blue-500 flex items-center justify-center p-4">
    <div class="w-full max-w-md backdrop-blur-lg bg-white/30 p-8 rounded-xl shadow-lg">
        <h2 class="text-3xl font-bold text-white text-center mb-8">Đăng ký</h2>
        <form action="" method="POST">
            <div class="space-y-6">
                <div>
                    <label class="text-white block mb-2">Họ và tên</label>
                    <input type="text" name="fullname" class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 focus:border-white/50 focus:outline-none text-white placeholder-white/70" placeholder="Họ và tên" required>
                </div>
                <div>
                    <label class="text-white block mb-2">Email</label>
                    <input type="email" name="email" class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 focus:border-white/50 focus:outline-none text-white placeholder-white/70" placeholder="Email của bạn" required>
                </div>
                <div>
                    <label class="text-white block mb-2">Mật khẩu</label>
                    <input type="password" name="password" class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 focus:border-white/50 focus:outline-none text-white placeholder-white/70" placeholder="Mật khẩu của bạn" required>
                </div>
                <div>
                    <label class="text-white block mb-2">Xác nhận mật khẩu</label>
                    <input type="password" name="confirm_password" class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 focus:border-white/50 focus:outline-none text-white placeholder-white/70" placeholder="Nhập lại mật khẩu" required>
                </div>
                <button type="submit" class="w-full py-3 bg-white/20 hover:bg-white/30 text-white rounded-lg transition duration-300">
                    Đăng ký
                </button>
                <p class="text-white text-center">
                    Đã có tài khoản? 
                    <a href="login.php" class="underline hover:text-blue-200">Đăng nhập</a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>
