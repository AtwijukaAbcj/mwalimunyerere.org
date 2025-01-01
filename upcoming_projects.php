<?php 
include('header.php'); 
include_once('root/config.php'); 
?>

<!-- Events Page Banner -->
<!-- Upcoming Projects Banner -->
<div class="events-banner position-relative text-center text-white" style="background-color: #8E3951; padding: 80px 20px;">
    <div class="container position-relative">
        <h1 class="display-4 font-weight-bold mb-3">Upcoming Projects</h1>
        <p class="lead mb-3">Join us in making a difference by participating in our upcoming projects aimed at transforming lives and building a better future.</p>
    </div>
</div>


<div class="container py-5">
    <h2 class="text-center mb-4">Upcoming Projects</h2>

    <div class="row">
        <?php
        // Fetch only upcoming projects (status = 0)
        $sql = "SELECT * FROM projects WHERE status = 0 ORDER BY start_date ASC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($project = $result->fetch_assoc()) { ?>
                <div class="col-md-6 col-lg-4">
                    <div class="project-card">
                        <img src="<?= htmlspecialchars($project['image_url']); ?>" alt="Project Image" class="img-fluid">
                        <div class="p-3">
                            <h5><?= htmlspecialchars($project['title']); ?></h5>
                            <p><?= substr(htmlspecialchars($project['description']), 0, 100); ?>...</p>
                            <small>Start Date: <?= htmlspecialchars($project['start_date']); ?></small>
                        </div>
                    </div>
                </div>
            <?php }
        } else { 
            echo "<p class='text-center w-100'>No upcoming projects available at the moment.</p>"; 
        }
        ?>
    </div>
</div>

<?php include('footer.php'); ?>
