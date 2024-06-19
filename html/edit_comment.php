<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['comment_id'], $_POST['comment_text'])) {
        echo "댓글 ID 또는 댓글 내용이 제공되지 않았습니다.";
        exit();
    }

    $comment_id = $_POST['comment_id'];
    $comment_text = $_POST['comment_text'];

    // 댓글 정보 가져오기
    $sql_comment = "SELECT commenter_id, commenter_name FROM comments WHERE id = ?";
    $stmt_comment = $conn->prepare($sql_comment);
    $stmt_comment->bind_param("i", $comment_id);
    $stmt_comment->execute();
    $result_comment = $stmt_comment->get_result();
    $row_comment = $result_comment->fetch_assoc();

    if (!$row_comment) {
        echo "댓글을 찾을 수 없습니다.";
        exit();
    }

    // 댓글 작성자가 commenter_id가 NULL일 경우 commenter_name으로 확인
    if ($row_comment['commenter_id'] === NULL) {
        $sql_update = "UPDATE comments SET comment_text = ? WHERE id = ? AND commenter_name = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sis", $comment_text, $comment_id, $_SESSION['username']);
    } else {
        // commenter_id가 있는 경우 commenter_id로 확인
        $sql_update = "UPDATE comments SET comment_text = ? WHERE id = ? AND commenter_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sii", $comment_text, $comment_id, $_SESSION['user_id']);
    }

    if ($stmt_update->execute()) {
        // 수정 성공
        header("Location: view_article.php?id=" . $_SESSION['current_article_id']); // 수정 후 보여줄 게시글 페이지로 리디렉션
        exit();
    } else {
        // 수정 실패
        echo "댓글 수정 중 오류가 발생했습니다.";
    }

    $stmt_update->close();
} else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // 댓글 수정 폼 표시
    $comment_id = $_GET['id'];

    // 해당 댓글 정보 가져오기
    $sql_comment = "SELECT * FROM comments WHERE id = ? AND (commenter_id = ? OR (commenter_id IS NULL AND commenter_name = ?))";
    $stmt_comment = $conn->prepare($sql_comment);
    $stmt_comment->bind_param("iis", $comment_id, $_SESSION['user_id'], $_SESSION['username']);
    $stmt_comment->execute();
    $result_comment = $stmt_comment->get_result();
    $row_comment = $result_comment->fetch_assoc();

    if (!$row_comment) {
        echo "댓글을 찾을 수 없거나 수정 권한이 없습니다.";
        exit();
    }

    // 댓글 수정 폼
    echo "<h2>댓글 수정</h2>";
    echo "<form action='edit_comment.php' method='post'>";
    echo "<input type='hidden' name='comment_id' value='" . htmlspecialchars($comment_id) . "'>";
    echo "댓글: <textarea name='comment_text' rows='4' cols='50' required>" . htmlspecialchars($row_comment['comment_text']) . "</textarea><br>";
    echo "<input type='submit' value='댓글 수정'>";
    echo "</form>";

    $stmt_comment->close();
} else {
    echo "잘못된 요청입니다.";
}

$conn->close();
?>

