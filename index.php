<?php
require_once 'includes/functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (login($email, $password)) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = 'Email atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html class="light" lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Halaman Login User - Certificate App</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1b4f98",
                        "background-light": "#fafaf9",
                        "background-dark": "#1a1d23",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
<style type="text/tailwindcss">
        body {
            font-family: 'Manrope', sans-serif;
            min-height: 100dvh;
        }
        .ios-shadow {
            box-shadow: 0 4px 24px -1px rgba(0, 0, 0, 0.06), 0 2px 8px -1px rgba(0, 0, 0, 0.04);
        }
        .input-focus {
            @apply focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all;
        }
    </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
  </head>
<body class="bg-background-light dark:bg-background-dark font-display text-[#0f131a] dark:text-white">
<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
<div class="relative h-[40vh] w-full overflow-hidden">
<div class="absolute inset-0 bg-primary/10 dark:bg-primary/20"></div>
<div class="w-full h-full bg-center bg-no-repeat bg-cover" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBQ-Mb7PodEixKBHkbb23hz-tJM5FCewZs7YAoQPakvAclgTRLRPODINK6v-hxyHpCCN5Azld5Y3H7ry2Fc8DfWKaSRlOunVTrDMJ5DVlxihbGhP5rCfgsvin3ltow2LtZ1LPna1azkWugFEd1zDITodxALfLZsG0rFPI_0Df0PRBAXdIOYR6wE9pyNk9Br8tWFWpUC2eVPDMN1pOMbyaKqwkgEKI34n_7CO3RsoeWIp9O_gJLoiZm3mDnS1tnte4asB96226LGJxU");'>
</div>
<div class="absolute inset-0 bg-gradient-to-t from-background-light via-transparent to-transparent dark:from-background-dark"></div>
<div class="absolute top-0 left-0 right-0 flex items-center p-4 justify-between">
<!-- Back button removed as this is the entry page -->
</div>
</div>
<div class="flex-1 px-8 -mt-16 relative z-10 flex flex-col">
<div class="bg-background-light dark:bg-background-dark rounded-3xl pt-4">
<div class="mb-10 text-center sm:text-left">
<h1 class="tracking-tight text-5xl font-black leading-tight text-transparent bg-clip-text bg-gradient-to-br from-blue-800 via-blue-600 to-indigo-600 drop-shadow-sm" style="font-family: 'Manrope', sans-serif;">
                        E-Certift
                    </h1>
<p class="text-[#536d93] dark:text-gray-400 text-base font-normal mt-2">
                        Masukkan kredensial Anda untuk mengakses dasbor sertifikat.
                    </p>
</div>


<?php if ($error): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline"><?php echo $error; ?></span>
    </div>
<?php endif; ?>

<form class="space-y-6" method="POST">
<div class="flex flex-col gap-2">
<label class="text-[#0f131a] dark:text-gray-200 text-sm font-bold ml-1 uppercase tracking-wider">Email Address</label>
<div class="relative group">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[#536d93] text-xl group-focus-within:text-primary transition-colors">mail</span>
<input name="email" class="form-input flex w-full rounded-2xl text-[#0f131a] dark:text-white border border-[#d1dae5] dark:border-gray-700 bg-white dark:bg-gray-800 h-14 pl-12 pr-4 placeholder:text-[#a0aec0] text-base font-normal input-focus shadow-sm" placeholder="" required="" type="email"/>
</div>
</div>
<div class="flex flex-col gap-2">
<div class="flex justify-between items-center px-1">
<label class="text-[#0f131a] dark:text-gray-200 text-sm font-bold uppercase tracking-wider">Password</label>
</div>
<div class="relative group">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[#536d93] text-xl group-focus-within:text-primary transition-colors">lock</span>
<input name="password" class="form-input flex w-full rounded-2xl text-[#0f131a] dark:text-white border border-[#d1dae5] dark:border-gray-700 bg-white dark:bg-gray-800 h-14 pl-12 pr-12 placeholder:text-gray-300 text-base font-normal input-focus shadow-sm" placeholder="••••••••" required="" type="password"/>
<span onclick="togglePassword()" class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-[#536d93] text-xl cursor-pointer hover:text-primary transition-colors">visibility</span>
</div>
</div>

<div class="pt-4">
<button class="w-full bg-primary text-white h-14 rounded-2xl font-bold text-lg ios-shadow active:scale-[0.98] transition-all flex items-center justify-center gap-2 hover:bg-primary/95" type="submit">
<span>Masuk Dashboard</span>
<span class="material-symbols-outlined text-xl">login</span>
</button>
</div>
</form>

<div class="mt-8 text-center pb-8">
    <p class="text-[#536d93] dark:text-gray-400 text-sm font-medium">
        Belum punya akun? 
        <a class="text-primary dark:text-primary/90 font-bold ml-1 hover:text-blue-700 transition-colors" href="register.php">Daftar Sekarang</a>
    </p>
</div>



</div>
</div>
<div class="flex justify-center pb-3 pt-4">
<div class="w-32 h-1.5 bg-gray-200 dark:bg-gray-800 rounded-full"></div>
</div>
</div>

<script>
function togglePassword() {
    var x = document.getElementsByName("password")[0];
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>

</body></html>
