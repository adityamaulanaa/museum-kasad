<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Admin - Museum KASAD</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="min-h-screen flex items-center justify-center p-4 font-montserrat text-white bg-primary">

    <div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-12 gap-8 items-center">

        <div class="md:col-span-5 space-y-6 items-center text-center md:text-left">
            <div class="flex items-center space-x-3">
                <img src="images/kasad-logo.png" alt="Museum Kasad Logo" class="h-10 w-auto object-contain">
            </div>

            <div class="space-y-2">
                <h1
                    class="text-3xl sm:text-4xl lg:text-5xl font-bold text-[#e2ca52] tracking-wide leading-tight uppercase">
                    Selamat Datang
                </h1>
                <p class="text-xs sm:text-sm text-gray-400 font-medium tracking-wide max-w-sm leading-relaxed">
                    Silahkan Login untuk melanjutkan ke Dashboard Admin Museum.
                </p>
            </div>
        </div>

        <div
            class="md:col-span-7 bg-[#111111]/90 border border-gray-800/60 rounded-3xl p-8 sm:p-10 backdrop-blur-md max-w-lg w-full justify-self-center md:justify-self-end">

            <div class="text-center mb-8">
                <h2 class="text-xl text-[#e2ca52] tracking-widest uppercase font-bold">
                    Login Admin
                </h2>
            </div>

            @if ($errors->any())
                <div class="mb-4 bg-red-900/50 border border-red-800 text-red-300 p-3 rounded-xl text-sm font-semibold">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $errors->first() }}
                </div>
            @endif

            <form action="/login" method="POST" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Username</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-gray-500 text-sm">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="username" required placeholder="Masukkan Username"
                            class="w-full bg-black border border-gray-800 rounded-xl py-3.5 pl-12 pr-4 text-white text-xs font-medium focus:border-[#e2ca52] focus:outline-none transition-all placeholder-gray-700">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Password</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-gray-500 text-sm">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password-field" required
                            placeholder="Masukkan Password"
                            class="w-full bg-black border border-gray-800 rounded-xl py-3.5 pl-12 pr-12 text-white text-xs font-medium focus:border-[#e2ca52] focus:outline-none transition-all placeholder-gray-700">

                        <button type="button" onclick="togglePassword()"
                            class="absolute right-4 text-gray-500 hover:text-white transition-colors text-xs focus:outline-none">
                            <i id="eye-icon" class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div
                    class="flex items-center justify-between text-[10px] font-semibold tracking-wide text-gray-500 pt-1">
                    <label class="flex items-center space-x-2 cursor-pointer hover:text-gray-300 transition-colors">
                        <input type="checkbox" name="remember"
                            class="accent-[#e2ca52] rounded border-gray-800 bg-black">
                        <span>Ingat Saya</span>
                    </label>
                    <a href="#" class="hover:text-[#e2ca52] transition-colors">
                        Lupa Password?
                    </a>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-[#e2ca52] hover:bg-[#6e5a27] text-black font-bold py-3.5 rounded-xl transition-all uppercase tracking-widest text-xs shadow-lg shadow-black/50 border border-[#e2ca52]/20 cursor-pointer">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password-field');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        }
    </script>
</body>

</html>
