<?php
require_once "config.php";
$title = "My Blogs";
include("master_pages/header.php");

if (!isset($_SESSION['isLoggedIn'])) {
    header("location: login.php");
}

$id = $_SESSION['id'];

$query = "SELECT id, user_id, title, description, full_desc, date FROM blogs_tbl WHERE user_id = $id";

$sql = mysqli_query($conn, $query);

?>
<div class="container py-3" style="max-width: 1000px;">

    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        echo '<script>
            if(confirm("Are you sure!!") == true) {
                window.location.href = "./delete_blog.php?id=' . $_POST['blog_id'] . '";
            }
        </script>';
    }

    while ($row = mysqli_fetch_array($sql)) {
        $id_blog = $row['id'];
    ?>
        <h4><?php echo $row['title'] ?></h4>
        <p><?php echo $row['description'] ?></p>


        <form method="POST">
            <a href="edit_blog.php?id=<?php echo $id_blog; ?>" class="btn btn-warning">Edit</a>
            <input type="hidden" name="blog_id" value="<?php echo $id_blog; ?>">
            <button type="submit" class="btn btn-danger">Delete</button>

        </form>
        <button type="button" hidden> </button>
        <hr>

    <?php } ?>
</div>

<?php
include("master_pages/footer.php");
?>