<?php
include('db_connection.php');

$stmt = $conn->prepare("SELECT id, supplier_name FROM suppliers");
$stmt->execute();
$result = $stmt->get_result();

$categories = [];
$bar_chart_data = [];

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $supplier_name = $row['supplier_name'];

    $stmt_inner = $conn->prepare("SELECT COUNT(*) as p_count FROM productsuppliers WHERE supplier = ?");
    $stmt_inner->bind_param("i", $id);
    $stmt_inner->execute();
    $inner_result = $stmt_inner->get_result();
    $inner_row = $inner_result->fetch_assoc();
    $count = (int) $inner_row['p_count'];

    $categories[] = $supplier_name;
    $bar_chart_data[] = [
        'y' => (int) $count,
        'color' => '#808080'
    ];

    $stmt_inner->close();
}

$stmt->close();
?>
