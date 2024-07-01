<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>유저 검색</title>
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

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="submit"] {
            padding: 8px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 200px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: mediumaquamarine;
            color: white;
            border: none;
            cursor: pointer;
        }

        p {
            text-align: center;
            margin-top: 10px;
        }

        p strong {
            color: mediumaquamarine;
        }
    </style>
</head>
<body>
    <h2>유저 검색</h2>
    <form action="search.php" method="get">
        유저 아이디: <input type="text" name="username" required>
	<input type="submit" value="검색">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['username'])) {
        include 'db.php';

        // GET 방식으로 전달된 유저 아이디 받기
        $search_username = $_GET['username'];

        // 데이터베이스에서 유저 정보 검색
        $sql = "SELECT username, email FROM users WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $search_username);
        $stmt->execute();
        $result = $stmt->get_result();

        // 검색 결과가 있는 경우 출력
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<h2>검색 결과:</h2>";
            echo "<p><strong>아이디:</strong> " . htmlspecialchars($row['username']) . "</p>";
            echo "<p><strong>이메일:</strong> " . htmlspecialchars($row['email']) . "</p>";
        } else {
            echo "<p>해당하는 유저를 찾을 수 없습니다.</p>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>

