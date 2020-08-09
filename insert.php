<?php

$conn = mysqli_connect("localhost", "root", "fmlskdk1", "opentutorials");
mysqli_query($conn, "
    INSERT INTO comment
    (id, description, author, profile)
    VALUE
    (5, 'This is query from php...', 'groundP', 'developer') 
");

?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>WEB</title>
</head>
<body>
    <h1>WEB</h1>
    <ol>
    <form action="process_create.php" method="POST">
    <p><input type="text", name="title", placeholder="title"></p>
    <p><textarea name="description" placeholder="description"></textarea></p>
    <p><input type="submit"></p>
    </form>
    </ol>
</body>
</html>