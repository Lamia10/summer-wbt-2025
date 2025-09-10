<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet"  href="login.css">
</head>
<body>
    <div class="header">
        <div class="logo"><span class="x">X</span>Company</div>
        <div class="nav">
            <a href="../index.php">Home</a> |
            
            <a href="../registration/registeration.php">Registration</a>
        </div>
    </div>
 
    <div class="login-box">
        <form action="login.php" method="POST">
            <h3>LOGIN</h3>
            <label>User Name :</label>
            <input type="text" name="username" required><br><br>
 
            <label>Password :</label>
            <input type="password" name="password" required><br><br>
 
            <input type="checkbox" name="remember"> Remember Me <br><br>
 
            <input type="submit" value="Submit">
            <a href="../forgot/forgot.php" class="forgot">Forgot Password?</a>
        </form>
    </div>
 
    <div class="footer">
        Copyright © 2017
    </div>
</body>
</html>