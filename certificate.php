<?php
require_once 'includes/functions.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$participant = getParticipant($id);

if (!$participant) {
    echo "Peserta tidak ditemukan.";
    exit;
}

$config = getConfig();
$template = isset($config['template']) ? $config['template'] : 'classic';

$name = $participant['name'];
$event = $config['event'];
$signer = $config['signer'];
$role = $config['role'];

// Format date
$dateInput = $config['date'];
$dateObj = new DateTime($dateInput);
$months = [
    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
];
$monthNum = $dateObj->format('m');
$dateFormatted = $dateObj->format('d') . ' ' . $months[$monthNum] . ' ' . $dateObj->format('Y');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat - <?php echo $name; ?></title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Segoe+UI:wght@400;700;900&family=Poppins:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body class="cert-body-page">

    <div class="print-actions">
        <button onclick="window.print()">Cetak / Simpan PDF</button>
        <button onclick="window.close()">Tutup</button>
    </div>

    <?php if (isset($_GET['action']) && $_GET['action'] == 'print'): ?>
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
    <?php endif; ?>

    <!-- Theme Container -->
    <div class="cert-container theme-<?php echo $template; ?>">
        
        <?php if ($template == 'modern'): ?>
            <div class="cert-bg-accent"></div>
        <?php endif; ?>
        
        <?php if ($template == 'elegant'): ?>
            <div class="cert-border"></div>
        <?php endif; ?>

        <?php if ($template == 'geometric'): ?>
            <div class="cert-bg-accent"></div>
        <?php endif; ?>

        <div class="cert-content">
            <!-- Institution Logo -->
            <!-- Institution Logo -->
            <?php if (file_exists('logo.png')): ?>
             <img src="logo.png" class="cert-logo" alt="Institution Logo">
            <?php endif; ?>

            <div class="cert-header">Sertifikat Penghargaan</div>
            
            <div class="cert-subheader">Diberikan kepada:</div>
            
            <div class="cert-name"><?php echo $name; ?></div>
            
            <?php if (!empty($participant['affiliation'])): ?>
                <p class="cert-body" style="margin-top: -15px; margin-bottom: 20px; font-weight: bold; opacity: 0.8;">
                    <?php echo htmlspecialchars($participant['affiliation']); ?>
                </p>
            <?php endif; ?>
            
            <div class="cert-body">
                Atas partisipasinya dalam acara:<br>
                <strong><?php echo $event; ?></strong><br><br>
                Pada Tanggal: <?php echo $dateFormatted; ?>
            </div>
            
            <div class="cert-footer">
                <div class="signature-block">
                    <!-- Signature Lines -->
                    <?php if ($template == 'modern'): ?>
                        <div style="width: 200px; border-top: 2px solid #333; margin-bottom: 10px;"></div>
                    <?php elseif ($template == 'geometric'): ?>
                        <div style="width: 150px; border-top: 4px solid #8e44ad; margin: 0 auto 10px;"></div>
                    <?php elseif ($template == 'tech'): ?>
                        <div style="width: 150px; border-top: 1px dashed #58a6ff; margin: 0 auto 10px;"></div>
                    <?php elseif ($template == 'luxury'): ?>
                        <div style="width: 200px; border-top: 1px solid #8d6e63; margin: 0 auto 10px;"></div>
                    <?php elseif ($template == 'vintage'): ?>
                        <div style="width: 220px; border-top: 1px solid #8b4513; margin: 0 auto 10px;"></div>
                    <?php elseif ($template == 'minimal'): ?>
                         <!-- No line for minimal, just text -->
                    <?php else: ?>
                        <br><br>
                    <?php endif; ?>
                    
                    <strong><?php echo $signer; ?></strong><br>
                    <?php echo $role; ?>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
