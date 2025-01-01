<?php
include('header.php');
include_once('root/config.php');

// Check for database connection issues
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle delete request
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $sql = "DELETE FROM projects WHERE project_id = $delete_id";
    if (mysqli_query($con, $sql)) {
        echo "<div class='alert alert-success'>Project deleted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error deleting project: " . mysqli_error($con) . "</div>";
    }
}
?>

<div class="container mt-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2">
            <!-- Sidebar content -->
        </div>

        <!-- Main Content -->
        <div class="col-md-10">
            <!-- Card for Displaying the Table -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <h3 class="mb-0">Manage Projects</h3>
                </div>
                <div class="card-body">
                    <?php
                    // Fetch all projects
                    $sql = "SELECT * FROM projects ORDER BY start_date DESC";
                    $result = mysqli_query($con, $sql);

                    if (!$result) {
                        echo "<div class='alert alert-danger'>Error fetching projects: " . mysqli_error($con) . "</div>";
                    } elseif (mysqli_num_rows($result) > 0) {
                    ?>
                        <!-- Responsive Table Wrapper -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Start Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($project = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <!-- Display Image -->
                                            <td>
                                                <?php if (!empty($project['image_url']) && file_exists($project['image_url'])): ?>
                                                    <img src="<?= htmlspecialchars($project['image_url']); ?>" 
                                                         alt="<?= htmlspecialchars($project['title']); ?>" 
                                                         width="100" 
                                                         height="100" 
                                                         class="img-thumbnail">
                                                <?php else: ?>
                                                    <img src="default-image.jpg" 
                                                         alt="Default Image" 
                                                         width="100" 
                                                         height="100" 
                                                         class="img-thumbnail">
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($project['title']); ?></td>
                                            <td><?= htmlspecialchars(substr($project['description'], 0, 50)) . '...'; ?></td>
                                            <td><?= date('d M Y', strtotime($project['start_date'])); ?></td>
                                            <td>
                                                <?= $project['status'] == 0 ? "<span class='badge badge-info'>Upcoming</span>" : "<span class='badge badge-success'>Completed</span>"; ?>
                                            </td>
                                            <td class="text-nowrap">
                                                <!-- Edit Button -->
                                                <a href="edit_project.php?id=<?= htmlspecialchars($project['project_id']); ?>" 
                                                   class="btn btn-warning btn-sm me-2">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <!-- Delete Button -->
                                                <a href="view_projects.php?delete=<?= htmlspecialchars($project['project_id']); ?>" 
                                                   class="btn btn-danger btn-sm" 
                                                   onclick="return confirm('Are you sure you want to delete this project?');">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php
                    } else {
                        echo "<div class='alert alert-info'>No projects found.</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
