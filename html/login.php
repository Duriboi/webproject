<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 사용자 정보 조회
    $sql = "SELECT id, username, password, email FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            header("Location: index.php");
        } else {
            echo "로그인 실패: 아이디나 비밀번호를 확인하세요.";
        }
    } else {
        echo "로그인 실패: 아이디나 비밀번호를 확인하세요.";
    }

    $stmt->close();
    $conn->close();
}
?>

