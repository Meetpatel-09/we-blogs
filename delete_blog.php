<?php

    require_once "config.php";

    $id = $_GET['id'];

    $result = mysqli_query($conn, "DELETE FROM blogs_tbl WHERE id = $id");

    header("location: my_blogs.php");
    
    exit();
    
?>