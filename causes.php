<?php
// include('includes/session.php');
session_start();
include('header.php');
include_once('root/config.php');

// Check database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch all causes from the database
$sql_causes = "SELECT * FROM causes ORDER BY created_at DESC";
$result_causes = $conn->query($sql_causes);
?>

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper" style="margin-top: 20px;"> <!-- Added margin-top -->
        <div class="content-wrapper">
            <div class="container">
                <section class="content">
                    <div class="row">
                        <div class="col-12">
                            <div class="general-donation-banner text-center py-5" style="background-image: url('images/banner-background.jpg'); background-size: cover; background-position: center; color: white;">
                                <div class="container text-center py-5" style="background: rgba(0,0,0,0.5); color: #fff; border-radius: 8px;">
                                    <h1 class="mb-4 font-weight-bold">Give Where Most Needed</h1>
                                    <p class="lead mb-4">Your generous support helps us transform lives and create sustainable communities.</p>

                                    <form action="donation_checkout.php" method="POST" class="d-flex justify-content-center align-items-center flex-wrap">
                                        <div class="input-group mb-3" style="max-width: 500px; width: 100%;">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" style="background-color: #fff; border-radius: 4px 0 0 4px;">UGX</span>
                                            </div>
                                            <input type="number" name="general_donation_amount" class="form-control" placeholder="Enter Amount" required style="border-radius: 0;">
                                        </div>
                                        <button type="submit" class="btn btn-primary" style="background-color: maroon; border: none; border-radius: 10px;">Donate Now</button>
                                    </form>
                                </div>
                            </div>

                            <div class="section-heading text-center my-5">
                                <h1 class="entry-title" style="color: purple;">Our Causes</h1>
                                <p>Join us in making a difference by supporting any of these impactful causes.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <?php if ($result_causes && $result_causes->num_rows > 0): ?>
                            <?php while ($cause = $result_causes->fetch_assoc()): ?>
                                <!-- Cause Card -->
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 shadow-sm" style="border: 2px solid purple;">
                                        <img src="<?= htmlspecialchars($cause['image_url']); ?>" 
                                             alt="<?= htmlspecialchars($cause['title']); ?>" 
                                             class="card-img-top" 
                                             style="height: 200px; object-fit: cover; border-radius: 10px 10px 0 0;">
                                        <div class="card-body">
                                            <h5 class="card-title" style="color: purple;"><?= htmlspecialchars($cause['title']); ?></h5>
                                            <p class="card-text"><?= htmlspecialchars(substr($cause['description'], 0, 100)); ?>...</p>
                                            <p><strong>Raised:</strong> $<?= number_format($cause['raised'], 2); ?> 
                                               | <strong>Goal:</strong> $<?= number_format($cause['goal'], 2); ?></p>
                                            <div class="progress mb-3" style="height: 15px;">
                                                <?php $progress = min(100, ($cause['raised'] / $cause['goal']) * 100); ?>
                                                <div class="progress-bar" 
                                                     role="progressbar" 
                                                     style="width: <?= $progress; ?>%; background-color: maroon;" 
                                                     aria-valuenow="<?= $progress; ?>" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    <?= round($progress, 2); ?>%
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <a href="cause_details.php?id=<?= htmlspecialchars($cause['id']); ?>" 
                                                   class="btn btn-sm" 
                                                   style="background-color: purple; color: white; border-radius: 10px;">View Details</a>
                                                <a href="add_to_cart.php?id=<?= htmlspecialchars($cause['id']); ?>" 
                                                   class="btn btn-sm" 
                                                   style="background-color: maroon; color: white; border-radius: 10px;">Donate</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <p class="text-center">No causes available at the moment. Please check back later.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </div>

        <?php include('footer.php'); ?>
    </div>
<script>
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function () {
            const causeId = this.dataset.causeId;

            fetch('add_to_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `cause_id=${causeId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Cause added to cart successfully!');
                } else {
                    alert('Failed to add cause to cart.');
                }
            });
        });
    });
</script>
</body>
<?php include_once'footer.php'?>

