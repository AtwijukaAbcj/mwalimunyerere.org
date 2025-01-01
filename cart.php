<?php
ob_start(); // Start output buffering
include 'header.php';
include 'root/config.php';

// Handle item removal
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    $sql_remove = "DELETE FROM cart WHERE cause_id = ?";
    $stmt = $conn->prepare($sql_remove);
    $stmt->bind_param('i', $remove_id);
    $stmt->execute();
    header("Location: cart.php"); // Redirect to the same page after removing the item
    exit();
}

// Fetch cart items
$sql = "SELECT c.cause_id, c.quantity, ca.title, ca.description, ca.price 
        FROM cart c 
        JOIN causes ca ON c.cause_id = ca.id";
$result = $conn->query($sql);

$total = 0;
?>

<div class="container mt-5">
    <h2>Your Cart</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Price (UGX)</th>
                <th>Quantity</th>
                <th>Subtotal (UGX)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['title']); ?></td>
                        <td><?= number_format($row['price'], 2); ?></td>
                        <td><?= $row['quantity']; ?></td>
                        <td><?= number_format($row['price'] * $row['quantity'], 2); ?></td>
                        <td>
                            <a href="cart.php?remove=<?= $row['cause_id']; ?>" class="btn btn-danger btn-sm">Remove</a>
                        </td>
                    </tr>
                    <?php $total += $row['price'] * $row['quantity']; ?>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Your cart is empty</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h3>Total: UGX <?= number_format($total, 2); ?></h3>

    <div class="mt-4">
        <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
    </div>
</div>

<?php 
include 'footer.php';
ob_end_flush(); // Flush the output buffer
?>
