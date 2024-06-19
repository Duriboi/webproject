<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "1234"; // 본인의 데이터베이스 사용자 이름으로 변경
$password = "1234"; // 본인의 데이터베이스 비밀번호로 변경
$dbname = "user_database"; // 본인의 데이터베이스 이름으로 변경

$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

