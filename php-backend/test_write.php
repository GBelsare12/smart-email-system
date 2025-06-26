<?php
$file_path = __DIR__ . "/data/emails.csv";

echo "🟡 Trying to write to: $file_path<br>";

$file = fopen($file_path, "a");

if ($file) {
    echo "🟢 File opened successfully.<br>";
    $row = ["Test Subject", "Test Body", date("Y-m-d H:i:s")];
    fputcsv($file, $row);
    fclose($file);
    echo "✅ Write completed successfully!<br>";
} else {
    echo "❌ Failed to open the file. Check permissions.<br>";
}
?>
