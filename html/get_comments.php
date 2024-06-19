<?php
// get_comments.php

include 'db.php';

// 게시글 ID 가져오기
$article_id = $_GET['id'];

// 댓글 조회 쿼리
$sql_comments = "SELECT * FROM comments WHERE article_id = ?";
$stmt_comments = $conn->prepare($sql_comments);
$stmt_comments->bind_param("i", $article_id);
$stmt_comments->execute();
$result_comments = $stmt_comments->get_result();

// 댓글 목록 출력
if ($result_comments->num_rows > 0) {
    while ($row_comment = $result_comments->fetch_assoc()) {
        $commenter_name = htmlspecialchars($row_comment['commenter_name']);
        $comment_text = htmlspecialchars($row_comment['comment_text']);
        echo "<p><strong>$commenter_name</strong>: $comment_text</p>";
    }
} else {
    echo "<p>댓글이 없습니다.</p>";
}

$stmt_comments->close();
$conn->close();
?>

