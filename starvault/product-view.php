<?php
    session_start();
    if(!isset($_SESSION['user']['username'])) header('location: login.php');
    $show_table = 'products';
    $products = include('show.php');
    $username = $_SESSION['user']['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product View - Starvault</title>
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
                            <h1 class = "section_header"><i class = "fa fa-list"></i> List of Products </h1>
                            <div class = "section_content">
                                <div class = "users">
                                    <table>
                                        <thread>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Product Name</th>
                                                <th>Description</th>
                                                <th style="width: 100px;">Suppliers</th>
                                                <th style="width: 100px;">Created By</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                            </tr>
                                        </thread>
                                        <tbody>
                                            <?php foreach($products as $index => $product){?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td class="productImage">
                                                        <img class="productImages" src="images/products/<?= htmlspecialchars($product['image']); ?>" alt="Product Image" />
                                                    </td>
                                                    <td class="productName"><?= htmlspecialchars($product['product_name']); ?></td>
                                                    <td class="description"><?= htmlspecialchars($product['description']); ?></td>
                                                    <td class="supplier">
                                                    <?php
                                                        $supplier_list = '-';
                                                        $pid = $product['id']; 

                                                        $stmt = $conn->prepare("
                                                            SELECT suppliers.supplier_name 
                                                            FROM suppliers
                                                            INNER JOIN productsuppliers ON productsuppliers.supplier = suppliers.id
                                                            WHERE productsuppliers.product = ?
                                                        ");

                                                        if (!$stmt) {
                                                            die("Error preparing statement: " . $conn->error);
                                                        }

                                                        $stmt->bind_param("i", $pid);
                                                        $stmt->execute(); 

                                                        $result = $stmt->get_result();

                                                        $supplier_array = [];

                                                        while ($row = $result->fetch_assoc()) {
                                                            $supplier_array[] = $row['supplier_name'];
                                                        }

                                                        if (!empty($supplier_array)) {
                                                            $supplier_list = '<li>' . implode("</li><li>", $supplier_array) . '</li>';
                                                        } else {
                                                            $supplier_list = 'No Supplier found';
                                                        }

                                                        echo $supplier_list;
                                                        $stmt->close();
                                                    ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $uid = $product['created_by'];
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
                                                    <td><?= date("M d, Y @ h:i:s A", strtotime($product['created_at'])); ?></td>
                                                    <td><?= date("M d, Y @ h:i:s A", strtotime($product['updated_at'])); ?></td>
                                                </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                    <p class = "userCount"><?= count($products) ?> Products </p>
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
