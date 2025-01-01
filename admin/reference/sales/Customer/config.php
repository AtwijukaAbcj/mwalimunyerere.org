<?php

$conn = mysqli_connect("localhost", "root", "", "blog");

if (!$conn) {
    echo "Connection Failed";
}
