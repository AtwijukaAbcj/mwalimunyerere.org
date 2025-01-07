<?php
ob_start(); // Start output buffering
session_start();
include 'root/config.php'; // Include config before any HTML is output

// Fetch causes from the database
$sql = "SELECT * FROM causes WHERE status = 'active'";
$result = $conn->query($sql);

include 'header.php'; // Include header only after header() modifications are done
?>
<!-- Page Header Start -->
<section class="page-header">
    <div class="page-header__bg-shape" style="background-image: url(assets/images/shapes/page-header-bg-shape.png);">
    </div>
    <div class="container">
        <div class="page-header__inner">
            <div class="page-header__shape-1">
                <img src="assets/images/shapes/page-header-shape-1.png" alt="">
            </div>
            <h2>Our Causes</h2>
            <div class="thm-breadcrumb__box">
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="index.html">Home</a></li>
                    <li><span>-</span></li>
                    <li>Causes</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- Page Header End -->
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
<!-- Causes Section Start -->
<section class="causes-section">
    <div class="container">
        <div class="row">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".1s">
                        <div class="courses-one__single">
                            <div class="courses-one__img-box">
                                <div class="courses-one__img">
                                    <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                                </div>
                                <div class="courses-one__tag">
                                    <span><?= htmlspecialchars($row['category']) ?></span>
                                </div>
                            </div>
                            <div class="courses-one__content">
                                <h3 class="courses-one__title">
                                    <a href="cause-details.php?id=<?= $row['id'] ?>">
                                        <?= htmlspecialchars($row['title']) ?>
                                    </a>
                                </h3>
                                <p class="courses-one__text">
                                    <?= htmlspecialchars(substr($row['description'], 0, 100)) ?>...
                                </p>
                                <div class="courses-one__rised-and-goals">
                                    <div class="courses-one__raised">
                                        <h4>$<?= number_format($row['raised'], 2) ?><span>Raised</span></h4>
                                    </div>
                                    <div class="courses-one__goals">
                                        <h4>$<?= number_format($row['goal'], 2) ?><span>Goal</span></h4>
                                    </div>
                                </div>
                                <div class="progress-levels">
                                    <!-- Skill Box -->
                                    <div class="progress-box">
                                        <div class="inner count-box">
                                            <div class="bar">
                                                <div class="bar-inner">
                                                    <div class="skill-percent">
                                                        <span class="count-text" data-speed="3000" data-stop="<?= round(($row['raised'] / $row['goal']) * 100); ?>">0</span>
                                                        <span class="percent">%</span>
                                                    </div>
                                                    <div class="bar-fill" data-percent="<?= round(($row['raised'] / $row['goal']) * 100); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <a onclick="addToCartAndCheckout(<?= $row['id'] ?>)" class="courses-one__btn thm-btn">
                                        <span>Donate Now</span><i class="icon-arrow-up"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No causes found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- Causes Section End -->

<script>
    function addToCartAndCheckout(causeId) {
        fetch('cart.php?action=add&id=' + causeId + '&redirect=1', {
            method: 'GET'
        })
        .then(response => {
            if (response.ok) {
                window.location.href = 'payments.php'; // Redirect to checkout
            } else {
                alert('Failed to add the item to the cart. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>

<?php include 'footer.php'; ?>
