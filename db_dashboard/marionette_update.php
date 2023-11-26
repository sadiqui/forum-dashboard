<?php
include "marionette_conn.php";

if (isset($_GET['id'])) {
    $member_id = $_GET['id'];

    // Fetch member details from the database
    $sql_select = "SELECT * FROM `members` WHERE `id` = ?";
    $stmt_select = mysqli_prepare($conn, $sql_select);

    if ($stmt_select) {
        mysqli_stmt_bind_param($stmt_select, "i", $member_id);
        mysqli_stmt_execute($stmt_select);

        $result = mysqli_stmt_get_result($stmt_select);

        if ($row = mysqli_fetch_assoc($result)) {
            $first_name = $row['f_name'];
            $last_name = $row['l_name'];
            $email = $row['email'];
            $gender = $row['gender'];
        } else {
            // Handle if the member is not found
            echo "Member not found.";
            exit();
        }

        mysqli_stmt_close($stmt_select);
    } else {
        // Handle error in preparing the statement
        echo "Failed to prepare statement: " . mysqli_error($conn);
        exit();
    }
} else {
    // Redirect to the index page if no ID is provided
    header("Location: marionette_index.php");
    exit();
}

// Update member details when the form is submitted
if (isset($_POST['submit'])) {
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

    // Using prepared statements to prevent SQL injection
    $sql_update = "UPDATE `members` SET `f_name`=?, `l_name`=?, `email`=?, `gender`=? WHERE `id`=?";
    $stmt_update = mysqli_prepare($conn, $sql_update);

    if ($stmt_update) {
        mysqli_stmt_bind_param($stmt_update, "ssssi", $first_name, $last_name, $email, $gender, $member_id);
        $executeResult = mysqli_stmt_execute($stmt_update);

        if ($executeResult) {
            // Re-fetch member details after the update
            $sql_select_updated = "SELECT * FROM `members` WHERE `id` = ?";
            $stmt_select_updated = mysqli_prepare($conn, $sql_select_updated);

            if ($stmt_select_updated) {
                mysqli_stmt_bind_param($stmt_select_updated, "i", $member_id);
                mysqli_stmt_execute($stmt_select_updated);

                $result_updated = mysqli_stmt_get_result($stmt_select_updated);

                if ($row_updated = mysqli_fetch_assoc($result_updated)) {
                    $first_name = $row_updated['f_name'];
                    $last_name = $row_updated['l_name'];
                    $email = $row_updated['email'];
                    $gender = $row_updated['gender'];
                }

                mysqli_stmt_close($stmt_select_updated);
            }

            // If the execution is successful, redirect
            header("Location: marionette_index.php?msg=Member updated successfully");
            exit();
        } else {
            // If there's an error during execution
            echo "Failed: " . mysqli_stmt_error($stmt_update);
        }

        mysqli_stmt_close($stmt_update);
    } else {
        // If there's an error in preparing the statement
        echo "Failed to prepare statement: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
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
    <div class="text-center mb-4">
        <h3>Edit Member Information</h3>
        <p>Click update after changing any information</p>
    </div><br>
    <div class="container d-flex justify-content-center">
        <form method="post" action="marionette_update.php?id=<?php echo $member_id; ?>"
            style="width:50vw; min-width:300px">
            <!-- Add a hidden field to send the member_id -->
            <input type="hidden" name="id" value="<?php echo $member_id; ?>">
            <div class="row">
                <div class="col">
                    <label class="form-label">First Name :</label>
                    <input class="form-control" type="text" name="first_name" value="<?php echo $first_name; ?>">
                </div>
                <div class="col">
                    <label class="form-label">Last Name :</label>
                    <input class="form-control" type="text" name="last_name" value="<?php echo $last_name; ?>">
                </div>
            </div><br>
            <div class="mb-3">
                <label class="form-label">Email :</label>
                <input class="form-control" type="email" name="email" value="<?php echo $email; ?>">
            </div>
            <div class="form-group mb-3">
                <label>Gender :</label> &nbsp;
                <input class="form-check-input" type="radio" name="gender" id="male" value="male"
                    <?php echo ($gender=='male')?"checked":""; ?>>
                <label class="form-input-label" for="male">Male</label> &nbsp;
                <input class="form-check-input" type="radio" name="gender" id="female" value="female"
                    <?php echo ($gender=='female')?"checked":""; ?>>
                <label class="form-input-label" for="female">Female</label>
            </div><br>
            <div>
                <button class="btn btn-success" type="submit" name="submit" value="Submit"
                    style="background-color: #2a2b6a; border-color: #2a2b6a;">Update</button> &nbsp;
                <a href="marionette_index.php" class="btn btn-danger"
                    style="background-color: #2a2b6a; border-color: #2a2b6a;">Cancel</a>
            </div>
        </form>
    </div>
</body>

</html>