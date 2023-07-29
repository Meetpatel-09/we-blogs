<?php

$conn = mysqli_connect("localhost", "root", "", "vblogs");
// $conn = mysqli_connect("http://139.59.30.3", "meet", "BhavsarSamaj@78", "nav-yuvan");

if (mysqli_connect_error()) {
    echo "Fail to connect: " . mysqli_connect_error();
}