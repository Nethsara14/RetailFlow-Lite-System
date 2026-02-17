<?php include 'connection.php'; ?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wikunuma Athul Kirima</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background-color: #f4f4f4; }
        .form-container { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, select, button { width: 100%; padding: 12px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; }
        button { background-color: #28a745; color: white; font-weight: bold; border: none; cursor: pointer; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Badu Wikunuma Athul Kirima</h2>
    <form action="save_sale.php" method="POST">
        <label>Badu Jathiya:</label>
        <select name="product_id" required>
            <option value="">Select Item</option>
            <?php
            // Database eken items tika ganna
            $res = $conn->query("SELECT id, item_name FROM products");
            while($row = $res->fetch_assoc()) {
                echo "<option value='".$row['id']."'>".$row['item_name']."</option>";
            }
            ?>
        </select>

        <label>Pramanaya (Qty):</label>
        <input type="number" name="qty_sold" step="0.01" placeholder="Ex: 5" required>

        <button type="submit">Submit (Update Karanna)</button>
    </form>
</div>

</body>
</html>