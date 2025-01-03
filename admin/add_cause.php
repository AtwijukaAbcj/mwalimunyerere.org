<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('header.php');
require_once __DIR__ . '/../root/config.php'; // Include your database configuration

// Check if the connection was successfully established
if (!isset($conn)) {
    die("Database connection not established. Please check the configuration.");
}

// Handle form submission for adding a new cause
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category = $_POST['category'];
    $status = $_POST['status'];
    $raised = floatval($_POST['raised']);
    $goal = floatval($_POST['goal']);
    $button_text = $_POST['button_text'];
    $button_link = $_POST['button_link'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Define the target directory
        $relative_dir = "/mwalimunyerere.org/admin/assets/images/causes/";
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . $relative_dir;

        // Ensure the directory exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $image_name = uniqid() . "_" . basename($_FILES['image']['name']);
        $target_file = $target_dir . $image_name;

        // Construct the full URL
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $image_url = $protocol . "://" . $host . $relative_dir . $image_name;

        // Move uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // File uploaded successfully
        } else {
            $image_url = ""; // If upload fails, set to an empty string
            echo "<div class='alert alert-danger'>Image upload failed!</div>";
        }
    } else {
        $image_url = ""; // If no image is uploaded, set to an empty string
    }

    // Insert the new cause into the database
    try {
        $sql = "INSERT INTO causes (title, description, price, stock, category, status, image_url, raised, goal, button_text, button_link, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdisssdsss', $title, $description, $price, $stock, $category, $status, $image_url, $raised, $goal, $button_text, $button_link);
        $stmt->execute();

        echo "<div class='alert alert-success'>Cause added successfully!</div>";
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Error adding cause: " . $e->getMessage() . "</div>";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">Add New Cause</h2>
            <form action="add_cause.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="price">Price (UGX)</label>
                    <input type="number" name="price" id="price" class="form-control" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" name="category" id="category" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="raised">Amount Raised (UGX)</label>
                    <input type="number" name="raised" id="raised" class="form-control" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="goal">Goal Amount (UGX)</label>
                    <input type="number" name="goal" id="goal" class="form-control" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="button_text">Button Text</label>
                    <input type="text" name="button_text" id="button_text" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="button_link">Button Link</label>
                    <input type="text" name="button_link" id="button_link" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Add Cause</button>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
