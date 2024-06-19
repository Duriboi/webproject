<?php
session_start();

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 게시글 ID와 댓글 정보 가져오기
    $article_id = $_POST['article_id'];
    $commenter_name = $_SESSION['username'];  // 세션에서 작성자 이름 가져오기
    $comment_text = $_POST['comment_text'];
    $parent_comment_id = isset($_POST['parent_comment_id']) ? $_POST['parent_comment_id'] : null;  // 부모 댓글 ID 가져오기

    // SQL 문 작성
    $sql = "INSERT INTO comments (article_id, commenter_name, comment_text, parent_comment_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $article_id, $commenter_name, $comment_text, $parent_comment_id);

    if ($stmt->execute()) {
        echo "댓글이 성공적으로 작성되었습니다.";
    } else {
        echo "댓글 작성에 실패했습니다.";
    }

    $stmt->close();
    $conn->close();
}
?>

