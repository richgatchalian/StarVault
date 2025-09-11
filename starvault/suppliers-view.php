<?php
    session_start();
    if(!isset($_SESSION['user']['username'])) header('location: login.php');
    $show_table = 'suppliers';
    $suppliers = include('show.php');
    $username = $_SESSION['user']['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppliers View - Starvault</title>
    <?php include('partials/app-header-scripts.php')?>
</head>
<body>
    <div id = "dashboardMainContainer">
        <?php include('partials/app-sidebar.php')?>
        <div class = "dashboard_content_container" id = "dashboard_content_container">
        <?php include('partials/app-topNav.php')?>
            <div class = "dashboard_content"> 
                <div class = "dashboard_content_main">  
                    <div class = "row">
                        <div class = "column column-12">
                            <h1 class = "section_header"><i class = "fa fa-list"></i> List of Suppliers </h1>
                            <div class = "section_content">
                                <div class = "users">
                                    <table>
                                        <thread>
                                            <tr>
                                                <th>#</th>
                                                <th>Supplier Name</th>
                                                <th>Location</th>
                                                <th>Email</th>
                                                <th>Products</th>
                                                <th>Created By</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                            </tr>
                                        </thread>
                                        <tbody>
                                            <?php foreach($suppliers as $index => $supplier){?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= $supplier['supplier_name']?></td>
                                                    <td><?= $supplier['supplier_location']?></td>
                                                    <td><?= $supplier['email']?></td>
                                                    <td>
                                                    <?php
                                                        $product_list = '-';
                                                        $sid = $supplier['id']; 
                                                        $stmt = $conn->prepare("
                                                            SELECT products.product_name 
                                                            FROM products
                                                            INNER JOIN productsuppliers ON productsuppliers.product = products.id
                                                            WHERE productsuppliers.supplier = ?
                                                        ");

                                                        if (!$stmt) {
                                                            die("Error preparing statement: " . $conn->error);
                                                        }

                                                        $stmt->bind_param("i", $sid);
                                                        $stmt->execute(); 

                                                        $result = $stmt->get_result();

                                                        $product_array = [];

                                                        while ($row = $result->fetch_assoc()) {
                                                            $product_array[] = $row['product_name'];
                                                        }

                                                        if (!empty($product_array)) {
                                                            $product_list = '<li>' . implode("</li><li>", $product_array) . '</li>';
                                                        } else {
                                                            $product_list = 'No Supplier found';
                                                        }

                                                        echo $product_list;
                                                        $stmt->close();
                                                    ?>

                                                    </td>
                                                    <td>
                                                        <?php
                                                            $uid = $supplier['created_by'];
                                                            $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
                                                            if (!$stmt) {
                                                                die("Error preparing statement: " . $conn->error);
                                                            }

                                                            $stmt->bind_param("i", $uid);
                                                            $stmt->execute(); 
                                                            $result = $stmt->get_result();
                                                            $row = $result->fetch_assoc();

                                                            if ($row) {
                                                                $created_by_name = $row['username']; 
                                                                echo htmlspecialchars($created_by_name); 
                                                            } else {
                                                                echo "No user found with the given ID.";
                                                            }
                                                            $stmt->close();
                                                        ?>
                                                    </td>
                                                    <td><?= date("M d, Y @ h:i:s A", strtotime($supplier['created_at'])); ?></td>
                                                    <td><?= date("M d, Y @ h:i:s A", strtotime($supplier['updated_at'])); ?></td>
                                                </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                    <p class = "userCount"><?= count($suppliers) ?> Supplier </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include('partials/app-scripts.php')?>
</body>
</html>
