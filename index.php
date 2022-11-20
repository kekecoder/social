<?php
session_start();
require_once('process/dblib.php');
$conn = db();
$limit = 6;
$query = "SELECT * FROM stories";
$result = mysqli_query($conn, $query);
$total_rows = mysqli_num_rows($result);

$total_pages = ceil($total_rows / $limit);

if (!isset($_GET['page'])) {
    $page_num = 1;
} else {
    $page_num = $_GET['page'];
}

$initial_page = ($page_num - 1) * $limit;
$query = "SELECT * FROM stories ORDER BY created_at DESC LIMIT $initial_page, $limit";
$result = mysqli_query($conn, $query);
$rows = $result->fetch_all(MYSQLI_ASSOC);

// while ($rows = mysqli_fetch_array($result)) {
//     echo $rows['story'];
// }

$error_msg = [];
$success = [];
require_once 'process/dblib.php';
require_once 'process/randomString.php';
$story_ids = [
    'stories' => "",
    'id' => ''
];
$story = "";
if (isset($_GET['id'])) {
    $story_ids = get_story_id($_GET['id']);
}

if (isset($_POST['submit'])) {
    $story = trim(htmlspecialchars(($_POST['stories']), ENT_QUOTES));
    $date = date('Y-m-d H:i');
    $id = $_POST['id'] ?? '';

    if (empty($story)) {
        $error_msg['stories'] = "This field cannot be empty";
    } else if (strlen($story) <= 1) {
        $error_msg['stories'] = "String is too low";
    }

    if (empty($error_msg)) {
        if (isset($_FILES['upload_img']) && isset($_FILES['error']) == 0) {
            $allowed_img = [
                'jpg' => 'image/jpg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
            ];

            $file_name = $_FILES['upload_img']['name'];
            $file_type = $_FILES['upload_img']['type'];
            $file_size = $_FILES['upload_img']['size'];

            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            if (!array_key_exists($ext, $allowed_img)) {
                $error_msg['upload_img'] = "Please select a valid file format.";
            }

            $max_size = 5 * 1024 * 1024;
            if ($file_size >= $max_size) {
                $error_msg['upload_img'] = "Error: The filesize is too large, your file should not be more than 5MB";
            }

            if (in_array($file_type, $allowed_img)) {
                // $img_path = random_string(10) . str_replace(" ", " ", basename($_FILES["upload_img"]["name"]));
                $img_path = random_string(10) . "." . $ext;

                move_uploaded_file($_FILES['upload_img']['tmp_name'], "image/" . $img_path);
            }
        }
        if ($id) {
            $query = update_story($id, $story);
            if ($query->affected_rows === 1) {
                $success[] = "Story Updated";
            }
            $story_ids = [];
            // header("Location: /");
        } else {
            $query = insert($story, $date, $img_path ?? null);
            if ($query->affected_rows === 1) {
                $success[] = "Story Successfully posted";
            } else {
                $error_msg[] = "Something went wrong";
            }
            $story = "";
        }
    }
}

// Handle Delete
if (isset($_POST['delete'])) {
    delete_story($_POST['id']);
    header("Location: /");
}

// All stories
// $rows = get_all_story();
// using pagination
require_once "utility/head.html";
require_once "utility/nav.php"
?>
<?php
if (isset($_SESSION['success'])) : ?>
<div class="alert alert-success alert-dimissible fade show">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <p><?= $_SESSION['success'] ?></p>
    <?php unset($_SESSION['success']) ?>
</div>
<?php endif ?>
<div class="jumbotron jumbotron-fluid">
    <div class="container text-center">
        <h1 class="display">Welcome <?php echo (isset($_SESSION['username'])) ? ucfirst($_SESSION['username']) : '' ?>
        </h1>
        <p class="lead">This is your personal Page</p>
    </div>
</div>
<div class="container">
    <?php
    if (isset($success)) : ?>
    <?php foreach ($success as $pass) : ?>
    <div class="alert alert-success alert-dimissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <p><?= $pass ?></p>
    </div>
    <?php endforeach ?>
    <?php endif ?>
    <?php if (isset($_SESSION['username'])) : ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <input type="hidden" name="id" value="<?php foreach ($story_ids as $story_id) {
                                                            echo $story_id['id'] ?? '';
                                                        } ?>">
        </div>
        <div class="form-group">
            <label for="post">Create Post</label>
            <textarea name="stories"
                class="form-control <?php echo isset($error_msg['stories']) ? 'is-invalid' : '' ?>"><?php foreach ($story_ids as $story_id) {
                                                                                                                                    echo $story_id['story'] ?? '';
                                                                                                                                } ?></textarea>
            <small class="invalid-feedback">
                <?= $error_msg['stories'] ?? "" ?>
            </small>
        </div>
        <div class="row">
            <div class="form-group d-flex">
                <div class="col-6">
                    <input type="file" name="upload_img"
                        class="<?php echo isset($error_msg['upload_img']) ? 'is-invalid' : '' ?>">
                    <small class="invalid-feedback">
                        <?= $error_msg['upload_img'] ?? "" ?>
                    </small>
                </div>
                <div class="col-6 mls">
                    <?php if (isset($_GET['id'])) : ?>
                    <input type="submit" name="submit" value="Update Post" class="btn btn-outline-primary btn-sm">
                    <?php else : ?>
                    <input type="submit" name="submit" value="Create Post" class="btn btn-outline-danger btn-sm">
                    <?php endif ?>
                </div>
            </div>
        </div>
    </form>
    <?php else : ?>
    <p class="lead text-center">Please <a href="users/login.php">login</a> to make a post or <a
            href="users/login.php">register</a>
        an account
    </p>
    <?php endif ?>
</div>
</div>
<div class="container mt-3 mb-3">
    <?php if (count($rows) === 0) : ?>
    <?= "No Stories" ?>
    <?php endif ?>
    <?php foreach ($rows as $row) : ?>
    <div class="card mb-3" style="width: 100%;">
        <?php if (isset($row['image_path'])) : ?>
        <img class="card-img-top" src="image/<?= $row['image_path'] ?>" alt="">
        <?php else : ?>
        <img class="card-img-top" src="" alt="">
        <?php endif ?>
        <div class='card-body bg-secondary text-white'>
            <p class='card-text'>
                <?= $row['story'] ?>
            </p>
            <div class='card-footer'>
                <div class='row'>
                    <div class='col'>
                        <a href="index.php?id=<?= $row['id'] ?>" class='btn btn-primary'>Edit</a>
                    </div>
                    <div class='col'>
                        <form action="" method="post" class="d-inline fml">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input name="delete" type="submit" class="btn btn-danger" value="Delete">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php endforeach ?>
    <nav>
        <ul class="pagination">
            <?php
            for ($page_num = 1; $page_num <= $total_pages; $page_num++) {
                echo '<li class = "page-item"><a class = "page-link" href="index.php?page=' . $page_num . '">' . $page_num . '</a></li>';
            }
            ?>
        </ul>
    </nav>

</div>
<?php require_once "utility/util.html" ?>
</body>

</html>