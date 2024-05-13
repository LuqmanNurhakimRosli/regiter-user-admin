<?php
require('db.php');
session_start();

// When form submitted, check and create user session.
if (isset($_POST['username'])) {
  $username = stripslashes($_REQUEST['username']); // removes backslashes
  $username = mysqli_real_escape_string($con, $username);
  $password = stripslashes($_REQUEST['password']);
  $password = mysqli_real_escape_string($con, $password);

  // Check user exists in the database
  $query = "SELECT * FROM `users` WHERE username='$username'";
  $result = mysqli_query($con, $query);

  if (!$result) {
    echo "Error executing query: " . mysqli_error($con);
    exit; // Stops script execution after the error message
  }

  $rows = mysqli_num_rows($result);

  if ($rows == 1) {
    // Use a secure password hashing algorithm (replace with your implementation)
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // if (password_verify($password, $hashed_password)) { // Verify password
    if (md5($password)  === mysqli_fetch_assoc($result)["password"]) { // Username and password match (replace with secure hashing if implemented)
      // Username and password match
      $_SESSION['username'] = $username;
      if ($username == "admin") {
        header("Location: adminpage.php"); // Redirect to admin page for admin user
      } else {
        header("Location: dashboard.php"); // Redirect to regular user dashboard
      }
    } else {
      echo "<div class='form'><h3>Incorrect Username/password.</h3><br/>
            <p class='link'>Click here to <a href='index.php'>Login</a> again.</p></div>";
    }
  } else {
    echo "<div class='form'><h3>Incorrect Username/password.</h3><br/>
          <p class='link'>Click here to <a href='index.php'>Login</a> again.</p></div>";
  }
} else {
  // Display login form...
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <form class="form" method="post" name="login">
        <h1 class="login-title">Login</h1>
        <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true"/>
        <input type="password" class="login-input" name="password" placeholder="Password"/>
        <input type="submit" value="Login" name="submit" class="login-button"/>
        <p class="link"><a href="registration.php">New Registration</a></p>
    </form>
    
    
</body>
</html>