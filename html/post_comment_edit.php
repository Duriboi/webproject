<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

// 댓글 ID 가져오기
$comment_id = $_POST['comment_id'];
$comment_text = $_POST['comment_text'];

// 댓글 수정 쿼리
$sql_update = "UPDATE comments SET comment_text=? WHERE id=? AND commenter_id=?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("sii", $comment_text, $comment_id, $_SESSION['user_id']);

if ($stmt_update->execute()) {
    echo "댓글이 성공적으로 수정되었습니다.";
} else {
    echo "댓글 수정에 실패했습니다.";
}

$stmt_update->close();
$conn->close();
?>

