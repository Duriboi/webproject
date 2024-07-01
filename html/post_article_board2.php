<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id']; // 현재 로그인한 사용자의 ID
    $username = $_SESSION['username']; // 현재 로그인한 사용자의 username

    // 파일 업로드 처리
    $upload_dir = 'uploads/';
    $file_path = '';
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $file_name = basename($_FILES['file']['name']);
        $file_path = $upload_dir . $file_name;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
            echo "파일이 성공적으로 업로드되었습니다.";
        } else {
            echo "파일 업로드 중 오류가 발생했습니다.";
            exit();
        }
    }

    // board1_posts 테이블에 게시글 저장
    $sql_board1 = "INSERT INTO board2_posts (title, content, user_id, username) VALUES (?, ?, ?, ?)";
    $stmt_board1 = $conn->prepare($sql_board1);
    $stmt_board1->bind_param("ssis", $title, $content, $user_id, $username);

    if ($stmt_board1->execute()) {
        $board1_post_id = $stmt_board1->insert_id; // 삽입된 게시글의 ID 가져오기

        // 파일 정보 저장
        if ($file_path) {
            // board1_post_id를 그대로 사용하여 files 테이블에 저장
            $sql_file = "INSERT INTO board2_files (post_id, file_name, file_path) VALUES (?, ?, ?)";
            $stmt_file = $conn->prepare($sql_file);
            $stmt_file->bind_param("iss", $board1_post_id, $file_name, $file_path);

            if ($stmt_file->execute()) {
                echo "게시글과 파일이 성공적으로 저장되었습니다.";
            } else {
                echo "파일 정보 저장 중 오류가 발생했습니다: " . $stmt_file->error;
            }
            $stmt_file->close();
        } else {
            echo "게시글이 성공적으로 작성되었습니다.";
        }
    } else {
        echo "게시글 작성 중 오류가 발생했습니다: " . $stmt_board1->error;
    }

    $stmt_board1->close();
    $conn->close();
}
?>
