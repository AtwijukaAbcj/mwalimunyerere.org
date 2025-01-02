<?php 
include_once('header.php');
include_once('root/config.php');

// Check database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch banners from the database
$sql_banners = "SELECT title, subtitle, image_url, button_text, button_link FROM banners ORDER BY created_at DESC";
$result_banners = $conn->query($sql_banners);

$sql_projects = "SELECT * FROM projects ORDER BY created_at DESC";
$result_projects = $conn->query($sql_projects);


// Fetch events from the database
$sql_events = "SELECT title, description, event_date, event_time, location, image 
               FROM events 
               ORDER BY event_date DESC 
               LIMIT 2";
$result_events = $conn->query($sql_events);

// Fetch the latest featured cause
$sql_cause = "SELECT title, description, image_url, raised, goal, button_text, button_link FROM causes ORDER BY created_at DESC LIMIT 1";
$result_cause = $conn->query($sql_cause);
$cause = $result_cause ? $result_cause->fetch_assoc() : null;

// Default colors for events
$colors = ['#8E3951', '#6A273A', '#D9B8C2', '#8C484A', '#5C1A1E'];
$colorIndex = 0;
?>

<!-- Swiper Container -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<div class="swiper-container hero-slider">
    <div class="swiper-wrapper">
        <?php if ($result_banners->num_rows > 0): ?>
            <?php while ($row = $result_banners->fetch_assoc()): ?>
                <!-- Single Slide -->
                <div class="swiper-slide hero-content-wrap" style="background-image: url('<?= htmlspecialchars($row['image_url']); ?>'); background-size: cover; background-position: center;">
                    <div class="banner-overlay position-absolute w-100 h-100 d-flex flex-column justify-content-center align-items-start">
                        <div class="container">
                            <h2><?= htmlspecialchars($row['title']); ?></h2>
                            <h4><?= htmlspecialchars($row['subtitle']); ?></h4>
                            <a href="<?= htmlspecialchars($row['button_link']); ?>" class="btn btn-maroon mt-3">
                                <?= htmlspecialchars($row['button_text']); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <!-- Default Slide -->
            <div class="swiper-slide hero-content-wrap" style="background-image: url('images/default-banner.jpg'); background-size: cover; background-position: center;">
                <div class="banner-overlay position-absolute w-100 h-100 d-flex flex-column justify-content-center align-items-start">
                    <div class="container">
                        <h2>Welcome to Our Website</h2>
                        <h4>Explore Our Services</h4>
                        <a href="#" class="btn btn-maroon mt-3">Learn More</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="swiper-pagination"></div>

    <!-- Navigation Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>

<div class="home-page-icon-boxes">
    <div class="container">
        <div class="row">
            <!-- Empower Farmers -->
            <div class="col-12 col-md-6 col-lg-4 mt-4 mt-lg-0">
                <div class="icon-box active">
                    <figure class="d-flex justify-content-center">
                        <img src="images/hands-gray.png" alt="Empowering Farmers">
                        <img src="images/hands-white.png" alt="Empowering Farmers">
                    </figure>

                    <header class="entry-header">
                        <h3 class="entry-title">Empowering Farmers</h3>
                    </header>

                    <div class="entry-content">
                        <p>We provide training and resources to enhance livestock and crop production, ensuring food security and sustainable practices.</p>
                    </div>
                </div>
            </div>

            <!-- Community Development -->
            <div class="col-12 col-md-6 col-lg-4 mt-4 mt-lg-0">
                <div class="icon-box">
                    <figure class="d-flex justify-content-center">
                        <img src="images/donation-gray.png" alt="Community Development">
                        <img src="images/donation-white.png" alt="Community Development">
                    </figure>

                    <header class="entry-header">
                        <h3 class="entry-title">Community Development</h3>
                    </header>

                    <div class="entry-content">
                        <p>Through capacity building and livelihood training, we create sustainable economic opportunities for vulnerable communities.</p>
                    </div>
                </div>
            </div>

            <!-- Access to Services -->
            <div class="col-12 col-md-6 col-lg-4 mt-4 mt-lg-0">
                <div class="icon-box">
                    <figure class="d-flex justify-content-center">
                        <img src="images/charity-gray.png" alt="Access to Essential Services">
                        <img src="images/charity-white.png" alt="Access to Essential Services">
                    </figure>

                    <header class="entry-header">
                        <h3 class="entry-title">Access to Services</h3>
                    </header>

                    <div class="entry-content">
                        <p>We improve access to clean water, education, and healthcare while promoting environmental conservation and sustainability.</p>
                    </div>
                </div>
            </div>
        </div><!-- .row -->
    </div><!-- .container -->
</div><!-- .home-page-icon-boxes -->


<!-- Welcome Section -->
<div class="home-page-welcome">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 order-2 order-lg-1">
                <div class="welcome-content">
                    <header class="entry-header">
                        <h1 class="entry-title">Welcome to Mwalimu Nyerere Livelihood Program</h1>
                    </header><!-- .entry-header -->

                    <div class="entry-content mt-5">
                        <p>
                            The Mwalimu Nyerere Livelihood Program (MNLP) aims to empower farmers by offering
                            capacity building, training, extension services, and community mobilization to address
                            the challenges in livestock and crop value chains. We focus on improving food security,
                            promoting clean animal products, safeguarding the environment, and creating sustainable
                            economic opportunities for vulnerable and marginalized groups.
                        </p>
                    </div><!-- .entry-content -->

                    <div class="entry-footer mt-5">
                        <a href="about.html" class="btn gradient-bg mr-2">Learn More</a>
                        <a href="contact.html" class="btn gradient-bg">Contact Us</a>
                    </div><!-- .entry-footer -->
                </div><!-- .welcome-content -->
            </div><!-- .col -->

            <div class="col-12 col-lg-6 mt-4 order-1 order-lg-2 rounded-img welcome-img">
                <img class="rounded-img" src="images/welcome.jpg" alt="welcome to MNLP">
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- .container -->
</div><!-- .home-page-icon-boxes -->

<!-- Projects section -->

<div class="container-fluid py-5">
    <h1 class="text-center mb-4 text-maroon">Our Projects</h1>

    <!-- Swiper Slider -->
    <div class="swiper-container project-slider">
        <div class="swiper-wrapper">
            <?php
            $sql_latest = "SELECT * FROM projects ORDER BY created_at DESC LIMIT 6";
            $result_latest = $conn->query($sql_latest);
            if ($result_latest && $result_latest->num_rows > 0) {
                while ($project = $result_latest->fetch_assoc()) { ?>
                    <div class="swiper-slide">
                        <div class="project-card-large">
                            <div class="project-image-container">
                                <img src="<?= htmlspecialchars($project['image_url']); ?>" alt="Project Image" class="img-fluid">
                            </div>
                            <div class="project-content">
                                <h4 class="project-title"><?= htmlspecialchars($project['title']); ?></h4>
                                <p class="project-description"><?= substr(htmlspecialchars($project['description']), 0, 100); ?>...</p>
                                <small><strong>Start Date:</strong> <?= $project['start_date']; ?></small><br>
                                <?php if (!empty($project['completion_date'])): ?>
                                    <small><strong>Completion Date:</strong> <?= $project['completion_date']; ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php }
            } else {
                echo "<p class='text-center'>No latest projects available.</p>";
            }
            ?>
        </div>
        <!-- Navigation Buttons -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- Pagination -->
        <div class="swiper-pagination"></div>
    </div>
</div>




<!-- End projects section -->

<!-- Events section -->
<div class="home-page-events">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm mb-4" style="border-radius: 8px; border: 1px solid #ddd;">
                    <div class="card-body">
                        <div class="upcoming-events">
                            <div class="section-heading mb-4">
                                <h2 class="entry-title text-maroon">Upcoming Events</h2>
                            </div>
                            <?php if ($result_events && $result_events->num_rows > 0): ?>
                                <?php while ($row = $result_events->fetch_assoc()): ?>
                                    <div class="event-wrap d-flex align-items-center mb-4" style="border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                        <figure class="m-0" style="flex: 0 0 120px; margin-right: 20px;">
                                            <img src="<?= htmlspecialchars($row['image']); ?>" alt="<?= htmlspecialchars($row['title']); ?>" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px;">
                                        </figure>
                                        <div class="event-content-wrap flex-grow-1">
                                            <header class="entry-header">
                                                <h3 class="entry-title m-0"><a href="#" class="text-dark" style="text-decoration: none;"><?= htmlspecialchars($row['title']); ?></a></h3>
                                                <div class="posted-date mt-2">
                                                    <span><i class="fa fa-calendar text-maroon"></i> <?= date("M d, Y", strtotime($row['event_date'])); ?> | <i class="fa fa-clock text-maroon"></i> <?= htmlspecialchars($row['event_time']); ?></span>
                                                </div>
                                                <div class="cats-links mt-1">
                                                    <span><i class="fa fa-map-marker text-maroon"></i> <?= htmlspecialchars($row['location']); ?></span>
                                                </div>
                                            </header>
                                            <div class="entry-content mt-2">
                                                <p class="m-0"><?= htmlspecialchars(substr($row['description'], 0, 100)); ?>...</p>
                                            </div>
                                            <div class="entry-footer mt-3">
                                                <a href="#" class="btn btn-light btn-bg" style="color: #8E3951; border-radius: 5px; padding: 10px 20px; font-size: 14px;">Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p>No events found.</p>
                            <?php endif; ?>
                            <div class="text-center mt-4">
                                <a href="events.php" class="btn btn-maroon" style="padding: 12px 24px; border-radius: 5px; font-size: 16px;">View All Events</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm mb-4" style="border-radius: 8px; border: 1px solid #ddd;">
                    <div class="card-body">
                        <div class="featured-cause p-4">
                            <div class="section-heading mb-4">
                                <h2 class="entry-title text-center text-maroon">Featured Cause</h2>
                            </div>
                            <?php if ($cause): ?>
                                <div class="cause-wrap">
                                    <img src="<?= htmlspecialchars($cause['image_url']); ?>" alt="<?= htmlspecialchars($cause['title']); ?>" class="img-fluid rounded mb-3" style="width: 100%; border-radius: 8px; object-fit: cover; max-height: 250px;">
                                    <div class="cause-content-wrap">
                                        <h3 class="text-center text-primary"><?= htmlspecialchars($cause['title']); ?></h3>
                                        <p class="text-muted"><?= htmlspecialchars($cause['description']); ?></p>
                                        <div class="fund-raised text-center">
                                            <p class="mb-2">
                                                <strong>Raised:</strong> $<?= number_format($cause['raised'], 2); ?> 
                                                |
                                                <strong>Goal:</strong> $<?= number_format($cause['goal'], 2); ?>
                                            </p>
                                            <div class="progress" style="height: 20px; border-radius: 5px;">
                                                <?php $progress = min(100, ($cause['raised'] / $cause['goal']) * 100); ?>
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?= $progress; ?>%;" aria-valuenow="<?= $progress; ?>" aria-valuemin="0" aria-valuemax="100"><?= round($progress, 2); ?>%</div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-4">
                                            <a href="<?= htmlspecialchars($cause['button_link']); ?>" class="btn btn-lg" style="background: maroon; color: white; border-radius: 5px; padding: 10px 20px;"><?= htmlspecialchars($cause['button_text']); ?></a>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <p class="text-center text-muted">No featured cause available at the moment.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Our cause -->
<div class="our-causes">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading text-center">
                    <h2 class="entry-title">Our Causes</h2>
                    <p>We are committed to empowering communities through impactful projects that foster sustainability and development.</p>
                </div><!-- .section-heading -->
            </div><!-- .col -->
        </div><!-- .row -->

        <div class="row">
            <div class="col-12">
                <div class="swiper-container causes-slider">
                    <div class="swiper-wrapper">
                        <!-- Cause 1: Clean Water Access -->
                        <div class="swiper-slide">
                            <div class="cause-wrap">
                                <figure class="m-0">
                                    <img src="images/cause-1.jpg" alt="Clean Water Access">
                                    <div class="figure-overlay d-flex justify-content-center align-items-center position-absolute w-100 h-100">
                                        <a href="#" class="btn gradient-bg mr-2">Donate Now</a>
                                    </div>
                                </figure>
                                <div class="cause-content-wrap">
                                    <header class="entry-header d-flex flex-wrap align-items-center">
                                        <h3 class="entry-title w-100 m-0"><a href="#">Clean Water Access</a></h3>
                                    </header>
                                    <div class="entry-content">
                                        <p>Providing clean and safe drinking water to underserved communities to improve health and well-being.</p>
                                    </div>
                                    <div class="fund-raised w-100">
                                        <div class="fund-raised-bar-1 barfiller">
                                            <div class="tipWrap"><span class="tip"></span></div>
                                            <span class="fill" data-percentage="75"></span>
                                        </div>
                                        <div class="fund-raised-details d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="fund-raised-total mt-4">Raised: $50,000</div>
                                            <div class="fund-raised-goal mt-4">Goal: $70,000</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cause 2: Education for All -->
                        <div class="swiper-slide">
                            <div class="cause-wrap">
                                <figure class="m-0">
                                    <img src="images/cause-2.jpg" alt="Education for All">
                                    <div class="figure-overlay d-flex justify-content-center align-items-center position-absolute w-100 h-100">
                                        <a href="#" class="btn gradient-bg mr-2">Donate Now</a>
                                    </div>
                                </figure>
                                <div class="cause-content-wrap">
                                    <header class="entry-header d-flex flex-wrap align-items-center">
                                        <h3 class="entry-title w-100 m-0"><a href="#">Education for All</a></h3>
                                    </header>
                                    <div class="entry-content">
                                        <p>Supporting access to quality education by building schools and providing learning materials.</p>
                                    </div>
                                    <div class="fund-raised w-100">
                                        <div class="fund-raised-bar-2 barfiller">
                                            <div class="tipWrap"><span class="tip"></span></div>
                                            <span class="fill" data-percentage="80"></span>
                                        </div>
                                        <div class="fund-raised-details d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="fund-raised-total mt-4">Raised: $60,000</div>
                                            <div class="fund-raised-goal mt-4">Goal: $75,000</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cause 3: Farmers Support -->
                        <div class="swiper-slide">
                            <div class="cause-wrap">
                                <figure class="m-0">
                                    <img src="images/cause-3.jpg" alt="Farmers Support">
                                    <div class="figure-overlay d-flex justify-content-center align-items-center position-absolute w-100 h-100">
                                        <a href="#" class="btn gradient-bg mr-2">Donate Now</a>
                                    </div>
                                </figure>
                                <div class="cause-content-wrap">
                                    <header class="entry-header d-flex flex-wrap align-items-center">
                                        <h3 class="entry-title w-100 m-0"><a href="#">Farmers Support</a></h3>
                                    </header>
                                    <div class="entry-content">
                                        <p>Empowering farmers with modern tools, training, and access to resources to boost agricultural productivity.</p>
                                    </div>
                                    <div class="fund-raised w-100">
                                        <div class="fund-raised-bar-3 barfiller">
                                            <div class="tipWrap"><span class="tip"></span></div>
                                            <span class="fill" data-percentage="60"></span>
                                        </div>
                                        <div class="fund-raised-details d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="fund-raised-total mt-4">Raised: $30,000</div>
                                            <div class="fund-raised-goal mt-4">Goal: $50,000</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cause 4: Youth Empowerment -->
                        <div class="swiper-slide">
                            <div class="cause-wrap">
                                <figure class="m-0">
                                    <img src="images/cause-4.jpg" alt="Youth Empowerment">
                                    <div class="figure-overlay d-flex justify-content-center align-items-center position-absolute w-100 h-100">
                                        <a href="#" class="btn gradient-bg mr-2">Donate Now</a>
                                    </div>
                                </figure>
                                <div class="cause-content-wrap">
                                    <header class="entry-header d-flex flex-wrap align-items-center">
                                        <h3 class="entry-title w-100 m-0"><a href="#">Youth Empowerment</a></h3>
                                    </header>
                                    <div class="entry-content">
                                        <p>Providing training programs and job opportunities for youth to foster economic independence.</p>
                                    </div>
                                    <div class="fund-raised w-100">
                                        <div class="fund-raised-bar-4 barfiller">
                                            <div class="tipWrap"><span class="tip"></span></div>
                                            <span class="fill" data-percentage="70"></span>
                                        </div>
                                        <div class="fund-raised-details d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="fund-raised-total mt-4">Raised: $40,000</div>
                                            <div class="fund-raised-goal mt-4">Goal: $60,000</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cause 5: Healthcare Access -->
                        <div class="swiper-slide">
                            <div class="cause-wrap">
                                <figure class="m-0">
                                    <img src="images/cause-5.jpg" alt="Healthcare Access">
                                    <div class="figure-overlay d-flex justify-content-center align-items-center position-absolute w-100 h-100">
                                        <a href="#" class="btn gradient-bg mr-2">Donate Now</a>
                                    </div>
                                </figure>
                                <div class="cause-content-wrap">
                                    <header class="entry-header d-flex flex-wrap align-items-center">
                                        <h3 class="entry-title w-100 m-0"><a href="#">Healthcare Access</a></h3>
                                    </header>
                                    <div class="entry-content">
                                        <p>Expanding access to healthcare by building clinics and providing essential medical supplies.</p>
                                    </div>
                                    <div class="fund-raised w-100">
                                        <div class="fund-raised-bar-5 barfiller">
                                            <div class="tipWrap"><span class="tip"></span></div>
                                            <span class="fill" data-percentage="65"></span>
                                        </div>
                                        <div class="fund-raised-details d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="fund-raised-total mt-4">Raised: $32,500</div>
                                            <div class="fund-raised-goal mt-4">Goal: $50,000</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- .swiper-wrapper -->
                </div><!-- .swiper-container -->

                <!-- Arrows -->
                <div class="swiper-button-next flex justify-content-center align-items-center">
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div class="swiper-button-prev flex justify-content-center align-items-center">
                    <i class="fas fa-chevron-left"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-0 p-0" style="background-color: #f8f9fa;">
    <div class="p-4" style="border-radius: 0; box-shadow: none;">
        <div class="row align-items-end g-0">
            <div class="col-12 col-lg-6">
                <div class="section-heading">
                    <h2 class="entry-title">Empowering communities through sustainable development and impactful initiatives</h2>
                    <p class="mt-4">At Mwalimu Nyerere Livelihood Program, we focus on improving lives by providing access to clean water, education, and healthcare. Join us in making a lasting difference.</p>
                </div>
            </div><!-- .col -->

            <div class="col-12 col-lg-6">
                <div class="milestones d-flex flex-wrap justify-content-between">
                    <div class="col-12 col-sm-4 mt-4 mt-lg-0">
                        <div class="counter-box text-center">
                            <div class="d-flex justify-content-center align-items-center">
                                <i class="fas fa-users fa-3x text-primary"></i>
                            </div>
                            <div class="d-flex justify-content-center align-items-baseline mt-2">
                                <div class="start-counter" data-to="500" data-speed="2000"></div>
                                <div class="counter-k">K</div>
                            </div>
                            <h3 class="entry-title mt-2">Lives impacted</h3>
                        </div>
                    </div><!-- .col -->

                    <div class="col-12 col-sm-4 mt-4 mt-lg-0">
                        <div class="counter-box text-center">
                            <div class="d-flex justify-content-center align-items-center">
                                <i class="fas fa-water fa-3x text-info"></i>
                            </div>
                            <div class="d-flex justify-content-center align-items-baseline mt-2">
                                <div class="start-counter" data-to="150" data-speed="2000"></div>
                            </div>
                            <h3 class="entry-title mt-2">Water wells built</h3>
                        </div>
                    </div><!-- .col -->

                    <div class="col-12 col-sm-4 mt-4 mt-lg-0">
                        <div class="counter-box text-center">
                            <div class="d-flex justify-content-center align-items-center">
                                <i class="fas fa-handshake fa-3x text-success"></i>
                            </div>
                            <div class="d-flex justify-content-center align-items-baseline mt-2">
                                <div class="start-counter" data-to="320" data-speed="2000"></div>
                            </div>
                            <h3 class="entry-title mt-2">Volunteers engaged</h3>
                        </div>
                    </div><!-- .col -->
                </div>
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- Border-radius container -->
</div><!-- .container-fluid -->

<?php include('footer.php'); ?>
