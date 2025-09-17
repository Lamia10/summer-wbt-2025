<?php
include 'db.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $name=$_POST['name'];
    $price=$_POST['price'];
    $display=$_POST['display'];
    $conn->query("INSERT INTO products (name, price, display) VALUES ('$name','$price','$display')");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head><title>Add Product</title></head>
<body>
<h2>Add Product</h2>
<form method="post">
    Name: <input type="text" name="name" required><br><br>
    Price: <input type="number" name="price" required><br><br>
    Display: 
    <select name="display">
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select><br><br>
    <input type="submit" value="Save">
</form>
</body>
</html>
