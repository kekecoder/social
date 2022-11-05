<?php
$error_msg = [];
$success = [];
require_once 'process/dbconfig.php';

// $date = date('Y-m-d H:i');
// echo $date;
// exit;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $story = $_POST['stories'];
    $date = date('Y-m-d H:i');
    if (empty($story)) {
        $error_msg['stories'] = "This field cannot be empy";
    }

    if (empty($error_msg)) {
        $query = $conn->prepare("INSERT INTO stories(story, created_at) VALUES(?, '$date');");
        $query->bind_param("s", $story);
        $query->execute();
        if ($query->affected_rows === 1) {
            $success[] = "Story Successfully posted";
        }
        $query->close();
    }
}

$query = "SELECT * FROM stories ORDER BY created_at DESC";
$result = $conn->query($query);
$rows = $result->fetch_all(MYSQLI_ASSOC);
// echo '<pre>';
// var_dump($rows);
// echo '</pre>';
// exit;
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
        <div class="container-fluid">
            <?php
            if (isset($success)) : ?>
            <?php foreach ($success as $pass) : ?>
            <div class="alert alert-success">
                <?= $pass ?>
            </div>
            <?php endforeach ?>
            <?php endif ?>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="post">Create Post</label>
                    <textarea name="stories"
                        class="form-control <?php echo isset($error_msg['stories']) ? 'is-invalid' : '' ?>"></textarea>
                </div>
                <div class="row">
                    <div class="form-group d-flex">
                        <div class="col-6">
                            <input type="file" name="upload_img">
                        </div>
                        <div class="col ml-3">
                            <button class="btn btn-outline-danger btn-sm">Create Post</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="container-fluid mt-3 mb-3">
        <?php if ($result->num_rows > 0) : ?>
        <?php foreach ($rows as $row) : ?>
        <div class="card-body bg-secondary text-white mb-4">
            <p class="card-text">
                <?= $row['story'] ?>
            </p>
            <div class="card-footer">
                <div class="row">
                    <div class="col">
                        <button class="btn btn-primary">Edit</button>
                    </div>
                    <div class="col">
                        <button class="btn btn-danger ml-5">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach ?>
        <?php endif ?>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>