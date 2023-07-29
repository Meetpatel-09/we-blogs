<?php
require_once "config.php";
$title = "My Profile";
include("master_pages/header.php");

$id = $_SESSION['id'];

$query = "SELECT * FROM user_tbl WHERE id = $id";

$sql = mysqli_query($conn, $query);

while ($row = mysqli_fetch_array($sql)) {
    $name = $row['name'];
    $email = $row['email'];
    $h1 = $row['hobbies1'];
    $h2 = $row['hobbies2'];
    $h3 = $row['hobbies3'];

    if ($row['image'] != null) {
        $image = "profile_images/" . $row['image'];
    } else {
        $image = "images/npp.png";
    }

    $_SESSION['image'] = $image;

    $hobbies;
    if ($h1 != null) {
        $hobbies = $h1;

        if ($h2 != null) {
            $hobbies = $hobbies . ", " . $h2;
        } else {

            if ($h3 != null) {
                $hobbies = $hobbies . ", " . $h3;
            }
        }
    } elseif ($h2 != null) {
        $hobbies = $h2;

        if ($h3 != null) {
            $hobbies = $hobbies . ", " . $h3;
        }
 
    } elseif ($h3 != null) {
        $hobbies = $h3;
    } else {
        $hobbies = "No Hobbilse";
    }
}

?>

<div class="container mt-5" style="max-width: 1000px;">

    <div class="d-flex">

        <div>
            <img src="<?php echo $image; ?>" height="200px" style="border-radius: 50%;" alt="Profile Picture">
            <br>
            <br>
            <a href="upload_profile_pic.php">Change Profile Picture</a>
    </div>
        
       
        <div class=" my-4 mx-3">

                <h5>Name: <?php echo $name; ?></h5>
                <br>
                <h5>Email: <?php echo $email; ?></h5>
                <br>
                <h5>Hobbies: <?php echo $hobbies; ?></h5>
                <br>

        </div>
    </div>


  <?php
    
$query = "SELECT id, user_id, title, description, full_desc, date FROM blogs_tbl WHERE user_id = $id";

$sql = mysqli_query($conn, $query);

?>


    <h3 class="mt-5">Blogs</h3>
    <hr>
    <?php 
    while ($row = mysqli_fetch_array($sql)) {
        $id_blog = $row['id'];
    ?>
    <h4> <?php echo $row['title'] 
                ?></h4>
    <p><?php echo $row['description'] 
                    ?></p>

    <div class="d-flex justify-content-between">
        <a href="single_blog.php?id=<?php echo $row['id']; 
                                    ?>">Read more...</a>
        <div class="d-flex">
            <p><?php echo $row['date'] 
                            ?></p> &nbsp;
            <b><?php //echo $name; 
                ?></b>
        </div>
    </div>
    <hr>
    <?php } ?>
</div>

<?php
include("master_pages/footer.php");
?>