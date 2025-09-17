<?php
include 'db.php';
$result = $conn->query("SELECT * FROM products WHERE display='Yes'");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
</head>
<body>
    <h2>Product List</h2>
    <a href="add.php">➕ Add Product</a>
    <form action="search.php" method="get">
        <input type="text" name="query" placeholder="Search product...">
        <input type="submit" value="Search">
    </form>
    <br><br>
    <table border="1" cellpadding="8">
        <tr><th>ID</th><th>Name</th><th>Price</th><th>Display</th><th>Actions</th></tr>
        <?php while($row=$result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['price'] ?></td>
            <td><?= $row['display'] ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> | 
                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
