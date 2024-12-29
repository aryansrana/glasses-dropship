<?php
    
    $glasses_id = filter_input(INPUT_POST, 'glasses_id', FILTER_VALIDATE_INT);
    $pair_id = filter_input(INPUT_POST, 'pair_id', FILTER_VALIDATE_INT);
    $name = filter_input(INPUT_POST, 'name');
    $description = filter_input(INPUT_POST, 'description');
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $image = filter_input(INPUT_POST, 'image');

    
    if ($_POST['review'] != ""){
        $review = filter_input(INPUT_POST, 'review', FILTER_VALIDATE_FLOAT);
    }

    
    if ($glasses_id === FALSE || $pair_id === FALSE || $name === FALSE || $description === FALSE || $price === FALSE || $image === FALSE || $review === FALSE){
        echo "Something went wrong, please try again later.";
        include("catalog.php");
        exit();
    }
    
    $cnx = new mysqli('localhost', 'root', '112784', 'dropship');

    if($cnx->connect_error){
        die('Connection failed: ' . $cnx->connect_error);
    }

    $statement = $cnx->prepare("SELECT * FROM glasses WHERE pair_id = ? AND glasses_id != ?");
    $statement->bind_param('ii', $pair_id, $glasses_id);
    $statement->execute();
    $statement->bind_result($glasses_id2, $name2, $description2, $price2, $image2, $review2, $pair_id2);
    $statement->fetch();
    $statement->close();

    $cnx->close();
?>

<html>
    <head>
        <title>Product Page</title> 
    </head>
    <body>
        <img src="logo.png" width=100% height=auto alt="Logo">
        <nav style="background-color: #87CEEB">
            <a href="catalog.php">Catalog<a>
        </nav>
        <figure align ="center">
            <img src = <?php echo $image?> alt="Glasses Image Placeholder" width=500vw height=auto/>
            <figcaption>
            <p><?php echo $name?><p>
            <p>$<?php echo number_format($price * 1.1, 2)?></p>
            <?php
            if ($review == ""){
                echo "<p>No Reviews</p>";
            }
            else{
                echo "<p>". number_format($review, 1) . "/5.0</p>";
            }
            ?>
            <p><?php echo $description?></p>
            <p>
            <form action="shipping.php" method="post"> 
                <input type="hidden" name="glasses_id" value="<?php echo $glasses_id;?>"/>
                <input type="hidden" name="name" value= "<?php echo $name;?>"/>
                <input type="hidden" name="price" value="<?php echo $price;?>"/>
                <input type="submit" value="Buy"/>
            </form>
            <p>
            </figcaption>
        </figure>
        <br>
        <h1>Product related to this item:</h1>
        <br>
        <figure align ="center">
            <img src = <?php echo $image2?> alt="Glasses Image Placeholder" width=500vw height=auto/>
            <figcaption>
            <?php 
                if ($price2 < $price) {
                    echo '<p style="color:green">Cheaper!!</p>';
                } 
            ?>
            <p><?php echo $name2?><p>
            <p>$<?php echo number_format($price2 * 1.1, 2)?></p>
            <?php
            if ($review2 == ""){
                echo "<p>No Reviews</p>";
            }
            else{
                echo "<p>". number_format($review2, 1) . "/5.0</p>";
            }
            ?>
            <p><?php echo $description2?></p>
            <p>
            <form action="product.php" method="post"> 
                <input type="hidden" name="glasses_id" value= "<?php echo $glasses_id2;?>"/>
                <input type="hidden" name="pair_id" value= "<?php echo $pair_id2;?>"/>
                <input type="hidden" name="name" value= "<?php echo $name2;?>"/>
                <input type="hidden" name="description" value= "<?php echo $description2;?>"/>
                <input type="hidden" name="price" value= "<?php echo $price2;?>"/>
                <input type="hidden" name="image" value= "<?php echo $image2;?>"/>
                <input type="hidden" name="review" value= "<?php echo $review2;?>"/>
                <input type="submit" value="View"/>
            </form>
            <p>
            </figcaption>
        </figure>
    </body>
</html>