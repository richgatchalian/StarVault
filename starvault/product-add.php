<?php
    session_start();
    if(!isset($_SESSION['user']['username'])) header('location: login.php');
    $_SESSION['table'] = 'products';
    $_SESSION['redirect_to'] = 'product-add.php';
    $username = $_SESSION['user']['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Add - Starvault</title>
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
                            <h1 class = "section_header"><i class = "fa fa-plus"></i> Create Product </h1>
                            <div id="userAddFormContainer">
                                <form action = "add.php" method = "POST" class="appForm" enctype="multipart/form-data">
                                    <div class = "appFormInputContainer">
                                        <label for = "product_name">Product Name</label>
                                        <input type = "text" class = "appFormInput" id = "product_name" placeholder = "Enter Product name" name = "product_name" />
                                    </div>
                                    <div class = "appFormInputContainer">
                                        <label for = "description">Description</label>
                                        <textArea class = "appFormInput productTextAreaInput" id = "description" placeholder = "Enter Product description" name = "description"></textArea>
                                    </div>
                                    <div class = "appFormInputContainer">
                                        <label for = "description">Suppliers</label>
                                        <select name = "suppliers[]" id = "suppliersSelect" multiple>
                                            <option value = ""> Select Supplier </option>
                                            <?php
                                                $show_table  = 'suppliers';
                                                $suppliers = include('show.php');
                                                
                                                foreach($suppliers as $supplier){
                                                    echo "<option value ='".$supplier['id']."'>". $supplier['supplier_name']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class = "appFormInputContainer">
                                        <label for = "product_image">Product Image</label>
                                        <input type = "file" name = "image" accept="image/*" required />
                                    </div>
                                    <button type = "submit" class = "appButton"><i class = "fa fa-plus"></i> Add Product</button>
                                </form>
                                <?php
                                    if(isset($_SESSION['response'])){
                                        $response_message = $_SESSION['response']['message'];
                                        $is_success = $_SESSION['response']['success'];
                                ?>
                                    <div class = "responseMessage">
                                        <p class = "responseMessage <?= $is_success ? 'responseMessage_success' : 'responseMessage_error' ?>">
                                            <?= $response_message ?>
                                        </p>
                                    </div>
                                <?php unset($_SESSION['response']);}?>
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
