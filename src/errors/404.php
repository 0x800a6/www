<?php 
http_response_code(404);
require_once __DIR__ ."/../utils/data.php";

$me = $me_data; // For backward compatibility
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 Not Found — <?php echo $me['name']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/style.css">
</head>
<body>
<?php include '../includes/nav.php'; ?>
    <div class="hero">
        <div class="container">
            <h1>404</h1>
            <p class="lead">Page Not Found</p>
            <p>The page you're looking for doesn't exist or has been moved.</p>
            <a href="/" class="btn btn-light mt-3">Go Home</a>
        </div>
    </div>
<?php include '../includes/footer.php'; ?>
</body>
</html>