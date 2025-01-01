<?php
include('header.php');

// Include database configuration
require_once('root/config.php');

// Check if the event ID is provided in the URL and valid
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    die("Invalid event ID.");
}

$event_id = intval($_GET['id']); // Ensure the ID is an integer

// Fetch the event details
$event_query = $con->prepare("SELECT * FROM events WHERE id = ?");
$event_query->bind_param("i", $event_id);
$event_query->execute();
$event_result = $event_query->get_result();

// Check if the event exists
if ($event_result && $event_result->num_rows > 0) {
    $event = $event_result->fetch_assoc();
} else {
    die("Event not found.");
}

// Handle the form submission for updating the event
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $overview = $_POST['overview'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $location = $_POST['location'];
    $ticket_price = $_POST['ticket_price'];
    $contact_number = $_POST['contact_number'];
    $category = $_POST['category'];
    $additional_info = $_POST['additional_info'];

    // Update query
    $update_query = $con->prepare("UPDATE events SET title = ?, description = ?, overview = ?, event_date = ?, event_time = ?, location = ?, ticket_price = ?, contact_number = ?, category = ?, additional_info = ? WHERE id = ?");
    $update_query->bind_param("ssssssisssi", $title, $description, $overview, $event_date, $event_time, $location, $ticket_price, $contact_number, $category, $additional_info, $event_id);

    if ($update_query->execute()) {
        echo "<div class='alert alert-success'>Event updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating event: " . $con->error . "</div>";
    }
}
?>

<div class="container mt-5">
    <h2>Edit Event</h2>

    <form method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Event Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($event['title']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($event['description']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="overview" class="form-label">Overview</label>
            <textarea class="form-control" id="overview" name="overview" rows="3" required><?= htmlspecialchars($event['overview']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="event_date" class="form-label">Event Date</label>
            <input type="date" class="form-control" id="event_date" name="event_date" value="<?= htmlspecialchars($event['event_date']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="event_time" class="form-label">Event Time</label>
            <input type="time" class="form-control" id="event_time" name="event_time" value="<?= htmlspecialchars($event['event_time']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="<?= htmlspecialchars($event['location']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="ticket_price" class="form-label">Ticket Price</label>
            <input type="number" class="form-control" id="ticket_price" name="ticket_price" value="<?= htmlspecialchars($event['ticket_price']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="contact_number" class="form-label">Contact Number</label>
            <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?= htmlspecialchars($event['contact_number']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" class="form-control" id="category" name="category" value="<?= htmlspecialchars($event['category']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="additional_info" class="form-label">Additional Info</label>
            <textarea class="form-control" id="additional_info" name="additional_info" rows="3"><?= htmlspecialchars($event['additional_info']); ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Event</button>
        <a href="events.php" class="btn btn-secondary">Back to Events</a>
    </form>
</div>

<?php include 'footer.php'; ?>
