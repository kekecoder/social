<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: users/login.php");
}
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
                <input type="hidden" name="id" value="<?= $_SESSION['id'] ?? null ?>">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" id=""
                    class="form-control <?php echo isset($_SESSION['email']) ? 'is-invalid' : '' ?>">
                <small class="invalid-feedback">
                    <?= $_SESSION['email'] ?? '' ?>
                </small>
            </div>
            <input type="submit" value="Update Email" class="btn btn-danger" name="update_email">
        </form>
    </div>
</div>
<?php require_once "../utility/util.html";
session_destroy()
?>