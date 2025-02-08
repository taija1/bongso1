<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="min-h-screen gradient-bg flex items-center justify-center p-4">
    <div class="w-full max-w-md glass-effect p-8 rounded-2xl relative overflow-hidden">
        <h2 class="text-3xl font-bold text-[#342955] text-center mb-8 relative z-10">Đăng ký</h2>
        <form action="" method="POST" class="relative z-10">
            <div class="space-y-6">
                <div class="form-group">
                    <label class="text-[#342955] font-medium block mb-2">Tên người dùng</label>
                    <input type="text" name="username" 
                        class="glass-input w-full px-4 py-3 rounded-lg focus:outline-none text-[#342955] placeholder-[#342955]/60"
                        placeholder="Nhập tên hoặc biệt danh" required>
                </div>
                <div class="form-group">
                    <label class="text-[#342955] font-medium block mb-2">Email hoặc Số điện thoại</label>
                    <input type="text" name="contact" 
                        class="glass-input w-full px-4 py-3 rounded-lg focus:outline-none text-[#342955] placeholder-[#342955]/60"
                        placeholder="Email hoặc số điện thoại" required>
                </div>
                <div class="form-group">
                    <label class="text-[#342955] font-medium block mb-2">Mật khẩu</label>
                    <input type="password" name="password" 
                        class="glass-input w-full px-4 py-3 rounded-lg focus:outline-none text-[#342955] placeholder-[#342955]/60"
                        placeholder="Mật khẩu của bạn" required>
                </div>
                <div class="form-group">
                    <label class="text-[#342955] font-medium block mb-2">Xác nhận mật khẩu</label>
                    <input type="password" name="confirm_password" 
                        class="glass-input w-full px-4 py-3 rounded-lg focus:outline-none text-[#342955] placeholder-[#342955]/60"
                        placeholder="Nhập lại mật khẩu" required>
                </div>
                <button type="submit" class="btn-primary w-full py-3 text-white rounded-lg transform transition hover:scale-[1.02] hover:-translate-y-1">
                    Đăng ký
                </button>
                <p class="text-[#342955]/90 text-center">
                    Đã có tài khoản? 
                    <a href="login.php" class="text-[#583399] hover:text-[#7c4dff] font-medium">Đăng nhập</a>
                </p>
            </div>
        </form>
    </div>
    <script src="assets/js/effects.js"></script>
</body>
</html>
