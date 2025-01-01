<?php
require_once 'root/config.php';
include('header.php');

// Fetch all banners
$banners = dbSQL("SELECT * FROM banners ORDER BY id DESC");

?>

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="<?=HOME_URL;?>">Home</a></li>
              <li class="breadcrumb-item active">View Banners</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
      <?php if(!empty($_SESSION['msg'])) echo log_message(); ?>
        <!--- main content starts here -->
        <div class="card mb-4 info">
            <div class="card-header">
                <i class="fas fa-eye mr-1"> </i>
                <b> View Banners </b>
            </div>
            <div class="card-body">
                <?php if (!empty($banners)): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th>Image</th>
                            <th>Button Text</th>
                            <th>Button Link</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($banners as $index => $banner): ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= htmlspecialchars($banner->title); ?></td>
                            <td><?= htmlspecialchars($banner->subtitle); ?></td>
                            <td><img src="<?= htmlspecialchars($banner->image_url); ?>" alt="Banner Image" style="width: 100px;"></td>
                            <td><?= htmlspecialchars($banner->button_text); ?></td>
                            <td><?= htmlspecialchars($banner->button_link); ?></td>
                            <td>
                                <a href="edit_banner.php?id=<?= $banner->id; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete_banner.php?id=<?= $banner->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this banner?');">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p>No banners found.</p>
                <?php endif; ?>
            </div>
        </div>
        <!--- main content ends here --> 
      </div>
    </section>
  </div>
<?php include('footer.php'); ?>
