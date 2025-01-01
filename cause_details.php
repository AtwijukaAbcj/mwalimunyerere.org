<?php
include 'header.php';
include_once('root/config.php');

// Fetch the cause details based on the `id` parameter
$cause_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$cause_id) {
    echo "<p class='text-center'>Invalid Cause ID.</p>";
    include 'footer.php';
    exit();
}

$sql_cause = "SELECT * FROM causes WHERE id = ?";
$stmt = $conn->prepare($sql_cause);
$stmt->bind_param('i', $cause_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p class='text-center'>Cause not found.</p>";
    include 'footer.php';
    exit();
}

$cause = $result->fetch_assoc();
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <img src="<?= htmlspecialchars($cause['image_url']); ?>" 
                 alt="<?= htmlspecialchars($cause['title']); ?>" 
                 class="img-fluid rounded">
        </div>
        <div class="col-md-6">
            <h2><?= htmlspecialchars($cause['title']); ?></h2>
            <p><?= htmlspecialchars($cause['description']); ?></p>
            <p><strong>Raised:</strong> $<?= number_format($cause['raised'], 2); ?> 
               | <strong>Goal:</strong> $<?= number_format($cause['goal'], 2); ?></p>

            <div class="progress mb-3" style="height: 20px;">
                <?php $progress = min(100, ($cause['raised'] / $cause['goal']) * 100); ?>
                <div class="progress-bar bg-success" 
                     role="progressbar" 
                     style="width: <?= $progress; ?>%;" 
                     aria-valuenow="<?= $progress; ?>" 
                     aria-valuemin="0" 
                     aria-valuemax="100">
                    <?= round($progress, 2); ?>%
                </div>
            </div>

            <!-- Donation Form -->
            <form action="add_to_cart.php" method="POST">
                <div class="form-group">
                    <label for="donationAmount">Donation Amount</label>
                    <input type="number" name="custom_amount" id="donationAmount" class="form-control" placeholder="Enter Amount" required>
                    <input type="hidden" name="cause_id" value="<?= htmlspecialchars($cause['id']); ?>">
                </div>
                <div class="form-group">
                    <label>
                        <input type="radio" name="payment_type" value="one_time" checked> One Time Payment
                    </label>
                    <label class="ml-3">
                        <input type="radio" name="payment_type" value="monthly"> Monthly Payments
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Add to Cart</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
