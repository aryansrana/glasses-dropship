<html>
    <head>
        <title>Catalog Page</title>
    </head>
    <body>
        <img src="logo.png" width=100% height=auto alt="Logo">
        <h2>Glasses Catalog</h2>
        <table align="center" border="1">
            <tr><td align="center">Name</td><td align="center">Rating</td><td align="center">Price</td><td align="center">Image</td>
            <?php
                $cnx = new mysqli('localhost', 'root', '112784', 'dropship');

                if($cnx->connect_error){
                    die('Connection failed: ' . $cnx->connect_error);
                }

                $query = 'SELECT * FROM glasses';
                $cursor = $cnx->query($query);
                while ($row = $cursor->fetch_assoc()){
                    echo '<tr>';
                    echo '<td align="center">' . $row['name'] . '</td><td align="center">';
                    if ($row['review'] === NULL){
                        echo "No Reviews";
                    } 
                    else{
                        echo number_format($row['review'],1) . '/5.0'; 
                    }
                    echo '</td><td align="right">$' . number_format($row['price'] * 1.1, 2) . '</td><td>' . '<img src="' . $row['image'] . '" width=500vw height=auto/></td>';
                    echo '<td>' . '<form action="product.php" method="post"> <input type="hidden" name="glasses_id" value="' . $row['glasses_id'] . '"/> <input type="hidden" name="name" value="' . $row['name'] . '"/> <input type="hidden" name="description" value="' . $row['description'] . '"/> <input type="hidden" name="price" value="' . $row['price'] . '"/> <input type="hidden" name="image" value="' . $row['image'] . '"/> <input type="hidden" name="review" value="' . $row['review'] . '"/> <input type="hidden" name="pair_id" value="' . $row['pair_id'] . '"/> <input type="submit" value="View"/>' . '</form>';
                    echo '</tr>';
                }
                $cnx->close();
            ?>
        </table>
    </body>
</html>