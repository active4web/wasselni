<?php
session_start();
ob_start();

unset($_SESSION['admin_name']);
 unset($_SESSION['id_admin']);
unset($_SESSION['user_id']);
unset($_SESSION['type_admin']);
unset($_SESSION['last_login']);
header("location:login");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>

<body>

</body>
</html>