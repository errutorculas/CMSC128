<?php

include 'config.php';

session_start();

error_reporting(0);

if(isset($_SESSION["user_id"])) {
  header("Location: home.php");
}


if(isset($_POST["signup"])) {
  $username = mysqli_real_escape_string($conn, $_POST["signup_username"]);
  $email = mysqli_real_escape_string($conn, $_POST["signup_email"]);
  $password = mysqli_real_escape_string($conn, md5($_POST["signup_password"]));
  $cpassword = mysqli_real_escape_string($conn, md5($_POST["signup_cpassword"]));

  $check_username = mysqli_num_rows(mysqli_query($conn, "SELECT username FROM users WHERE username='$username'"));
  $validate_password = $_POST["signup_password"];

    //Validate password
  $uppercase = preg_match('@[A-Z]@', $validate_password);
  $lowercase = preg_match('@[a-z]@', $validate_password);
  $number = preg_match('@[0-9]@', $validate_password);
  $specialChars = preg_match('@[^\w]@', $validate_password);

  if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($validate_password) < 8) {
    echo "<script>alert('Password should be at least 8 characters in length and should include at least one uppercase letter, one number, and one special charater.');</script>";
  }

  if($password !== $cpassword) {
    echo "<script>alert('Password did not match.');</script>";
  } elseif($check_username > 0) {
    echo "<script>alert('Username already exists');</script>";
  } else {
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $_POST["signup_username"] = "";
      $_POST["signup_email"] = "";
      $_POST["signup_password"] = "";
      $_POST["signup_cpassword"] = "";
      echo "<script>alert('User signup successfully');</script>";
    } else {
      echo "<script>alert('User signup failed');</script>";
    }
  }
}


if(isset($_POST["signin"])) {
  $username = mysqli_real_escape_string($conn, $_POST["username"]);
  $password = mysqli_real_escape_string($conn, md5($_POST["password"]));

  $check_username = mysqli_query($conn, "SELECT id FROM users WHERE username='$username' AND password='$password'");

  if(mysqli_num_rows($check_username) > 0) {
    $row = mysqli_fetch_assoc($check_username);
    $_SESSION["user_id"] = $row['id'];
    header("Location: home.php");
  } else {
    echo "<script>alert('Login failed. Try again');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="style.css" />
    <title>Sign in & Sign up Form</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          
          <!-- Sign In Form -->
          <form action="" method="post" class="sign-in-form">
            <h2 class="title">Sign in</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Username" name="username" value="<?php echo $_POST["username"]; ?>" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Password" name="password" value="<?php echo $_POST["password"]; ?>" required/>
            </div>
            <input type="submit" value="Login" name="signin" class="btn solid" />
            <p class="social-text">Or Sign in with social platforms</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>

          <!-- Sign Up Form -->
          <form action="" class="sign-up-form" method="post">
            <h2 class="title">Sign up</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Username" name="signup_username" value="<?php echo $_POST["signup_username"]; ?>" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" placeholder="Email" name="signup_email" value="<?php echo $_POST["signup_email"]; ?>" required />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Password" name="signup_password" value="<?php echo $_POST["signup_password"]; ?>" required />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Confirm Password" name="signup_cpassword" value="<?php echo $_POST["signup_cpassword"]; ?>" required />
            </div>
            <input type="submit" class="btn" name="signup" value="Sign up" />

            <p class="social-text">Or Sign up with social platforms</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>New here?</h3>
            <p>
              Signup now and get the current events with us as we like to know you more
              and what you want for our services!
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <!--<img src="img/log.svg" class="image" alt="" />-->
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>One of us?</h3>
            <p>
              Login to see the existing and new events just for you. Be with us.
              We want to see you more often.
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          
          <!--<img src="img/register.svg" class="image" alt="" />-->
        </div>
      </div>
    </div>

    <script src="app.js"></script>
  </body>
</html>
