<?php
    session_start();
    if(!isset($_SESSION['user']['username'])) header('location: login.php');
    $_SESSION['table'] = 'suppliers';
    $_SESSION['redirect_to'] = 'suppliers-add.php';
    $username = $_SESSION['user']['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Suppliers - Starvault</title>
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
                            <h1 class = "section_header"><i class = "fa fa-plus"></i> Create Supplier </h1>
                            <div id="userAddFormContainer">
                                <form action = "add.php" method = "POST" class="appForm" enctype="multipart/form-data">
                                    <div class = "appFormInputContainer">
                                        <label for = "supplier_name">Supplier Name</label>
                                        <input type = "text" class = "appFormInput" id = "supplier_name" placeholder = "Enter Supplier name" name = "supplier_name" />
                                    </div>
                                    <div class = "appFormInputContainer">
                                        <label for = "supplier_location">Location</label>
                                        <textArea class = "appFormInput productTextAreaInput" id = "supplier_location" placeholder = "Enter Supplier Location" name = "supplier_location"></textArea>
                                    </div>
                                    <div class = "appFormInputContainer">
                                        <label for = "email">Email Address</label>
                                        <input type = "text" class = "appFormInput" id = "email" placeholder = "Enter Supplier Email" name = "email" />
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
