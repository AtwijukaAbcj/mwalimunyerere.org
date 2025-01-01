<?php
require_once('root/config.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Redirect if user is not logged in
if (empty($_SESSION['userid'])) {
    redirect_page(SITE_URL);
}

// Fetch all levels for the dropdown
$levels_result = $con->query("SELECT * FROM levels");

// Handle adding a new program
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_program'])) {
    // Collect form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $lessons = $_POST['lessons'];
    $students = $_POST['students'];
    $rating = $_POST['rating'];
    $level = $_POST['level'];
    $ugandan_fees = $_POST['ugandan_fees'];
    $international_fees = $_POST['international_fees'];
    $duration_years = $_POST['duration_years'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Define target directory
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/admin/uploads/programs/";

        // Create directory if it doesn't exist
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // Generate unique filename
        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $unique_name = uniqid('program_', true) . '.' . $file_ext;
        $target_file = $target_dir . $unique_name;

        // Public URL for the image
        $public_url = "https://su.ac.ug/admin/uploads/programs/" . $unique_name;

        // Validate file type
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_ext, $allowed_types)) {
            $_SESSION['msg'] = 'Only JPG, JPEG, PNG, and GIF files are allowed.';
            header("Location: manage_programs.php");
            exit();
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Insert program into the database
            $stmt = $con->prepare("INSERT INTO programs (title, description, lessons, students, rating, level, image, ugandan_fees, international_fees, duration_years) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiiissddi", $title, $description, $lessons, $students, $rating, $level, $public_url, $ugandan_fees, $international_fees, $duration_years);

            if ($stmt->execute()) {
                $_SESSION['msg'] = 'Program added successfully.';
            } else {
                $_SESSION['msg'] = 'Failed to add program. Error: ' . $stmt->error;
            }

            $stmt->close();
        } else {
            $_SESSION['msg'] = 'Error uploading your file.';
        }
    } else {
        $_SESSION['msg'] = 'Please upload a valid image.';
    }

    header("Location: manage_programs.php");
    exit();
}

// Handle adding a new course unit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_course_unit'])) {
    $program_id = $_POST['program_id'];
    $title = $_POST['unit_title'];
    $code = $_POST['unit_code'];
    $level = $_POST['unit_level'];
    $credit_units = $_POST['credit_units'];

    // Insert course unit into the database
    $stmt = $con->prepare("INSERT INTO course_units (program_id, title, code, level, credit_units) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $program_id, $title, $code, $level, $credit_units);

    if ($stmt->execute()) {
        $_SESSION['msg'] = 'Course unit added successfully.';
    } else {
        $_SESSION['msg'] = 'Failed to add course unit. Please try again.';
    }

    $stmt->close();
    header("Location: manage_programs.php");
    exit();
}

// Fetch programs and levels
$result = $con->query("SELECT programs.*, levels.level_name FROM programs 
                       LEFT JOIN levels ON programs.level = levels.id");

include 'header.php';
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="<?= HOME_URL; ?>">Home</a></li>
                        <li class="breadcrumb-item active">Manage Programs</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Display session messages -->
            <?php if (!empty($_SESSION['msg'])) { ?>
                <div class="alert alert-info"><?= $_SESSION['msg']; ?></div>
            <?php } ?>

            <div class="row">
                <div class="col-12 mb-4">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProgramModal">
                        <i class="fa fa-plus"></i> Add New Program
                    </button>
                </div>

                <!-- Modal for adding a new program -->
                <div class="modal fade" id="addProgramModal" tabindex="-1" role="dialog" aria-labelledby="addProgramModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addProgramModalLabel">Add New Program</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="add_program" value="1">
                                    <div class="form-group">
                                        <label for="title">Program Title</label>
                                        <input type="text" class="form-control" name="title" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description" rows="3" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="lessons">Number of Lessons</label>
                                        <input type="number" class="form-control" name="lessons" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="students">Number of Students</label>
                                        <input type="number" class="form-control" name="students" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="rating">Rating</label>
                                        <input type="number" step="0.01" class="form-control" name="rating" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="level">Level</label>
                                        <select class="form-control" name="level" required>
                                            <option value="">Select Level</option>
                                            <?php while ($level = $levels_result->fetch_assoc()) { ?>
                                                <option value="<?= htmlspecialchars($level['id']); ?>"><?= htmlspecialchars($level['level_name']); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="ugandan_fees">Fees (UGANDAN)</label>
                                        <input type="number" class="form-control" name="ugandan_fees" step="0.01" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="international_fees">Fees (INTERNATIONAL)</label>
                                        <input type="number" class="form-control" name="international_fees" step="0.01" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="duration_years">Program Duration (Years)</label>
                                        <input type="number" class="form-control" name="duration_years" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Upload Program Image</label>
                                        <input type="file" class="form-control" name="image" accept="image/*" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add Program</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Display Existing Programs -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><b><i class="fa fa-list"></i> List of Programs</b></h3>
                        </div>
                        <div class="card-body table-responsive">
                            <?php if ($result->num_rows > 0) { ?>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Lessons</th>
                                            <th>Students</th>
                                            <th>Rating</th>
                                            <th>Level</th>
                                            <th>Fees (UGANDAN)</th>
                                            <th>Fees (INTERNATIONAL)</th>
                                            <th>Duration (Years)</th>
                                            <th>Image</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($program = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?= htmlspecialchars($program['title']); ?></td>
                                                <td><?= htmlspecialchars($program['description']); ?></td>
                                                <td><?= htmlspecialchars($program['lessons']); ?></td>
                                                <td><?= htmlspecialchars($program['students']); ?></td>
                                                <td><?= htmlspecialchars($program['rating']); ?></td>
                                                <td><?= htmlspecialchars($program['level_name']); ?></td>
                                                <td>UGX <?= number_format($program['ugandan_fees'], 2); ?></td>
                                                <td>USD <?= number_format($program['international_fees'], 2); ?></td>
                                                <td><?= htmlspecialchars($program['duration_years']); ?> Years</td>
                                                <td>
                                                    <?php if (!empty($program['image'])) { ?>
                                                        <img src="<?= htmlspecialchars($program['image']); ?>" alt="Program Image" style="width: 100px; height: auto;">
                                                    <?php } else { ?>
                                                        <img src="img/content/default-program.jpg" alt="Default Image" style="width: 100px; height: auto;">
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#addCourseUnitModal<?= htmlspecialchars($program['id']); ?>">Add Course Unit</button>
                                                    <a href="edit_program.php?id=<?= htmlspecialchars($program['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                                                    <a href="delete_program.php?id=<?= htmlspecialchars($program['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this program?');">Delete</a>
                                                </td>
                                            </tr>

                                            <!-- Modal for adding a course unit -->
                                            <div class="modal fade" id="addCourseUnitModal<?= htmlspecialchars($program['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="addCourseUnitModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addCourseUnitModalLabel">Add Course Unit to <?= htmlspecialchars($program['title']); ?></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="" method="POST">
                                                                <input type="hidden" name="add_course_unit" value="1">
                                                                <input type="hidden" name="program_id" value="<?= htmlspecialchars($program['id']); ?>">
                                                                <div class="form-group">
                                                                    <label for="unit_title">Course Unit Title</label>
                                                                    <input type="text" class="form-control" name="unit_title" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="unit_code">Course Code</label>
                                                                    <input type="text" class="form-control" name="unit_code" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="unit_level">Level</label>
                                                                    <input type="text" class="form-control" name="unit_level" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="credit_units">Credit Units</label>
                                                                    <input type="number" class="form-control" name="credit_units" required>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary">Add Course Unit</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php } else { ?>
                                <div class="alert alert-warning">No programs available.</div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>
