<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$sql = "SELECT username, email FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
    } else {
        echo "<p>Error: No user data found.</p>";
        exit;
    }

    $stmt->close();
} else {
    echo "<p>Error: Failed to prepare the query.</p>";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Starvault</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>    
    <form action="logout.php" method="POST">
        <button type="submit">Logout</button>
    </form>
</body>
</html>
