<?php
require_once "config.php";
$title = "Edit Blog";
include("master_pages/header.php");

$title_error = $desc_error = $fdesc_error = "";

$title = $desc = $fdesc = "";

$isImagePicked = "no";

$id = $_GET['id'];

$user_id = $_SESSION['id'];

$query = "SELECT user_id, title, description, full_desc, date FROM blogs_tbl WHERE id = $id";

$sql = mysqli_query($conn, $query);

?>

<div class="container px-5 py-3">

    <form class="row g-3 px-5" method="POST" enctype="multipart/form-data">

        <?php
        while ($row = mysqli_fetch_array($sql)) {

            if ($row['user_id'] != $user_id) {
                header("location: login.php");
            }

            $title = $row['title'];
            $desc = $row['description'];
            $fdesc = $row['full_desc'];
        ?>

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
                <textarea type="text" class="form-control" rows="5" name="fdesc" id="inputfDesc"><?php echo $fdesc; ?></textarea>
                <div class="form-text text-danger"><?php echo $fdesc_error; ?></div>
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label">Choose Image (To change image, select a new image.)</label>
                <input class="form-control" name="image" type="file" id="formFile">
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-warning">Update</button>
            </div>

        <?php } ?>
    </form>
</div>

<?php

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
    
    if (isset($_FILES['image'])) {
        $isImagePicked = "yes";   
        $image_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
    }

    if (empty($title_error) and empty($desc_error) and empty($fdesc_error)) {


        $des = "./uploaded_images/" . $image_name;

        move_uploaded_file($tmp_name, $des);

        if ($isImagePicked == "no") {
            $sql2 = "UPDATE blogs_tbl SET title = '{$title}', description= '{$desc}', full_desc = '{$fdesc}' WHERE id = $id";
        } else {
            echo "image";
            $sql2 = "UPDATE blogs_tbl SET title = '{$title}', description= '{$desc}', full_desc = '{$fdesc}', blog_image = '{$image_name}' WHERE id = $id";
        }

        $result = mysqli_query($conn, $sql2);

        header("location: my_blogs.php");
    }
}
include("master_pages/footer.php");
?>