<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $userid = $_POST['userid'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM user WHERE userid = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $userid); // bind the userid as a string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row['id']; // Fetch user ID

        // Debugging: Check if the ID is fetched
        if ($id) {
            echo "User ID fetched: " . $id;
            // If needed, temporarily stop the script here to check the ID
            // exit();
        }

        // Directly compare the plaintext password
        if ($password === $row['password']) {
            $_SESSION['id'] = $id;

            if (isset($_POST['remember'])) {
                setcookie('remember', '1', time() + (86400 * 30), "/");
            }

            // Redirect to dashboard with the correct ID
            header("Location: dashboard.php?accountID=$id");
            exit();
        } else {
            echo "<script>alert('Wrong Password');</script>";
        }
    } else {
        echo "<script>alert('User can\'t be found');</script>";
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Login Page</title>
</head>

<body>
    <div class="login-page-container">
        <div class="login-form-container">
            <img src="asset/unsplash_h-LcVG8W1XY.png" alt="Login Image" class="login-image">
            <div class="login-container">
                <div class="logo-gt">
                    <img src="asset/a2 logo 1.png" alt="">
                </div>
                <form method="post" class="login-form">
                    <div class="sub-login">
                        <h1>Login</h1>
                    </div>
                    <input type="text" id="userid" name="userid" required placeholder="userid"><br><br>
                    <input type="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="password" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required placeholder="Password"><br><br>
                    <input type="submit" name="login" value="Login">
                </form>
            </div>
        </div>
    </div>
</body>

</html>
