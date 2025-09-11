<?php
session_start();
include('tables_columns.php');

if (!isset($_SESSION['table']) || empty($_SESSION['table'])) {
    die('Table name is not set. Please set it first.');
}
$table_name = $_SESSION['table'];


if (!isset($table_columns_mapping[$table_name])) {
    die('Invalid table mapping.');
}
$columns = $table_columns_mapping[$table_name];

$db_arr = [];

$user = $_SESSION['user'] ?? null;
if (!$user) {
    die('User is not logged in.');
}

// Validate and collect values for the columns
foreach ($columns as $column) {
    if (in_array($column, ['created_at', 'updated_at'])) {
        $value = date('Y-m-d H:i:s');
    } else if ($column == 'created_by') {
        $value = $user['id'];
    } else if ($column == 'image' && isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Handle image upload
        $target_dir = "images/products/";
        $file_data = $_FILES['image'];
        $file_name = $file_data['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $file_name = 'product-' . time() . '.' . $file_ext;

        // Check if the file is an image
        $check = getimagesize($file_data['tmp_name']);
        if ($check !== false) {
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($file_ext, $allowed_types)) {
                if (move_uploaded_file($file_data['tmp_name'], $target_dir . $file_name)) {
                    $value = $file_name;
                } else {
                    die('Failed to upload image.');
                }
            } else {
                die('Invalid image type.');
            }
        } else {
            die('File is not an image.');
        }
    } else {
        $value = $_POST[$column] ?? '';
    }

    $db_arr[] = $value;
}

// Prepare column names and placeholders
$table_properties = implode(",", $columns);
$table_placeholders = implode(",", array_fill(0, count($columns), '?'));

try {
    include('db_connection.php');

    // Insert into main table
    $sql = "INSERT INTO $table_name ($table_properties) VALUES ($table_placeholders)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat('s', count($columns)), ...$db_arr);
    $stmt->execute();

    $product_id = $conn->insert_id;

    if ($table_name == 'products') {
        $suppliers = $_POST['suppliers'] ?? [];
        if ($suppliers) {
            foreach ($suppliers as $supplier) {
                $sql = "INSERT INTO productsuppliers (supplier, product, updated_at, created_at) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('iiss', $supplier, $product_id, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
                $stmt->execute();
            }
        }
    }

    $response = [
        'success' => true,
        'message' => 'Record successfully added to the system.'
    ];
} catch (mysqli_sql_exception $e) {
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
}

$_SESSION['response'] = $response;
header('Location: ./'. $_SESSION['redirect_to']);
exit();
?>
