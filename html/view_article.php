<?php
include 'auth.php';
include 'db.php';

if (!isset($_GET['id'])) {
    echo "게시글 ID가 제공되지 않았습니다.";
    exit();
}

$article_id = $_GET['id'];
$_SESSION['current_article_id'] = $article_id;

$sql_article = "SELECT * FROM posts WHERE id = ?";
$stmt_article = $conn->prepare($sql_article);
$stmt_article->bind_param("i", $article_id);
$stmt_article->execute();
$result_article = $stmt_article->get_result();
$row_article = $result_article->fetch_assoc();

if (!$row_article) {
    echo "게시글을 찾을 수 없습니다.";
    exit();
}

echo "<h2>" . htmlspecialchars($row_article['title']) . "</h2>";
echo "<p>" . htmlspecialchars($row_article['content']) . "</p>";

// 파일 다운로드 링크 추가
$sql_files = "SELECT * FROM files WHERE post_id = ?";
$stmt_files = $conn->prepare($sql_files);
$stmt_files->bind_param("i", $article_id);
$stmt_files->execute();
$result_files = $stmt_files->get_result();

if ($result_files->num_rows > 0) {
    echo "<h3>첨부 파일</h3>";
    while ($row_file = $result_files->fetch_assoc()) {
        echo "<p><a href='" . htmlspecialchars($row_file['file_path']) . "' download>" . htmlspecialchars($row_file['file_name']) . "</a></p>";
    }
} else {
    echo "<p>첨부 파일이 없습니다.</p>";
}

$stmt_files->close();

// 게시글 수정 및 삭제 버튼 추가
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row_article['user_id']) {
    echo "<a href='edit_article.php?id=$article_id'>게시글 수정</a> | ";
    echo "<a href='delete_article.php?id=$article_id' onclick='return confirm(\"정말로 삭제하시겠습니까?\")'>게시글 삭제</a>";
}

echo "<hr>";

// 댓글 목록 출력 함수
function display_comments($comments, $parent_id = 0, $level = 0) {
    foreach ($comments as $comment) {
        if ($comment['parent_comment_id'] == $parent_id) {
            echo "<div style='margin-left:" . ($level * 20) . "px'>";
            echo "<p><strong>" . htmlspecialchars($comment['commenter_name']) . "</strong>: " . htmlspecialchars($comment['comment_text']) . "</p>";

            // 댓글 작성자와 현재 로그인한 사용자가 같다면 수정 및 삭제 버튼 추가
            if (isset($_SESSION['username']) && $_SESSION['username'] == $comment['commenter_name']) {
                echo "<button onclick='showEditForm(" . $comment['id'] . ")'>수정</button>";
                echo "<button onclick='deleteComment(" . $comment['id'] . ")'> 삭제</button>";

                // 수정 폼 추가
                echo "<div id='edit-form-" . $comment['id'] . "' style='display:none; margin-left: 20px;'>";
                echo "<form id='edit-comment-form-" . $comment['id'] . "' onsubmit='editComment(event, " . $comment['id'] . ")'>";
                echo "<input type='hidden' name='comment_id' value='" . htmlspecialchars($comment['id']) . "'>";
                echo "댓글: <textarea name='comment_text' rows='2' cols='50' required>" . htmlspecialchars($comment['comment_text']) . "</textarea><br>";
                echo "<input type='submit' value='댓글 수정'>";
                echo "</form>";
                echo "</div>";
            }

            // 최상위 댓글에만 답글 달기 버튼 추가
            if ($level == 0) {
                echo "<button onclick='showReplyForm(" . $comment['id'] . ")'> 답글 달기</button>";
                echo "<div id='reply-form-" . $comment['id'] . "' style='display:none; margin-left: 20px;'>";
                echo "<form id='reply-comment-form-" . $comment['id'] . "' action='post_comment.php' method='post'>";
                echo "<input type='hidden' name='article_id' value='" . htmlspecialchars($comment['article_id']) . "'>";
                echo "<input type='hidden' name='parent_comment_id' value='" . htmlspecialchars($comment['id']) . "'>";
                echo "댓글: <textarea name='comment_text' rows='2' cols='50' required></textarea><br>";
                echo "<input type='submit' value='답글 작성'>";
                echo "</form>";
                echo "</div>";
            }

            display_comments($comments, $comment['id'], $level + 1);
            echo "</div>";
        }
    }
}

// 댓글 조회 쿼리
$sql_comments = "SELECT * FROM comments WHERE article_id = ?";
$stmt_comments = $conn->prepare($sql_comments);
$stmt_comments->bind_param("i", $article_id);
$stmt_comments->execute();
$result_comments = $stmt_comments->get_result();

$comments = [];
while ($row_comment = $result_comments->fetch_assoc()) {
    $comments[] = $row_comment;
}

echo "<h3>댓글 목록</h3>";
if (count($comments) > 0) {
    display_comments($comments);
} else {
    echo "<p>댓글이 없습니다.</p>";
}

// 댓글 작성 폼
echo "<h3>댓글 작성</h3>";
echo "<form action='post_comment.php' method='post'>";
echo "<input type='hidden' name='article_id' value='$article_id'>";
echo "<input type='hidden' name='parent_comment_id' value='0'>";
echo "댓글: <textarea name='comment_text' rows='4' cols='50' required></textarea><br>";
echo "<input type='submit' value='댓글 작성'>";
echo "</form>";

$stmt_article->close();
$stmt_comments->close();
$conn->close();
?>

<script>
function showReplyForm(commentId) {
    var form = document.getElementById('reply-form-' + commentId);
    if (form.style.display === 'none') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}

function showEditForm(commentId) {
    var form = document.getElementById('edit-form-' + commentId);
    if (form.style.display === 'none') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}

function deleteComment(commentId) {
    if (confirm("정말로 이 댓글을 삭제하시겠습니까?")) {
        // AJAX를 이용한 댓글 삭제 요청
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // 삭제 성공 시 페이지 새로고침
                location.reload();
            }
        };
        xhttp.open("GET", "delete_comment.php?id=" + commentId, true);
        xhttp.send();
    }
}

function editComment(event, commentId) {
    event.preventDefault();
    var formData = new FormData(document.getElementById('edit-comment-form-' + commentId));

    // AJAX를 이용한 댓글 수정 요청
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // 수정 성공 시 페이지 새로고침
            location.reload();
        }
    };
    xhttp.open("POST", "edit_comment.php", true);
    xhttp.send(formData);
}
</script>

