<?php
include 'auth.php';
include 'db.php';

if (!isset($_GET['id'])) {
    echo "게시글 ID가 제공되지 않았습니다.";
    exit();
}

$article_id = $_GET['id'];

$sql_delete = "DELETE FROM posts WHERE id = ? AND user_id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("ii", $article_id, $_SESSION['user_id']);
$stmt_delete->execute();

header("Location: index.php");
exit();
?>

