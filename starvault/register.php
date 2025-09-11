<?php
    include 'db_connection.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
    
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
        $sql = "INSERT INTO users (username, password, email) 
                VALUES ('$username', '$hashed_password', '$email')";
    
        if ($conn->query($sql) === TRUE) {
            echo "<h1>Registration successful.</h1>";
            header("Location: login.php");
        } else {
            die("Error: " . $sql . "<br>" . $conn->error);
        }
    
        $conn->close();
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Starvault Inventory Management System</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        body {
            background: url('images/login_bg.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-container {
            background-color: rgba(128, 128, 128, 0.9); 
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px;
        }

        form input[type="text"], form input[type="password"], form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        form button {
            background-color: #000000;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        form button:hover {
            background-color: #D3D3D3; 
            color: #000; 
        }

        .register-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #FFFFFF; 
        }

        .register-container a {
            color: #00BFFF; 
            text-decoration: none;
            font-weight: bold;
        }

        .register-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Registration</h2>
        <form method="POST" action="register.php" enctype="multipart/form-data">
            <input type="text" name="username" placeholder="Username" required>
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Signup</button>
            <p style="margin-top: 20px; color: #FFFFFF;">
                Already have an account? <a href="login.php">Login</a>
            </p>
        </form>
    </div>
</body>
</html>


