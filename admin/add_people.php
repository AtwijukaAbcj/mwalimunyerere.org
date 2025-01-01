<?php
include('header.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
$sql_causes = $dbh->query("SELECT * FROM causes ")->fetchColumn();
// Handle form submission logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $name = $_POST['name'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $facebook_link = $_POST['facebook_link'];
    $twitter_link = $_POST['twitter_link'];
    $youtube_link = $_POST['youtube_link'];
    $linkedin_link = $_POST['linkedin_link'];

    // Handle image upload
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/admin/uploads/people/'; // Define the correct target directory
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = uniqid('people_', true) . '.' . $image_ext;
        $image_path = $upload_dir . $image_name;

        // Check if the directory exists, create if not
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true); // Create directory with correct permissions
        }

        // Move the file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            // File uploaded successfully
            $image_path = '/admin/uploads/people/' . $image_name; // For saving the relative path to DB
        } else {
            echo "<div class='alert alert-danger'>Image upload failed.</div>";
        }
    }

    // Insert the data into the database
    $query = "INSERT INTO people (name, title, description, image, facebook_link, twitter_link, youtube_link, linkedin_link) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($query); // Ensure $con is defined from your config file
    $stmt->bind_param("ssssssss", $name, $title, $description, $image_path, $facebook_link, $twitter_link, $youtube_link, $linkedin_link);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Team member added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to add team member.</div>";
    }

    $stmt->close();
}
?>




<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'view_people.php') ? 'active' : ''; ?>" href="view_people.php">
                            <i class="fa fa-users"></i> View People
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'add_people.php') ? 'active' : ''; ?>" href="add_people.php">
                            <i class="fa fa-user-plus"></i> Add People
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content Area -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <!-- Form in a Card -->
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h3>Add New Team Member</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="add_people.php" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="invalid-feedback">
                                    Please enter a name.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                                <div class="invalid-feedback">
                                    Please enter a title.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Profile Image</label>
                                <input type="file" class="form-control" id="image" name="image" required>
                                <div class="invalid-feedback">
                                    Please upload an image.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="facebook_link" class="form-label">Facebook Link</label>
                                <input type="text" class="form-control" id="facebook_link" name="facebook_link">
                            </div>
                            <div class="mb-3">
                                <label for="twitter_link" class="form-label">Twitter Link</label>
                                <input type="text" class="form-control" id="twitter_link" name="twitter_link">
                            </div>
                            <div class="mb-3">
                                <label for="youtube_link" class="form-label">YouTube Link</label>
                                <input type="text" class="form-control" id="youtube_link" name="youtube_link">
                            </div>
                            <div class="mb-3">
                                <label for="linkedin_link" class="form-label">LinkedIn Link</label>
                                <input type="text" class="form-control" id="linkedin_link" name="linkedin_link">
                            </div>
                            <button type="submit" class="btn btn-primary">Add Team Member</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
// Bootstrap form validation
(function () {
    'use strict';
    window.addEventListener('load', function () {
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>

<?php include('footer.php'); ?>
