<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('header.php');
require_once 'root/config.php'; // Include your database configuration

// Handle form submission for adding new banner and trends
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Insert banner data
    if (isset($_POST['add_banner'])) {
        // Get banner data from form
        $title = $_POST['banner_title'];
        $subtitle = $_POST['banner_subtitle'];
        $button_text = $_POST['banner_button_text'];
        $button_link = $_POST['banner_button_link'];

        // Handle banner image upload
        if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] == 0) {
            $image_name = basename($_FILES['banner_image']['name']);
            $target_dir = "uploads/";
            $target_file = $target_dir . $image_name;
            $image_url = "https://su.ac.ug/admin/uploads/" . $image_name;

            // Move uploaded file
            if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $target_file)) {
                // File uploaded successfully
                echo "<div class='alert alert-success'>Image uploaded successfully!</div>";
            } else {
                $image_url = ""; // If upload fails, set to an empty string
                echo "<div class='alert alert-danger'>Image upload failed!</div>";
            }
        } else {
            $image_url = ""; // If no image is uploaded, set to an empty string
        }

        // Insert banner into the database
        try {
            $sql = "INSERT INTO banners (title, subtitle, image_url, button_text, button_link) VALUES (?, ?, ?, ?, ?)";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([$title, $subtitle, $image_url, $button_text, $button_link]);
            echo "<div class='alert alert-success'>Banner added successfully!</div>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error adding banner: " . $e->getMessage() . "</div>";
        }
    }

    // Insert trends data
    if (isset($_POST['add_trends'])) {
        $trend_titles = $_POST['trend_title'];
        $trend_descriptions = $_POST['trend_description'];

        // Insert each trend
        try {
            foreach ($trend_titles as $index => $title) {
                $description = $trend_descriptions[$index];
                $sql = "INSERT INTO trends (trend_title, trend_detail) VALUES (?, ?)";
                $stmt = $dbh->prepare($sql);
                $stmt->execute([$title, $description]);
            }
            echo "<div class='alert alert-success'>Trends added successfully!</div>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error adding trends: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<!-- CSS to fix sidebar issue -->
<style>
    /* Adjust sidebar and content layout */

    /* Adjust content layout to fill the rest of the space */
    .content-area {
        margin-left: 240px;
        padding: 20px;

    }

    .container {
        max-width: 100%;
    }

    .card {
        margin-top: 20px;
    }

    /* Ensure the form elements are displayed properly */
    .form-control {
        width: 100%;
        max-width: 600px;
    }
</style>

<div class="wrapper">
 

    <!-- Content Area -->
    <div class="content-area">
        <div class="container">
            <!-- Banner Add Form in a Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="mb-0">Add New Banner</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="add_banner.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="banner_title" class="form-label">Banner Title</label>
                            <input type="text" class="form-control" name="banner_title" required>
                        </div>
                        <div class="mb-3">
                            <label for="banner_subtitle" class="form-label">Banner Subtitle</label>
                            <input type="text" class="form-control" name="banner_subtitle">
                        </div>
                        <div class="mb-3">
                            <label for="banner_image" class="form-label">Banner Image</label>
                            <input type="file" class="form-control" name="banner_image">
                        </div>
                        <div class="mb-3">
                            <label for="banner_button_text" class="form-label">Button Text</label>
                            <input type="text" class="form-control" name="banner_button_text">
                        </div>
                        <div class="mb-3">
                            <label for="banner_button_link" class="form-label">Button Link</label>
                            <input type="text" class="form-control" name="banner_button_link">
                        </div>
                        <button type="submit" name="add_banner" class="btn btn-primary">Add Banner</button>
                    </form>
                </div>
            </div>

            <!-- Trends Add Form in a Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="mb-0">Add New Trends</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="add_banner.php">
                        <div id="trends-container">
                            <div class="trend-item">
                                <div class="mb-3">
                                    <label for="trend_title" class="form-label">Trend Title</label>
                                    <input type="text" class="form-control" name="trend_title[]" required>
                                </div>
                                <div class="mb-3">
                                    <label for="trend_detail" class="form-label">Trend Details</label>
                                    <textarea class="form-control" name="trend_description[]" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Button to add new trend -->
                        <button type="button" class="btn btn-secondary mb-3" onclick="addTrend()">Add New Trend</button>

                        <button type="submit" name="add_trends" class="btn btn-primary">Add Trends</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include('footer.php'); ?>

<script>
    // Function to add a new trend item
    function addTrend() {
        const trendsContainer = document.getElementById('trends-container');
        const trendItem = document.createElement('div');
        trendItem.classList.add('trend-item');
        trendItem.innerHTML = `
            <div class="mb-3">
                <label for="trend_title" class="form-label">Trend Title</label>
                <input type="text" class="form-control" name="trend_title[]" required>
            </div>
            <div class="mb-3">
                <label for="trend_description" class="form-label">Trend Description</label>
                <textarea class="form-control" name="trend_description[]" required></textarea>
            </div>
        `;
        trendsContainer.appendChild(trendItem);
    }
</script>
