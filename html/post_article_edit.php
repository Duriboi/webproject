<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

// 게시물 ID 가져오기
$article_id = $_POST['article_id'];
$title = $_POST['title'];
$content = $_POST['content'];

// 게시물 수정 쿼리
$sql_update = "UPDATE posts SET title=?, content=? WHERE id=? AND user_id=?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("ssii", $title, $content, $article_id, $_SESSION['user_id']);

if ($stmt_update->execute()) {
    echo "게시물이 성공적으로 수정되었습니다.";
} else {
    echo "게시물 수정에 실패했습니다.";
}

$stmt_update->close();
$conn->close();
?>

