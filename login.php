<!-- // session_start(); -->
<?php
include("conn.php");

$errors = []; // Initialize an array to store errors

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];

    $select = "SELECT * FROM admin WHERE email = '$email' AND password = '$pass'";

    $result = mysqli_query($conn, $select);

    // Check if the query was successful and there is at least one row
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        header('location: admin_page.php');
        exit(); // Add exit to stop further execution
    } else {
      //   $errors[] = 'Incorrect email or password!';
    }
}

?>

<?php
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo '<span class="error-msg">' . $error . '</span>';
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login form</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="form-container">

        <form action="" method="post">
            <h3>login now</h3>

            <input type="email" name="email" required placeholder="enter your email">
            <input type="password" name="password" required placeholder="enter your password">
            <input type="submit" name="submit" value="login now" class="form-btn">
            <p>don't have an account? <a href="register_form.php">register now</a></p>
        </form>

    </div>

</body>

</html>