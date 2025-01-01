<?php
include('header.php');

// Handle delete request
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $sql = "DELETE FROM people WHERE id=$delete_id";
    if (mysqli_query($con, $sql)) {
        echo "<div class='alert alert-success'>Team member deleted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error deleting record: " . mysqli_error($con) . "</div>";
    }
}
?>


<style>
    
        .container-fluid {
        margin-left: 140px;
        padding: 20px;
        width: calc(100% - 240px);
    }
</style>

<div class="container-fluid mt-5">
    <div class="row">
        <!-- Sidebar (2/12 of width, adjust as necessary) -->
        <div class="col-md-2">
            <!-- Sidebar Content (assuming this is already included in your template) -->
        </div>
        
        <!-- Main Content (10/12 of width) -->
        <div class="col-md-10">
            <!-- Card for Displaying the Table -->
            <div class="card shadow-sm">
                <div class="card-header text-black">
                    <h3 class="mb-0">Team Members</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch all team members
                            $sql = "SELECT * FROM people";
                            $result = mysqli_query($con, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($person = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($person['name']); ?></td>
                                        <td><?php echo htmlspecialchars($person['title']); ?></td>
                                        <td><?php echo htmlspecialchars($person['description']); ?></td>
                                        <td>
                                            <!-- Edit Button - Redirect to External File -->
                                            <a href="edit_people.php?id=<?php echo $person['id']; ?>" class="btn btn-warning btn-sm me-2">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <!-- Delete Button -->
                                            <a href="view_people.php?delete=<?php echo $person['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this member?');">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center'>No team members found.</td></tr>";
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
