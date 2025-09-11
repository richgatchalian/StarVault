<?php
    session_start();
    include 'db_connection.php';

    $error_message = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                session_start();
                $_SESSION['user'] = [
                    'id' => $row['id'],
                    'username' => $row['username'],
                    'email' => $row['email']
                ];
                header("Location: dashboard.php");
                exit;
            } else {
                $error_message = "<p>Incorrect password. Please try again.</p>";
            }
        } else {
            $error_message = "<p>No account found with that username.</p>";
        }

        $conn->close();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Starvault Inventory Management System</title>
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

        .login-container {
            background-color: rgba(128, 128, 128, 0.9);
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px;
        }

        .error-message {
            color: #FF6347;  
            font-size: 14px;
            margin-bottom: 10px;
        }

        form input[type="text"], form input[type="password"] {
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
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #FFFFFF;
        }

        .login-container a {
            color: #00BFFF; 
            text-decoration: none;
            font-weight: bold;
        }

        .login-container a:hover {
            text-decoration: underline;
        }

        .additional-text {
            margin-top: 20px;
            color: #FFFFFF;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <!-- Display the error message if it exists -->
        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p class="additional-text">
            Don't have an account? <a href="register.php">Signup</a>
        </p>
    </div>
</body>
</html>
