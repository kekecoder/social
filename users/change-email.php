<?php
session_start();
require_once "../utility/head.html";
require_once "../utility/nav.php";
?>
<h2 class="text-center text-danger">Change Password</h2>
<div class="container-sm">
    <div class="container">
        <?php if (isset($_SESSION['error'])) : ?>
        <div class="alert alert-danger alert-dimissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <p><?= $_SESSION['error'] ?></p>
        </div>
        <?php endif ?>
        <form action="/process/action.php" method="post">
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" id=""
                    class="form-control <?php echo isset($_SESSION['email']) ? 'is-invalid' : '' ?>">
                <small class="invalid-feedback">
                    <?= $_SESSION['email'] ?? '' ?>
                </small>
            </div>
            <input type="submit" value="Update Email" class="btn btn-danger" name="change_email">
        </form>
    </div>
</div>
<?php require_once "../utility/util.html";
session_destroy();
?>