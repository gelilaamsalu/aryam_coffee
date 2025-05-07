<?php
require 'config.php'; 
// Database connection
$conn = new mysqli("localhost", "root", "", "aryamcoffee");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get total products
$totalProductsQuery = "SELECT COUNT(*) AS total FROM tblmenu";
$totalProductsResult = $conn->query($totalProductsQuery);
$totalProducts = $totalProductsResult->fetch_assoc()['total'];

// Get number of orders
$totalOrdersQuery = "SELECT COUNT(*) AS total FROM tblorder";
$totalOrdersResult = $conn->query($totalOrdersQuery);
$totalOrders = $totalOrdersResult->fetch_assoc()['total'];

// Get number of reservations
$totalReservationsQuery = "SELECT COUNT(*) AS total FROM tblreservation";
$totalReservationsResult = $conn->query($totalReservationsQuery);
$totalReservations = $totalReservationsResult->fetch_assoc()['total'];

// Get number of branches (if it's represented in the reservation table)
$totalBranchesQuery = "SELECT COUNT(DISTINCT branch) AS total FROM tblreservation";
$totalBranchesResult = $conn->query($totalBranchesQuery);
$totalBranches = $totalBranchesResult->fetch_assoc()['total'];

// Example query to fetch order data for charts
$sql = "SELECT DATE(date) as order_date, COUNT(id) as order_count FROM tblorder GROUP BY DATE(date)";
$result = $conn->query($sql);

$data = [];
while($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Prepare the response
$response = [
    'totalProducts' => $totalProducts,
    'totalOrders' => $totalOrders,
    'totalReservations' => $totalReservations,
    'totalBranches' => $totalBranches,
    'chartData' => $data, // Include order data in response
];

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
