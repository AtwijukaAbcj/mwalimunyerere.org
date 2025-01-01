<?php
include('header.php');
require_once __DIR__ . '/../root/config.php';

// Check if the connection was successfully established
if (!isset($conn)) {
    die("Database connection failed. Please check the configuration.");
}

// Fetch all causes from the database
$sql_causes = "SELECT * FROM causes";
$result_causes = $conn->query($sql_causes);

if (!$result_causes) {
    die("Error fetching causes: " . $conn->error);
}
?>


<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="<?=HOME_URL;?>">Home</a></li>
              <li class="breadcrumb-item active">Manage Cause </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">    
      <?php if(!empty($_SESSION['msg'])) echo log_message(); ?>
        <div class="row">
          <div class="col-12">
            <div class="card">
            <div class="col-9">
            <h2 class="mb-4">Manage Causes</h2>
            <a href="add_cause.php" class="btn btn-success mb-3">Add New Cause</a>
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($cause = $result_causes->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($cause['title']); ?></td>
                            <td><?= htmlspecialchars(substr($cause['description'], 0, 50)); ?>...</td>
                            <td>UGX <?= number_format($cause['price'], 2); ?></td>
                            <td>
                                <!-- Display the image using the link in image_url -->
                                <img src="<?= htmlspecialchars($cause['image_url']); ?>" 
                                     alt="<?= htmlspecialchars($cause['title']); ?>" 
                                     width="100" 
                                     height="100" 
                                     class="img-thumbnail">
                            </td>
                            <td>
                                <a href="edit_cause.php?id=<?= $cause['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="delete_cause.php?id=<?= $cause['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
<?php include 'footer.php'; ?>
