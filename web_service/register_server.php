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
        
        $array = array(
    		"success" => "0",
    		"reason" => "0",
		    );
		    echo json_encode($array);
        mysqli_close($dbc);
        exit();
      }
      else {
        // An account already exists for this email, so display an error message
        
        $array = array(
    		"success" => "-1",
    		"reason" => "100",
		    );
		    echo json_encode($array);
        $email = "";
      }
    }
    else {
      
      $array = array(
    		"success" => "-1",
    		"reason" => "101",
	  );
	  echo json_encode($array);
    }
  }
  else{
     $array = array(
        "success" => "-1",
        "reason" => "102",
    );
    echo json_encode($array);
  }

  mysqli_close($dbc);
?>
