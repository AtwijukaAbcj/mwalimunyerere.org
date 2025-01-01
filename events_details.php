<?php 
include('header.php');
include_once('root/config.php'); // Include database connection

// Check if the event ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid Event ID.");
}

$event_id = (int)$_GET['id'];

// Fetch event details from the database
$sql_event = "SELECT * FROM events WHERE id = ?";
$stmt = $conn->prepare($sql_event);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result_event = $stmt->get_result();

if ($result_event->num_rows === 0) {
    die("Event not found.");
}

$event = $result_event->fetch_assoc();
?>

<!-- Event Details Page -->
<section class="page-header-section ptb-150" style="background: url('images/event_banner.jpg') no-repeat center center / cover;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-7">
                <div class="page-header-content text-white">
                    <h1 class="text-white display-4 mb-4">Event Details</h1>
                    <p class="lead mb-5">Discover more about this exciting event.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="event-details">
                <h2 class="mb-4 font-weight-bold"><?= htmlspecialchars($event['title']); ?></h2>
                <p><i class="fa fa-calendar"></i> <?= date("F d, Y", strtotime($event['event_date'])); ?> | <i class="fa fa-clock-o"></i> <?= htmlspecialchars($event['event_time']); ?></p>
                <p><i class="fa fa-map-marker"></i> <?= htmlspecialchars($event['location']); ?></p>

                <div class="mt-4">
                    <img src="<?= htmlspecialchars($event['image']); ?>" alt="<?= htmlspecialchars($event['title']); ?>" class="img-fluid rounded mb-4">
                </div>

                <p><?= nl2br(htmlspecialchars($event['description'])); ?></p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">Event Details</h5>
                    <ul class="list-unstyled">
                        <li><strong>Date:</strong> <?= date("F d, Y", strtotime($event['event_date'])); ?></li>
                        <li><strong>Time:</strong> <?= htmlspecialchars($event['event_time']); ?></li>
                        <li><strong>Location:</strong> <?= htmlspecialchars($event['location']); ?></li>
                    </ul>

                    <a href="contact.html" class="btn btn-primary btn-block mt-4">Contact Us for More Info</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
