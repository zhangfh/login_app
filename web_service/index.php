<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Show T94 Device Info</title>
</head>
<body>
  <h2>Show How Many device is used</h2>

<?php
require_once('database.php');
$user_count = 0;

$query = 'SELECT email FROM device_list';
$result = mysqli_query($dbc,$query);

while($row = mysqli_fetch_array($result)){
  $user_count++;
}
mysqli_close($dbc);
echo '<tr> <td class = "user_count">';
echo 'You have ' . $user_count . ' users';
echo '</td></tr>';
?>

</body>
</html>