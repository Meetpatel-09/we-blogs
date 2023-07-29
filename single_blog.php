<?php
require_once "config.php";
$title = "Blog";
include("master_pages/header.php");

$id = $_GET['id'];

$query = "SELECT blogs_tbl.*, user_tbl.name, user_tbl.image FROM blogs_tbl JOIN user_tbl WHERE blogs_tbl.user_id = user_tbl.id AND blogs_tbl.id = $id";

$sql = mysqli_query($conn, $query);

?>

<div class="container py-3" style="max-width: 1000px;">

    <?php

    while ($row = mysqli_fetch_array($sql)) {

        $id = $row['user_id'];
        $name = $row['name'];

        
        if ($row['image'] != null) {
            $image = "profile_images/" . $row['image'];
        } else {
            $image = "images/npp.png";
        }
    ?>

        <div class="d-flex justify-content-end">
            <div class="d-flex">
                <p> <?php echo $row['date'] ?></p> &nbsp;
                <a href="bloger_profile.php?id=<?php echo $id; ?>" class="text-decoration-none text-black"> 
                    <b><?php echo $name; ?></b>
                </a>
                &nbsp;&nbsp;
                <a href="bloger_profile.php?id=<?php echo $id; ?>">
                    <img src="<?php echo $image; ?>" height="30px;" style="border-radius: 50%;" alt="">
                </a>
            </div>
        </div>
        <img src="uploaded_images/<?php echo $row['blog_image']; ?>" class="img-fluid" alt="">

        <h4 class="mt-3"><?php echo $row['title'] ?></h4>

        <p class="p-0 m-0"><?php echo $row['description'] ?></p>
        <p><?php echo $row['full_desc'] ?></p>

    <?php } ?>

</div>

<?php
include("master_pages/footer.php");
?>