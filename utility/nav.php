<?php
session_regenerate_id();
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <?php if (!isset($_SESSION['username'])) : ?>
            <li class="nav-item">
                <a class="nav-link" href="/users/register.php">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link">Login</a>
            </li>
            <?php endif ?>
            <li class="nav-item">
                <a class="nav-link" href="#">Profile</a>
            </li>
            <li class="nav-item">
                <form action="../process/action.php" method="post">
                    <input type="hidden" name="id" value="<?= $_SESSION['id'] ?>">
                    <input type="submit" value="Logout" class="btn btn-outline-danger">
                </form>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-3">