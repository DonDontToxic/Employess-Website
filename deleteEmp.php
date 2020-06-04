<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>Delete Page</title>
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
            <a class="navbar-brand mx-auto" href="https://gg-bucket.appspot.com/home">DonDon Company</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="https://gg-bucket.appspot.com/detail">Name Frequency</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 2%">

        <h3 align="center" id="header">Delete Employee Process</h3>
        <?php
        $infoEmps = file_get_contents('gs://employees_bucket/Employees.csv');
        $infoArr = explode("\n", $infoEmps);
        $delID = $_POST['selEmp'];

        $file = fopen('gs://employees_bucket/Employees.csv', 'w')  or die("File does not exist!");

        $str = "<div class='table-responsive' style='margin-top: 2%'>";
        $str .= "<table class= 'table table-hover table-bordered' id='infoTable'>" .
            "<thead class='thead-dark'>" .
            "<tr>" .
            "<th scope='col'>ID</th>" .
            "<th scope='col'>First Name</th>" .
            "<th scope='col'>Last Name</th>" .
            "<th scope='col'>Gender</th>" .
            "<th scope='col'>Age</th>" .
            "<th scope='col'>Address</th>" .
            "<th scope='col'>Phone number</th>" .
            "<th scope='col'>Status</th>" .
            "</tr>" .
            "</thead>" .
            "<tbody>";

            for ($i = 1; $i < sizeof($infoArr); $i++) {
                $infoAttributes = explode(",", $infoArr[$i]);

                if ($infoAttributes[0] != $delID) {

                    fwrite($file, "\n" . $infoArr[$i] . "");

                } else {
                    foreach ($infoAttributes as $infoAttribute) {
    
                        $str .= "<td>" . $infoAttribute . "</td>";
                    }
                    $str .= "<td class='text-danger'>Deleted</td>";
                    $str .= "</td></tr></tbody></table>";
                }

            }

        $str .= "<table class= 'table table-hover table-bordered'>" .
            "<thead class='thead-dark'>" .
            "<tr>" .
            "<th scope='col'>Actions</th>" .
            "</tr>" .
            "</thead>" .
            "<tbody>";

        $str .= "<tbody><tr><td>
            <button onclick='recordClicked()' class='btn btn-warning btn-lg float-center'><-- Back to view record</button>
            <button onclick='freqClicked()' class='btn btn-primary btn-lg float-center'>Process to view frequency --></button>
            </td><tbody><tr></table></div>";

        echo $str;
        fclose($file);

        ?>
    </div>


    <script>
        function recordClicked() {
            window.open("https://gg-bucket.appspot.com/view", "_self");
        }

        function freqClicked() {
            window.open("https://gg-bucket.appspot.com/detail", "_self");
        }
    </script>
</body>

</html>