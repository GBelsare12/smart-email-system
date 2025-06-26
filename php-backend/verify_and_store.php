<?php
require_once "config.php";

function isValidEmailContent($subject, $body) {
    return strlen($subject) > 3 && strlen($body) > 5;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $subject = trim($_POST["subject"]);
    $body = trim($_POST["body"]);

    if (isValidEmailContent($subject, $body)) {
        $timestamp = date("Y-m-d H:i:s");
        $status = "new";

        // Call the Python AI classifier
        $escapedSubject = escapeshellarg($subject);
        $escapedBody = escapeshellarg($body);
        $command = "python ../python/email_classifier.py $escapedSubject $escapedBody";
        $label = trim(shell_exec($command));

        // Append to CSV
        $row = [$subject, $body, $timestamp, $status, $label];
        $file = fopen(EMAIL_CSV, "a");
        if ($file) {
            fputcsv($file, $row);
            fclose($file);
            echo "<p>✅ Email submitted, classified as '<strong>$label</strong>', and saved!</p>";
        } else {
            echo "<p>❌ Error: Unable to write to file.</p>";
        }
    } else {
        echo "<p>❌ Invalid subject or body content.</p>";
    }

    echo "<p><a href='/smart-email-system/frontend/index.php'>⬅ Back to Form</a></p>";
} else {
    echo "<p>❌ Invalid request method.</p>";
}
?>
