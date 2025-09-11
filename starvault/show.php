<?php
    include('db_connection.php');
    $table_name = $show_table;

    $table_name = mysqli_real_escape_string($conn, $table_name);

    $query = "SELECT * FROM `$table_name` ORDER BY created_at DESC";
    $result = $conn->query($query);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    return $data;
?>
