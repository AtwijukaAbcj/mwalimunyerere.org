

    <?php
    // Include database connection and header
    include 'root/config.php';
    include 'header.php';

    // Pagination setup
    $limit = 6; // Number of projects per page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Fetch total projects
    $total_query = "SELECT COUNT(*) AS total FROM projects";
    $total_result = $conn->query($total_query);
    $total_events = $total_result->fetch_assoc()['total'];
    $total_pages = ceil($total_events / $limit);

    // Fetch projects for the current page
    $query = "SELECT project_id, title, description, image_url FROM projects ORDER BY created_at DESC LIMIT $offset, $limit";
    $result = $conn->query($query);
    ?>

    <div class="custom-cursor__cursor"></div>
    <div class="custom-cursor__cursor-two"></div>
    <div class="preloader">
        <div class="preloader__image"></div>
    </div>

    <div class="page-wrapper">
        <header class="main-header">
            <div class="main-menu__top"></div>
        </header>

        <!-- Page Header -->
        <section class="page-header">
            <div class="page-header__bg-shape" style="background-image: url(assets/images/shapes/page-header-bg-shape.png);"></div>
            <div class="container">
                <div class="page-header__inner">
                    <div class="page-header__shape-1">
                        <img src="assets/images/shapes/page-header-shape-1.png" alt="">
                    </div>
                    <h2>Projects</h2>
                    <div class="thm-breadcrumb__box">
                        <ul class="thm-breadcrumb list-unstyled">
                            <li><a href="index.html">Home</a></li>
                            <li><span>-</span></li>
                            <li>Projects</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Projects Section -->
        <section class="project-one project-page">
            <div class="project-one__shape-1 float-bob-y">
                <img src="assets/images/shapes/project-one-shape-1.png" alt="">
            </div>
            <div class="section-title text-center sec-title-animation animation-style1">
                <div class="section-title__tagline-box">
                    <div class="section-title__tagline-shape"></div>
                    <span class="section-title__tagline">Our Recent Projects</span>
                </div>
                <h2 class="section-title__title title-animation">One Project At A Time</h2>
            </div>
            <div class="container">
                <div class="row">
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($project = $result->fetch_assoc()): ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="project-one__single" style="box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                                    <div class="project-one__img-box">
                                        <div class="project-one__img">
                                            <img src="<?= htmlspecialchars($project['image_url']); ?>" alt="<?= htmlspecialchars($project['title']); ?>">
                                        </div>
                                        <div class="project-one__arrow">
                                            <a href="project-details.php?project_id=<?= $project['project_id']; ?>" class="img-popup">
                                                <span class="icon-arrow-up"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="project-one__content">
                                        <h3 class="project-one__title">
                                            <a href="project-details.php?project_id=<?= $project['project_id']; ?>"><?= htmlspecialchars($project['title']); ?></a>
                                        </h3>
                                        <p class="project-one__text"><?= htmlspecialchars($project['description']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No projects found.</p>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
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

        <!-- Footer -->
        <?php include 'footer.php'; ?>
    </div>

    <!-- Scripts -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>
