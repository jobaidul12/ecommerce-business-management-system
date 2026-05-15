<?php
// php/get_orders.php
session_start();
include("db.php");
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$user_id = (int) $_SESSION['user_id'];

// Fetch all orders for this user
$stmt = mysqli_prepare($conn,
    "SELECT id, order_number, customer_name, phone, address,
            subtotal, delivery_charge, total, payment_method, status, created_at
     FROM orders
     WHERE user_id = ?
     ORDER BY created_at DESC"
);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}
mysqli_stmt_close($stmt);

// Fetch items for each order
foreach ($orders as &$order) {
    $oid  = (int) $order['id'];
    $stmt2 = mysqli_prepare($conn,
        "SELECT product_name, product_img, price, quantity FROM order_items WHERE order_id = ?"
    );
    mysqli_stmt_bind_param($stmt2, 'i', $oid);
    mysqli_stmt_execute($stmt2);
    $res2  = mysqli_stmt_get_result($stmt2);
    $items = [];
    while ($item = mysqli_fetch_assoc($res2)) {
        $items[] = $item;
    }
    mysqli_stmt_close($stmt2);
    $order['items'] = $items;
}
unset($order);

echo json_encode(['success' => true, 'orders' => $orders]);
