<?php
include('config.php');

// Check if the delete request is made
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Delete the course from the database
    $sql = "DELETE FROM courses WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['msg'] = "Course deleted successfully!";
    } else {
        $_SESSION['msg'] = "Error: " . $sql . "<br>" . $conn->error;
    }
    header('Location: manage_courses.php');
}
?>
