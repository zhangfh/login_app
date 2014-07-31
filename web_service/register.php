<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Sign Up</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h3>T94 - Sign Up</h3>
 <?php

  require_once('connectvars.php');

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
    $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
    $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));

    if (!empty($email) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
      // Make sure someone isn't already registered using this email
      $query = "SELECT * FROM device_list WHERE email = '$email'";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 0) {
        // The email is unique, so insert the data into the database
        $query = "INSERT INTO device_list (email, password, register_time) VALUES ('$email', SHA('$password1'), NOW())";
        mysqli_query($dbc, $query);

        // Confirm success with the user
        echo '<p>Your new account has been successfully created. You\'re now ready to <a href="login.php">log in</a>.</p>';
        /*
        $array = array(
    		"success" => "0",
    		"reason" => "0",
		);
		echo json_encode($array);
		*/
        mysqli_close($dbc);
        exit();
      }
      else {
        // An account already exists for this email, so display an error message
        echo '<p class="error">An account already exists for this email. Please use a different address.</p>';
        /*
        $array = array(
    		"success" => "-1",
    		"reason" => "100",
		);
		echo json_encode($array);
		*/
        $email = "";
      }
    }
    else {
      echo '<p class="error">You must enter all of the sign-up data, including the desired password twice.</p>';/*
      $array = array(
    		"success" => "-1",
    		"reason" => "101",
	  );
	  echo json_encode($array);
	  */
    }
  }

  mysqli_close($dbc);
?>
  <p>Please enter your username and desired password to sign up to T94.</p>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <legend>Registration Info</legend>
      <label for="email">Email:</label>
      <input type="text" id="email" name="email" value="<?php if (!empty($email)) echo $email; ?>" /><br />
      <label for="password1">Password:</label>
      <input type="password" id="password1" name="password1" /><br />
      <label for="password2">Password (retype):</label>
      <input type="password" id="password2" name="password2" /><br />
    </fieldset>
    <input type="submit" value="Sign Up" name="submit" />
  </form>
</body> 
</html>