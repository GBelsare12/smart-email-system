<?php
require_once "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submitted Emails</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">

    <h2 class="mb-4 text-primary">📧 Submitted Emails</h2>

    <?php
    $file = fopen(EMAIL_CSV, "r");
    if ($file) {
        $header = fgetcsv($file);

        echo "<table class='table table-bordered table-striped'>";
        echo "<thead class='table-dark'><tr>";
        foreach ($header as $col) {
            echo "<th>" . htmlspecialchars(ucfirst($col)) . "</th>";
        }
        echo "</tr></thead><tbody>";

        $hasData = false;
        while (($row = fgetcsv($file)) !== false) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>";
            $hasData = true;
        }

        if (!$hasData) {
            echo "<tr><td colspan='" . count($header) . "' class='text-center'>No email submissions yet.</td></tr>";
        }

        echo "</tbody></table>";
        fclose($file);
    } else {
        echo "<p class='text-danger'>❌ Unable to read emails.csv</p>";
    }
    ?>

    <a href="/smart-email-system/frontend/index.php" class="btn btn-primary mt-3">⬅ Back to Form</a>

</body>
</html>
