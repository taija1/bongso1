
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src='https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js'></script>
</head>
<body class="font-['Poppins']">
    <section>
        <div class="form-box w-[400px] glass-effect p-8 rounded-2xl relative">
            <div class="form-value">
                <form action="">
                    <h2 class="text-3xl font-bold text-white text-center mb-8">Khôi phục mật khẩu</h2>
                    
                    <div class="inputbox relative mb-8 border-b-2 border-white group">
                        <ion-icon name="mail-outline" class="absolute right-2 top-1/2 -translate-y-1/2 text-white text-xl"></ion-icon>
                        <input type="text" required 
                            class="w-full h-12 bg-transparent border-none outline-none text-white px-4 peer"
                            placeholder=" ">
                        <label class="absolute left-4 top-1/2 -translate-y-1/2 text-white pointer-events-none transition-all duration-300 peer-focus:-top-1 peer-focus:text-sm">
                            Email hoặc số điện thoại
                        </label>
                    </div>

                    <button class="w-full h-10 rounded-full bg-white hover:bg-opacity-90 text-[#342955] font-semibold transition-all duration-300 hover:-translate-y-1">
                        Gửi mã xác nhận
                    </button>

                    <div class="text-center text-white mt-6">
                        <a href="login.php" class="font-semibold hover:underline">
                            <ion-icon name="arrow-back-outline" class="inline-block mr-1"></ion-icon>
                            Quay lại đăng nhập
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
</html>