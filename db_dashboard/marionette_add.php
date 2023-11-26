<?php
include "marionette_conn.php";

if(isset($_POST['submit'])) {
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

    // Using prepared statements to prevent SQL injection
    $sql = "INSERT INTO `members`(`id`, `f_name`, `l_name`, `email`, `gender`) VALUES (NULL, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $first_name, $last_name, $email, $gender);
        $executeResult = mysqli_stmt_execute($stmt);

        if($executeResult) {
            // If the execution is successful, redirect
            header("Location: marionette_index.php?msg=New member added successfully");
            exit();
        } else {
            // If there's an error during execution
            echo "Failed: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        // If there's an error in preparing the statement
        echo "Failed to prepare statement: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Marionette Dashboard</title>
    <style>
    body {
        background-color: #d5e6ff;
        color: #2a2b6a;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="font-weight:500;">
        <br>Members Dashboard - Marionette High School
    </nav>
    <div class="container">
        <div class="text-center mb-4">
            <h3>Add New Member</h3>
            <p>Complete the form below to add a new member</p>
        </div><br>
        <div class="container d-flex justify-content-center">
            <form method="post" action="marionette_add.php" style="width:50vw; min-width:300px">
                <div class="row">
                    <div class="col">
                        <label class="form-label">First Name :</label>
                        <input class="form-control" type="text" name="first_name" placeholder="Nikola">
                    </div>
                    <div class="col">
                        <label class="form-label">Last Name :</label>
                        <input class="form-control" type="text" name="last_name" placeholder="Tesla">
                    </div>
                </div><br>
                <div class="mb-3">
                    <label class="form-label">Email :</label>
                    <input class="form-control" type="email" name="email" placeholder="name@example.com">
                </div>
                <div class="form-group mb-3">
                    <label>Gender :</label> &nbsp;
                    <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                    <label class="form-input-label" for="male">Male</label> &nbsp;
                    <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                    <label class="form-input-label" for="female">Female</label>
                </div><br>
                <div>
                    <button class="btn btn-success" type="submit" name="submit" value="Submit"
                        style="background-color: #2a2b6a; border-color: #2a2b6a;">Save</button> &nbsp;
                    <a href="marionette_index.php" class="btn btn-danger"
                        style="background-color: #2a2b6a; border-color: #2a2b6a;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    <!-- Bootstrap -->
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>