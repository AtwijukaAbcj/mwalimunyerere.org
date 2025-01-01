<?php
include('header.php');
include_once('root/config.php');

// Check database connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$title = $description = $start_date = $completion_date = $status = $image_url = "";

// Fetch existing project details
if ($project_id > 0) {
    $sql = "SELECT * FROM projects WHERE project_id = $project_id";
    $result = mysqli_query($con, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $project = mysqli_fetch_assoc($result);
        $title = $project['title'];
        $description = $project['description'];
        $start_date = $project['start_date'];
        $completion_date = $project['completion_date'];
        $status = $project['status'];
        $image_url = $project['image_url'];
    } else {
        echo "<div class='alert alert-danger'>Project not found.</div>";
        exit;
    }
}

// Update project
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $start_date = $_POST['start_date'];
    $completion_date = !empty($_POST['completion_date']) ? $_POST['completion_date'] : NULL;
    $status = intval($_POST['status']);

    // Handle image upload if a new image is provided
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/mwalimunyerere.org/admin/uploads/";
        $target_file = $target_dir . $image_name;

        // Move uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Generate full URL for the image
            $base_url = "http://" . $_SERVER['HTTP_HOST'] . "/mwalimunyerere.org/admin/uploads/";
            $image_url = $base_url . $image_name; // Update image URL with full link
        } else {
            echo "<div class='alert alert-danger'>Image upload failed!</div>";
        }
    }

    $update_sql = "UPDATE projects SET 
                    title = '$title', 
                    description = '$description', 
                    start_date = '$start_date', 
                    completion_date = " . ($completion_date ? "'$completion_date'" : "NULL") . ", 
                    status = $status,
                    image_url = '$image_url'
                   WHERE project_id = $project_id";

    if (mysqli_query($con, $update_sql)) {
        echo "<div class='alert alert-success'>Project updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating project: " . mysqli_error($con) . "</div>";
    }
}
?>

<div class="container-fluid mt-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 text-white">
            <!-- Optional Sidebar Content -->
        </div>

        <!-- Main Content -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4>Edit Project</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Project Title</label>
                            <input type="text" name="title" class="form-control" id="title" value="<?= htmlspecialchars($title); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" rows="4" required><?= htmlspecialchars($description); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" class="form-control" id="start_date" value="<?= $start_date; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="completion_date">Completion Date</label>
                            <input type="date" name="completion_date" class="form-control" id="completion_date" value="<?= $completion_date; ?>">
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" id="status" required>
                                <option value="0" <?= ($status == 0) ? 'selected' : ''; ?>>Upcoming</option>
                                <option value="1" <?= ($status == 1) ? 'selected' : ''; ?>>Completed</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="image">Project Image</label>
                            <?php if (!empty($image_url) && filter_var($image_url, FILTER_VALIDATE_URL)): ?>
                                <div class="mb-2">
                                    <img src="<?= htmlspecialchars($image_url); ?>" alt="Project Image" class="img-thumbnail" width="150">
                                </div>
                            <?php else: ?>
                                <p class="text-muted">No image set for this project.</p>
                            <?php endif; ?>
                            <input type="file" name="image" class="form-control" id="image">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Project</button>
                        <a href="view_projects.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
