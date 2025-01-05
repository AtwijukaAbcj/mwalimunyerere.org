<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title></title>
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicons/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicons/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicons/favicon-16x16.png" />
    <link rel="manifest" href="assets/images/favicons/site.webmanifest" />
    <meta name="description" content="Chioary HTML 5 Template " />

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/animate.min.css" />
    <link rel="stylesheet" href="assets/css/custom-animate.css" />
    <link rel="stylesheet" href="assets/css/swiper.min.css" />
    <link rel="stylesheet" href="assets/css/font-awesome-all.css" />
    <link rel="stylesheet" href="assets/css/jarallax.css" />
    <link rel="stylesheet" href="assets/css/jquery.magnific-popup.css" />
    <link rel="stylesheet" href="assets/css/odometer.min.css" />
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css" />
    <link rel="stylesheet" href="assets/css/nice-select.css" />
    <link rel="stylesheet" href="assets/css/jquery-ui.css" />
    <link rel="stylesheet" href="assets/css/vegas.min.css" />
    <link rel="stylesheet" href="assets/css/aos.css" />


    <link rel="stylesheet" href="assets/css/module-css/slider.css" />
    <link rel="stylesheet" href="assets/css/module-css/footer.css" />
    
    <link rel="stylesheet" href="assets/css/module-css/coming-soon.css" />
    <link rel="stylesheet" href="assets/css/module-css/services.css" />
    <link rel="stylesheet" href="assets/css/module-css/about.css" />
    <link rel="stylesheet" href="assets/css/module-css/counter.css" />
    <link rel="stylesheet" href="assets/css/module-css/courses.css" />
    <link rel="stylesheet" href="assets/css/module-css/event.css" />
    <link rel="stylesheet" href="assets/css/module-css/video.css" />
    <link rel="stylesheet" href="assets/css/module-css/become-volunteer.css" />
    <link rel="stylesheet" href="assets/css/module-css/team.css" />
    <link rel="stylesheet" href="assets/css/module-css/testimonial.css" />
    <link rel="stylesheet" href="assets/css/module-css/faq.css" />
    <link rel="stylesheet" href="assets/css/module-css/blog.css" />
    <link rel="stylesheet" href="assets/css/module-css/newsletter.css" />
    <link rel="stylesheet" href="assets/css/module-css/page-header.css" />
    <link rel="stylesheet" href="assets/css/module-css/404.css" />

    <!-- template styles -->
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/responsive.css" />
</head>
<?php
// Include header
require_once 'header.php';

// Include database connection
include 'root/config.php';

// Fetch data from the "people" table
$query = "SELECT * FROM people ORDER BY id ASC";
$result = $conn->query($query);
?>
<!--Page Header Start-->
<section class="page-header">
    <div class="page-header__bg-shape" style="background-image: url(assets/images/shapes/page-header-bg-shape.png);">
    </div>
    <div class="container">
        <div class="page-header__inner">
            <div class="page-header__shape-1">
                <img src="assets/images/shapes/page-header-shape-1.png" alt="">
            </div>
            <h2>Team</h2>
            <div class="thm-breadcrumb__box">
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="index.php">Home</a></li>
                    <li><span>-</span></li>
                    <li>Team</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!--Page Header End-->

<!--Team Two Start -->
<section class="team-two team-page">
    <div class="container">
        <div class="row">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($person = $result->fetch_assoc()): ?>
                    <!--Team Two Single Start-->
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".1s">
                        <div class="team-two__single">
                            <div class="team-two__img-box">
                                <div class="team-two__img">
                                    <img src="<?= htmlspecialchars($person['image']); ?>" alt="<?= htmlspecialchars($person['name']); ?>">
                                </div>
                                <div class="team-two__social-list">
                                    <div class="team-two__social-plus-minus">
                                        <p>
                                            <span class="icon-plus team-two__plus"></span>
                                            <span class="icon-minus team-two__minus"></span>
                                        </p>
                                    </div>
                                    <div class="team-two__social">
                                        <a href="<?= htmlspecialchars($person['social_link']); ?>" target="_blank"><span class="icon-facebook"></span></a>
                                        <a href="#"><span class="icon-twitter"></span></a>
                                        <a href="#"><span class="icon-instagram"></span></a>
                                        <a href="#"><span class="icon-youtube"></span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="team-two__content">
                                <h3 class="team-two__title"><?= htmlspecialchars($person['name']); ?></h3>
                                <p class="team-two__text"><?= htmlspecialchars($person['title']); ?></p>
                            </div>
                        </div>
                    </div>
                    <!--Team Two Single End-->
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No team members found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<!--Team Two End -->

<?php
// Close the database connection
$conn->close();

// Include footer
include 'footer.php';
?>
