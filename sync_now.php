<?php
require_once 'includes/functions.php';

echo "Syncing Database to JSON files...\n";

// Sync Config
$config = getConfig();
syncConfigToJson($config);
echo "Config synced to data/config.json\n";

// Sync Participants
syncParticipantsToJson();
echo "Participants synced to data/participants.json\n";

echo "Done.";
?>
