<?php 
include('header.php');
include('root/config.php');

// Check database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch banners from the database
$sql_banners = "SELECT * FROM banners ORDER BY created_at DESC";
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
$sql_cause = "SELECT title, description, image_url, raised, goal, button_text, button_link FROM causes ORDER BY created_at DESC LIMIT 3";
$result_cause = $conn->query($sql_cause);

// Default colors for events
$colors = ['#8E3951', '#6A273A', '#D9B8C2', '#8C484A', '#5C1A1E'];
$colorIndex = 0;

?>


<body class="custom-cursor">

        <!-- Main Slider Start -->
        <section class="main-slider">
            <?php if ($result_banners && $result_banners->num_rows > 0): ?>
                <div class="main-slider__carousel owl-carousel owl-theme">
                    <?php while ($banner = $result_banners->fetch_assoc()): ?>
                        <div class="item">
                            <div class="main-slider__bg" style="background-image: url(<?= htmlspecialchars($banner['image_url']); ?>);"></div>
                            <div class="main-slider__map" style="background-image: url(<?= isset($banner['map_url']) ? htmlspecialchars($banner['map_url']) : 'default-map.png'; ?>);"></div>
                            <div class="container">
                                <div class="main-slider__content">
                                    <div class="main-slider__sub-title-box">
                                        <div class="main-slider__sub-title-shape"></div>
                                        <h5 class="main-slider__sub-title">
                                            <?= isset($banner['subtitle']) ? htmlspecialchars($banner['subtitle']) : 'Default Subtitle'; ?>
                                        </h5>
                                    </div>
                                    <h2 class="main-slider__title">
                                        <?= htmlspecialchars($banner['title']); ?>
                                    </h2>
                                    <p class="main-slider__text">
                                        <?= isset($banner['description']) ? htmlspecialchars($banner['description']) : 'Default Description'; ?>
                                    </p>
                                    <div class="main-slider__btn-box">
                                        <a href="<?= htmlspecialchars($banner['button_link']); ?>" class="main-slider__btn thm-btn">
                                            <span><?= htmlspecialchars($banner['button_text']); ?></span>
                                            <i class="icon-arrow-up"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No banners available</p>
            <?php endif; ?>
        </section>




        <!--Main Slider Start -->

        <!--Services One Start -->
        <section class="services-one">
            <div class="services-one__shape-1 float-bob-y">
                <img src="assets/images/shapes/services-one-shape-1.png" alt="">
            </div>
            <div class="services-one__shape-2 float-bob-x">
                <img src="assets/images/shapes/services-one-shape-2.png" alt="">
            </div>
            <div class="services-one__shape-3 float-bob-y">
                <img src="assets/images/shapes/services-one-shape-3.png" alt="">
            </div>
            <div class="container">
                <div class="section-title text-center sec-title-animation animation-style1">
                    <div class="section-title__tagline-box">
                        <div class="section-title__tagline-shape"></div>
                        <span class="section-title__tagline">Our Services</span>
                    </div>
                    <h2 class="section-title__title title-animation">Empowering Communities Through <br> Compassionate Action</h2>
                </div>
                <div class="row">
                <!--Services One Single Start-->
                <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay=".3s">
                    <div class="services-one__single">
                        <div class="services-one__img-box">
                            <div class="services-one__img">
                                <img src="assets/images/services/services-1-1.png" alt="">
                            </div>
                            <div class="services-one__content">
                                <div class="services-one__content-inner">
                                    <div class="services-one__icon">
                                        <span class="icon-take-away"></span>
                                    </div>
                                    <h3 class="services-one__title">
                                        <a href="service-details.html">Addressing Agricultural Challenges</a>
                                    </h3>
                                    <p class="services-one__text">
                                        Providing solutions to key agricultural challenges like low-yielding breeds, diseases, and poor management practices.
                                    </p>
                                    <div class="services-one__arrow">
                                        <a href="service-details.html"><span class="icon-arrow-up"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Services One Single End-->
    
    <!--Services One Single Start-->
    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay=".5s">
        <div class="services-one__single">
            <div class="services-one__img-box">
                <div class="services-one__img">
                    <img src="assets/images/services/services-1-2.png" alt="">
                </div>
                <div class="services-one__content">
                    <div class="services-one__content-inner">
                        <div class="services-one__icon">
                            <span class="icon-take-away"></span>
                        </div>
                        <h3 class="services-one__title">
                            <a href="service-details.html">Empowerment and Capacity Building</a>
                        </h3>
                        <p class="services-one__text">
                            Offering capacity building, training, and extension services to empower farmers and marginalized groups.
                        </p>
                        <div class="services-one__arrow">
                            <a href="service-details.html"><span class="icon-arrow-up"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Services One Single End-->
    
    <!--Services One Single Start-->
    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay=".7s">
        <div class="services-one__single">
            <div class="services-one__img-box">
                <div class="services-one__img">
                    <img src="assets/images/services/services-1-3.jpg" alt="">
                </div>
                <div class="services-one__content">
                    <div class="services-one__content-inner">
                        <div class="services-one__icon">
                            <span class="icon-take-away"></span>
                        </div>
                        <h3 class="services-one__title">
                            <a href="service-details.html">Innovation and Sustainability</a>
                        </h3>
                        <p class="services-one__text">
                            Promoting climate-smart practices, clean animal products, and IT-driven solutions for record-keeping and market linkages.
                        </p>
                        <div class="services-one__arrow">
                            <a href="service-details.html"><span class="icon-arrow-up"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Services One Single End-->
</div>

                <div class="services-one__video">
                    <div class="services-one__video-img">
                        <img src="assets/images/services/services-one-video-img.png" alt="">
                        <div class="services-one__video-link">
                            <a href="https://www.youtube.com/watch?v=Get7rqXYrbQ" class="video-popup">
                                <div class="services-one__video-icon">
                                    <span>Play</span>
                                    <i class="ripple"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="services-one__audio-box">
                        <div class="services-one__audio-content">
                            <audio>
                                <source src="https://file-examples-com.github.io/uploads/2017/11/file_example_MP3_700KB.mp3" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                            <div class="player">
                                <div class="playpause">
                                    <i class="play fa fa-play-circle" aria-hidden="true"></i>
                                    <i class="pause fa fa-pause-circle" aria-hidden="true"></i>
                                </div>
                                <div class="scrubber">
                                    <div class="bar">
                                        <div class="position-marker"></div>
                                    </div>
                                </div>
                                <div class="elapsed">
                                    <span>00:00</span>
                                </div>
                            </div>
                        </div>
                        <div class="services-one__audio-title-box">
                            <h4>Holistic Solutions</h4>
                            <p>
                                Providing access to nutritious animal products, IT-based solutions, and innovative tools for farmers' empowerment.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!--Services One End -->

        <!--About One Start -->
        <section class="about-one">
            <div class="about-one__shape-1 float-bob">
                <img src="assets/images/shapes/about-one-shape-1.png" alt="">
            </div>
            <div class="container">
                <div class="section-title text-left sec-title-animation animation-style2">
                    <div class="section-title__tagline-box">
                        <div class="section-title__tagline-shape"></div>
                        <span class="section-title__tagline">About Us</span>
                    </div>
                    <h2 class="section-title__title title-animation">Transforming Lives Through Empowerment and Innovation</h2>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="about-one__left">
                            <p class="about-one__text">Despite the growing demand for livestock products, farmers have not been able to bridge the gap through supply. Challenges such as low-yielding breeds, poor management practices, diseases, and seasonal fluctuations in forage and feed persist. Our organization aims to empower farmers by providing capacity building, training, extension services, consultation, and community mobilization.</p>
                            <div class="about-one__img-box">
                                <div class="about-one__img">
                                    <img src="assets/images/resources/aboutone-img-1.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="about-one__right">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6">
                                    <div class="about-one__single">
                                        <div class="about-one__icon">
                                            <span class="icon-mother-earth-day"></span>
                                        </div>
                                        <h3 class="about-one__title"><a href="about.php">Empowering Farmers</a></h3>
                                        <p class="about-one__text">Offering training, market linkage, and support to address challenges in livestock and crop value chains.</p>
                                        <div class="about-one__read-more">
                                            <span></span>
                                            <a href="about.php">Read More</a>
                                        </div>
                                    </div>
                                    <div class="about-one__single">
                                        <div class="about-one__icon">
                                            <span class="icon-dollar"></span>
                                        </div>
                                        <h3 class="about-one__title"><a href="about.php">Sustainable Practices</a></h3>
                                        <p class="about-one__text">Promoting clean animal products, good nutrition, and food security while safeguarding the environment.</p>
                                        <div class="about-one__read-more">
                                            <span></span>
                                            <a href="about.php">Read More</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="about-one__round-text-box">
                                        <div class="about-one__round-text-box-inner rotate-me">
                                            <div class="about-one__curved-circle">
                                                - years of experience - years of experience
                                            </div>
                                        </div>
                                        <div class="about-one__count count-box">
                                            <h3 class="count-text" data-stop="25" data-speed="1500">00</h3>
                                            <span>+</span>
                                        </div>
                                    </div>
                                    <div class="about-one__single">
                                        <div class="about-one__icon">
                                            <span class="icon-people"></span>
                                        </div>
                                        <h3 class="about-one__title"><a href="about.php">Innovative Solutions</a></h3>
                                        <p class="about-one__text">Embracing IT tools to solve challenges in the livestock and crop sectors effectively.</p>
                                        <div class="about-one__read-more">
                                            <span></span>
                                            <a href="about.php">Read More</a>
                                        </div>
                                    </div>
                                    <div class="about-one__client-box">
                                        <div class="about-one__client-img">
                                            <img src="assets/images/resources/about-one-client-img.jpg" alt="">
                                        </div>
                                        <div class="about-one__client-content">
                                            <p>Dedicated to Empowerment</p>
                                            <div class="about-one__sign">
                                                <img src="assets/images/resources/about-one-client-sign.png" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--About One End -->

        <!--Counter One Start -->
        <section class="counter-one">
            <div class="container">
                <div class="row text-center">
                    <!-- Counter Single Start -->
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                        <div class="counter-one__single">
                            <h3 class="count-text" data-stop="98" data-speed="1500">00</h3>
                            <p class="counter-one__count-text">Causes</p>
                        </div>
                    </div>
                    <!-- Counter Single End -->

                    <!-- Counter Single Start -->
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                        <div class="counter-one__single">
                            <h3 class="count-text" data-stop="6084" data-speed="1500">00</h3>
                            <p class="counter-one__count-text">Saved Lives</p>
                        </div>
                    </div>
                    <!-- Counter Single End -->

                    <!-- Counter Single Start -->
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                        <div class="counter-one__single">
                            <h3 class="count-text" data-stop="378" data-speed="1500">00</h3>
                            <p class="counter-one__count-text">Volunteers</p>
                        </div>
                    </div>
                    <!-- Counter Single End -->

                    <!-- Counter Single Start -->
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                        <div class="counter-one__single">
                            <h3 class="count-text" data-stop="16" data-speed="1500">00</h3>
                            <p class="counter-one__count-text">Places</p>
                        </div>
                    </div>
                    <!-- Counter Single End -->
                </div>
            </div>
        </section>

        <!--Counter One End -->

        <!--Courses One Start -->

        <section class="courses-one">
            <div class="courses-one__shape-1 float-bob">
                <img src="assets/images/shapes/courses-one-shape-1.png" alt="">
            </div>
            <div class="container-fluid"> <!-- Full width container -->
                <div class="row">
                    <?php if ($result_cause && $result_cause->num_rows > 0): ?>
                        <?php while ($cause = $result_cause->fetch_assoc()): ?>
                            <div class="col-xl-4 col-lg-4 col-md-6"> <!-- Ensures 3 columns -->
                                <div class="courses-one__single">
                                    <div class="courses-one__img-box">
                                        <div class="courses-one__img">
                                            <img src="<?= htmlspecialchars($cause['image_url']); ?>" alt="Image Not Found">
                                            <!-- Debugging Output -->
                                            <p>Debug: <?= htmlspecialchars($cause['image_url']); ?></p>
                                        </div>
                                        <div class="courses-one__tag">
                                            <span><?= htmlspecialchars($cause['title']); ?></span>
                                        </div>
                                    </div>
                                    <div class="courses-one__content">
                                        <h3 class="courses-one__title"><a href="#"><?= htmlspecialchars($cause['title']); ?></a></h3>
                                        <p class="courses-one__text"><?= htmlspecialchars($cause['description']); ?></p>
                                        <div class="courses-one__rised-and-goals">
                                            <div class="courses-one__raised">
                                                <h4>$<?= number_format($cause['raised'], 2); ?><span>Raised</span></h4>
                                            </div>
                                            <div class="courses-one__goals">
                                                <h4>$<?= number_format($cause['goal'], 2); ?><span>Goal</span></h4>
                                            </div>
                                        </div>
                                        <div class="progress-levels">
                                            <div class="progress-box">
                                                <div class="inner count-box">
                                                    <div class="bar">
                                                        <div class="bar-innner">
                                                            <div class="skill-percent">
                                                                <span class="count-text" data-speed="3000" data-stop="<?= round(($cause['raised'] / $cause['goal']) * 100, 2); ?>">0</span>
                                                                <span class="percent">%</span>
                                                                <div class="progress-box__progress-shape-1">
                                                                    <img src="assets/images/shapes/courses-one-progress-shape-1.png" alt="">
                                                                </div>
                                                                <div class="progress-box__progress-shape-2">
                                                                    <img src="assets/images/shapes/courses-one-progress-shape-2.png" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="bar-fill" data-percent="<?= round(($cause['raised'] / $cause['goal']) * 100, 2); ?>"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="courses-one__btn-box">
                                            <a href="<?= htmlspecialchars($cause['button_link']); ?>" class="courses-one__btn thm-btn">
                                                <span><?= htmlspecialchars($cause['button_text']); ?></span><i class="icon-arrow-up"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No causes available at the moment.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>




        <!--Courses One End -->

        <!--Event One Start -->
        <section class="event-one">
            <div class="event-one__shape-1 float-bob">
                <img src="assets/images/shapes/event-one-shape-1.png" alt="">
            </div>
            <div class="container">
                <div class="section-title text-center sec-title-animation animation-style1">
                    <div class="section-title__tagline-box">
                        <div class="section-title__tagline-shape"></div>
                        <span class="section-title__tagline">Our Events</span>
                    </div>
                    <h2 class="section-title__title title-animation">Events Schedule Upcoming
                        <br> Events.</h2>
                </div>
                <div class="row">
                    <!--Event One Single Start-->
                    <div class="col-xl-6 col-lg-6 wow fadeInUp" data-wow-delay=".1s">
                        <div class="event-one__single">
                            <div class="event-one__img-box">
                                <div class="event-one__img">
                                    <img src="assets/images/event/event-1-1.jpg" alt="">
                                </div>
                                <div class="event-one__date">
                                    <div class="event-one__date-shape-1">
                                        <img src="assets/images/shapes/event-one-date-shape-1.png" alt="">
                                    </div>
                                    <p>10 August</p>
                                </div>
                            </div>
                            <div class="event-one__content">
                                <h3 class="event-one__title"><a href="events.html">Environmental Clean <br>Up Day</a>
                                </h3>
                                <p class="event-one__text">By Brooklyn Simmons<span>09:05AM - 01:05 AM</span></p>
                                <div class="event-one__btn-box">
                                    <a href="events.html" class="event-one__btn"><i
                                            class="icon-right-arrow"></i><span>Read
                                            More</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Event One Single End-->
                    <!--Event One Single Start-->
                    <div class="col-xl-6 col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                        <div class="event-one__single">
                            <div class="event-one__img-box">
                                <div class="event-one__img">
                                    <img src="assets/images/event/event-1-2.jpg" alt="">
                                </div>
                                <div class="event-one__date">
                                    <div class="event-one__date-shape-1">
                                        <img src="assets/images/shapes/event-one-date-shape-1.png" alt="">
                                    </div>
                                    <p>23 April</p>
                                </div>
                            </div>
                            <div class="event-one__content">
                                <h3 class="event-one__title"><a href="events.html">Environmental Clean <br>Up Day</a>
                                </h3>
                                <p class="event-one__text">By Brooklyn Simmons<span>09:05AM - 01:05 AM</span></p>
                                <div class="event-one__btn-box">
                                    <a href="events.html" class="event-one__btn"><i
                                            class="icon-right-arrow"></i><span>Read
                                            More</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Event One Single End-->
                    <!--Event One Single Start-->
                    <div class="col-xl-6 col-lg-6 wow fadeInUp" data-wow-delay=".5s">
                        <div class="event-one__single">
                            <div class="event-one__img-box">
                                <div class="event-one__img">
                                    <img src="assets/images/event/event-1-3.jpg" alt="">
                                </div>
                                <div class="event-one__date">
                                    <div class="event-one__date-shape-1">
                                        <img src="assets/images/shapes/event-one-date-shape-1.png" alt="">
                                    </div>
                                    <p>03 June</p>
                                </div>
                            </div>
                            <div class="event-one__content">
                                <h3 class="event-one__title"><a href="events.html">Environmental Clean <br>Up Day</a>
                                </h3>
                                <p class="event-one__text">By Brooklyn Simmons<span>09:05AM - 01:05 AM</span></p>
                                <div class="event-one__btn-box">
                                    <a href="events.html" class="event-one__btn"><i
                                            class="icon-right-arrow"></i><span>Read
                                            More</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Event One Single End-->
                    <!--Event One Single Start-->
                    <div class="col-xl-6 col-lg-6 wow fadeInUp" data-wow-delay=".7s">
                        <div class="event-one__single">
                            <div class="event-one__img-box">
                                <div class="event-one__img">
                                    <img src="assets/images/event/event-1-4.jpg" alt="">
                                </div>
                                <div class="event-one__date">
                                    <div class="event-one__date-shape-1">
                                        <img src="assets/images/shapes/event-one-date-shape-1.png" alt="">
                                    </div>
                                    <p>10 March</p>
                                </div>
                            </div>
                            <div class="event-one__content">
                                <h3 class="event-one__title"><a href="events.html">Environmental Clean <br>Up Day</a>
                                </h3>
                                <p class="event-one__text">By Brooklyn Simmons<span>09:05AM - 01:05 AM</span></p>
                                <div class="event-one__btn-box">
                                    <a href="events.html" class="event-one__btn"><i
                                            class="icon-right-arrow"></i><span>Read
                                            More</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Event One Single End-->
                </div>
                <div class="event-one__btn-2">
                    <a href="events.html" class="event-one__btn-2 thm-btn"><span>See All</span><i
                            class="icon-arrow-up"></i></a>
                </div>
            </div>
        </section>
        <!--Event One End -->

        <!--Video One Start -->
        <section class="video-one">
            <div class="video-one__shape-1 float-bob-x">
                <img src="assets/images/shapes/video-one-shape-1.png" alt="">
            </div>
            <div class="video-one__bg" style="background-image: url(assets/images/backgrounds/video-one-bg.jpg);"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-7 wow fadeInUp" data-wow-delay=".3s">
                        <div class="video-one__left">
                            <div class="video-one__video-link">
                                <a href="https://www.youtube.com/watch?v=Get7rqXYrbQ" class="video-popup">
                                    <div class="video-one__video-icon">
                                        <span>Play</span>
                                        <i class="ripple"></i>
                                    </div>
                                </a>
                            </div>
                            <h3 class="video-one__left-title">Best Volunteer</h3>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5 wow fadeInRight" data-wow-delay=".3s">
                        <div class="video-one__right">
                            <div class="video-one__need-help">
                                <h3 class="video-one__need-help-title">Support Us, we need
                                    <br> your help</h3>
                                <div class="video-one__progress-box">
                                    <div class="circle-progress"
                                        data-options='{ "value": 0.80,"thickness": 6,"emptyFill": "#007B39","lineCap": "square", "size": 116, "fill": { "color": "#FFFFFF" } }'>
                                    </div><!-- /.circle-progress -->
                                    <span>70%</span>
                                </div>
                                <h3 class="video-one__need-help-dolor">$72,000</h3>
                                <p class="video-one__need-help-donate">Donation Collected</p>
                                <div class="video-one__need-help-btn-box">
                                    <a href="courses-details.html" class="video-one__btn thm-btn"><span>Donate
                                            Now</span><i class="icon-arrow-up"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Video One End -->

        <!--Become Volunteer Start -->
        <section class="become-volunteer">
            <div class="become-volunteer__inner">
                <div class="become-volunteer__shape-1">
                    <img src="assets/images/shapes/become-volunteer-shape-1.png" alt="">
                </div>
                <div class="become-volunteer__single">
                    <div class="become-volunteer__single-bg"
                        style="background-image: url(assets/images/backgrounds/become-volunteer-single-bg.jpg);"></div>
                    <h3 class="become-volunteer__title"><a href="contact.html">Join Us Volunteer</a></h3>
                    <p class="become-volunteer__text">Becoming a volunteer with Chioary means joining a dedicated
                        team
                        <br> committed to making a difference. We welcome individuals from
                        <br> all walks of life who are passionate</p>
                    <div class="become-volunteer__btn-box">
                        <a href="contact.html" class="become-volunteer__btn thm-btn"><span>See More</span><i
                                class="icon-arrow-up"></i></a>
                    </div>
                </div>
                <div class="become-volunteer__single">
                    <div class="become-volunteer__single-bg-2"
                        style="background-image: url(assets/images/backgrounds/become-volunteer-single-bg-2.jpg);">
                    </div>
                    <h3 class="become-volunteer__title"><a href="team.html">Become Volunteer</a></h3>
                    <p class="become-volunteer__text">Becoming a volunteer with Chioary means joining a dedicated
                        team
                        <br> committed to making a difference. We welcome individuals from
                        <br> all walks of life who are passionate</p>
                    <div class="become-volunteer__btn-box">
                        <a href="team.html" class="become-volunteer__btn-2 thm-btn"><span>See More</span><i
                                class="icon-arrow-up"></i></a>
                    </div>
                </div>
            </div>
        </section>
        <!--Become Volunteer End -->

        <!--Team One Start -->
        <section class="team-one">
            <div class="team-one__shape-1 float-bob">
                <img src="assets/images/shapes/team-one-shape-1.png" alt="">
            </div>
            <div class="container">
                <div class="section-title text-center sec-title-animation animation-style1">
                    <div class="section-title__tagline-box">
                        <div class="section-title__tagline-shape"></div>
                        <span class="section-title__tagline">Our Team Member</span>
                    </div>
                    <h2 class="section-title__title title-animation">Events Schedule Upcoming
                        <br> Events.</h2>
                </div>
                <div class="row">
                    <!--Team One Single Start-->
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".1s">
                        <div class="team-one__single">
                            <div class="team-one__img-box">
                                <div class="team-one__img">
                                    <img src="assets/images/team/team-1-1.jpg" alt="">
                                </div>
                            </div>
                            <div class="team-one__content">
                                <div class="team-one__social-list">
                                    <div class="team-one__social-plus-minus">
                                        <p>
                                            <span class="icon-plus team-one__plus"></span>
                                            <span class="icon-minus team-one__minus"></span>
                                        </p>
                                    </div>
                                    <div class="team-one__social">
                                        <a href="#"><span class="icon-facebook"></span></a>
                                        <a href="#"><span class="icon-twitter"></span></a>
                                        <a href="#"><span class="icon-instagram"></span></a>
                                        <a href="#"><span class="icon-youtube"></span></a>
                                    </div>
                                </div>
                                <div class="team-one__title-box">
                                    <h3><a href="team.html">Leslie Alexander</a></h3>
                                    <p>Junior Poster</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Team One Single End-->
                    <!--Team One Single Start-->
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                        <div class="team-one__single">
                            <div class="team-one__img-box">
                                <div class="team-one__img">
                                    <img src="assets/images/team/team-1-2.jpg" alt="">
                                </div>
                            </div>
                            <div class="team-one__content">
                                <div class="team-one__social-list">
                                    <div class="team-one__social-plus-minus">
                                        <p>
                                            <span class="icon-plus team-one__plus"></span>
                                            <span class="icon-minus team-one__minus"></span>
                                        </p>
                                    </div>
                                    <div class="team-one__social">
                                        <a href="#"><span class="icon-facebook"></span></a>
                                        <a href="#"><span class="icon-twitter"></span></a>
                                        <a href="#"><span class="icon-instagram"></span></a>
                                        <a href="#"><span class="icon-youtube"></span></a>
                                    </div>
                                </div>
                                <div class="team-one__title-box">
                                    <h3><a href="team.html">Annette Black</a></h3>
                                    <p>Senior Poster</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Team One Single End-->
                    <!--Team One Single Start-->
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                        <div class="team-one__single">
                            <div class="team-one__img-box">
                                <div class="team-one__img">
                                    <img src="assets/images/team/team-1-3.jpg" alt="">
                                </div>
                            </div>
                            <div class="team-one__content">
                                <div class="team-one__social-list">
                                    <div class="team-one__social-plus-minus">
                                        <p>
                                            <span class="icon-plus team-one__plus"></span>
                                            <span class="icon-minus team-one__minus"></span>
                                        </p>
                                    </div>
                                    <div class="team-one__social">
                                        <a href="#"><span class="icon-facebook"></span></a>
                                        <a href="#"><span class="icon-twitter"></span></a>
                                        <a href="#"><span class="icon-instagram"></span></a>
                                        <a href="#"><span class="icon-youtube"></span></a>
                                    </div>
                                </div>
                                <div class="team-one__title-box">
                                    <h3><a href="team.html">Dianne Russell</a></h3>
                                    <p>Junior Poster</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Team One Single End-->
                    <!--Team One Single Start-->
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".7s">
                        <div class="team-one__single">
                            <div class="team-one__img-box">
                                <div class="team-one__img">
                                    <img src="assets/images/team/team-1-4.jpg" alt="">
                                </div>
                            </div>
                            <div class="team-one__content">
                                <div class="team-one__social-list">
                                    <div class="team-one__social-plus-minus">
                                        <p>
                                            <span class="icon-plus team-one__plus"></span>
                                            <span class="icon-minus team-one__minus"></span>
                                        </p>
                                    </div>
                                    <div class="team-one__social">
                                        <a href="#"><span class="icon-facebook"></span></a>
                                        <a href="#"><span class="icon-twitter"></span></a>
                                        <a href="#"><span class="icon-instagram"></span></a>
                                        <a href="#"><span class="icon-youtube"></span></a>
                                    </div>
                                </div>
                                <div class="team-one__title-box">
                                    <h3><a href="team.html">Marvin McKinney</a></h3>
                                    <p>Junior Poster</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Team One Single End-->
                </div>
                <div class="team-one__btn-box">
                    <a href="team.html" class="team-one__btn thm-btn"><span>See All</span><i
                            class="icon-arrow-up"></i></a>
                </div>
            </div>
        </section>
        <!--Team One End -->

        <!--Testimonial One Start -->
        <section class="testimonial-one">
            <div class="testimonial-one__bg" data-jarallax data-speed="0.3" data-imgPosition="100% 100%"
                style="background-image: url(assets/images/backgrounds/testimonial-one-bg.jpg);"></div>
            <div class="testimonial-one__quote">
                <img src="assets/images/icon/quote.png" alt="">
            </div>
            <div class="container">
                <div class="section-title text-center sec-title-animation animation-style1">
                    <div class="section-title__tagline-box">
                        <div class="section-title__tagline-shape"></div>
                        <span class="section-title__tagline">Our Testimonial</span>
                    </div>
                    <h2 class="section-title__title title-animation">Our Impact in Their Words</h2>
                </div>
                <div class="testimonial-one__carousel owl-theme owl-carousel">
                    <!--Testimonial One Single Start-->
                    <div class="item">
                        <div class="testimonial-one__single">
                            <p class="testimonial-one__text">I’ve had the privilege of volunteering
                                <br> with Chioary and I’m continually inspired by the
                                <br> dedication and passion of the team.</p>
                            <div class="testimonial-one__client-info">
                                <div class="testimonial-one__client-img">
                                    <img src="assets/images/testimonial/testimonial-1-1.jpg" alt="">
                                </div>
                                <div class="testimonial-one__client-content">
                                    <h3>Ronald Richards</h3>
                                    <p>General manager</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Testimonial One Single End-->
                    <!--Testimonial One Single Start-->
                    <div class="item">
                        <div class="testimonial-one__single">
                            <p class="testimonial-one__text">I’ve had the privilege of volunteering
                                <br> with Chioary and I’m continually inspired by the
                                <br> dedication and passion of the team.</p>
                            <div class="testimonial-one__client-info">
                                <div class="testimonial-one__client-img">
                                    <img src="assets/images/testimonial/testimonial-1-2.jpg" alt="">
                                </div>
                                <div class="testimonial-one__client-content">
                                    <h3>Courtney Henry</h3>
                                    <p>General manager</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Testimonial One Single End-->
                    <!--Testimonial One Single Start-->
                    <div class="item">
                        <div class="testimonial-one__single">
                            <p class="testimonial-one__text">I’ve had the privilege of volunteering
                                <br> with Chioary and I’m continually inspired by the
                                <br> dedication and passion of the team.</p>
                            <div class="testimonial-one__client-info">
                                <div class="testimonial-one__client-img">
                                    <img src="assets/images/testimonial/testimonial-1-3.jpg" alt="">
                                </div>
                                <div class="testimonial-one__client-content">
                                    <h3>Adam Smith</h3>
                                    <p>General manager</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Testimonial One Single End-->
                    <!--Testimonial One Single Start-->
                    <div class="item">
                        <div class="testimonial-one__single">
                            <p class="testimonial-one__text">I’ve had the privilege of volunteering
                                <br> with Chioary and I’m continually inspired by the
                                <br> dedication and passion of the team.</p>
                            <div class="testimonial-one__client-info">
                                <div class="testimonial-one__client-img">
                                    <img src="assets/images/testimonial/testimonial-1-4.jpg" alt="">
                                </div>
                                <div class="testimonial-one__client-content">
                                    <h3>Robert Ken</h3>
                                    <p>General manager</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Testimonial One Single End-->
                </div>
            </div>
        </section>
        <!--Testimonial One End -->

        <!--FAQ One Start -->
        <section class="faq-one">
            <div class="faq-one__shape-1 float-bob">
                <img src="assets/images/shapes/faq-one-shape-1.png" alt="">
            </div>
            <div class="faq-one__shape-2 float-bob-x">
                <img src="assets/images/shapes/faq-one-shape-2.png" alt="">
            </div>
            <div class="container">
                <div class="faq-one__inner">
                    <div class="row">
                        <div class="col-xl-5 col-lg-6">
                            <div class="faq-one__left">
                                <div class="section-title text-left sec-title-animation animation-style2">
                                    <div class="section-title__tagline-box">
                                        <div class="section-title__tagline-shape"></div>
                                        <span class="section-title__tagline">Our Faq</span>
                                    </div>
                                    <h2 class="section-title__title title-animation">Frequently Asking
                                        <br> Questions.</h2>
                                </div>
                                <div class="faq-one__btn-box">
                                    <a href="faq.html" class="faq-one__btn thm-btn"><span>More Questions</span><i
                                            class="icon-arrow-up"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-6">
                            <div class="faq-one__right">
                                <div class="accrodion-grp faq-one-accrodion" data-grp-name="faq-one-accrodion-1">
                                    <div class="accrodion">
                                        <div class="accrodion-title">
                                            <h4>Can I organize a fundraiser for your charity?</h4>
                                        </div>
                                        <div class="accrodion-content">
                                            <div class="inner">
                                                <p>We are committed to maintaining the highest standards of
                                                    transparency.
                                                    Our financial statements, annual reports, and impact assessments are
                                                    publicly available, and we are regularly</p>
                                            </div><!-- /.inner -->
                                        </div>
                                    </div>
                                    <div class="accrodion  active">
                                        <div class="accrodion-title">
                                            <h4>How can I stay updated on your activities?</h4>
                                        </div>
                                        <div class="accrodion-content">
                                            <div class="inner">
                                                <p>We are committed to maintaining the highest standards of
                                                    transparency.
                                                    Our financial statements, annual reports, and impact assessments are
                                                    publicly available, and we are regularly</p>
                                            </div><!-- /.inner -->
                                        </div>
                                    </div>
                                    <div class="accrodion">
                                        <div class="accrodion-title">
                                            <h4>Do you collaborate with other organizations?</h4>
                                        </div>
                                        <div class="accrodion-content">
                                            <div class="inner">
                                                <p>We are committed to maintaining the highest standards of
                                                    transparency.
                                                    Our financial statements, annual reports, and impact assessments are
                                                    publicly available, and we are regularly</p>
                                            </div><!-- /.inner -->
                                        </div>
                                    </div>
                                    <div class="accrodion">
                                        <div class="accrodion-title">
                                            <h4>What kind of services do you provide?</h4>
                                        </div>
                                        <div class="accrodion-content">
                                            <div class="inner">
                                                <p>We are committed to maintaining the highest standards of
                                                    transparency.
                                                    Our financial statements, annual reports, and impact assessments are
                                                    publicly available, and we are regularly</p>
                                            </div><!-- /.inner -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--FAQ One End -->

        <!--Blog One Start -->
        <section class="blog-one">
            <div class="blog-one__shape-1 float-bob">
                <img src="assets/images/shapes/blog-one-shape-1.png" alt="#">
            </div>
            <div class="container">
                <div class="blog-one__top">
                    <div class="section-title text-left sec-title-animation animation-style2">
                        <div class="section-title__tagline-box">
                            <div class="section-title__tagline-shape"></div>
                            <span class="section-title__tagline">Our Blog</span>
                        </div>
                        <h2 class="section-title__title title-animation">Frequently asking
                            <br> questions.</h2>
                    </div>
                    <div class="blog-one__top-btn-box">
                        <a href="blog.html" class="blog-one__top-btn thm-btn"><span>See All Blog</span><i
                                class="icon-arrow-up"></i></a>
                    </div>
                </div>
                <div class="row">
                    <!--Blog One Single Start-->
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay=".1s">
                        <div class="blog-one__single">
                            <div class="blog-one__img-box">
                                <div class="blog-one__img">
                                    <img src="assets/images/blog/blog-1-1.jpg" alt="">
                                    <div class="blog-one__plus">
                                        <a href="blog-details.html"><span class="icon-plus"></span></a>
                                    </div>
                                </div>
                                <div class="blog-one__date">
                                    <div class="blog-one__date-shape-1">
                                        <img src="assets/images/shapes/blog-one-date-shape-1.png" alt="">
                                    </div>
                                    <div class="blog-one__date-shape-2">
                                        <img src="assets/images/shapes/blog-one-date-shape-2.png" alt="">
                                    </div>
                                    <p>10 Aug 2024</p>
                                </div>
                            </div>
                            <div class="blog-one__content">
                                <ul class="blog-one__meta list-unstyled">
                                    <li>
                                        <a href="#"><span class="icon-user-two"></span>By cane Anderson</a>
                                    </li>
                                    <li>
                                        <a href="#"><span class="icon-chat"></span>02 Comment</a>
                                    </li>
                                </ul>
                                <h3 class="blog-one__title"><a href="blog-details.html">One such example is our recent
                                        food distribution program.</a></h3>
                                <div class="blog-one__btn-box">
                                    <a href="blog-details.html" class="blog-one__btn thm-btn"><span>Read More</span><i
                                            class="icon-arrow-up"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Blog One Single End-->
                    <!--Blog One Single Start-->
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay=".3s">
                        <div class="blog-one__single">
                            <div class="blog-one__img-box">
                                <div class="blog-one__img">
                                    <img src="assets/images/blog/blog-1-2.jpg" alt="">
                                    <div class="blog-one__plus">
                                        <a href="blog-details.html"><span class="icon-plus"></span></a>
                                    </div>
                                </div>
                                <div class="blog-one__date">
                                    <div class="blog-one__date-shape-1">
                                        <img src="assets/images/shapes/blog-one-date-shape-1.png" alt="">
                                    </div>
                                    <div class="blog-one__date-shape-2">
                                        <img src="assets/images/shapes/blog-one-date-shape-2.png" alt="">
                                    </div>
                                    <p>25 June 2024</p>
                                </div>
                            </div>
                            <div class="blog-one__content">
                                <ul class="blog-one__meta list-unstyled">
                                    <li>
                                        <a href="#"><span class="icon-user-two"></span>By cane Anderson</a>
                                    </li>
                                    <li>
                                        <a href="#"><span class="icon-chat"></span>02 Comment</a>
                                    </li>
                                </ul>
                                <h3 class="blog-one__title"><a href="blog-details.html">the impact of our community
                                        doesn’t stop at food distribution.</a></h3>
                                <div class="blog-one__btn-box">
                                    <a href="blog-details.html" class="blog-one__btn thm-btn"><span>Read More</span><i
                                            class="icon-arrow-up"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Blog One Single End-->
                    <!--Blog One Single Start-->
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay=".7s">
                        <div class="blog-one__single">
                            <div class="blog-one__img-box">
                                <div class="blog-one__img">
                                    <img src="assets/images/blog/blog-1-3.jpg" alt="">
                                    <div class="blog-one__plus">
                                        <a href="blog-details.html"><span class="icon-plus"></span></a>
                                    </div>
                                </div>
                                <div class="blog-one__date">
                                    <div class="blog-one__date-shape-1">
                                        <img src="assets/images/shapes/blog-one-date-shape-1.png" alt="">
                                    </div>
                                    <div class="blog-one__date-shape-2">
                                        <img src="assets/images/shapes/blog-one-date-shape-2.png" alt="">
                                    </div>
                                    <p>15 March 2024</p>
                                </div>
                            </div>
                            <div class="blog-one__content">
                                <ul class="blog-one__meta list-unstyled">
                                    <li>
                                        <a href="#"><span class="icon-user-two"></span>By cane Anderson</a>
                                    </li>
                                    <li>
                                        <a href="#"><span class="icon-chat"></span>02 Comment</a>
                                    </li>
                                </ul>
                                <h3 class="blog-one__title"><a href="blog-details.html">These stories are just a few
                                        examples of how powerful.</a></h3>
                                <div class="blog-one__btn-box">
                                    <a href="blog-details.html" class="blog-one__btn thm-btn"><span>Read More</span><i
                                            class="icon-arrow-up"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Blog One Single End-->
                </div>
            </div>
        </section>
        <!--Blog One End -->

        <!--Newsletter One Start -->
        <section class="newsletter-one">
            <div class="newsletter-one__bg"
                style="background-image: url(assets/images/backgrounds/newsletter-one-bg.jpg);"></div>
            <div class="container">
                <div class="newsletter-one__inner">
                    <h2 class="newsletter-one__title">Get updated by subscribing to
                        <br> our newsletter</h2>
                    <p class="newsletter-one__text">Join our community of supporters by subscribing to our newsletter!
                        <br> Get the latest updates on our projects,</p>
                    <form class="newsletter-one__form">
                        <div class="newsletter-one__input">
                            <input type="email" placeholder="Your Email">
                        </div>
                        <button type="submit" class="newsletter-one__btn"><i class="icon-arrow-up"></i></button>
                    </form>
                </div>
            </div>
        </section>
        <!--Newsletter One End -->
</body>

<?php include('footer.php')?>