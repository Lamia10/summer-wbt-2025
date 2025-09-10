<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword= $_POST['cpassword'];
    $gender   = $_POST['gender'];
    $day      = $_POST['day'];
    $month    = $_POST['month'];
    $year     = $_POST['year'];
 
    if ($password !== $cpassword) {
        echo "Passwords do not match!";
        exit;
    }
 
    $dob = $day . "/" . $month . "/" . $year;
 
    $data = "$name | $email | $username | $gender | $dob\n";
    file_put_contents("users.txt", $data, FILE_APPEND);
 
    echo "Registration Successful!<br>";
 
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration - xCompany</title>
    <link rel="stylesheet" href="registration.css">
</head>

<body>
    <div class="container">

        <header>
            <div class="logo"><span class="x">X</span>Company</div>
            <nav>
                <a href="index.php">Home</a> |
                <a href="../login/logoin.php">Login</a> |
                <a href="registration.php">Registration</a>
            </nav>
        </header>

        <main>
            <h2>REGISTRATION</h2>
            <form action="register_process.php" method="post">
                <label>Name:</label>
                <input type="text" name="name" required><br><br>

                <label>Email:</label>
                <input type="email" name="email" required><br><br>

                <label>User Name:</label>
                <input type="text" name="username" required><br><br>

                <label>Password:</label>
                <input type="password" name="password" required><br><br>

                <label>Confirm Password:</label>
                <input type="password" name="cpassword" required><br><br>

                <fieldset>
                    <legend>Gender</legend>
                    <input type="radio" name="gender" value="Male" required> Male
                    <input type="radio" name="gender" value="Female"> Female
                    <input type="radio" name="gender" value="Other"> Other
                </fieldset>
                <br>

                <fieldset>
                    <legend>Date of Birth</legend>
                    <input type="text" name="day" placeholder="dd" size="2" required> /
                    <input type="text" name="month" placeholder="mm" size="2" required> /
                    <input type="text" name="year" placeholder="yyyy" size="4" required>
                </fieldset>
                <br>

                <input type="submit" value="Submit">
                <input type="reset" value="Reset">
            </form>
        </main>

        <footer>
            <p>Copyright © 2017</p>
        </footer>
    </div>
</body>

</html>