<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>View Record Page</title>
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

    #topBtn {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 30px;
        z-index: 99;
        font-size: 18px;
        border: none;
        outline: none;
        background-color: mediumpurple;
        color: white;
        cursor: pointer;
        padding: 20px;
        border-radius: 5px;
    }

    #topBtn:hover {
        background-color: mediumvioletred;
    }
</style>

<body style="background-color: lavender">

    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
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

    <div class="container-fluid" style="margin-top:2%">

        <div class="row">

            <div class="col-sm-8">
                <h3 align="center">Record Table</h3>
                <div class="row" style="margin-top: 2%">
                    <div class="col">
                        <form id="searchForm" class="form-inline float-left">
                            <input class="form-control" type="text" name="searchName" id="searchName" placeholder="Enter searched name">
                            <button class="btn btn-success" type="button" onclick="searchClicked()">Search</button>
                        </form>
                    </div>
                    <div class="col">
                        <form id="filterForm" class="form-inline float-right">
                            <h6 class="text-muted" for="genderOptions">Filter by:</h6>
                            <select class="form-control" id="genderOptions" name="genderOptions">
                                <option value="none" disabled selected>Gender</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                            <select class="form-control" id="ageOptions" name="ageOptions">
                                <option value="none" disabled selected>Age</option>
                                <option value="<25">
                                    < 25 </option> <option value="50"> 25 - 50
                                </option>
                                <option value=">50"> > 50 </option>
                            </select>
                            <button class="btn btn-primary" type="button" onclick="filterClicked()">Apply</button>
                            <button class="btn btn-secondary" type="button" onclick="resetClicked()">Reset</button>
                        </form>
                    </div>
                </div>

                <?php

                $infoEmps = file_get_contents('gs://employees_bucket/Employees.csv');

                $infoArr = explode("\n", $infoEmps);

                $str = "<div class='table-responsive' style='margin-top: 2%'>";
                $str .= "<table class= 'table table-bordered ' id='infoTable' name='infoTable'>" .
                    "<thead class='thead-dark'>" .
                    "<tr>" .
                    "<th scope='col'>ID</th>" .
                    "<th scope='col'>First Name</th>" .
                    "<th scope='col'>Last Name</th>" .
                    "<th scope='col'>Gender</th>" .
                    "<th scope='col'>Age</th>" .
                    "<th scope='col'>Address</th>" .
                    "<th scope='col'>Phone number</th>" .
                    "</tr>" .
                    "</thead>" .
                    "<tbody>";

                for ($i = 1; $i < sizeof($infoArr); $i++) {
                    $str .= "<tr>";
                    $infoAttributes = explode(",", $infoArr[$i]);

                    foreach ($infoAttributes as $infoAttribute) {
                        $str .= "<td>" . $infoAttribute . "</td>";
                    }

                    $str .= "</td></tr>";
                }
                $str .= '</tbody></table></div>';

                echo $str;

                ?>

            </div>

            <div class="col-sm-4">

                <?php if (isset($_POST['form_submitted'])) :

                    $infoEmps = file_get_contents('gs://employees_bucket/Employees.csv');
                    $infoArr = explode("\n", $infoEmps);
                    $infoAttributes = explode(",", $infoArr[sizeof($infoArr) - 1]);
                    $id =  $infoAttributes[0] + 1;

                    $file = fopen('gs://employees_bucket/Employees.csv', 'w')  or die("File does not exist!");
                    $infoEmps .= "\n" . $id . ',' . $_POST['fname'] . ',' . $_POST['lname'] . ','
                        . $_POST['gender'] . ',' . $_POST['age'] . ',' . $_POST['add'] . ',' . $_POST['pnum'] . '';

                    fwrite($file, $infoEmps);
                    fclose($file);

                ?>


                    <div class="container" style="text-align: center;">
                        <table class="table table-bordered table-hover" style="margin-top: 10%">
                            <thead class="thead-light">
                                <tr>
                                    <th>Annoucement</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-muted">Employee have been added sucessfully</td>
                                </tr>
                                <thead class="thead-light">
                                    <tr>
                                        <th>Please reload page to update information
                                            <button onclick="reloadClicked()" class="btn btn-secondary btn-sm float-right">Reload</button>
                                        </th>
                                    </tr>
                                </thead>
                            </tbody>
                        </table>
                    </div>

                <?php else : ?>

                    <h3 class="Fixed" align="center">Add Form</h3>

                    <form id="addForm" action="/view" method="post">

                        <div class="form-group">
                            <div class="col-xs-4">
                                <label for="fname">First Name:</label>
                                <input type="text" class="form-control " id="fname" placeholder="Enter first name" name="fname" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4">
                                <label for="lname">Last Name:</label>
                                <input type="text" class="form-control" id="lname" placeholder="Enter last name" name="lname" required>
                            </div>
                        </div>

                        <label for="gender">Gender:</label>
                        <div class="form-check-inline">
                            <div class="col-xs-4">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" id="gender" name="gender" value="M" required>Male
                                </label>
                            </div>
                        </div>
                        <div class="form-check-inline">
                            <div class="col-xs-4">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" id="gender" name="gender" value="F" required>Female
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-4">
                                <label for="age">Age:</label>
                                <input type="number" class="form-control" id="age" placeholder="Enter age" name="age" aria-describedby="ageHelpBlock" min="18" max="60" required>
                                <small id="ageHelpBlock" class="form-text text-muted">
                                    Your entered age must between 18 - 60
                                </small>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-4">
                                <label for="add">Address:</label>
                                <input type="text" class="form-control" id="add" placeholder="Enter address" name="add" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-4">
                                <label for="pnum">Phone Number:</label>
                                <input type="tel" class="form-control" id="pnum" placeholder="Enter number" name="pnum" aria-describedby="phoneHelpBlock" pattern="[0-9]*" minlength="10" required>
                                <small id="phoneHelpBlock" class="form-text text-muted">
                                    Your entered phone number must have at least 10 digits
                                </small>
                            </div>
                        </div>

                        <input type="hidden" id="form_submitted" name="form_submitted" value="1" />
                        <input class="btn btn-primary float-right" type="submit" value="Submit">

                    </form>
                <?php endif; ?>


                <h4 align="center" style="margin-top: 10%">Edit/Delete Employee Record</h4>
                <form id="selectForm" action="" method="post">
                    <div class="form-group">
                        <div class="col-xs-4">
                            <label for="selEmp">Select employee (select one):</label>
                            <select class="form-control" id="selEmp" name="selEmp">
                                <option disabled selected value="empty">ID - Name</option>
                            </select>
                            <button class="btn btn-danger float-right" type="button" onclick="delClicked()">Delete</button>
                            <button class="btn btn-success  float-right" type="button" onclick="editClicked()">Edit</button>
                        </div>
                    </div>
                </form>
                <div class="toast float-right">
                    <div class="toast-header text-white bg-danger">
                        Error Message
                    </div>
                    <div class="toast-body text-danger">
                        One employee need to be selected to perform this action.
                    </div>
                </div>
            </div>
        </div>
        <button onclick="backTop()" id="topBtn">Back to top</button>
    </div>


    <script>
        var topBtn = document.getElementById("topBtn");
        var containInfo = <?php echo json_encode($infoEmps); ?>;
        var empInfos = <?php echo json_encode($infoArr); ?>;
        var selectOptions = document.getElementById("selEmp");
        var selectGender = document.getElementById("genderOptions");
        var selectAge = document.getElementById("ageOptions");


        empInfos.forEach(loadOptions);
        window.onscroll = function() {
            checkScroll()
        };

        function checkScroll() {
            if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
                topBtn.style.display = "block";
            } else {
                topBtn.style.display = "none";
            }
        }

        function backTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }

        function loadOptions(item, index) {
            if (index != 0) {
                var attributes = item.split(",");
                var option = document.createElement("option");
                option.text = attributes[0] + " - " + attributes[1] + " " + attributes[2];
                option.value = attributes[0];
                selectOptions.add(option);
            }
        }

        function clearTable(table, numOfRow) {

            for (var x = numOfRow - 1; x > 0; x--) {
                table.deleteRow(x);
            }
        }

        function insertInfo(table, index, infos) {
            var row = table.insertRow(index);

            for (var i = 0; i < infos.length; i++) {
                var cell = row.insertCell(i);
                cell.innerHTML = infos[i];
            }


        }

        function searchClicked() {

            var sName = document.getElementById("searchName").value;
            var infoTable = document.getElementById('infoTable');
            var tableRows = infoTable.getElementsByTagName('tr');
            var rowCount = tableRows.length;
            var rowIndex = 1;

            clearTable(infoTable, rowCount);

            for (i = 1; i < empInfos.length; i++) {
                var attributes = empInfos[i].split(",");
                var name = attributes[1] + " " + attributes[2];

                name = name.toLowerCase();
                sName = sName.toLowerCase();

                if (name.includes(sName)) {
                    insertInfo(infoTable, rowIndex, attributes);
                    rowIndex++;
                }
            }


        }


        function filterClicked() {

            var infoTable = document.getElementById('infoTable');
            var tableRows = infoTable.getElementsByTagName('tr');
            var rowCount = tableRows.length;

            var gender = selectGender.options[selectGender.selectedIndex].value;
            var age = selectAge.options[selectAge.selectedIndex].value;
            var rowIndex = 1;


            if (selectGender.selectedIndex != 0 && selectAge.selectedIndex != 0) {

                clearTable(infoTable, rowCount);

                for (i = 1; i < empInfos.length; i++) {

                    var attributes = empInfos[i].split(",");
                    var empAge = parseInt(attributes[4]);

                    if (attributes[3].includes(gender)) {

                        switch (age) {
                            case "<25":
                                if (empAge < 25) {
                                    insertInfo(infoTable, rowIndex, attributes);
                                    rowIndex++;
                                }
                                break;

                            case "50":
                                if (empAge >= 25 && empAge <= 50) {
                                    insertInfo(infoTable, rowIndex, attributes);
                                    rowIndex++;
                                }
                                break;

                            case ">50":
                                if (empAge > 50) {
                                    insertInfo(infoTable, rowIndex, attributes);
                                    rowIndex++;
                                }
                                break;
                        }
                    }
                }
            } else {
                alert("Please select both gender and age to perform this action");
            }
        }


        function resetClicked() {
            var infoTable = document.getElementById('infoTable');
            var tableRows = infoTable.getElementsByTagName('tr');
            var rowCount = tableRows.length;
            var rowIndex = 1;

            var genderOptions = document.getElementById("genderOptions");
            var ageOptions = document.getElementById("ageOptions");

            selectGender.selectedIndex = 0;
            selectAge.selectedIndex = 0;


            clearTable(infoTable, rowCount);

            for (i = 1; i < empInfos.length; i++) {
                var attributes = empInfos[i].split(",");
                insertInfo(infoTable, rowIndex, attributes);
                rowIndex++;
            }
        }

        function delClicked() {
            var selectValue = document.getElementById("selEmp").value;

            if (selectValue != "empty") {
                selectForm.action = "/delete";
                selectForm.submit();
            } else {
                $('.toast').toast('show');
            }

        }

        function editClicked() {
            var selectValue = document.getElementById("selEmp").value;

            if (selectValue != "empty") {
                selectForm.action = "/update";
                selectForm.submit();
            } else {
                $('.toast').toast('show');
            }
        }

        function reloadClicked() {
            window.open("https://gg-bucket.appspot.com/view", "_self");
        }
    </script>

</body>

</html>