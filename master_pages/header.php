<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">vBlogs</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $title == "Home" || $title == "Blog" ? "active" : "";  ?>" href="index.php">Home</a>
                    </li>

                    <?php
                    session_start();
                    if (isset($_SESSION['isLoggedIn'])) { ?>

                        <li class="nav-item">
                            <a class="nav-link <?php echo $title == "Add Blog" ? "active" : "";  ?>" href="add_blog.php">Add Blog</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?php echo $title == "My Blogs" || $title == "Edit Blog" ? "active" : "";  ?>" href="my_blogs.php">My Blogs</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?php echo $title == "My Profile" ? "active" : "";  ?>" href="profile.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Log Out</a>
                        </li>

                    <?php } else { ?>

                        <li class="nav-item">
                            <a class="nav-link <?php echo $title == "Log In" ? "active" : "";  ?>" href="login.php">Log In</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $title == "Register" ? "active" : "";  ?>" href="register.php">Register</a>
                        </li>

                    <?php }     ?>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <main style="min-height: 85vh;">



        <?php
        // $a = 15;
        // $b = 13;

        // if ($a > $b) {
        //     echo $a;
        // } else {
        //     echo $b;
        // }

        // echo $a > $b ? "max is $a" : $b;
        ?>