<footer class="site-footer">
    <div class="footer-widgets">
        <div class="container">
            <div class="row">
                <!-- About Section -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="foot-about site-branding">
                        <h2><a class="foot-logo" href="#"><img src="images/logo.png" alt="Footer Logo"></a></h2>
                        <p>The Mwalimu Nyerere Livelihood Program (MNLP) empowers communities through capacity building, sustainable solutions, and impactful initiatives.</p>
                        <ul class="d-flex flex-wrap align-items-center">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- Useful Links -->
                <div class="col-12 col-md-6 col-lg-3">
                    <h2>Useful Links</h2>
                    <ul>
                        <li><a href="about.html">About Us</a></li>
                        <li><a href="causes.html">Our Causes</a></li>
                        <li><a href="portfolio.html">Gallery</a></li>
                        <li><a href="news.html">News</a></li>
                        <li><a href="contact.html">Contact Us</a></li>
                        <li><a href="privacy.html">Privacy Policy</a></li>
                    </ul>
                </div>
                <!-- Quick Links -->
                <div class="col-12 col-md-6 col-lg-3">
                    <h2>Quick Links</h2>
                    <ul>
                        <li><a href="#">Donate Now</a></li>
                        <li><a href="#">Volunteer</a></li>
                        <li><a href="#">Upcoming Events</a></li>
                        <li><a href="#">Testimonials</a></li>
                        <li><a href="#">Partner with Us</a></li>
                    </ul>
                </div>
                <!-- Contact Section -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="foot-contact">
                        <h2>Contact</h2>
                        <ul>
                            <li><i class="fa fa-phone"></i><span>+24 3772 120 091</span></li>
                            <li><i class="fa fa-envelope"></i><span><a href="mailto:info@mnlp.org">info@mnlp.org</a></span></li>
                            <li><i class="fa fa-map-marker"></i><span>Main Str. no 45-46, B3, Los Angeles, CA</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Bar -->
    <div class="footer-bar">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="m-0">Copyright &copy; <?php echo date('Y'); ?> All rights reserved. Designed by <a href="https://colorlib.com/" target="_blank">Colorlib</a>.</p>
                </div>
            </div>
        </div>
    </div>
    <script type='text/javascript' src='js/jquery.js'></script>
    <script type='text/javascript' src='js/jquery.collapsible.min.js'></script>
    <script type='text/javascript' src='js/swiper.min.js'></script>
    <script type='text/javascript' src='js/jquery.countdown.min.js'></script>
    <script type='text/javascript' src='js/circle-progress.min.js'></script>
    <script type='text/javascript' src='js/jquery.countTo.min.js'></script>
    <script type='text/javascript' src='js/jquery.barfiller.js'></script>
    <script type='text/javascript' src='js/custom.js'></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- JavaScript Libraries -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
    </script>
<!-- Initialize Swiper -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script>
    var swiper = new Swiper('.hero-slider', {
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const navbar = document.querySelector(".navbar");
        const topHeaderHeight = document.querySelector(".top-header-bar").offsetHeight;

        window.addEventListener("scroll", function () {
            if (window.scrollY > topHeaderHeight) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const navbar = document.querySelector(".navbar");
        window.addEventListener("scroll", function () {
            if (window.scrollY > 80) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });
    });
</script>
<!-- projects part index  -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.project-slider', {
        slidesPerView: 2,
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
    });
</script>




    <script defer
        src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"rayId":"8ee6b3dd082765e6","version":"2024.10.5","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"cd0b4b3a733644fc843ef0b185f98241","b":1}'
        crossorigin="anonymous"></script>
</footer>
