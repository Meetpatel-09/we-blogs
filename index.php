<?php

require_once "config.php";
$title = "Home";
include("master_pages/header.php");


$query = "SELECT blogs_tbl.*, user_tbl.name, user_tbl.image FROM blogs_tbl JOIN user_tbl WHERE blogs_tbl.user_id = user_tbl.id ORDER BY blogs_tbl.id DESC";

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

        <h4><?php echo $row['title'] ?></h4>
        <p><?php echo $row['description'] ?></p>

        <div class="d-flex justify-content-between">
            <a href="single_blog.php?id=<?php echo $row['id']; ?>">Read more...</a>
            <div class="d-flex">
                <p><?php echo $row['date'] ?></p> &nbsp;
                <a href="bloger_profile.php?id=<?php echo $id; ?>" class="text-decoration-none text-black"> 
                    <b><?php echo $name; ?></b>
                </a>
                &nbsp;&nbsp;
                <a href="bloger_profile.php?id=<?php echo $id; ?>">
                    <img src="<?php echo $image; ?>" height="30px;" style="border-radius: 50%;" alt="">
                </a>
            </div>
        </div>
        <hr>

    <?php } ?>

</div>

<?php
include("master_pages/footer.php");
?>