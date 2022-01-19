<?php

session_start();

if(!isset($_SESSION["user_id"])) {
    header("Location: index.php");
}

echo $_SESSION["user_id"];


// Logged out popout message
$logged_out = FALSE;

if ($logged_out === TRUE) {
    echo "<script>alert('You've logged out');</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
  </head>
<body>
    <a href="logout.php">Logout</a>
</body>
</html>