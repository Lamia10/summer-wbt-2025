<?php
include 'db.php';
$id=$_GET['id'];
$product=$conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if($_SERVER['REQUEST_METHOD']=='POST'){
    $name=$_POST['name'];
    $price=$_POST['price'];
    $display=$_POST['display'];
    $conn->query("UPDATE products SET name='$name', price='$price', display='$display' WHERE id=$id");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Product</title></head>
<body>
<h2>Edit Product</h2>
<form method="post">
    Name: <input type="text" name="name" value="<?= $product['name'] ?>" required><br><br>
    Price: <input type="number" name="price" value="<?= $product['price'] ?>" required><br><br>
    Display: 
    <select name="display">
        <option value="Yes" <?= $product['display']=='Yes'?'selected':'' ?>>Yes</option>
        <option value="No" <?= $product['display']=='No'?'selected':'' ?>>No</option>
    </select><br><br>
    <input type="submit" value="Update">
</form>
</body>
</html>
