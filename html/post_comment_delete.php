<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

// 댓글 ID 가져오기
$comment_id = $_POST['comment_id'];

// 댓글 삭제 쿼리
$sql_delete = "DELETE FROM comments WHERE id=? AND commenter_id=?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("ii", $comment_id, $_SESSION['user_id']);

if ($stmt_delete->execute()) {
    echo "댓글이 성공적으로 삭제되었습니다.";
} else {
    echo "댓글 삭제에 실패했습니다.";
}

$stmt_delete->close();
$conn->close();
?>

