<?php

$infoEmps = file_get_contents('gs://employees_bucket/Employees.csv');

$file = fopen('gs://employees_bucket/Employees.csv', 'w')  or die("File does not exist!");

$infoEmps .= '<br/>' .$_POST['id']. ',' .$_POST['fname']. ',' .$_POST['lname']. ',' 
.$_POST['gender']. ',' .$_POST['age']. ',' .$_POST['add']. ','.$_POST['pnum']. '';

fwrite($file, $infoEmps);
fclose($file);
 
echo 'Employees Added <br/>';
echo '<a href="https://gg-bucket.appspot.com/view">View Employees</a>';

?>

