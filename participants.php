<?php
require_once 'includes/functions.php';
requireLogin();

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $affiliation = htmlspecialchars($_POST['affiliation']);
        if ($name && $email) {
            if (addParticipant($name, $email, $affiliation)) {
                $message = 'Peserta berhasil ditambahkan!';
            } else {
                $message = 'Gagal menambahkan peserta.';
            }
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        if (deleteParticipant($id)) {
            $message = 'Peserta berhasil dihapus!';
        } else {
            $message = 'Gagal menghapus peserta.';
        }
    }
}

$participants = getParticipants();
?>
<?php include 'includes/header.php'; ?>

<div class="px-4 py-4">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Daftar Peserta</h1>

    <?php if ($message): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo $message; ?></span>
        </div>
    <?php endif; ?>

    <!-- Add Participant Form -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 mb-6">
        <h2 class="text-lg font-bold mb-3 text-gray-900 dark:text-white">Tambah Peserta Baru</h2>
        <form method="POST" class="space-y-4">
            <div>
                <input type="text" name="name" placeholder="Nama Lengkap" required
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-primary focus:ring-primary shadow-sm">
            </div>
            <div>
                <input type="text" name="affiliation" placeholder="Asal Instansi" required
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-primary focus:ring-primary shadow-sm">
            </div>
            <div>
                <input type="email" name="email" placeholder="Alamat Email" required
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-primary focus:ring-primary shadow-sm">
            </div>
            <button type="submit" name="add"
                    class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow hover:bg-blue-700 active:scale-95 transition-all">
                <span class="material-symbols-outlined align-middle text-sm mr-1">add_circle</span>
                Tambah
            </button>
        </form>
    </div>

    <!-- Participants List -->
    <div class="space-y-3 pb-20">
        <?php foreach ($participants as $p): ?>
        <div class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <div class="size-10 rounded-full bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 font-bold shrink-0">
                <?php echo strtoupper(substr($p['name'], 0, 1)); ?>
            </div>
            
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-[#111418] dark:text-white truncate"><?php echo htmlspecialchars($p['name']); ?></p>
                <div class="flex flex-col">
                     <?php if(!empty($p['affiliation'])): ?>
                        <p class="text-xs text-indigo-600 dark:text-indigo-400 font-medium truncate"><?php echo htmlspecialchars($p['affiliation']); ?></p>
                    <?php endif; ?>
                    <p class="text-xs text-[#617289] dark:text-gray-400 truncate"><?php echo htmlspecialchars($p['email']); ?></p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <a href="certificate.php?id=<?php echo $p['id']; ?>" target="_blank" 
                   class="size-8 flex items-center justify-center text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-300"
                   title="Lihat Sertifikat">
                    <span class="material-symbols-outlined text-lg">visibility</span>
                </a>

                <a href="certificate.php?id=<?php echo $p['id']; ?>&action=print" target="_blank" 
                   class="size-8 flex items-center justify-center text-gray-600 bg-gray-50 rounded-lg hover:bg-gray-100 dark:bg-gray-700/50 dark:text-gray-300"
                   title="Cetak PDF">
                    <span class="material-symbols-outlined text-lg">print</span>
                </a>
                
                <form method="POST" onsubmit="return confirm('Hapus peserta ini?');">
                    <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                    <button type="submit" name="delete"
                            class="size-8 flex items-center justify-center text-red-600 bg-red-50 rounded-lg hover:bg-red-100 dark:bg-red-900/30 dark:text-red-300">
                        <span class="material-symbols-outlined text-lg">delete</span>
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
        
        <?php if (empty($participants)): ?>
            <div class="text-center py-10 text-gray-500">
                <span class="material-symbols-outlined text-4xl mb-2">sentiment_dissatisfied</span>
                <p>Belum ada peserta.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
