<?php
session_start();
include('header.php');

// Initialize the cart if not already done
if (!isset($_SESSION['donation_cart'])) {
    $_SESSION['donation_cart'] = [];
}

// Handle adding a general donation from the banner
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['general_donation_amount'])) {
    $general_donation_amount = floatval($_POST['general_donation_amount']);
    if ($general_donation_amount > 0) {
        // Add the general donation to the cart
        $general_donation_id = "general_donation";
        $_SESSION['donation_cart'][$general_donation_id] = [
            'title' => 'General Donation',
            'description' => 'Support for the most needed causes.',
            'amount' => $general_donation_amount,
            'quantity' => 1,
        ];
    }
}

// Handle removing an item from the cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    unset($_SESSION['donation_cart'][$remove_id]);
}

// Handle quantity updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $id => $qty) {
        if (isset($_SESSION['donation_cart'][$id])) {
            $_SESSION['donation_cart'][$id]['quantity'] = max(1, intval($qty));
        }
    }
}

// Calculate the total amount
$total_amount = 0;
foreach ($_SESSION['donation_cart'] as $item) {
    $total_amount += $item['amount'] * $item['quantity'];
}
?>

<div class="container my-5">
    <h1 class="text-center mb-4">Checkout - Donations</h1>

    <?php if (!empty($_SESSION['donation_cart'])): ?>
        <form action="donation_checkout.php" method="POST">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Amount (USD)</th>
                        <th>Quantity</th>
                        <th>Subtotal (USD)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['donation_cart'] as $id => $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['title']); ?></td>
                            <td><?= htmlspecialchars(substr($item['description'], 0, 50)) . '...'; ?></td>
                            <td>$<?= number_format($item['amount'], 2); ?></td>
                            <td>
                                <input type="number" name="quantity[<?= $id; ?>]" value="<?= $item['quantity']; ?>" class="form-control text-center" style="width: 80px;">
                            </td>
                            <td>$<?= number_format($item['amount'] * $item['quantity'], 2); ?></td>
                            <td>
                                <a href="donation_checkout.php?remove=<?= $id; ?>" class="btn btn-danger btn-sm">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="text-right mb-4">
                <h4><strong>Total: $<?= number_format($total_amount, 2); ?></strong></h4>
            </div>

            <div class="d-flex justify-content-between">
                <a href="causes.php" class="btn btn-secondary">Continue Donating</a>
                <button type="submit" name="update_cart" class="btn btn-primary">Update Cart</button>
                <a href="donation_payment.php" class="btn btn-success">Proceed to Payment</a>
            </div>
        </form>
    <?php else: ?>
        <div class="text-center">
            <p>Your donation cart is empty. <a href="causes.php" class="btn btn-link">Browse Causes</a></p>
        </div>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>
