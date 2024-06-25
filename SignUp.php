<?php
require_once('classes/database.php');
$con = new database();
$error_message = '';

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $AccType = $_POST['AccType'];
    $password = $_POST['Pass_word'];
    $confirmpassword = $_POST['confirmpassword'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $sex = isset($_POST['sex']) ? $_POST['sex'] : '';
    $_POST['payment'];

    if (!empty($username) && !empty($password) && !empty($confirmpassword) && !empty($firstname) && !empty($lastname) && !empty($sex) && !empty($payment)) {
        if ($password == $confirmpassword) {
            if ($con->SignUp($username, $AccType, $password, $firstname, $lastname, $sex, $payment)) {
                header('location:login.php');
                exit();
            } else {
                $error_message = "Username already exists. Please choose a different username.";
            }
        } else {
            $error_message = "Password did not match.";
        }
    } else {
        $error_message = "Please fill all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
     body{
      background-image: url('uploads/signupbk.jpg');
      background-repeat: no-repeat;
      background-size: cover;
    }
    .signup-container {
      max-width: 400px;
      margin: 0 auto;
      margin-top: 100px;
      height: auto;
      padding: 20px;
    }
  </style>
</head>
<body>
<div class="container-fluid signup-container rounded shadow">
  <h2 class="text-center mb-4">Sign Up</h2>
  <form method="post">
    <div class="form-group">
      <label for="AccType" class="form-label">AccType:</label>
      <select class="form-select" required name="AccType">
        <option selected disabled>Select Type of User</option>
        <option value="Tenant">Tenant</option>
        <option value="Admin">Admin</option>
      </select>
    </div>
    <div class="form-group">
      <label for="firstname">First Name:</label>
      <input type="text" class="form-control" required name="firstname" placeholder="Enter First Name">
    </div>
    <div class="form-group">
      <label for="lastname">Last Name:</label>
      <input type="text" class="form-control" required name="lastname" placeholder="Enter Last Name">
    </div>
    <div class="form-group">
      <label for="sex" class="form-label">Sex:</label>
      <select class="form-select" required name="sex">
        <option selected disabled>Select Sex</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
      </select>
    </div>
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" class="form-control" required name="username" placeholder="Enter Username">
    </div>
    <div class="form-group">
      <label for="Pass_word">Password:</label>
      <input type="password" class="form-control" required name="Pass_word" placeholder="Enter Password">
    </div>
    <div class="form-group">
      <label for="confirmpassword">Confirm Password:</label>
      <input type="password" class="form-control" required name="confirmpassword" placeholder="Confirm Password">
    </div>
    <?php if (!empty($error_message)): ?>
    <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <input type="submit" name="signup" class="btn btn-danger btn-block" value="Sign Up">
  </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>
</html>
