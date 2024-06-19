<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT username, email, created_at FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $username = htmlspecialchars($user['username']);
    $email = htmlspecialchars($user['email']);
    $created_at = htmlspecialchars($user['created_at']);
} else {
    echo "사용자 정보를 찾을 수 없습니다.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Page</title>
</head>
<body>
    <h2>My Page</h2>
    <p><strong>Username:</strong> <?php echo $username; ?></p>
    <p><strong>Email:</strong> <?php echo $email; ?></p>
    <p><strong>Registered At:</strong> <?php echo $created_at; ?></p>
    <a href="logout.php">Logout</a>
</body>
</html>

