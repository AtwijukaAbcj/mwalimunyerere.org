<?php
include 'root/config.php';

header('Content-Type: application/json');

// Fetch cart items
$sql = "SELECT c.cause_id, c.quantity, ca.title 
        FROM cart c 
        JOIN causes ca ON c.cause_id = ca.id";
$result = $conn->query($sql);

$cart = ['items' => [], 'totalQuantity' => 0];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cart['items'][] = [
            'id' => $row['cause_id'],
            'title' => $row['title'],
            'quantity' => $row['quantity']
        ];
        $cart['totalQuantity'] += $row['quantity'];
    }
}

echo json_encode($cart);
?>
