<?php
session_start();

// 로그인 상태 확인
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 작성</title>
</head>
<body>
    <h2>게시글 작성</h2>
    <form action="post_article.php" method="post">
        제목: <input type="text" name="title" required><br>
        내용: <textarea name="content" rows="10" cols="50" required></textarea><br>
        <input type="submit" value="작성">
    </form>
</body>
</html>

