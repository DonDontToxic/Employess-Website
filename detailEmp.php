<?php
session_start();
require_once 'php/google-api-php-client/vendor/autoload.php';
?>
<!DOCTYPE html>
<html>

<head>
	<title>Employees Record Detail</title>
	<meta charset='UTF-8'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<title>Frequency Page</title>
</head>
<style>
	table,
	thead,
	tr,
	tbody,
	th,
	td {
		text-align: center;
	}

	.table td {
		text-align: center;
	}
</style>


<body style="background-color: lavender">
	<nav class="navbar navbar-expand-md navbar-dark bg-dark">
		<div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item ">
					<a class="nav-link" href="https://gg-bucket.appspot.com/view">Employee Record</a>
				</li>
			</ul>
		</div>
		<div class="mx-auto order-0">
			<a class="navbar-brand mx-auto" href="https://gg-bucket.appspot.com">DonDon Company</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
				<span class="navbar-toggler-icon"></span>
			</button>
		</div>
		<div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active">
					<a class="nav-link" href="https://gg-bucket.appspot.com/detail">Name Frequency</a>
				</li>
			</ul>
		</div>
	</nav>


	<div class='container' style="margin-top:2%">

		<h2 align="center">Name Frequency Table</h3>


			<?php

			$client = new Google_Client();
			$client->useApplicationDefaultCredentials();
			$client->addScope(Google_Service_Bigquery::BIGQUERY);
			$bigquery = new Google_Service_Bigquery($client);
			$projectId = 'gg-bucket';


			$infoEmps = file_get_contents('gs://employees_bucket/Employees.csv');
			$infoArr = explode("\n", $infoEmps);

			$str = "<div class='table-responsive' style='margin-top: 2%'>";
			$str .= "<table id='infoTable' class='table table-dark table-hover table-striped'>" .
				"<thead>" .
				"<tr>" .
				"<th>ID</th>" .
				"<th>First Name</th>" .
				"<th>Last Name</th>" .
				"<th>Gender</th>" .
				"<th>Age</th>" .
				"<th>Address</th>" .
				"<th>Phone number</th>" .
				"<th>Fname Frequency</th>" .
				"<th>Lname Frequency</th>" .
				"</tr>" .
				"</thead>" .
				"<tbody>";

			for ($i = 1; $i < sizeof($infoArr); $i++) {


				$str .= "<tr>";
				$infoAttributes = explode(",", $infoArr[$i]);

				foreach ($infoAttributes as $infoAttribute) {
					$str .= "<td>" . $infoAttribute . "</td>";
				}

				$fname = "'" . $infoAttributes[1] . "'";
				$lname = "'" . $infoAttributes[2] . "'";
				$gender = "'" . $infoAttributes[3] . "'";

				$fnameFreq = '0';
				$lnameFreq = '0';

				$request = new Google_Service_Bigquery_QueryRequest();
				$request->setQuery("SELECT SUM(Frequency) FROM [Baby_Names.names_detail] WHERE Name = {$fname} AND Gender = {$gender}");
				$response = $bigquery->jobs->query($projectId, $request);
				$rows = $response->getRows();
		

				foreach ($rows as $row) {					
					foreach ($row['f'] as $field) {
						$fnameFreq = $field['v'];
					}
				}

				$request = new Google_Service_Bigquery_QueryRequest();
				$request->setQuery("SELECT SUM(Frequency) FROM [Baby_Names.names_detail] WHERE Name = {$lname} AND Gender = {$gender}");
				$response = $bigquery->jobs->query($projectId, $request);
				$rows = $response->getRows();

				foreach ($rows as $row) {
					foreach ($row['f'] as $field) {
						$lnameFreq = $field['v'];
					}
				}

				if(strcmp($fnameFreq, '') == 0) {			
					$fnameFreq = '0';
				} 
				if(strcmp($lnameFreq, '') == 0) {		
					$lnameFreq = '0';
				}

				$str .= "<td>" . $fnameFreq . "</td>";

				$str .= "<td>" . $lnameFreq . "</td>";

				$str .= "</tr>";
			}

			$str .= ' </tbody></table></div>';

			echo $str;
			?>

	</div>
</body>

<script>
</script>

</html>