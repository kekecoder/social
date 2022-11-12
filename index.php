<?php
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
                $img_path = random_string(10) . str_replace(" ", " ", basename($_FILES["upload_img"]["name"]));

                move_uploaded_file($_FILES['upload_img']['tmp_name'], "image/" . $img_path);
            }
        }
        if ($id) {
            $query = update_story($id, $story);
            if ($query->affected_rows === 1) {
                $success[] = "Story Updated posted";
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
$rows = get_all_story();

// <?php echo $story ?? "" 
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Dashboard</title>
</head>

<body>
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
                <li class="nav-item">
                    <a class="nav-link" href="#">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-3">
        <div class="jumbotron jumbotron-fluid">
            <div class="container text-center">
                <h1 class="display">Welcome User</h1>
                <p class="lead">This is your personal Page</p>
            </div>
        </div>
        <div class="container">
            <?php
            if (isset($success)) : ?>
            <?php foreach ($success as $pass) : ?>
            <div class="alert alert-success">
                <?= $pass ?>
            </div>
            <?php endforeach ?>
            <?php endif ?>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="upload_img">
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
                            <!-- <input type="file" name="upload_img"> -->
                        </div>
                        <div class="col-6 ml-3">
                            <?php if (isset($_GET['id'])) : ?>
                            <input type="submit" name="submit" value="Update Post"
                                class="btn btn-outline-primary btn-sm">
                            <?php else : ?>
                            <input type="submit" name="submit" value="Create Post"
                                class="btn btn-outline-danger btn-sm">
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="container mt-3 mb-3">
        <?php if (count($rows) === 0) : ?>
        <?= "No Stories" ?>
        <?php endif ?>
        <?php foreach ($rows as $row) : ?>
        <div class='card-body bg-secondary text-white mb-4'>
            <p class='card-text'>
                <?= $row['story'] ?>
            </p>
            <div class='card-footer'>
                <div class='row'>
                    <div class='col'>
                        <a href="index.php?id=<?= $row['id'] ?>" class='btn btn-primary'>Edit</a>
                    </div>
                    <div class='col'>
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input name="delete" type="submit" class="btn btn-danger" value="Delete">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach ?>
    </div>
    <script src=" js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>