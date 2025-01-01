<?php
include'header.php';
require_once __DIR__ . '/root/config.php'; // Include database configuration

// Get the project ID from the query string
$project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the project details from the database
$sql_project = "SELECT * FROM projects WHERE project_id = ?";
$stmt = $conn->prepare($sql_project);
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result_project = $stmt->get_result();

if ($result_project->num_rows === 0) {
    die("Project not found.");
}

$project = $result_project->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($project['title']); ?> - Project Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <!-- Top Banner -->
    <div class="banner" style="background-image: url('<?= htmlspecialchars($project['image_url']); ?>'); background-size: cover; background-position: center; height: 300px;">
        <div class="container h-100 d-flex align-items-center justify-content-center">
            <h1 class="text-white text-center" style="background: rgba(0, 0, 0, 0.6); padding: 20px; border-radius: 10px;">
                <?= htmlspecialchars($project['title']); ?>
            </h1>
        </div>
    </div>

    <!-- Project Details -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="mb-4"><?= htmlspecialchars($project['title']); ?></h2>
                
                <p><strong>Description:</strong></p>
                <p><?= nl2br(htmlspecialchars($project['description'])); ?></p>

                <p>
                    <strong>Start Date:</strong> <?= date("M d, Y", strtotime($project['start_date'])); ?><br>
                    <strong>Completion Date:</strong> 
                    <?= $project['completion_date'] ? date("M d, Y", strtotime($project['completion_date'])) : 'Ongoing'; ?>
                </p>

                <?php if (!empty($project['image_url'])): ?>
                    <div class="text-center my-4">
                        <img src="<?= htmlspecialchars($project['image_url']); ?>" alt="<?= htmlspecialchars($project['title']); ?>" class="img-fluid rounded shadow">
                    </div>
                <?php endif; ?>

                <a href="index.php" class="btn btn-primary">Back to Home</a>
            </div>
        </div>
    </div>

   <?php include 'footer.php' ?>

