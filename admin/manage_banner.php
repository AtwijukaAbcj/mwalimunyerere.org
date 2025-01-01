<?php
include('header.php'); // Include the header file

// Include the database configuration file
require_once('root/config.php');

// Handle delete request
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $delete_sql = "DELETE FROM banners WHERE id=$delete_id";
    if (mysqli_query($con, $delete_sql)) {
        echo "<div class='alert alert-success'>Banner deleted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error deleting banner: " . mysqli_error($con) . "</div>";
    }
}

// Fetch all banners from the database
$sql = "SELECT * FROM banners";
$result = mysqli_query($con, $sql);
?>
<style>
    
        .container-fluid {
        margin-left: 240px;
        padding: 20px;
        width: calc(100% - 240px);
    }
</style>
<div class="container-fluid mt-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-md-12">
            <!-- Card for Displaying Banners -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="mb-0">Manage Banners</h3>
                    <a href="add_banner.php" class="btn btn-primary float-right">Add New Banner</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>Title</th>
                                <th>Subtitle</th>
                                <th>Button Text</th>
                                <th>Button Link</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($banner = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($banner['title']); ?></td>
                                        <td><?php echo htmlspecialchars($banner['subtitle']); ?></td>
                                        <td><?php echo htmlspecialchars($banner['button_text']); ?></td>
                                        <td><a href="<?php echo htmlspecialchars($banner['button_link']); ?>" target="_blank"><?php echo htmlspecialchars($banner['button_link']); ?></a></td>
                                        <td><img src="<?php echo htmlspecialchars($banner['image_url']); ?>" alt="Banner Image" width="150"></td>
                                        <td>
                                            <a href="edit_banner.php?id=<?php echo $banner['id']; ?>" class="btn btn-warning btn-sm me-2">Edit</a>
                                            <a href="manage_banners.php?delete=<?php echo $banner['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this banner?');">Delete</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>No banners found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
