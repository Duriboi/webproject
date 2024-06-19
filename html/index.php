<?php
include 'db.php';
include 'auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <ul>
            <a href="index.php"><li>메인페이지</li></a>
            <a href="about.php"><li>about</li></a>
            <a href="search.php"><li>유저검색</li></a>
	    <a href="mypage.php"><li>마이페이지</li></a>
	    <a href="search_articles.php"><li>게시글검색</li></a>
        </ul>
    </header>

    <section>
        <h1>메인페이지입니다.</h1>
    </section>

    <footer>
            <a href="logout.php">Logout</a>
    </footer>

</body>
</html>

