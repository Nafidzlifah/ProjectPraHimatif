<?php
require_once 'includes/functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm_password) {
        $error = 'Password tidak sama!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } else {
        if (register($name, $email, $password)) {
            $success = 'Akun berhasil dibuat! Silakan login.';
        } else {
            $error = 'Email sudah terdaftar atau terjadi kesalahan.';
        }
    }
}
?>
<!DOCTYPE html>
<html class="light" lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              colors: {
                "primary": "#006c80",
                "background-light": "#f9fafa",
                "background-dark": "#1a1f23",
              },
              fontFamily: {
                "display": ["Manrope", "sans-serif"]
              },
              borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
            },
          },
        }
    </script>
<title>Daftar Akun - Certificate App</title>
<style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
  </head>
<body class="bg-background-light dark:bg-background-dark font-display antialiased text-[#0c1a1d] dark:text-white transition-colors duration-300">
<div class="relative flex h-auto min-h-screen w-full flex-col overflow-x-hidden">
<div class="flex items-center bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md sticky top-0 z-50 p-4 pb-2 justify-between border-b border-primary/10">
<a href="index.php" class="text-primary flex size-10 shrink-0 items-center justify-center rounded-full hover:bg-primary/10 cursor-pointer transition-colors">
<span class="material-symbols-outlined">arrow_back</span>
</a>
<h2 class="text-lg font-bold leading-tight tracking-tight flex-1 text-center pr-10">Daftar Akun</h2>
</div>
<main class="flex-1">
<div class="@container">
<div class="@[480px]:px-4 @[480px]:py-6">
<div class="bg-cover bg-center flex flex-col justify-end overflow-hidden bg-primary/20 @[480px]:rounded-xl min-h-[240px] relative group" style='background-image: linear-gradient(180deg, rgba(0, 0, 0, 0) 40%, rgba(0, 50, 60, 0.8) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuDDq5Vg0S7Yz9z5SkiWf-vhJtEpmGBR_kBBe_xLkXjozOANxFtVYDN1lq8dUWE_W_gk-nBrD1z2E7Ww4J699vDrYlfZHHF3mnf053_Srj3khFKt2FFDfN7G-TbsQy595RhNvMXMTtEWfsLQB7Jj3MOA6TcXo4Dao1ddszLLDZzLwN1-E6neaR18G-ocZ_dPv6A4ehwtBUpIxuH2PlIT0iQSWkgSwgpMF2TnNFu_hCM19QW5XVUdiTUyi-CkpBLBtWmZDz_0079zIFI");'>
<div class="flex flex-col p-6 gap-2">
<p class="text-white text-[28px] font-extrabold leading-tight tracking-tight">Klaim sertifikat Anda secara instan</p>
<p class="text-white/80 text-sm font-medium">Platform terpercaya untuk manajemen kredensial digital Anda.</p>
</div>
</div>
</div>
</div>

<?php if ($error): ?>
    <div class="px-4 py-2">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline"><?php echo $error; ?></span>
        </div>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="px-4 py-2">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline"><?php echo $success; ?></span>
            <p class="mt-2 text-sm"><a href="index.php" class="font-bold underline">Login sekarang &rarr;</a></p>
        </div>
    </div>
<?php endif; ?>

<div class="grid grid-cols-3 gap-2 px-4 py-6">
<div class="flex flex-col items-center text-center gap-2">
<div class="bg-primary/10 p-3 rounded-full text-primary">
<span class="material-symbols-outlined">verified</span>
</div>
<p class="text-[10px] font-bold uppercase tracking-wider text-primary/70">Terverifikasi</p>
</div>
<div class="flex flex-col items-center text-center gap-2">
<div class="bg-primary/10 p-3 rounded-full text-primary">
<span class="material-symbols-outlined">security</span>
</div>
<p class="text-[10px] font-bold uppercase tracking-wider text-primary/70">Aman</p>
</div>
<div class="flex flex-col items-center text-center gap-2">
<div class="bg-primary/10 p-3 rounded-full text-primary">
<span class="material-symbols-outlined">share</span>
</div>
<p class="text-[10px] font-bold uppercase tracking-wider text-primary/70">Berbagi</p>
</div>
</div>
<div class="px-4 pb-12">
<form method="POST" class="bg-white dark:bg-[#252a2e] rounded-xl shadow-sm border border-primary/5 p-5 space-y-4">
<div class="flex flex-col gap-1.5">
<p class="text-sm font-semibold text-primary/80 dark:text-primary/60 ml-1">Nama Lengkap</p>
<div class="relative">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary/40 text-xl">person</span>
<input name="name" class="form-input flex w-full rounded-lg border border-primary/10 bg-background-light dark:bg-background-dark/50 focus:border-primary focus:ring-1 focus:ring-primary/20 h-14 pl-12 pr-4 placeholder:text-gray-400 dark:placeholder:text-gray-600 transition-all" placeholder="Budi Santoso" type="text" required/>
</div>
</div>
<div class="flex flex-col gap-1.5">
<p class="text-sm font-semibold text-primary/80 dark:text-primary/60 ml-1">Email</p>
<div class="relative">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary/40 text-xl">mail</span>
<input name="email" class="form-input flex w-full rounded-lg border border-primary/10 bg-background-light dark:bg-background-dark/50 focus:border-primary focus:ring-1 focus:ring-primary/20 h-14 pl-12 pr-4 placeholder:text-gray-400 dark:placeholder:text-gray-600 transition-all" placeholder="budi@example.com" type="email" required/>
</div>
</div>
<div class="flex flex-col gap-1.5">
<p class="text-sm font-semibold text-primary/80 dark:text-primary/60 ml-1">Password</p>
<div class="relative">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary/40 text-xl">lock</span>
<input name="password" id="password" class="form-input flex w-full rounded-lg border border-primary/10 bg-background-light dark:bg-background-dark/50 focus:border-primary focus:ring-1 focus:ring-primary/20 h-14 pl-12 pr-12 placeholder:text-gray-400 dark:placeholder:text-gray-600 transition-all" placeholder="••••••••" type="password" required/>
<span onclick="togglePassword('password')" class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-primary/40 cursor-pointer">visibility</span>
</div>
</div>
<div class="px-1 space-y-2">
<div class="flex gap-1 h-1">
<div class="flex-1 bg-primary rounded-full"></div>
<div class="flex-1 bg-primary rounded-full"></div>
<div class="flex-1 bg-primary/20 rounded-full"></div>
<div class="flex-1 bg-primary/20 rounded-full"></div>
</div>
<p class="text-[11px] text-primary font-medium flex items-center gap-1">
<span class="material-symbols-outlined text-xs">info</span>
                            Kekuatan Password: Cukup Aman
                        </p>
</div>
<div class="flex flex-col gap-1.5 pt-2">
<p class="text-sm font-semibold text-primary/80 dark:text-primary/60 ml-1">Konfirmasi Password</p>
<div class="relative">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary/40 text-xl">lock_reset</span>
<input name="confirm_password" id="confirm_password" class="form-input flex w-full rounded-lg border border-primary/10 bg-background-light dark:bg-background-dark/50 focus:border-primary focus:ring-1 focus:ring-primary/20 h-14 pl-12 pr-4 placeholder:text-gray-400 dark:placeholder:text-gray-600 transition-all" placeholder="••••••••" type="password" required/>
</div>
</div>
<div class="pt-6">
<button class="w-full bg-primary hover:bg-primary/90 text-white font-bold h-14 rounded-xl shadow-lg shadow-primary/20 flex items-center justify-center gap-2 active:scale-[0.98] transition-all" type="submit">
                            Buat Akun Sekarang
                            <span class="material-symbols-outlined text-lg">arrow_forward</span>
</button>
<p class="text-[12px] text-gray-500 text-center mt-4 px-4 leading-relaxed">
                            Dengan mendaftar, Anda menyetujui <span class="text-primary font-bold">Syarat &amp; Ketentuan</span> dan <span class="text-primary font-bold">Kebijakan Privasi</span> kami.
                        </p>
</div>
</form>
</div>
<div class="mt-8 flex flex-col items-center gap-4">
<div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                        Sudah punya akun?
                        <a class="text-primary font-bold hover:underline" href="index.php">Masuk di sini</a>
</div>
</div>
</div>
</main>
<div class="h-1.5 w-full bg-gradient-to-r from-primary/10 via-primary to-primary/10"></div>
</div>

<script>
function togglePassword(id) {
    var x = document.getElementById(id);
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>

</body></html>
