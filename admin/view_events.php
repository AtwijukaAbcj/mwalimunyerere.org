<?php
include('header.php');

// Check for database connection issues
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle delete request
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $sql = "DELETE FROM events WHERE id=$delete_id";
    if (mysqli_query($con, $sql)) {
        echo "<div class='alert alert-success'>Event deleted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error deleting record: " . mysqli_error($con) . "</div>";
    }
}

?>
<style>
    
        .container-fluid {
        margin-left: 90px;
        padding: 20px;
   
    }
</style>

<div class="container-fluid mt-5">
    <div class="row">
        <!-- Sidebar (2/12 of width, adjust as necessary) -->
        <div class="col-md-2">
            <!-- Sidebar Content -->
        </div>
        
        <!-- Main Content (10/12 of width) -->
        <div class="col-md-10">
            <!-- Card for Displaying the Table -->
            <div class="card shadow-sm">
                <div class="card-header text-black">
                    <h3 class="mb-0">Events</h3>
                </div>
                <div class="card-body">
                    <?php
                    // Fetch all events
                    $sql = "SELECT * FROM events ORDER BY event_date DESC";
                    $result = mysqli_query($con, $sql);

                    // Check if query executed successfully
                    if (!$result) {
                        echo "<div class='alert alert-danger'>Error fetching events: " . mysqli_error($con) . "</div>";
                    } elseif (mysqli_num_rows($result) > 0) {
                        ?>
                        <table class="table table-bordered table-hover mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Event Date</th>
                                    <th>Event Time</th>
                                    <th>Location</th>
                                    <th>Ticket Price</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($event = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($event['title']); ?></td>
                                        <td><?php echo htmlspecialchars($event['description']); ?></td>
                                        <td><?php echo date('d M Y', strtotime($event['event_date'])); ?></td>
                                        <td><?php echo htmlspecialchars($event['event_time']); ?></td>
                                        <td><?php echo htmlspecialchars($event['location']); ?></td>
                                        <td>$<?php echo number_format($event['ticket_price'], 2); ?></td>
                                        <td><?php echo htmlspecialchars($event['category']); ?></td>
                                        <td>
                                            <!-- Edit Button - Redirect to External File -->
                                            <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="btn btn-warning btn-sm me-2">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <!-- Delete Button -->
                                            <a href="view_events.php?delete=<?php echo $event['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this event?');">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                    } else {
                        echo "<div class='alert alert-info'>No events found.</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
