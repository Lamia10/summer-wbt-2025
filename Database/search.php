<?php
include 'db.php';
$query=$_GET['query'];
$result=$conn->query("SELECT * FROM products WHERE name LIKE '%$query%' AND display='Yes'");
?>
<!DOCTYPE html>
<html>
<head><title>Search Results</title></head>
<body>
<h2>Search Results for "<?= $query ?>"</h2>
<a href="index.php">Back</a>
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
