<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Smart Email Submission</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2 class="mb-4 text-primary">📩 Smart Email Submission</h2>

    <form action="/smart-email-system/php-backend/verify_and_store.php" method="post">
        <div class="mb-3">
            <label for="subject" class="form-label">Email Subject</label>
            <input type="text" name="subject" id="subject" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="body" class="form-label">Email Body</label>
            <textarea name="body" id="body" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit Email</button>
        <a href="/smart-email-system/php-backend/view_emails.php" class="btn btn-secondary ms-2">📂 View Submitted Emails</a>
    </form>
</body>
</html>
