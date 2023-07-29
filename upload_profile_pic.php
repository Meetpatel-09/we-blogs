<?php
require_once "config.php";
$title = "My Profile";
include("master_pages/header.php");

$id = $_SESSION['id'];
$image_src =  $_SESSION['image'];

$image_error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_FILES['image'])) {
        $image_error = "Please selete image";
    } else {
        $image_name = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $type = $_FILES['image']['type'];
    }

    if (empty($image_error)) {
        $des = "./profile_images/" . $image_name;

        move_uploaded_file($tmp_name, $des);

        $image_src = "profile_image/" . $image_name;

        $sql2 = "UPDATE user_tbl SET image = '{$image_name}' WHERE id = $id";

        $result = mysqli_query($conn, $sql2);
    }
}

?>

<div class="container mt-5 d-flex justify-content-center" style="max-width: 1000px;">

    <img src="<?php echo $image_src ?>" alt="" style="max-height: 400px;">

    <form action="" method="POST" enctype="multipart/form-data">

        <div class=" my-2 mx-2">
            <label for="formFile" class="form-label">Choose Image</label>
            <input class="form-control" name="image" type="file" id="formFile">
            <div class="form-text text-danger"><?php echo $image_error; ?></div>
        </div>
        <div class="col-12  my-2 mx-2">
            <button type="submit" name="submit" class="btn btn-primary">Upload</button>
        </div>
        <div class="col-12  my-2 mx-2">
            <a href="profile.php" class="btn btn-secondary">Back</a>
        </div>

    </form>

</div>
<?php
include("master_pages/footer.php");
?>