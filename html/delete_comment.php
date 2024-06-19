<?php
include 'auth.php';
include 'db.php';

if (!isset($_GET['id'])) {
    // 댓글 ID가 전달되지 않았을 경우 처리
    echo "댓글 ID가 제공되지 않았습니다.";
    exit();
}

$comment_id = $_GET['id'];

// 댓글 삭제 쿼리 실행
$sql_delete_comment = "DELETE FROM comments WHERE id = ?";
$stmt_delete_comment = $conn->prepare($sql_delete_comment);
$stmt_delete_comment->bind_param("i", $comment_id);

if ($stmt_delete_comment->execute()) {
    // 삭제 성공 시
    echo "댓글이 성공적으로 삭제되었습니다.";
} else {
    // 삭제 실패 시
    echo "댓글 삭제 중 문제가 발생했습니다.";
}

$stmt_delete_comment->close();
$conn->close();
?>

