<?php
$servername = "localhost";
$username = "1234"; // 본인의 MySQL 사용자 이름 입력
$password = "1234"; // 본인의 MySQL 비밀번호 입력
$dbname = "user_database"; // 본인의 기존 데이터베이스 이름 입력 (보드2가 포함된)

// MySQL 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}
?>

