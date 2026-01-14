<?php
require_once 'includes/functions.php';
requireLogin();

$message = '';
$config = getConfig();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newConfig = [
        'event' => htmlspecialchars($_POST['event']),
        'date' => $_POST['date'],
        'signer' => htmlspecialchars($_POST['signer']),
        'role' => htmlspecialchars($_POST['role']),
        'template' => $_POST['template']
    ];
    
    // Handle Logo Deletion
    if (isset($_POST['delete_logo'])) {
        $logoPath = __DIR__ . '/logo.png';
        if (file_exists($logoPath)) {
            unlink($logoPath);
            $message = 'Logo berhasil dihapus!';
        }
    }

    // Handle Logo Upload
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/';
        $uploadFile = $uploadDir . 'logo.png';
        
        // Validate image
        $check = getimagesize($_FILES['logo']['tmp_name']);
        if ($check !== false) {
            move_uploaded_file($_FILES['logo']['tmp_name'], $uploadFile);
        }
    }

    saveConfig($newConfig);
    $config = $newConfig; // Update current view
    if (empty($message)) {
        $message = 'Pengaturan berhasil disimpan!';
    }
}
?>
<?php include 'includes/header.php'; ?>

<div class="px-4 py-4">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Pengaturan Sertifikat</h1>

    <?php if ($message): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 flex items-center gap-2" role="alert">
            <span class="material-symbols-outlined">check_circle</span>
            <span class="block sm:inline"><?php echo $message; ?></span>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-6" enctype="multipart/form-data">
        
        <!-- Template Selection -->
        <div>
            <label class="block text-lg font-bold text-gray-900 dark:text-white mb-3">Pilih Desain Sertifikat</label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                
                <!-- Classic Template -->
                <label class="cursor-pointer group">
                    <input type="radio" name="template" value="classic" class="peer sr-only" <?php echo ($config['template'] == 'classic') ? 'checked' : ''; ?>>
                    <div class="rounded-xl border-2 p-1 hover:scale-[1.02] transition-all peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-primary/50 border-gray-200 dark:border-gray-700 relative">
                        <!-- Active Badge -->
                        <div class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full p-1 shadow-md hidden peer-checked:block z-10">
                            <span class="material-symbols-outlined text-sm font-bold">check</span>
                        </div>
                        
                        <div class="aspect-[4/3] bg-[#f8f5e6] rounded-lg flex flex-col items-center justify-center p-4 border-double border-4 border-gray-800 text-center">
                            <h3 class="font-serif text-gray-900 font-bold text-lg mb-1">Klasik</h3>
                            <div class="w-16 h-0.5 bg-gray-800 mb-2"></div>
                            <p class="text-[10px] text-gray-600 font-serif">Formal & Tradisional</p>
                        </div>
                        <p class="text-center font-bold text-gray-700 dark:text-gray-300 mt-2">Klasik</p>
                    </div>
                </label>

                <!-- Modern Template -->
                <label class="cursor-pointer group">
                    <input type="radio" name="template" value="modern" class="peer sr-only" <?php echo ($config['template'] == 'modern') ? 'checked' : ''; ?>>
                    <div class="rounded-xl border-2 p-1 hover:scale-[1.02] transition-all peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-primary/50 border-gray-200 dark:border-gray-700 relative">
                         <!-- Active Badge -->
                         <div class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full p-1 shadow-md hidden peer-checked:block z-10">
                            <span class="material-symbols-outlined text-sm font-bold">check</span>
                        </div>

                        <div class="aspect-[4/3] bg-white rounded-lg flex flex-col items-center justify-center p-4 shadow-inner overflow-hidden relative">
                            <div class="absolute top-0 left-0 w-full h-2 bg-blue-500"></div>
                            <div class="absolute bottom-0 right-0 w-16 h-16 bg-blue-100 rounded-tl-full"></div>
                            <h3 class="font-sans text-gray-900 font-bold text-lg z-10">MODERN</h3>
                            <p class="text-[10px] text-gray-500 mt-1 z-10">Clean & Minimalist</p>
                        </div>
                        <p class="text-center font-bold text-gray-700 dark:text-gray-300 mt-2">Modern</p>
                    </div>
                </label>

                <!-- Elegant Template -->
                <label class="cursor-pointer group">
                    <input type="radio" name="template" value="elegant" class="peer sr-only" <?php echo ($config['template'] == 'elegant') ? 'checked' : ''; ?>>
                    <div class="rounded-xl border-2 p-1 hover:scale-[1.02] transition-all peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-primary/50 border-gray-200 dark:border-gray-700 relative">
                         <!-- Active Badge -->
                         <div class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full p-1 shadow-md hidden peer-checked:block z-10">
                            <span class="material-symbols-outlined text-sm font-bold">check</span>
                        </div>

                        <div class="aspect-[4/3] bg-[#1a1a1a] rounded-lg flex flex-col items-center justify-center p-4 border border-yellow-600">
                            <h3 class="font-serif text-yellow-500 font-bold text-lg tracking-widest uppercase">Elegant</h3>
                            <div class="w-8 h-8 border border-yellow-500 rotate-45 mt-2"></div>
                        </div>
                        <p class="text-center font-bold text-gray-700 dark:text-gray-300 mt-2">Elegan</p>
                    </div>
                </label>

                <!-- Geometric Template -->
                <label class="cursor-pointer group">
                    <input type="radio" name="template" value="geometric" class="peer sr-only" <?php echo ($config['template'] == 'geometric') ? 'checked' : ''; ?>>
                    <div class="rounded-xl border-2 p-1 hover:scale-[1.02] transition-all peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-primary/50 border-gray-200 dark:border-gray-700 relative">
                         <!-- Active Badge -->
                         <div class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full p-1 shadow-md hidden peer-checked:block z-10">
                            <span class="material-symbols-outlined text-sm font-bold">check</span>
                        </div>

                        <div class="aspect-[4/3] bg-white rounded-lg flex flex-col items-center justify-center p-4 overflow-hidden relative">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500 rounded-bl-full opacity-50"></div>
                            <div class="absolute bottom-0 left-0 w-20 h-20 bg-pink-500 rounded-tr-full opacity-50"></div>
                            <h3 class="font-display text-gray-800 font-bold text-lg z-10">Geometric</h3>
                        </div>
                        <p class="text-center font-bold text-gray-700 dark:text-gray-300 mt-2">Geometris</p>
                    </div>
                </label>

                <!-- Minimal Template -->
                <label class="cursor-pointer group">
                    <input type="radio" name="template" value="minimal" class="peer sr-only" <?php echo ($config['template'] == 'minimal') ? 'checked' : ''; ?>>
                    <div class="rounded-xl border-2 p-1 hover:scale-[1.02] transition-all peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-primary/50 border-gray-200 dark:border-gray-700 relative">
                         <!-- Active Badge -->
                         <div class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full p-1 shadow-md hidden peer-checked:block z-10">
                            <span class="material-symbols-outlined text-sm font-bold">check</span>
                        </div>

                        <div class="aspect-[4/3] bg-gray-50 rounded-lg flex flex-col items-center justify-center p-4 border border-gray-200">
                            <h3 class="font-sans text-gray-900 font-bold text-lg tracking-tight">Minimal</h3>
                        </div>
                        <p class="text-center font-bold text-gray-700 dark:text-gray-300 mt-2">Minimalis</p>
                    </div>
                </label>

                <!-- Tech Template -->
                <label class="cursor-pointer group">
                    <input type="radio" name="template" value="tech" class="peer sr-only" <?php echo ($config['template'] == 'tech') ? 'checked' : ''; ?>>
                    <div class="rounded-xl border-2 p-1 hover:scale-[1.02] transition-all peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-primary/50 border-gray-200 dark:border-gray-700 relative">
                         <!-- Active Badge -->
                         <div class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full p-1 shadow-md hidden peer-checked:block z-10">
                            <span class="material-symbols-outlined text-sm font-bold">check</span>
                        </div>

                        <div class="aspect-[4/3] bg-black rounded-lg flex flex-col items-center justify-center p-4 overflow-hidden border border-cyan-500 shadow-[0_0_15px_rgba(0,255,255,0.3)]">
                             <h3 class="font-mono text-cyan-400 font-bold text-lg tracking-widest">&lt;TECH&gt;</h3>
                        </div>
                        <p class="text-center font-bold text-gray-700 dark:text-gray-300 mt-2">Teknologi</p>
                    </div>
                </label>

                <!-- Luxury Template -->
                <label class="cursor-pointer group">
                    <input type="radio" name="template" value="luxury" class="peer sr-only" <?php echo ($config['template'] == 'luxury') ? 'checked' : ''; ?>>
                    <div class="rounded-xl border-2 p-1 hover:scale-[1.02] transition-all peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-primary/50 border-gray-200 dark:border-gray-700 relative">
                         <!-- Active Badge -->
                         <div class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full p-1 shadow-md hidden peer-checked:block z-10">
                            <span class="material-symbols-outlined text-sm font-bold">check</span>
                        </div>

                        <div class="aspect-[4/3] bg-[#fdfbf7] rounded-lg flex flex-col items-center justify-center p-4 border-4 border-double border-yellow-700">
                            <h3 class="font-serif text-yellow-800 font-bold text-lg tracking-widest uppercase">Luxury</h3>
                        </div>
                        <p class="text-center font-bold text-gray-700 dark:text-gray-300 mt-2">Mewah</p>
                    </div>
                </label>

                <!-- Vintage Template -->
                <label class="cursor-pointer group">
                    <input type="radio" name="template" value="vintage" class="peer sr-only" <?php echo ($config['template'] == 'vintage') ? 'checked' : ''; ?>>
                    <div class="rounded-xl border-2 p-1 hover:scale-[1.02] transition-all peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-primary/50 border-gray-200 dark:border-gray-700 relative">
                         <!-- Active Badge -->
                         <div class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full p-1 shadow-md hidden peer-checked:block z-10">
                            <span class="material-symbols-outlined text-sm font-bold">check</span>
                        </div>

                        <div class="aspect-[4/3] bg-[#fdf5e6] rounded-lg flex flex-col items-center justify-center p-4 border-[6px] border-[#8b4513]">
                             <h3 class="font-serif text-[#8b4513] font-bold text-xl" style="font-family: 'Times New Roman', serif;">Vintage</h3>
                        </div>
                        <p class="text-center font-bold text-gray-700 dark:text-gray-300 mt-2">Klasik Tua</p>
                    </div>
                </label>

            </div>
        </div>

        <div class="h-px bg-gray-200 dark:bg-gray-700 my-6"></div>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Acara / Kegiatan</label>
                <input type="text" name="event" value="<?php echo $config['event']; ?>" required
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-primary focus:ring-primary shadow-sm">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Sertifikat</label>
                <input type="date" name="date" value="<?php echo $config['date']; ?>" required
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-primary focus:ring-primary shadow-sm">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Penandatangan</label>
                <input type="text" name="signer" value="<?php echo $config['signer']; ?>" required
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-primary focus:ring-primary shadow-sm">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jabatan Penandatangan</label>
                <input type="text" name="role" value="<?php echo $config['role']; ?>" required
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-primary focus:ring-primary shadow-sm">
            </div>

            <!-- Logo Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Logo Instansi (Wajib Transparan/PNG)</label>
                <div class="flex items-center gap-4">
                    <?php if (file_exists(__DIR__ . '/logo.png')): ?>
                        <div class="relative group">
                            <div class="p-2 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800">
                                <img src="logo.png?v=<?php echo time(); ?>" alt="Current Logo" class="h-16 w-16 object-contain">
                            </div>
                            <button type="submit" name="delete_logo" value="1" onclick="return confirm('Apakah Anda yakin ingin menghapus logo?')" 
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition-opacity" title="Hapus Logo">
                                <span class="material-symbols-outlined text-xs">close</span>
                            </button>
                        </div>
                    <?php else: ?>
                         <div class="p-2 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 flex items-center justify-center w-16 h-16 text-gray-400">
                            <span class="material-symbols-outlined">image_not_supported</span>
                        </div>
                    <?php endif; ?>

                    <input type="file" name="logo" accept="image/png, image/jpeg"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
                <p class="text-xs text-gray-500 mt-1">Disarankan menggunakan file PNG transparan (Tanpa background).</p>
            </div>
        </div>
        
        <div class="pt-4 pb-20">
            <button type="submit" 
                    class="w-full bg-primary text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-primary/30 hover:bg-blue-600 active:scale-95 transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined">save</span>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
