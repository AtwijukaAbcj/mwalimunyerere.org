<?php
include('header.php');
include_once('root/config.php');

// Check database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Define variables for pagination
$limit = 6; // Number of events per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
$offset = ($page - 1) * $limit; // Offset for SQL query

// Fetch total number of events
$total_events_sql = "SELECT COUNT(*) AS total FROM events";
$total_events_result = $conn->query($total_events_sql);
$total_events = $total_events_result->fetch_assoc()['total'];
$total_pages = ceil($total_events / $limit);

// Fetch events for the current page
$sql_events = "SELECT id, title, description, event_date, event_time, location, image FROM events 
               ORDER BY event_date DESC 
               LIMIT $limit OFFSET $offset";

$result_events = $conn->query($sql_events);

if (!$result_events) {
    die("Query Failed: " . $conn->error);
}

// Define brand colors
$colorIndex = 0;
$colors = ['#8E3951', '#A84759', '#6A273A', '#B05A72', '#8B3D54', '#F3D7D9'];
?>

<!-- Events Page Banner -->
<div class="events-banner position-relative text-center text-white" style="background-color: #8E3951; padding: 100px 20px;">
    <div class="container position-relative">
        <h1 class="display-4 font-weight-bold mb-3">Upcoming Events</h1>
        <p class="lead mb-0">Join us for events that empower and transform communities.</p>
    </div>
</div>

<!-- Events Section -->
<div class="events-list py-5">
    <div class="container">
        <div class="row">
            <?php if ($result_events && $result_events->num_rows > 0): ?>
                <?php while ($row = $result_events->fetch_assoc()): ?>
                    <!-- Event Card -->
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="event-card card h-100 shadow border-0" style="background-color: <?= $colors[$colorIndex++ % count($colors)]; ?>; border-radius: 10px;">
                            <!-- Event Image -->
                            <img src="<?= htmlspecialchars($row['image']); ?>" alt="<?= htmlspecialchars($row['title']); ?>" class="card-img-top" >

                            <!-- Event Details -->
                            <div class="card-body text-white d-flex flex-column">
                                <h5 class="card-title font-weight-bold"><?= htmlspecialchars($row['title']); ?></h5>
                                <p class="mb-1"><i class="fa fa-calendar"></i> <?= date("F d, Y", strtotime($row['event_date'])); ?> | <i class="fa fa-clock-o"></i> <?= htmlspecialchars($row['event_time']); ?></p>
                                <p class="mb-1"><i class="fa fa-map-marker"></i> <?= htmlspecialchars($row['location']); ?></p>
                                <p class="card-text"><?= htmlspecialchars(substr($row['description'], 0, 100)); ?>...</p>

                                <!-- Action Button -->
                                <!-- Action Button -->
                                <a href="events_details.php?id=<?= isset($row['id']) ? htmlspecialchars($row['id']) : ''; ?>" class="btn btn-light  mt-auto">Read More</a>

                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No events available at the moment. Please check back later.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination Controls -->
        <div class="row">
            <div class="col-12">
                <nav aria-label="Events Pagination">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $page - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $page + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
