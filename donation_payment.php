<?php
session_start();
include 'header.php';
include 'root/config.php';

// Fetch cart items
$sql = "SELECT c.cause_id, c.quantity, ca.title, ca.description, ca.goal 
        FROM cart c 
        JOIN causes ca ON c.cause_id = ca.id";
$result = $conn->query($sql);

// Calculate total amount
$total_amount = 0;
$cart_items = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
        $total_amount += $row['quantity'] * $row['goal'];
    }
}
?>

<div class="container py-5">
    <h1>Proceed to Payment</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Subtotal (USD)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($cart_items)): ?>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['title']) ?></td>
                        <td><?= htmlspecialchars(substr($item['description'], 0, 100)) ?>...</td>
                        <td><?= $item['quantity'] ?></td>
                        <td>$<?= number_format($item['quantity'] * $item['goal'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Your cart is empty.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="text-right">
        <h4>Total Amount: $<?= number_format($total_amount, 2) ?></h4>
    </div>

    <?php if ($total_amount > 0): ?>
        <button id="pay-now" class="btn btn-success btn-lg mt-3">Pay Now</button>
    <?php else: ?>
        <p class="text-center">No items to proceed with payment.</p>
    <?php endif; ?>
</div>

<script src="https://checkout.flutterwave.com/v3.js"></script>
<script>
    document.getElementById('pay-now').addEventListener('click', function () {
        const totalAmount = <?= $total_amount ?>;
        const email = "<?= $_SESSION['user_email'] ?? 'donor@example.com'; ?>"; // Replace with user's email dynamically
        const phone = "<?= $_SESSION['user_phone'] ?? '1234567890'; ?>"; // Replace with user's phone dynamically
        const name = "<?= $_SESSION['user_name'] ?? 'John Doe'; ?>"; // Replace with user's name dynamically

        FlutterwaveCheckout({
            public_key: "FLWPUBK-00c21af36bd92d40d6599b82b2087fea-X", // Replace with your Flutterwave public key
            tx_ref: "cart_" + Math.floor(Math.random() * 1000000), // Unique transaction reference
            amount: totalAmount,
            currency: "USD",
            country: "UG",
            payment_options: "card, mobilemoneyuganda, ussd",
            redirect_url: "http://localhost/mwalimunyerere.org/payment_success.php", // Redirect after payment
            meta: {
                consumer_id: <?= $_SESSION['user_id'] ?? '0'; ?>, // Replace with dynamic user ID
                consumer_mac: "92a3-912ba-1192a",
            },
            customer: {
                email: email,
                phone_number: phone,
                name: name,
            },
            callback: function (data) {
                if (data.status === "successful") {
                    alert("Payment Successful!");
                    window.location.href = "payment_success.php?tx_ref=" + data.tx_ref;
                } else {
                    alert("Payment failed.");
                }
            },
            onclose: function () {
                alert("Payment process was closed.");
            },
            customizations: {
                title: "Donation Cart Payment",
                description: "Payment for items in your donation cart.",
                logo: "path/to/logo.png", // Optional: Add your logo here
            },
        });
    });
</script>

<?php include 'footer.php'; ?>
