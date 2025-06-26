<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $index = (int) $_POST["index"];
    $newLabel = trim($_POST["label"]);

    // Load all rows
    $rows = [];
    if (($file = fopen(EMAIL_CSV, "r")) !== false) {
        while (($row = fgetcsv($file)) !== false) {
            $rows[] = $row;
        }
        fclose($file);
    }

    // Update label in the correct row
    if (isset($rows[$index]) && count($rows[$index]) >= 5) {
        $rows[$index][4] = $newLabel;

        // Save back to CSV
        $file = fopen(EMAIL_CSV, "w");
        foreach ($rows as $row) {
            fputcsv($file, $row);
        }
        fclose($file);

        // ✅ Trigger re-training (fixed command)
        $command = "python ../python/email_classifier.py train 2>&1";
        $output = shell_exec($command);
        // Optional: file_put_contents("log.txt", $output); // for debugging
    }

    // Redirect back to view page
    header("Location: view_emails.php");
    exit;
}
?>
