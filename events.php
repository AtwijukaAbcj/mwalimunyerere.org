<!DOCTYPE html>
<html lang="en">
<?php include 'root/config.php';
        $sql = "SELECT * FROM events ORDER BY event_date ASC";
        $result = $conn->query($sql);
            // Pagination logic
            $limit = 6; // Number of items per page
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;

            // Fetch total number of events
            $total_sql = "SELECT COUNT(*) as total FROM events";
            $total_result = $conn->query($total_sql);
            $total_events = $total_result->fetch_assoc()['total'];
            $total_pages = ceil($total_events / $limit);

            // Fetch paginated events
            $sql = "SELECT * FROM events ORDER BY event_date ASC LIMIT $offset, $limit";
            $result = $conn->query($sql);
?>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Events || Chioary || Chioary HTML 5 Template </title>
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

    <div class="page-wrapper">
    <?php include 'header.php'?>

        <div class="stricky-header stricked-menu main-menu">
            <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->



        <!--Page Header Start-->
        <section class="page-header">
            <div class="page-header__bg-shape"
                style="background-image: url(assets/images/shapes/page-header-bg-shape.png);">
            </div>
            <div class="container">
                <div class="page-header__inner">
                    <div class="page-header__shape-1">
                        <img src="assets/images/shapes/page-header-shape-1.png" alt="">
                    </div>
                    <h2>Events</h2>
                    <div class="thm-breadcrumb__box">
                        <ul class="thm-breadcrumb list-unstyled">
                            <li><a href="index.html">Home</a></li>
                            <li><span>-</span></li>
                            <li>Events</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--Page Header End-->

<!--Event One Start -->
<section class="event-one">
    <div class="container">
        <div class="section-title text-center sec-title-animation animation-style1">
            <div class="section-title__tagline-box">
                <div class="section-title__tagline-shape"></div>
                <span class="section-title__tagline">Our Events</span>
            </div>
            <h2 class="section-title__title title-animation">Events Schedule Upcoming<br>Events.</h2>
        </div>
        <div class="row">
            <?php


            if ($result && $result->num_rows > 0): ?>
                <?php while ($event = $result->fetch_assoc()): ?>
                    <div class="col-xl-6 col-lg-6 wow fadeInUp" data-wow-delay=".1s">
                        <div class="event-one__single" style="height: 100%;"> <!-- Ensure equal card heights -->
                            <div class="event-one__img-box">
                                <div class="event-one__img">
                                    <img src="<?= htmlspecialchars($event['image']); ?>" alt="">
                                </div>
                                <div class="event-one__date">
                                    <div class="event-one__date-shape-1">
                                        <img src="assets/images/shapes/event-one-date-shape-1.png" alt="">
                                    </div>
                                    <p><?= date('d F', strtotime($event['event_date'])); ?></p>
                                </div>
                            </div>
                            <div class="event-one__content">
                                <h3 class="event-one__title">
                                    <a href="event-details.php?id=<?= $event['id']; ?>">
                                        <?= htmlspecialchars($event['title']); ?>
                                    </a>
                                </h3>
                                <p class="event-one__text">
                                    <?= htmlspecialchars($event['overview']); ?>
                                    <span><?= date('h:i A', strtotime($event['event_time'])); ?></span>
                                </p>
                                <div class="event-one__btn-box">
                                    <a href="event-details.php?id=<?= $event['id']; ?>" class="event-one__btn">
                                        <i class="icon-right-arrow"></i><span>Read More</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No events available at the moment.</p>
            <?php endif;

            $conn->close();
            ?>
        </div>
        <!-- Pagination Section -->
        <div class="prev-and-next">
            <ul class="pg-pagination list-unstyled">
                <?php if ($page > 1): ?>
                    <li class="prev">
                        <a href="?page=<?= $page - 1; ?>" aria-label="prev">Prev</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li>
                        <a href="?page=<?= $i; ?>" class="<?= $i === $page ? 'active' : ''; ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="next">
                        <a href="?page=<?= $page + 1; ?>" aria-label="Next">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
            <p class="prev-and-next__text">
                Showing <?= ($offset + 1); ?> to <?= min($offset + $limit, $total_events); ?> of <?= $total_events; ?>
            </p>
        </div>
    </div>
</section>


        <!--Event One End -->

        <!--Newsletter One Start -->
        <section class="newsletter-one">
            <div class="newsletter-one__bg jarallax" data-jarallax data-speed="0.2" data-imgPosition="50% 0%"
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

        <!--Site Footer Start-->
        <footer class="site-footer">
            <div class="site-footer__shape-1 float-bob">
                <img src="assets/images/shapes/site-footer-shape-1.png" alt="">
            </div>
            <div class="site-footer__shape-2 float-bob-y">
                <img src="assets/images/shapes/site-footer-shape-2.png" alt="">
            </div>
            <div class="site-footer__shape-3 float-bob-x">
                <img src="assets/images/shapes/site-footer-shape-3.png" alt="">
            </div>
            <div class="site-footer__top">
                <div class="container">
                    <div class="site-footer__top-inner">
                        <div class="row">
                            <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                                <div class="footer-widget__about">
                                    <div class="footer-widget__about-logo">
                                        <a href="index.html"><img src="assets/images/resources/footer-logo-1.png"
                                                alt=""></a>
                                    </div>
                                    <p class="footer-widget__about-text">Charity and donation is category that
                                        <br> involves giving.</p>
                                    <div class="site-footer__social">
                                        <a href="#"><i class="icon-facebook"></i></a>
                                        <a href="#"><i class="icon-twitter"></i></a>
                                        <a href="#"><i class="icon-instagram"></i></a>
                                        <a href="#"><i class="icon-youtube"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                                <div class="footer-widget__links">
                                    <h4 class="footer-widget__title">Quick links</h4>
                                    <ul class="footer-widget__links-list list-unstyled">
                                        <li><a href="about.html">About Us</a></li>
                                        <li><a href="services.html">Our Services</a></li>
                                        <li><a href="team.html">Our Team</a></li>
                                        <li><a href="blog.html">Our Blog</a></li>
                                        <li><a href="contact.html">Contact Us</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                                <div class="footer-widget__contact">
                                    <h3 class="footer-widget__title">Contact Us</h3>
                                    <ul class="footer-widget__contact-list list-unstyled">
                                        <li>
                                            <p>4517 Washington Ave. Manchester,
                                                Kentucky 39495</p>
                                        </li>
                                        <li>
                                            <p><a href="tel:2195550114">(219) 555-0114</a></p>
                                        </li>
                                        <li>
                                            <p><a href="mailto:Chioary@gmail.com">Chioary@gmail.com</a></p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="400ms">
                                <div class="footer-widget__services">
                                    <h4 class="footer-widget__title">Services</h4>
                                    <ul class="footer-widget__links-list list-unstyled">
                                        <li><a href="about.html">Emergency Relief</a></li>
                                        <li><a href="about.html">Medical Outreach</a></li>
                                        <li><a href="about.html">Educational Support</a></li>
                                        <li><a href="about.html">Mental Health</a></li>
                                        <li><a href="about.html">Community Development</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site-footer__bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="site-footer__bottom-inner">
                                <div class="site-footer__copyright">
                                    <p class="site-footer__copyright-text">© 1995-2024 All rights for <a
                                            href="#">Chioary</a>
                                        exclusive</p>
                                </div>
                                <div class="site-footer__bottom-menu-box">
                                    <ul class="list-unstyled site-footer__bottom-menu">
                                        <li><a href="about.html">Terms of Service</a></li>
                                        <li><a href="about.html">Privacy policy</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!--Site Footer End-->




    </div><!-- /.page-wrapper -->


    <div class="mobile-nav__wrapper">
        <div class="mobile-nav__overlay mobile-nav__toggler"></div>
        <!-- /.mobile-nav__overlay -->
        <div class="mobile-nav__content">
            <span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>

            <div class="logo-box">
                <a href="index.html" aria-label="logo image"><img src="assets/images/resources/logo-1.png" width="150"
                        alt="" /></a>
            </div>
            <!-- /.logo-box -->
            <div class="mobile-nav__container"></div>
            <!-- /.mobile-nav__container -->

            <ul class="mobile-nav__contact list-unstyled">
                <li>
                    <i class="fa fa-envelope"></i>
                    <a href="mailto:needhelp@packageName__.com">needhelp@chioary.com</a>
                </li>
                <li>
                    <i class="fas fa-phone"></i>
                    <a href="tel:666-888-0000">666 888 0000</a>
                </li>
            </ul><!-- /.mobile-nav__contact -->
            <div class="mobile-nav__top">
                <div class="mobile-nav__social">
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-facebook-square"></a>
                    <a href="#" class="fab fa-pinterest-p"></a>
                    <a href="#" class="fab fa-instagram"></a>
                </div><!-- /.mobile-nav__social -->
            </div><!-- /.mobile-nav__top -->



        </div>
        <!-- /.mobile-nav__content -->
    </div>
    <!-- /.mobile-nav__wrapper -->

    <div class="search-popup">
        <div class="search-popup__overlay search-toggler"></div>
        <!-- /.search-popup__overlay -->
        <div class="search-popup__content">
            <form action="#">
                <label for="search" class="sr-only">search here</label><!-- /.sr-only -->
                <input type="text" id="search" placeholder="Search Here..." />
                <button type="submit" aria-label="search submit" class="thm-btn">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <!-- /.search-popup__content -->
    </div>
    <!-- /.search-popup -->

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top">
        <span class="scroll-to-top__wrapper"><span class="scroll-to-top__inner"></span></span>
        <span class="scroll-to-top__text"> Go Back Top</span>
    </a>


    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jarallax.min.js"></script>
    <script src="assets/js/jquery.ajaxchimp.min.js"></script>
    <script src="assets/js/jquery.appear.min.js"></script>
    <script src="assets/js/swiper.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/jquery.validate.min.js"></script>
    <script src="assets/js/odometer.min.js"></script>
    <script src="assets/js/wNumb.min.js"></script>
    <script src="assets/js/wow.js"></script>
    <script src="assets/js/isotope.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/jquery-ui.js"></script>
    <script src="assets/js/jquery.nice-select.min.js"></script>
    <script src="assets/js/jquery.circleType.js"></script>
    <script src="assets/js/jquery.fittext.js"></script>
    <script src="assets/js/jquery.lettering.min.js"></script>
    <script src="assets/js/jquery.circle-progress.min.js"></script>
    <script src="assets/js/vegas.min.js"></script>
    <script src="assets/js/aos.js"></script>




    <script src="assets/js/gsap/gsap.js"></script>
    <script src="assets/js/gsap/ScrollTrigger.js"></script>
    <script src="assets/js/gsap/SplitText.js"></script>




    <!-- template js -->
    <script src="assets/js/script.js"></script>
</body>

</html>