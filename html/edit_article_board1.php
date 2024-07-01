<?php
include 'auth.php';
include 'db.php';

if (!isset($_GET['id'])) {
    echo "게시글 ID가 제공되지 않았습니다.";
    exit();
}

$article_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql_update = "UPDATE board1_posts SET title = ?, content = ? WHERE id = ? AND user_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssii", $title, $content, $article_id, $_SESSION['user_id']);
    $stmt_update->execute();

    header("Location: view_article_board1.php?id=$article_id");
    exit();
}

$sql_article = "SELECT * FROM board1_posts WHERE id = ?";
$stmt_article = $conn->prepare($sql_article);
$stmt_article->bind_param("i", $article_id);
$stmt_article->execute();
$result_article = $stmt_article->get_result();
$row_article = $result_article->fetch_assoc();

if (!$row_article || $row_article['user_id'] != $_SESSION['user_id']) {
    echo "권한이 없습니다.";
    exit();
}
?>

<form action="edit_article_board1.php?id=<?php echo $article_id; ?>" method="post">
    제목: <input type="text" name="title" value="<?php echo htmlspecialchars($row_article['title']); ?>" required><br>
    내용: <textarea name="content" rows="10" cols="50" required><?php echo htmlspecialchars($row_article['content']); ?></textarea><br>
    <input type="submit" value="수정">
</form>
