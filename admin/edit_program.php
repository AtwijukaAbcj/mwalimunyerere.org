<?php
require_once('root/config.php');

// Check if program ID is passed
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    die("Invalid program ID.");
}

$program_id = intval($_GET['id']);

// Fetch program details
$program_query = $con->prepare("SELECT * FROM programs WHERE id = ?");
$program_query->bind_param("i", $program_id);
$program_query->execute();
$program_result = $program_query->get_result();

// Check if the program exists
if ($program_result && $program_result->num_rows > 0) {
    $program = $program_result->fetch_assoc();
} else {
    die("Program not found.");
}

// Fetch all levels to populate the dropdown
$levels_result = $con->query("SELECT * FROM levels");

// Handle the form submission for updating the program
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $lessons = $_POST['lessons'];
    $students = $_POST['students'];
    $rating = $_POST['rating'];
    $level = $_POST['level'];
    $ugandan_fees = $_POST['ugandan_fees'];
    $international_fees = $_POST['international_fees'];
    $duration_years = $_POST['duration_years'];
    
    // Handle image update
    $image_updated = false;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/admin/uploads/programs/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $public_url = "https://su.ac.ug/admin/uploads/programs/" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image_updated = true;
    }

    if ($image_updated) {
        $stmt = $con->prepare("UPDATE programs SET title = ?, description = ?, lessons = ?, students = ?, rating = ?, level = ?, ugandan_fees = ?, international_fees = ?, duration_years = ?, image = ? WHERE id = ?");
        $stmt->bind_param("ssiiissddsi", $title, $description, $lessons, $students, $rating, $level, $ugandan_fees, $international_fees, $duration_years, $public_url, $program_id);
    } else {
        $stmt = $con->prepare("UPDATE programs SET title = ?, description = ?, lessons = ?, students = ?, rating = ?, level = ?, ugandan_fees = ?, international_fees = ?, duration_years = ? WHERE id = ?");
        $stmt->bind_param("ssiiissdds", $title, $description, $lessons, $students, $rating, $level, $ugandan_fees, $international_fees, $duration_years, $program_id);
    }

    if ($stmt->execute()) {
        $_SESSION['msg'] = 'Program updated successfully.';
        header("Location: manage_programs.php");
        exit();
    } else {
        echo "Failed to update the program.";
    }
}

include 'header.php';
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Edit Program</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Program Title</label>
                    <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($program['title']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" rows="3" required><?= htmlspecialchars($program['description']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="lessons">Number of Lessons</label>
                    <input type="number" class="form-control" name="lessons" value="<?= htmlspecialchars($program['lessons']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="students">Number of Students</label>
                    <input type="number" class="form-control" name="students" value="<?= htmlspecialchars($program['students']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="rating">Rating</label>
                    <input type="number" step="0.01" class="form-control" name="rating" value="<?= htmlspecialchars($program['rating']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="level">Level</label>
                    <select class="form-control" name="level" required>
                        <?php while ($level = $levels_result->fetch_assoc()) { ?>
                            <option value="<?= $level['id']; ?>" <?= $level['id'] == $program['level'] ? 'selected' : ''; ?>>
                                <?= $level['level_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <!-- New fields for Fees and Duration -->
                <div class="form-group">
                    <label for="ugandan_fees">Fees (Ugandan)</label>
                    <input type="number" class="form-control" name="ugandan_fees" value="<?= htmlspecialchars($program['ugandan_fees']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="international_fees">Fees (International)</label>
                    <input type="number" class="form-control" name="international_fees" value="<?= htmlspecialchars($program['international_fees']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="duration_years">Program Duration (Years)</label>
                    <input type="number" class="form-control" name="duration_years" value="<?= htmlspecialchars($program['duration_years']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="image">Update Program Image</label>
                    <input type="file" class="form-control" name="image">
                    <p>Current Image: <img src="<?= htmlspecialchars($program['image']); ?>" style="width: 50px;"></p>
                </div>
                <button type="submit" class="btn btn-primary">Update Program</button>
            </form>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>
