<?php 
http_response_code(403);
require_once __DIR__ ."/../utils/data.php";

$me = $me_data; // For backward compatibility
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>403 Forbidden — <?php echo $me['name']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/style.css">
</head>
<body>
  <?php include '../includes/nav.php'; ?>
  <main class="flex-grow-1 d-flex align-items-center justify-content-center">
    <div class="hero w-100">
      <div class="container">
        <h1>403</h1>
        <p class="lead">Access Forbidden</p>
        <p>You don't have permission to access this resource.</p>
        <a href="/" class="btn btn-light mt-3">Go Home</a>
      </div>
    </div>
  </main>
  <?php include '../includes/footer.php'; ?>
</body>


</html>