<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Dashboard</title>
</head>
<style>
textarea {
    height: 120px !important;
    resize: none;
}

@media only screen and (min-width: 768px) {
    textarea {
        width: 65% !important;
        margin: 0 auto;
        height: 190px !important;
    }

    label {
        margin-left: 116px;
    }
}

@media only screen and (min-width: 992px) {
    textarea {
        width: 65% !important;
        margin: 0 auto;
        height: 190px !important;
    }

    label {
        margin-left: 190px;
    }
}
</style>

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
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="post">Create Post</label>
                    <textarea name="" class="form-control"></textarea>
                </div>
                <div class="row">
                    <div class="form-group d-flex">
                        <div class="col-6">
                            <input type="file" class="">
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
        <div class="card-body bg-secondary text-white mb-4">
            <p class="card-text">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias quia veniam placeat deleniti culpa
                accusamus ut dolorem quas tempore eius mollitia ab exercitationem unde nesciunt ad voluptates iusto,
                doloremque aspernatur.
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
        <div class="card-body bg-secondary text-white mb-4">
            <p class="card-text">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias quia veniam placeat deleniti culpa
                accusamus ut dolorem quas tempore eius mollitia ab exercitationem unde nesciunt ad voluptates iusto,
                doloremque aspernatur.
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
        <div class="card-body bg-secondary text-white mb-4">
            <p class="card-text">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias quia veniam placeat deleniti culpa
                accusamus ut dolorem quas tempore eius mollitia ab exercitationem unde nesciunt ad voluptates iusto,
                doloremque aspernatur.
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
        <div class="card-body bg-secondary text-white mb-4">
            <p class="card-text">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias quia veniam placeat deleniti culpa
                accusamus ut dolorem quas tempore eius mollitia ab exercitationem unde nesciunt ad voluptates iusto,
                doloremque aspernatur.
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
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>