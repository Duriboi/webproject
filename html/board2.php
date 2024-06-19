<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Board 2</title>
</head>
<body>
    <h2>Board 2</h2>

    <!-- 게시글 작성 폼 -->
    <form action="post_article.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="page" value="board2">
        제목: <input type="text" name="title" required><br>
        내용: <textarea name="content" rows="4" cols="50" required></textarea><br>
        파일: <input type="file" name="file"><br>
        <input type="submit" value="게시">
    </form>

    <h3>글 목록</h3>
    <form method="get" action="board2.php">
        <label for="sort">정렬 기준:</label>
        <select name="sort" id="sort" onchange="this.form.submit()">
            <option value="created_at_desc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'created_at_desc') echo 'selected'; ?>>최신순</option>
            <option value="created_at_asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'created_at_asc') echo 'selected'; ?>>오래된순</option>
            <option value="title_asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'title_asc') echo 'selected'; ?>>제목 오름차순</option>
            <option value="title_desc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'title_desc') echo 'selected'; ?>>제목 내림차순</option>
        </select>
    </form>

    <ul>
        <?php
        include 'db_board2.php';

        // 정렬 기준 설정
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'created_at_desc';
        switch ($sort) {
            case 'created_at_asc':
                $order_by = 'created_at ASC';
                break;
            case 'title_asc':
                $order_by = 'title ASC';
                break;
            case 'title_desc':
                $order_by = 'title DESC';
                break;
            case 'created_at_desc':
            default:
                $order_by = 'created_at DESC';
                break;
        }

        // 데이터베이스에서 모든 게시글 가져오기
        $sql = "SELECT id, title, username, created_at FROM board2_posts ORDER BY $order_by";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $title = htmlspecialchars($row['title']);
                $username = htmlspecialchars($row['username']);
                $created_at = htmlspecialchars($row['created_at']);
                echo "<li><a href='view_article.php?id=$id&page=board2'>$title</a> - 작성자: $username, 작성일: $created_at</li>";
            }
        } else {
            echo "<li>게시된 글이 없습니다.</li>";
        }

        $conn->close();
        ?>
    </ul>
</body>
</html>

