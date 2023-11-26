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
    a {
        text-decoration: none;
        color: inherit;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="font-weight:500;">
        <br><br><a href="marionette_index.php">Members Dashboard</a>&nbsp;-&nbsp;<a href="../index.html">Marionette High School</a>
    </nav>
    <div class="container">
        <?php
        if(isset($_GET['msg'])) {
            $msg = $_GET['msg'];
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert" style="width:30%;
            border-color:#2a2b6a; background-color:rgb(41, 42, 107, 0.05); color:#2a2b6a;">
            '.$msg.'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div><br>';
        }
        ?>
        <a href="marionette_add.php" class="btn btn-dark mb-3" style="background-color: #2a2b6a;">Add New Member</a>
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col" style="background-color: #2a2b6a; color: #d5e6ff">ID</th>
                    <th scope="col" style="background-color: #2a2b6a; color: #d5e6ff">First Name</th>
                    <th scope="col" style="background-color: #2a2b6a; color: #d5e6ff">Last Name</th>
                    <th scope="col" style="background-color: #2a2b6a; color: #d5e6ff">Email</th>
                    <th scope="col" style="background-color: #2a2b6a; color: #d5e6ff">Gender</th>
                    <th scope="col" style="background-color: #2a2b6a; color: #d5e6ff">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include "marionette_conn.php";
                    $sql = "SELECT * FROM `members`";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr style='color:#161616;'>
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['f_name'] ?></td>
                    <td><?php echo $row['l_name'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                    <td><?php echo $row['gender'] ?></td>
                    <td>
                        <a href="marionette_update.php?id=<?php echo $row['id'] ?>" class="link-dark"><i
                                class="fas fa-pen-to-square fs-5 me-3" style="color: #2a2b6a;"></i></a>
                        <a href="marionette_remove.php?id=<?php echo $row['id'] ?>" class="link-dark"><i
                                class="fas fa-trash fs-5" style="color: #2a2b6a;"></i></a>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Bootstrap -->
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>