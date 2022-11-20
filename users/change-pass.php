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
            <div class="form-group">
                <label for="">New Password</label>
                <input type="password" name="password" id=""
                    class="form-control <?php echo isset($_SESSION['password']) ? 'is-invalid' : '' ?>">
                <small class="invalid-feedback">
                    <?= $_SESSION['password'] ?? '' ?>
                </small>
            </div>
            <div class="form-group">
                <label for="">Confirm Password</label>
                <input type="password" name="cp" id=""
                    class="form-control <?php echo isset($_SESSION['cp']) ? 'is-invalid' : '' ?>">
                <small class="invalid-feedback">
                    <?= $_SESSION['cp'] ?? '' ?>
                </small>
            </div>
            <input type="submit" value="Change Password" class="btn btn-danger" name="change_password">
        </form>
    </div>
</div>
<?php require_once "../utility/util.html";
session_destroy()
?>