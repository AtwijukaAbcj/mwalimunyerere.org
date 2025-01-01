<?php
include('header.php'); // Include header

// Database connection
require_once('root/config.php');

// Check if the banner ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $banner_id = intval($_GET['id']);
} else {
    die('Invalid banner ID.');
}

// Handle form submission for editing the banner
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $subtitle = mysqli_real_escape_string($con, $_POST['subtitle']);
    $button_text = mysqli_real_escape_string($con, $_POST['button_text']);
    $button_link = mysqli_real_escape_string($con, $_POST['button_link']);
    
    // Check if a new image was uploaded
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/mwalimunyerere.org/admin/uploads/";
        $target_file = $target_dir . $image_name;

        // Public URL for the uploaded image
        $public_url = "http://localhost/mwalimunyerere.org/admin/uploads/" . $image_name;

        // Move the uploaded file to the designated folder
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_url = $public_url;
        } else {
            echo "<div class='alert alert-danger'>Error uploading the image.</div>";
            $image_url = $_POST['existing_image']; // Keep existing image if upload fails
        }
    } else {
        // If no new image is uploaded, keep the existing image
        $image_url = $_POST['existing_image'];
    }

    // Update the banner details in the database
    $sql = "UPDATE banners SET 
            title='$title', 
            subtitle='$subtitle', 
            button_text='$button_text', 
            button_link='$button_link', 
            image_url='$image_url'
            WHERE id=$banner_id";

    if (mysqli_query($con, $sql)) {
        echo "<div class='alert alert-success'>Banner updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating banner: " . mysqli_error($con) . "</div>";
    }
}

// Fetch the banner details from the database
$sql = "SELECT * FROM banners WHERE id=$banner_id";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    $banner = mysqli_fetch_assoc($result);
} else {
    die('Banner not found.');
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h4 class="mb-4">Edit Banner</h4>
            <form method="post" action="edit_banner.php?id=<?php echo $banner_id; ?>" enctype="multipart/form-data">
                <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($banner['image_url']); ?>">
                
                <!-- Title Field -->
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($banner['title']); ?>" required>
                </div>
                
                <!-- Subtitle Field -->
                <div class="form-group">
                    <label for="subtitle">Subtitle</label>
                    <input type="text" class="form-control" name="subtitle" value="<?php echo htmlspecialchars($banner['subtitle']); ?>" required>
                </div>

                <!-- Button Text Field -->
                <div class="form-group">
                    <label for="button_text">Button Text</label>
                    <input type="text" class="form-control" name="button_text" value="<?php echo htmlspecialchars($banner['button_text']); ?>" required>
                </div>
                
                <!-- Button Link Field -->
                <div class="form-group">
                    <label for="button_link">Button Link</label>
                    <input type="text" class="form-control" name="button_link" value="<?php echo htmlspecialchars($banner['button_link']); ?>" required>
                </div>

                <!-- Image Upload Field -->
                <div class="form-group">
                    <label for="image">Banner Image</label>
                    <input type="file" class="form-control" name="image">
                    <p class="mt-2">Current Image:</p>
                    <img src="<?php echo htmlspecialchars($banner['image_url']); ?>" alt="Current Image" width="200">
                </div>

                <button type="submit" name="edit" class="btn btn-primary">Update Banner</button>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
