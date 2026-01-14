</main>

<!-- Bottom Navigation -->
<nav class="fixed bottom-0 left-0 right-0 bg-white/80 dark:bg-background-dark/80 backdrop-blur-md border-t border-gray-100 dark:border-gray-800 h-20 px-6 flex items-start justify-between z-50">
    <a href="index.php" class="flex flex-col items-center justify-center w-16 pt-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'text-primary' : 'text-[#617289]'; ?> nav-item">
        <span class="material-symbols-outlined">dashboard</span>
        <span class="text-[10px] font-bold mt-1">Dashboard</span>
    </a>
    <a href="participants.php" class="flex flex-col items-center justify-center w-16 pt-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'participants.php') ? 'text-primary' : 'text-[#617289]'; ?> nav-item">
        <span class="material-symbols-outlined">groups</span>
        <span class="text-[10px] font-medium mt-1">Peserta</span>
    </a>
    <a href="admin.php" class="flex flex-col items-center justify-center w-16 pt-3 <?php echo (basename($_SERVER['PHP_SELF']) == 'admin.php') ? 'text-primary' : 'text-[#617289]'; ?> nav-item">
        <span class="material-symbols-outlined">settings</span>
        <span class="text-[10px] font-medium mt-1">Pengaturan</span>
    </a>
</nav>

</div>
</body>
</html>
