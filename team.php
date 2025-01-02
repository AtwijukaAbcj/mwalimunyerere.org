<?php 
include('header.php');
include('root/config.php'); // Include database connection
?>

<!-- Page Header Section -->
<section class="page-header-section ptb-150" style="background: url('images/team_banner.jpg') no-repeat center center / cover;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-7">
                <div class="page-header-content text-white">
                    <h1 class="text-white display-4 mb-4">Our Team</h1>
                    <p class="lead mb-5">
                        Meet the passionate individuals driving change and empowering communities through innovation and dedication.
                    </p>
                    <a href="#team" class="btn btn-primary btn-lg px-4 py-3 mr-3">Meet the Team</a>
                    <a href="contact.html" class="btn btn-outline-light btn-lg px-4 py-3">Join Us</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<div class="container py-5" id="team">
    <div class="section-heading text-center mb-5">
        <h2 class="entry-title">Our Dedicated Team</h2>
        <p class="lead">Discover the individuals who bring our mission to life.</p>
    </div>
    
    <div class="row">
        <?php
        // Your original PHP code for fetching and displaying team members
        $query = "SELECT * FROM people"; // Fetch all team members
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $index = 1;  // Index to control pyramid structure
            while ($person = $result->fetch_assoc()) {
                ?>
                <div class="col-md-4 col-lg-3 mb-4 team-member">
                    <div class="card team-card">
                        <img src="<?= !empty($person['image']) ? htmlspecialchars($person['image']) : 'img/default-profile.png'; ?>" class="card-img-top" alt="<?= htmlspecialchars($person['name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="people-detail.php?id=<?= htmlspecialchars($person['id']); ?>">
                                    <?= htmlspecialchars($person['name']); ?>
                                </a>
                            </h5>
                        </div>
                        <div class="card-footer">
                            <p class="card-text"><?= htmlspecialchars($person['title']); ?></p>
                        </div>
                    </div>
                </div>
                <?php
                $index++;
            }
        } else {
            echo "<p class='text-center'>No team members available at the moment.</p>";
        }
        ?>
    </div>
</div>

<?php include('footer.php'); ?>
