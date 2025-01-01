<?php
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
$sql = "SELECT c.cause_id, c.quantity, ca.title, ca.description 
        FROM cart c 
        JOIN causes ca ON c.cause_id = ca.id";
$result = $conn->query($sql);
?>

<div class="container py-5">
    <h1>Cart</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars(substr($row['description'], 0, 100)) ?>...</td>
                        <td><?= $row['quantity'] ?></td>
                        <td>
                            <a href="cart.php?remove=<?= $row['cause_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Your cart is empty.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="payment.php" class="btn btn-primary">Proceed to Payment</a>
</div>

<?php include 'footer.php'; ?>
