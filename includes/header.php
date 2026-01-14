<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sistem Sertifikat</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet"/>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#2b7cee",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101822",
                        "success": "#2ecc71",
                        "warning": "#f39c12"
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                },
            },
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-tap-highlight-color: transparent;
            min-height: 100vh;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        /* Enhanced UI */
        button, a, input {
            transition: all 0.2s ease-in-out;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-[#111418] dark:text-white font-display">
<div class="relative flex min-h-screen w-full flex-col overflow-hidden">

<!-- Top App Bar -->
<header class="flex items-center bg-white dark:bg-background-dark p-4 border-b border-gray-100 dark:border-gray-800 justify-between sticky top-0 z-50">
    <div class="flex size-10 shrink-0 items-center">
        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 border-2 border-primary/20" 
             style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuA22TowYBDUA7SRLETKmAtCIliccGONuM7ZNnIeKWTkJtxdbtAZ5R6RDYVL4CqS_KbEnmNBD3pCOEE4SCRfyP-S9S3MaYTNrUnfIyJT2TDlhOnPhlZR_nvaiIlJetN5na0h5DF94x8daCwwCTg07Lrilc0Fq60yPEgQ2agvQuCMgLVvxt8rGIIJTSWOUMWf0gms6L0ASq8AuZzD-i3DEWPP1Hb3VVct6bws2x9BXITqnkD6JATUFeYg75stps2w6mjvBJYhaY0lI9UV");'>
        </div>
    </div>
    <div class="flex-1 px-3">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-xs text-[#617289] dark:text-gray-400 font-medium leading-none mb-1">Selamat Datang,</p>
                <h2 class="text-[#111418] dark:text-white text-base font-bold leading-tight"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?></h2>
            </div>
            <a href="logout.php" class="text-red-500 hover:text-red-700 font-bold text-sm bg-red-50 dark:bg-red-900/20 px-3 py-1.5 rounded-lg flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">logout</span>
                Keluar
            </a>
        </div>
    </div>
</header>
<main class="flex-1 overflow-y-auto pb-24">
