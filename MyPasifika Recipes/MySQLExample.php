<html>
<head>
<title>Connecting through Mysql and PHP</title>
</head>
<body>

<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = " ";


$mysqli = new mysqli ($dbhost,$dbuser,$dbpass);
if($mysqli -> connect_errno){
        printf("connection failed", $mysqli-> connect_error);
        exit();
}

printf("connected successfully");



$mysqli->close();
?>

</body>

</html>