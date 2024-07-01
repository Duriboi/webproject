<?php
include 'auth.php'; // 로그인 검사를 위한 auth.php 포함
include 'db.php';

$search_type = isset($_GET['search_type']) ? $_GET['search_type'] : '';
$keyword = isset($_GET['keyword']) ? '%' . $_GET['keyword'] . '%' : '';

// 초기 정렬 기본값 설정
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'latest';
$sort_clause = '';
switch ($sort_by) {
    case 'title_asc':
        $sort_clause = "ORDER BY title ASC";
        break;
    case 'title_desc':
        $sort_clause = "ORDER BY title DESC";
        break;
    case 'oldest':
        $sort_clause = "ORDER BY created_at ASC";
        break;
    case 'latest':
        $sort_clause = "ORDER BY created_at DESC";
        break;
    default:
        $sort_clause = "ORDER BY created_at DESC"; // 기본 정렬 설정
}

// 검색 조건 설정
$where_clause = '';
if (!empty($keyword)) {
    switch ($search_type) {
        case 'title':
            $where_clause = "WHERE title LIKE ?";
            break;
        case 'username':
            $where_clause = "WHERE username LIKE ?";
            break;
        case 'content':
            $where_clause = "WHERE content LIKE ?";
            break;
        default:
            echo "잘못된 검색 유형입니다.";
            exit();
    }
}

// 전체 쿼리
$sql = "SELECT id, title, username, created_at FROM board2_posts $where_clause $sort_clause";
$stmt = $conn->prepare($sql);

if (!empty($where_clause)) {
    $stmt->bind_param("s", $keyword);
}

$stmt->execute();
$result = $stmt->get_result();

// 검색 결과 수
$num_results = $result->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>게시글 검색</title>
    <style>
        body {
            background: #f6f5f7;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family: 'Montserrat', sans-serif;
            height: 100vh;
            margin: 0;
        }

        h2 {
            color: mediumaquamarine;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        label {
            margin-right: 10px;
        }

        select, input[type="text"], input[type="submit"] {
            background-color: #eee;
            border: none;
            padding: 10px;
            margin-right: 10px;
            border-radius: 4px;
            box-sizing: border-box;
            width: 200px;
        }

        input[type="submit"] {
            background-color: mediumaquamarine;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #4CAF50;
        }

        #sort_form {
            margin-top: 20px;
        }

        #sort_form h3 {
            color: mediumaquamarine;
            margin-bottom: 10px;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        ul li {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #FFFFFF;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        ul li a {
            color: mediumaquamarine;
            text-decoration: none;
        }

        ul li a:hover {
            text-decoration: underline;
        }

        .no-results {
            color: #555;
            font-style: italic;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var searchType = "<?php echo $search_type; ?>";
            var keyword = "<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>";
            var sortForm = document.getElementById('sort_form');

            // 페이지 로드 시 검색 조건이 있을 때만 정렬 옵션 폼 보이기
            if (searchType !== '' && keyword !== '') {
                sortForm.style.display = 'block';
            } else {
                sortForm.style.display = 'none';
            }
        });
    </script>
</head>
<body>
    <h2>게시글 검색</h2>

    <!-- 검색 폼 -->
    <form action="search_article_board2.php" method="get">
        <label for="search_type">검색 유형:</label>
        <select name="search_type" id="search_type">
            <option value="title" <?php echo ($search_type == 'title') ? 'selected' : ''; ?>>제목</option>
            <option value="username" <?php echo ($search_type == 'username') ? 'selected' : ''; ?>>작성자</option>
            <option value="content" <?php echo ($search_type == 'content') ? 'selected' : ''; ?>>내용</option>
        </select>
        <input type="text" name="keyword" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>" required>
        <input type="submit" value="검색">
    </form>

    <!-- 정렬 옵션 -->
    <?php if ($num_results > 0): ?>
        <div id="sort_form" style="display: none;">
            <h3>정렬 옵션</h3>
            <form action="search_article_board2.php" method="get">
                <input type="hidden" name="search_type" value="<?php echo $search_type; ?>">
                <input type="hidden" name="keyword" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
                <label for="sort_by">정렬:</label>
                <select name="sort_by" id="sort_by">
                    <option value="title_asc" <?php echo ($sort_by == 'title_asc') ? 'selected' : ''; ?>>제목 오름 차순</option>
                    <option value="title_desc" <?php echo ($sort_by == 'title_desc') ? 'selected' : ''; ?>>제목 내 림차순</option>
                    <option value="oldest" <?php echo ($sort_by == 'oldest') ? 'selected' : ''; ?>>오래된 순</option>
                    <option value="latest" <?php echo ($sort_by == 'latest') ? 'selected' : ''; ?>>최신 순</option>
                </select>
                <input type="submit" value="적용">
            </form>
        </div>
    <?php endif; ?>

    <!-- 검색 결과 -->
    <?php if ($num_results > 0): ?>
        <h3>검색 결과</h3>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                $id = $row['id'];
                $title = htmlspecialchars($row['title']);
                $username = htmlspecialchars($row['username']);
                $created_at = htmlspecialchars($row['created_at']);
                ?>
                <li><a href='view_article_board2.php?id=<?php echo $id; ?>'><?php echo $title; ?></a> - 작성자: <?php echo $username; ?>, 작성일: <?php echo $created_at; ?></li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>검색 결과가 없습니다.</p>
    <?php endif; ?>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
