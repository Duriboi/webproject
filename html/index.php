<?php
include 'db.php';
include 'auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <style>
        body {
            background: #f6f5f7;
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: mediumaquamarine;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            display: inline-block;
            margin-right: 20px;
        }

        a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #ffcc00;
        }

        section {
            text-align: center;
            padding: 20px;
        }

        footer {
            background-color: gainsboro;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        footer a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #ffcc00;
        }
    </style>
</head>
<body>
    <header>
        <ul>
            <li><a href="index.php">메인페이지</a></li>
            <li><a href="about.php">about</a></li>
            <li><a href="search.php">유저검색</a></li>
            <li><a href="mypage.php">마이페이지</a></li>
            <li><a href="board1.php">보드1</a></li>
            <li><a href="board2.php">보드2</a></li>
        </ul>
    </header>

    <section>
        <h1>메인페이지</h1>
        <img src="https://blog.kakaocdn.net/dn/P2mBX/btrUul3VTMl/r5gxoaKtxuJJVIZo4nIvgK/img.gif">
    </section>

    <footer>
        <a href="logout.php">Logout</a>
    </footer>
</body>
</html>?>
