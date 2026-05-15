<?php
// php/order.php
session_start();
include("db.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!$data || empty($data['items'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid or empty order data']);
    exit();
}

$customer = $data['customer'];
$items    = $data['items'];
$subtotal = (float) $data['subtotal'];
$delivery = (float) $data['delivery'];
$total    = (float) $data['total'];

$user_id      = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
$order_number = 'RD' . strtoupper(date('ymd')) . rand(100, 999);

$stmt = mysqli_prepare($conn,
    "INSERT INTO orders
        (user_id, order_number, customer_name, phone, address, subtotal, delivery_charge, total, payment_method)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Cash on Delivery')"
);
mysqli_stmt_bind_param($stmt, 'issssddd',
    $user_id,
    $order_number,
    $customer['name'],
    $customer['phone'],
    $customer['address'],
    $subtotal,
    $delivery,
    $total
);

if (!mysqli_stmt_execute($stmt)) {
    $err = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
    echo json_encode(['success' => false, 'message' => 'Could not save order: ' . $err]);
    exit();
}

$order_id = mysqli_insert_id($conn);
mysqli_stmt_close($stmt);

// Insert order items
$stmt2 = mysqli_prepare($conn,
    "INSERT INTO order_items (order_id, product_id, product_name, product_img, price, quantity)
     VALUES (?, ?, ?, ?, ?, ?)"
);
foreach ($items as $item) {
    $pid  = (int)   $item['id'];
    $name = (string) $item['name'];
    $img  = (string) $item['img'];
    $price = (float) $item['price'];
    $qty  = (int)   $item['qty'];
    mysqli_stmt_bind_param($stmt2, 'iissdi', $order_id, $pid, $name, $img, $price, $qty);
    mysqli_stmt_execute($stmt2);
}
mysqli_stmt_close($stmt2);

echo json_encode(['success' => true, 'order_id' => $order_number]);
