<?php
require_once 'includes/functions.php';
requireLogin(); // Protect this page

$participants = getParticipants();
$totalParticipants = count($participants);
$recentParticipants = array_slice(array_reverse($participants), 0, 3);
?>
<?php include 'includes/header.php'; ?>

    <!-- Statistics Section -->
    <div class="p-4">
        <div class="grid grid-cols-1 gap-3">
            <!-- Total Certified -->
            <div class="rounded-xl p-4 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-1">
                    <p class="text-[#617289] dark:text-gray-400 text-sm font-medium">Total Peserta Terdaftar</p>
                    <span class="material-symbols-outlined text-primary text-xl">verified</span>
                </div>
                <p class="text-[#111418] dark:text-white tracking-tight text-3xl font-bold leading-tight stat-number">
                    <?php echo number_format($totalParticipants); ?>
                </p>
                <p class="text-green-600 text-xs font-bold mt-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-xs">trending_up</span> Aktif Saat Ini
                </p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="px-4 py-3">
        <a href="participants.php" 
           class="flex w-full cursor-pointer items-center justify-center overflow-hidden rounded-xl h-14 px-5 bg-primary text-white gap-3 shadow-lg shadow-primary/20 active:scale-[0.98] transition-transform">
            <span class="material-symbols-outlined">group_add</span>
            <span class="truncate font-bold text-base">Kelola Peserta</span>
        </a>
    </div>

    <!-- Customize Certificate -->
    <div class="px-4 py-2">
        <div class="flex items-stretch justify-between gap-4 rounded-xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-100 dark:border-gray-700 card-hover">
            <div class="flex flex-[3_3_0px] flex-col justify-between">
                <div class="flex flex-col gap-1">
                    <p class="text-[#111418] dark:text-white text-base font-bold leading-tight">Pengaturan Sertifikat</p>
                    <p class="text-[#617289] dark:text-gray-400 text-xs font-normal leading-normal">Ubah nama acara, tanggal, dan penanda tangan.</p>
                </div>
                <a href="admin.php" 
                   class="flex items-center justify-center rounded-lg h-9 px-4 mt-4 bg-blue-100 text-blue-700 gap-2 text-sm font-bold w-fit">
                    <span class="material-symbols-outlined text-sm">edit</span>
                    <span>Edit Sekarang</span>
                </a>
            </div>
            <!-- Decorative Image -->
            <div class="w-24 h-24 bg-center bg-no-repeat bg-cover rounded-lg flex-1 border border-gray-100 dark:border-gray-700 shadow-inner" 
                 style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAU4kEICAgGFeQQwfm15AYNfjwY9XlR3YvNbA4QqL6OB8UnS3xUrZY82rDawdNMkFJVmQ2a_QGgXao0qQJsW-MYfWIiFNcORuYs2Pgu1an1C1r3BYNgL8PANTkWolmCihK2lUTpGV3jV2xBQoWTCUe96WmplNMFzU4rvvNtyUTY1xeEbQIvdJKQpST3OoyBqEJ6hi8QckWkDilnEicdFWcJDEpOf04W_6zpRzayDZAueJc7FZxZm48dMHNO8GpxWSp67Wf05bxtUchA");'>
            </div>
        </div>
    </div>

    <!-- Recent Participants -->
    <div class="px-4 pt-6">
        <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-tight mb-4">Peserta Terbaru</h2>
        <div class="space-y-3">
            <?php foreach ($recentParticipants as $p): ?>
            <div class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="size-10 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-primary font-bold">
                    <?php echo strtoupper(substr($p['name'], 0, 2)); ?>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-[#111418] dark:text-white"><?php echo htmlspecialchars($p['name']); ?></p>
                    <p class="text-xs text-[#617289] dark:text-gray-400"><?php echo htmlspecialchars($p['email']); ?></p>
                </div>
                <a href="certificate.php?id=<?php echo $p['id']; ?>" target="_blank" class="status-badge bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300 decoration-0">
                    LIHAT
                </a>
            </div>
            <?php endforeach; ?>
            
            <?php if (empty($recentParticipants)): ?>
                <p class="text-sm text-gray-500 text-center py-4">Belum ada peserta.</p>
            <?php endif; ?>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>
