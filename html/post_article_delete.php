<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

// 게시물 ID 가져오기
$article_id = $_POST['article_id'];

// 게시물 삭제 쿼리
$sql_delete = "DELETE FROM posts WHERE id=? AND user_id=?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("ii", $article_id, $_SESSION['user_id']);

if ($stmt_delete->execute()) {
    echo "게시물이 성공적으로 삭제되었습니다.";
} else {
    echo "게시물 삭제에 실패했습니다.";
}

$stmt_delete->close();
$conn->close();
?>

