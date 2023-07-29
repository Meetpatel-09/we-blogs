<?php

require_once "config.php";
$title = "Add Blog";
include("master_pages/header.php");

if (!isset($_SESSION['isLoggedIn'])) {
    header("location: login.php");
}

$title_error = $desc_error = $fdesc_error = $image_error = "";

$title = $desc = $fdesc = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty(trim($_POST['title']))) {
        $title_error = "Please Enter Title";
    } else {
        $title = $_POST['title'];
    }

    if (empty(trim($_POST['desc']))) {
        $desc_error = "Please Enter Description";
    } else {
        $desc = $_POST['desc'];
    }

    if (empty(trim($_POST['fdesc']))) {
        $fdesc_error = "Please Enter Full Description";
    } else {
        $fdesc = $_POST['fdesc'];
    }

    if (!isset($_FILES['image'])) {
        $image_error = "Please selete image";
    } else {
        $image_name = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $type = $_FILES['image']['type'];
        echo $image_name . "<br />" . $image_size . "<br />" . $tmp_name . "<br />";
        if ($type == "image/jpg" || $type == "image/webp" || $type == "image/jpeg" || $type == "image/png" || $type == "image/jpe" || $type == "image/jfif") {
        } else {
            $image_error = "Valid extensions .jpg, .jpeg, .png, .jpe, .jifi";
        }
        // $image_error = "ff";
        // echo "<pre>";
        // print_r($_FILES);
        // echo "</pre>";
    }



    if (empty($title_error) and empty($desc_error) and empty($fdesc_error) and empty($image_error)) {

        $id = $_SESSION['id'];

        $date = date('Y-m-d');

        $query = "INSERT INTO blogs_tbl(user_id, title, description, full_desc, date, blog_image) values (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {

            $image_name = rand(10000000, 99999999) . ".png";
            $des = "./uploaded_images/" . $image_name;

            move_uploaded_file($tmp_name, $des);

            mysqli_stmt_bind_param($stmt, 'ssssss', $param_user_id, $param_title, $param_desc, $param_full_desc, $param_date, $param_image);

            $param_user_id = $id;
            $param_title = $title;
            $param_desc = $desc;
            $param_full_desc = $fdesc;
            $param_date = $date;
            $param_image = $image_name;

            if (mysqli_stmt_execute($stmt)) {
                echo '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Blog Added Successfully</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';

                $title = "";
                $desc = "";
                $fdesc = "";
            }
        } else {
            echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Something Went Wrong!!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ';
        }

        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}

?>

<div class="container px-5 py-3">

     <form class="row g-3 px-5" method="POST" enctype="multipart/form-data">
          <div class="col-12">
               <label for="inputTitle" class="form-label">Title</label>
               <input type="text" class="form-control" name="title" id="inputTitle" value="<?php echo $title; ?>">
               <div class="form-text text-danger"><?php echo $title_error; ?></div>
          </div>

          <div class="col-12">
               <label for="inputDesc" class="form-label">Description</label>
               <textarea type="text" class="form-control" name="desc" id="inputDesc"><?php echo $desc; ?></textarea>
               <div class="form-text text-danger"><?php echo $desc_error; ?></div>
          </div>

          <div class="col-12">
               <label for="inputfDesc" class="form-label">Full Description</label>
               <textarea type="text" class="form-control" rows="5" name="fdesc"
                    id="inputfDesc"><?php echo $fdesc; ?></textarea>
               <div class="form-text text-danger"><?php echo $fdesc_error; ?></div>
          </div>

          <div class="mb-3">
               <label for="formFile" class="form-label">Choose Image</label>
               <input class="form-control" name="image" type="file" id="formFile">
               <div class="form-text text-danger"><?php echo $image_error; ?></div>
          </div>

          <div class="col-12">
               <button type="submit" class="btn btn-primary">Add</button>
          </div>
     </form>
</div>

<?php
include("master_pages/footer.php");
?>