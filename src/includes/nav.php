<?php
require_once __DIR__ ."/../utils/data.php";

$me = $me_data; // For backward compatibility
?>


<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand text-white fw-bold" href="/"><?php echo $me['name']; ?></a>
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a class="nav-link" href="/#about">About</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/blog">Blog</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/#contact">Contact</a>
        </li>
    </ul>
  </div>
</nav>