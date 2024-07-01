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
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f5f7;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: mediumaquamarine;
            text-align: center;
        }

        p {
            text-align: center;
            margin-bottom: 10px;
        }

        strong {
            color: mediumaquamarine;
        }

        a {
            display: block;
            width: 100px;
            padding: 10px;
            text-align: center;
            margin: 20px auto;
            background-color: mediumaquamarine;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background-color: #4CAF50;
	}
	img {
	display: block;
	margin: 0 auto;
	height:300px; width:300px;
}
    </style>
</head>
<body>
    <h2>My Page</h2>
    <p><strong>Username:</strong> <?php echo $username; ?></p>
    <p><strong>Email:</strong> <?php echo $email; ?></p>
    <p><strong>Registered At:</strong> <?php echo $created_at; ?></p>
    <img src="https://yt3.ggpht.com/EecR13zoIGuPWwwL1dfFz8UUkIZbavCkpJpPK1AUPMp8mf28nF4h50oaq7rytQOtd_k7BeYNGMar=s540-c-fcrop64=1,27620000d89dffff-nd-v1-rwa">
    <a href="logout.php">Logout</a>
</body>
</html>

