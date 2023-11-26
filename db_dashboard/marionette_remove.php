<?php
include "marionette_conn.php";

// Check if the member ID is set in the URL
if (isset($_GET['id'])) {
    $member_id = $_GET['id'];

    // Using prepared statement to prevent SQL injection
    $sql_delete = "DELETE FROM `members` WHERE `id` = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);

    if ($stmt_delete) {
        mysqli_stmt_bind_param($stmt_delete, "i", $member_id);
        $executeResult = mysqli_stmt_execute($stmt_delete);

        if ($executeResult) {
            // If the execution is successful, redirect to the index page with a success message
            header("Location: marionette_index.php?msg=Member deleted successfully");
            exit();
        } else {
            // If there's an error during execution
            echo "Failed: " . mysqli_stmt_error($stmt_delete);
        }

        mysqli_stmt_close($stmt_delete);
    } else {
        // If there's an error in preparing the statement
        echo "Failed to prepare statement: " . mysqli_error($conn);
    }
} else {
    // Redirect to the index page if no ID is provided
    header("Location: marionette_index.php");
    exit();
}

mysqli_close($conn);
?>