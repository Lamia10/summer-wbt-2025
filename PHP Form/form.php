<?php
$fname = $lname = $company = $address1 = $address2 = $city = $state = $zip = $country = $phone = $fax = $email = $amount = "";
$fnameErr = $lnameErr = $address1Err = $cityErr = $stateErr = $zipErr = $countryErr = $emailErr = $amountErr = $phoneErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $allValid = true;

    if (empty($_POST["fname"])) { $fnameErr = "First Name is required"; $allValid = false; } 
    else { $fname = test_input($_POST["fname"]); if (!preg_match("/^[a-zA-Z ]*$/",$fname)) { $fnameErr = "Only letters allowed"; $allValid = false; } }

    if (empty($_POST["lname"])) { $lnameErr = "Last Name is required"; $allValid = false; } 
    else { $lname = test_input($_POST["lname"]); if (!preg_match("/^[a-zA-Z ]*$/",$lname)) { $lnameErr = "Only letters allowed"; $allValid = false; } }

    if (empty($_POST["address1"])) { $address1Err = "Address 1 is required"; $allValid = false; } 
    else { $address1 = test_input($_POST["address1"]); }

    if (empty($_POST["city"])) { $cityErr = "City is required"; $allValid = false; } 
    else { $city = test_input($_POST["city"]); if (!preg_match("/^[a-zA-Z ]*$/",$city)) { $cityErr = "Only letters allowed"; $allValid = false; } }

    if (empty($_POST["state"])) { $stateErr = "State is required"; $allValid = false; } 
    else { $state = test_input($_POST["state"]); }

    if (empty($_POST["zip"])) { $zipErr = "Zip Code is required"; $allValid = false; } 
    else { $zip = test_input($_POST["zip"]); if (!preg_match("/^[0-9]{4,6}$/",$zip)) { $zipErr = "Zip code must be 4-6 digits"; $allValid = false; } }

    if (empty($_POST["country"])) { $countryErr = "Country is required"; $allValid = false; } 
    else { $country = test_input($_POST["country"]); }

    if (empty($_POST["email"])) { $emailErr = "Email is required"; $allValid = false; } 
    else { $email = test_input($_POST["email"]); if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $emailErr = "Invalid email format"; $allValid = false; } }

    if (empty($_POST["amount"])) { $amountErr = "Donation Amount is required"; $allValid = false; } 
    else { $amount = test_input($_POST["amount"]); if (!preg_match("/^[0-9]+$/",$amount)) { $amountErr = "Only numbers allowed"; $allValid = false; } }

    if (empty($_POST["phone"])) { $phoneErr = "Phone is required"; $allValid = false; } 
    else { $phone = test_input($_POST["phone"]); if (!preg_match("/^[0-9]*$/",$phone)) { $phoneErr = "Phone must be numbers only"; $allValid = false; } }

    $company = test_input($_POST["company"] ?? "");
    $address2 = test_input($_POST["address2"] ?? "");
    $fax = test_input($_POST["fax"] ?? "");

    if ($allValid) {
        echo "<h3>Form submitted successfully!</h3>";
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Donation Form</title>
<style>
body { font-family: Arial, sans-serif; font-size: 12px; background-color: #fff; padding: 30px; color: #000; }
.nav { font-size: 11px; margin-bottom: 10px; }
.form-container { max-width: 650px; margin: auto; display: flex; flex-direction: column; gap: 10px; justify-content: center; }
h2 { color: #c00; font-size: 14px; margin-top: 20px; font-weight: bold; border-bottom: 1px solid #ccc; padding-bottom: 3px; }
label { display: block; margin-bottom: 6px; font-weight: normal; }
input[type="text"], input[type="email"], input[type="number"], select, textarea { width: 100%; padding: 4px; font-size: 12px; margin-top: 3px; margin-bottom: 10px; box-sizing: border-box; border: 1px solid #ccc; }
textarea { resize: vertical; }
.form-row { display: flex; gap: 10px; width: 100%; padding: 4px; margin-bottom: 10px; font-size: 12px; box-sizing: border-box; }
.form-row label { flex: 1; }
.radio-group label, .checkbox-group label { display: inline-block; margin-right: 15px; margin-top: 5px; }
.radio-group legend { font-weight: bold; margin-bottom: 5px; }
.radio-group span { font-weight: normal; font-size: 11px; margin-left: 4px; }
input[type="radio"], input[type="checkbox"] { margin-right: 5px; }
.form-actions { text-align: left; margin-top: 20px; }
button { background-color: #ddd; border: 1px solid #999; padding: 5px 15px; margin-right: 10px; font-size: 12px; cursor: pointer; }
button:hover { background-color: #ccc; }
.footer-note { font-size: 11px; margin-top: 20px; color: #333; }
.footer-note a { color: #666; text-decoration: underline; }
span { color: red; font-size: 11px; }
</style>
</head>
<body>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="form-container">
<p class="nav">&gt; 1 Donation &nbsp; &gt; 2 Confirmation &nbsp; &gt; Thank You!</p>
<h2>Donor Information</h2>
<div class="form-row">
<label>First Name* <input type="text" name="fname" value="<?php echo $fname;?>"></label><span><?php echo $fnameErr;?></span>
<label>Last Name* <input type="text" name="lname" value="<?php echo $lname;?>"></label><span><?php echo $lnameErr;?></span>
</div>
<label>Company <input type="text" name="company" value="<?php echo $company;?>"></label>
<label>Address 1* <input type="text" name="address1" value="<?php echo $address1;?>"></label><span><?php echo $address1Err;?></span>
<label>Address 2 <input type="text" name="address2" value="<?php echo $address2;?>"></label>
<div class="form-row">
<label>City* <input type="text" name="city" value="<?php echo $city;?>"></label><span><?php echo $cityErr;?></span>
<label>State* <input type="text" name="state" value="<?php echo $state;?>"></label><span><?php echo $stateErr;?></span>
</div>
<div class="form-row">
<label>Zip Code* <input type="text" name="zip" value="<?php echo $zip;?>"></label><span><?php echo $zipErr;?></span>
<label>Country* <input type="text" name="country" value="<?php echo $country;?>"></label><span><?php echo $countryErr;?></span>
</div>
<label>Phone* <input type="number" name="phone" value="<?php echo $phone;?>"></label><span><?php echo $phoneErr;?></span>
<label>Fax <input type="text" name="fax" value="<?php echo $fax;?>"></label>
<label>Email* <input type="text" name="email" value="<?php echo $email;?>"></label><span><?php echo $emailErr;?></span>

<fieldset class="radio-group">
<legend>Donation Amount* <span>(Check a button or type in your amount)</span></legend>
<label><input type="radio" name="amount" value="50" <?php if($amount=="50") echo "checked";?>> $50</label>
<label><input type="radio" name="amount" value="75" <?php if($amount=="75") echo "checked";?>> $75</label>
<label><input type="radio" name="amount" value="100" <?php if($amount=="100") echo "checked";?>> $100</label>
<label><input type="radio" name="amount" value="250" <?php if($amount=="250") echo "checked";?>> $250</label>
<label>Other <input type="text" name="amount" value="<?php echo $amount;?>"></label><span><?php echo $amountErr;?></span>
</fieldset>

<div class="form-actions">
<button type="reset">Reset</button>
<button type="submit">Continue</button>
</div>

<p class="footer-note">
Donate online with confidence. You are on a secure server.<br>
If you have any problems or questions, please <a href="#">contact support</a>.
</p>
</form>
</body>
</html>
