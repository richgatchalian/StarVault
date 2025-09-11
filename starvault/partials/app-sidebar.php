<?php
    $username = $_SESSION['user']['username'];
?>

<div class = "dashboard_sidebar" id = "dashboard_sidebar">
    <h3 class = "dashboard_logo" id = "dashboard_logo">STARVAULT</h3>
    <div class = "dashboard_sidebar_user">
        <img src = "images/profile.png" alt = "user image." id="userImage"/>
        <span> <?= htmlspecialchars($username) ?> </span>
    </div>
    <div class = "dashboard_sidebar_menu">
        <ul class = "dashboard_menu_list">
            <li class = "liMainMenu">
                <a href="./dashboard.php"><i class ="fa fa-dashboard"></i><span class = "menuText">Dashboard</span></a>
            </li>
            <li class = "liMainMenu showHideSubmenu">
                <a href="javascript:void(0);" class = "showHideSubmenu">
                    <i class ="fa fa-tag showHideSubmenu"></i>
                    <span class = "menuText showHideSubmenu">Product</span>
                    <i class = "fa fa-angle-left mainMenuIconArrow showHideSubmenu"></i> 
                </a>
                <ul class = "subMenus">
                    <li><a class = "subMenuLink" href = "./product-view.php"><i class = "fa fa-circle-o"></i> View Product</a></li>
                    <li><a class = "subMenuLink" href = "./product-add.php"><i class = "fa fa-circle-o"></i> Add Product</a></li>
                </ul>
            </li>
            <li class = "liMainMenu">
            <a href="javascript:void(0);" class = "showHideSubmenu">
                    <i class ="fa fa-truck showHideSubmenu"></i>
                    <span class = "menuText showHideSubmenu">Supplier</span>
                    <i class = "fa fa-angle-left mainMenuIconArrow showHideSubmenu"></i> 
                </a>
                <ul class = "subMenus">
                    <li><a class = "subMenuLink" href = "./suppliers-view.php"><i class = "fa fa-circle-o"></i> View Supplier</a></li>
                    <li><a class = "subMenuLink" href = "./suppliers-add.php"><i class = "fa fa-circle-o"></i> Add Suppliers</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>