<?php
include('root/config.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $course_name = $_POST['course_name'];
    $description = $_POST['description'];
    $enroll_link = $_POST['enroll_link'];

    // Update course details
    $sql = "UPDATE courses SET course_name='$course_name', description='$description', enroll_link='$enroll_link' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['msg'] = "Course updated successfully!";
    } else {
        $_SESSION['msg'] = "Error: " . $sql . "<br>" . $conn->error;
    }
    header('Location: manage_courses.php');
}
?>
