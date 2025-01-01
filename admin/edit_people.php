<?php
include('header.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch data for editing if an id is provided
if (isset($_GET['id'])) {
    $edit_id = intval($_GET['id']);
    $edit_sql = "SELECT * FROM people WHERE id=$edit_id";
    $edit_result = mysqli_query($con, $edit_sql);
    $edit_data = mysqli_fetch_assoc($edit_result);

    if (!$edit_data) {
        echo "<div class='alert alert-danger'>Person not found!</div>";
        exit;
    }
}

// Handle form submission for updating the team member
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $facebook_link = mysqli_real_escape_string($con, $_POST['facebook_link']);
    $twitter_link = mysqli_real_escape_string($con, $_POST['twitter_link']);
    $youtube_link = mysqli_real_escape_string($con, $_POST['youtube_link']);
    $linkedin_link = mysqli_real_escape_string($con, $_POST['linkedin_link']);

    // Handle image upload
    $image_path = $edit_data['image']; // Keep existing image path unless a new one is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/admin/uploads/people/';
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = uniqid('people_', true) . '.' . $image_ext;
        $image_path = $upload_dir . $image_name;

        // Check if the directory exists, create if not
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Move the file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            $image_path = '/admin/uploads/people/' . $image_name; // Save relative path to database
        } else {
            echo "<div class='alert alert-danger'>Image upload failed.</div>";
        }
    }

    // Update the data in the database
    $sql = "UPDATE people SET name=?, title=?, description=?, image=?, facebook_link=?, twitter_link=?, youtube_link=?, linkedin_link=? WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssssssi", $name, $title, $description, $image_path, $facebook_link, $twitter_link, $youtube_link, $linkedin_link, $edit_id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Team member updated successfully!</div>";
        header('Location: view_people.php'); // Redirect to the view page after success
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($con) . "</div>";
    }

    $stmt->close();
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2>Edit Team Member</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($edit_data['name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($edit_data['title']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control"><?php echo htmlspecialchars($edit_data['description']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Profile Image</label>
                    <input type="file" name="image" class="form-control">
                    <?php if (!empty($edit_data['image'])) { ?>
                        <img src="<?php echo $edit_data['image']; ?>" alt="Profile Image" style="width: 100px; margin-top: 10px;">
                    <?php } ?>
                </div>
                <div class="mb-3">
                    <label for="facebook_link" class="form-label">Facebook Link</label>
                    <input type="text" name="facebook_link" class="form-control" value="<?php echo htmlspecialchars($edit_data['facebook_link']); ?>">
                </div>
                <div class="mb-3">
                    <label for="twitter_link" class="form-label">Twitter Link</label>
                    <input type="text" name="twitter_link" class="form-control" value="<?php echo htmlspecialchars($edit_data['twitter_link']); ?>">
                </div>
                <div class="mb-3">
                    <label for="youtube_link" class="form-label">YouTube Link</label>
                    <input type="text" name="youtube_link" class="form-control" value="<?php echo htmlspecialchars($edit_data['youtube_link']); ?>">
                </div>
                <div class="mb-3">
                    <label for="linkedin_link" class="form-label">LinkedIn Link</label>
                    <input type="text" name="linkedin_link" class="form-control" value="<?php echo htmlspecialchars($edit_data['linkedin_link']); ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update Member</button>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
