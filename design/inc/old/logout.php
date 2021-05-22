<?php
session_start();
ob_start();
unset($_SESSION['user_name']);
unset($_SESSION['fname']);
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
unset($_SESSION['email']);
header("location:../logout.php?success=true");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>

<body>

</body>
</html>