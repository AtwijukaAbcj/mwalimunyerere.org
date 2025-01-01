<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and header
include('header.php');
include_once('root/config.php');

// Check if the database connection is successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $start_date = mysqli_real_escape_string($con, $_POST['start_date']);
    $completion_date = !empty($_POST['completion_date']) ? mysqli_real_escape_string($con, $_POST['completion_date']) : NULL;
    $status = isset($_POST['status']) ? 1 : 0;

    // Define paths for uploads
    $upload_base_url = "http://localhost/mwalimunyerere.org/admin/uploads/";
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/mwalimunyerere.org/admin/uploads/";

    // Check if the uploads folder exists, create if not
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Handle image upload
    $image_url = NULL;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image_name = uniqid() . "_" . basename($_FILES['image']['name']);
        $target_file = $upload_dir . $image_name;

        // Validate image file type
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowed_types)) {
            // Move uploaded file
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image_url = $upload_base_url . $image_name; // Full URL to the uploaded file
            } else {
                echo "<div class='alert alert-danger'>Failed to upload the image.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.</div>";
        }
    }

    // Insert project data into the database
    $sql = "INSERT INTO projects (title, description, start_date, completion_date, status, image_url) 
            VALUES ('$title', '$description', '$start_date', " . ($completion_date ? "'$completion_date'" : "NULL") . ", $status, " . ($image_url ? "'$image_url'" : "NULL") . ")";
    if (mysqli_query($con, $sql)) {
        echo "<div class='alert alert-success'>Project added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($con) . "</div>";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-start">
        <!-- Pushed Card -->
        <div class="col-md-8 ml-auto">
            <div class="card shadow-sm">
                <!-- Card Header -->
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0 text-center">Add New Project</h4>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <!-- Title -->
                        <div class="form-group">
                            <label for="title">Project Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter project title" required>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Project Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter project description"></textarea>
                        </div>

                        <!-- Dates -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="start_date">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="completion_date">Completion Date</label>
                                <input type="date" class="form-control" id="completion_date" name="completion_date">
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="form-group">
                            <label for="image">Project Image</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>

                        <!-- Status -->
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="status" name="status">
                            <label class="form-check-label" for="status">Mark as Completed</label>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Add Project</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
