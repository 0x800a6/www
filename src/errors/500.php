<?php 
http_response_code(500);
require_once __DIR__ ."/../utils/data.php";

$me = $me_data; // For backward compatibility
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <?php 
    $title = "500 Internal Server Error";
    $description = "The server encountered an internal error or misconfiguration.";
    include '../includes/seo.php';
    ?>
    <link href="/static/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/style.css">
</head>
<body>
<?php include '../includes/nav.php'; ?>
    <div class="hero">
        <div class="container">
            <h1>500</h1>
            <p class="lead">Internal Server Error</p>
            <p>The server encountered an internal error or misconfiguration and was unable to complete your request.</p>
            <p>
                Please contact the server administrator at <a href="mailto:<?php echo $me['server']['server_email']; ?>"><?php echo $me['server']['server_email']; ?></a> to inform them of the time this error occurred, and the actions you performed just before this error.
            </p>
            <p>
                More information about this error may be available in the server error log.
            </p>
            <a href="/" class="btn btn-light mt-3">Go Home</a>
        </div>
    </div>
<?php include '../includes/footer.php'; ?>
</body>
</html>