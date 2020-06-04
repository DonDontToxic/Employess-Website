<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>Update Page</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="https://gg-bucket.appspot.com/detail">Name Frequency</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 2%">

        <h3 align="center" id="header">Update Employee Process</h3>

        <?php if (isset($_POST['form_submitted'])) :

            $infoEmps = file_get_contents('gs://employees_bucket/Employees.csv');
            $infoArr = explode("\n", $infoEmps);
            $file = fopen('gs://employees_bucket/Employees.csv', 'w')  or die("File does not exist!");


            $eID = $_POST['id'];
            $eFName = $_POST['fname'];
            $eLName = $_POST['lname'];
            $eGender = $_POST['gender'];
            $eAge = $_POST['age'];
            $eAdd = $_POST['add'];
            $eNumber = $_POST['pnum'];

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

                if ($infoAttributes[0] == $eID) {

                    $infoArr[$i] = '' . $eID . ','  . $eFName . ',' . $eLName . ','
                        . $eGender . ',' . $eAge . ',' . $eAdd . ',' . $eNumber . '';

                    $updatedAttributes = explode(",", $infoArr[$i]);

                    foreach ($updatedAttributes as $updatedAttribute) {

                        $str .= "<td>" . $updatedAttribute . "</td>";
                    }
                    $str .= "<td class='text-success'>Updated</td>";
                    $str .= "</td></tr></tbody></table>";
                }
                fwrite($file, "\n" . $infoArr[$i] . '');
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

        <?php else : ?>
            <?php
            $infoEmps = file_get_contents('gs://employees_bucket/Employees.csv');
            $infoArr = explode("\n", $infoEmps);
            $editID = $_POST['selEmp'];
            $str = '';
            $maleGender = '';
            $femaleGender = '';

            foreach ($infoArr as $info) {
                $infoAttributes = explode(",", $info);
                if ($infoAttributes[0] == $editID) {
                    if ($infoAttributes[3] == 'M') {
                        $maleGender = 'checked';
                    } else {
                        $femaleGender = 'checked';
                    }

                    $str =
                        "<form id='updateForm' action='/update' method='post'>

                    <div class='form-group'>
                        <label for='id'>ID</label>
                        <input class='form-control' type='number' name='id' id='id' value=$editID readonly>
                    </div>

                    <div class='form-group'>
                        <label for='fname'>First Name</label>
                        <input class='form-control' type='text' name='fname' id='fname' value='$infoAttributes[1]' required>
                    </div>

                    <div class='form-group'>
                        <label for='lname'>Last Name</label>
                        <input class='form-control' type='text' name='lname' id='lname' value='$infoAttributes[2]' required>
                    </div>

                    <label for='gender'>Gender</label>
                    <div class='form-check-inline'>
                        <label class='form-check-label'>
                            <input type='radio' class='form-check-input' name='gender' id='gender' value='M' $maleGender required> Male
                        </label>
                    </div>
                    <div class='form-check-inline'>
                        <label class='form-check-label'>
                            <input type='radio' class='form-check-input' name='gender' id='gender' value='F' $femaleGender required> Female
                        </label>
                    </div>

                    <div class='form-group'>
                        <label for='age'>Age</label>
                        <input class='form-control' type='number' name='age' id='age' value=$infoAttributes[4] required aria-describedby='ageHelpBlock' min='18' max='60'>
                        <small id='ageHelpBlock' class='form-text text-muted'>
                            Your entered age must between 18 - 60
                        </small>
                    </div>

                    <div class='form-group'>
                        <label for='add'>Address</label>
                        <input class='form-control' type='text' name='add' id='ad' value='$infoAttributes[5]' required>
                    </div>

                    <div class='form-group'>
                        <label for='pnum'>Phone Number</label>d
                        <input class='form-control' type='tel' name='pnum' id='pnum' value='$infoAttributes[6]' required aria-describedby='phoneHelpBlock' pattern='[0-9]*' minlength='10'>
                        <small id='phoneHelpBlock' class='form-text text-muted'>
                            Your entered phone number must have at least 10 digits
                        </small>
                    </div>

                    <input type='hidden' name='form_submitted' value='1' />
                    <input class='btn btn-primary float-right' type='submit' value='Submit'>

                </form><button class='btn btn-danger float-right' onclick='cancelClicked()'>Cancel</button>";

                    echo $str;
                }
            }
            ?>
        <?php endif; ?>

    </div>
</body>
<script>
    function recordClicked() {
        window.open("https://gg-bucket.appspot.com/view", "_self");
    }

    function freqClicked() {
        window.open("https://gg-bucket.appspot.com/detail", "_self");
    }

    function cancelClicked() {
        window.history.back();

    }
</script>

</html>