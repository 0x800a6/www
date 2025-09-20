<?php 
http_response_code(404);
require_once __DIR__ ."/../utils/data.php";

$me = $me_data; // For backward compatibility
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    $title = "404 Not Found";
    $description = "The page you're looking for doesn't exist.";
    include '../includes/seo.php';
    ?>
    <link href="/static/css/bootstrap.min.css" rel="stylesheet">
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