<?php 
include('header.php'); 
include_once('root/config.php'); ?>
<!-- Completed Projects Banner -->
<div class="events-banner position-relative text-center text-white" style="background-color: #A84759; padding: 80px 20px;">
    <div class="container position-relative">
        <h1 class="display-4 font-weight-bold mb-3">Completed Projects</h1>
        <p class="lead mb-3">Discover the projects we’ve successfully completed, making a lasting impact in the communities we serve.</p>
        </div>
</div>

<div class="container py-5">
        <h2 class="text-center mb-4">Our Projects</h2>

        <h3 class="mb-3 text-maroon">Upcoming Projects</h3>
        <div class="row">
            <?php
            $sql = "SELECT * FROM projects WHERE status = 0 ORDER BY start_date ASC";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($project = $result->fetch_assoc()) { ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="project-card">
                            <img src="<?= htmlspecialchars($project['image_url']); ?>" alt="Project Image">
                            <div class="p-3">
                                <h5><?= htmlspecialchars($project['title']); ?></h5>
                                <p><?= substr(htmlspecialchars($project['description']), 0, 100); ?>...</p>
                                <small>Start Date: <?= $project['start_date']; ?></small>
                            </div>
                        </div>
                    </div>
                <?php }
            } else { echo "<p>No upcoming projects.</p>"; }
            ?>
        </div>

        <h3 class="mt-5 mb-3 text-maroon">Completed Projects</h3>
        <div class="row">
            <?php
            $sql = "SELECT * FROM projects WHERE status = 1 ORDER BY completion_date DESC";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($project = $result->fetch_assoc()) { ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="project-card">
                            <img src="<?= htmlspecialchars($project['image_url']); ?>" alt="Project Image">
                            <div class="p-3">
                                <h5><?= htmlspecialchars($project['title']); ?></h5>
                                <p><?= substr(htmlspecialchars($project['description']), 0, 100); ?>...</p>
                                <small>Completion Date: <?= $project['completion_date']; ?></small>
                            </div>
                        </div>
                    </div>
                <?php }
            } else { echo "<p>No completed projects.</p>"; }
            ?>
        </div>
</div>
<include('footer.php'); 
