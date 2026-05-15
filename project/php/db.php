<?php
// php/db.php - Database connection (keep existing)
$conn = mysqli_connect("localhost", "root", "", "project_db");
if (!$conn) {
    die(json_encode(['success' => false, 'message' => 'DB connection failed: ' . mysqli_connect_error()]));
}
mysqli_set_charset($conn, "utf8mb4");
?>