<?php
$file = fopen('gs://employees_bucket/Employees.csv', 'w');
 

fwrite($file, "ID, First Name, Last Name, Gender, Age, Address, Phone number");

$id = 1;
$age = 32;
fwrite($file,"\n" .$id. ",Anna,Fillipe,F," .$age. ",District 7,0289281922");

$id = 2;
$age = 33;
fwrite($file, "\n" .$id. ",Andrew,Smith,M," .$age. ",Hanoi,02948238232");


fclose($file);

 
echo 'Employess Added<br/>';
echo '<a href="https://gg-bucket.appspot.com/view">View Employees</a>';
?>
