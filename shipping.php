<?php
     $glasses_id = filter_input(INPUT_POST, 'glasses_id', FILTER_VALIDATE_INT);
     $name = filter_input(INPUT_POST, 'name');
     $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

     if ($glasses_id === FALSE || $name === FALSE || $price === FALSE){
        echo $_POST['glasses_id'];
        echo "<br>";
        echo $_POST['name'];
        echo "<br>";
        echo $_POST['price'];
        echo "<br>";
        echo "Something went wrong, please try again later.";
        include("catalog.php");
        exit();
    }
?>
<html>
    <head>
        <title>Purchase Page</title> 
    </head>
    <body>
        <img src="logo.png" width=100% height=auto alt="Logo">
        <nav style="background-color: #87CEEB">
            <a href="catalog.php">Catalog<a>
        </nav>
        <p>Product: <?php echo $name;?><p>
        <p>Total: $<?php echo number_format($price * 1.1, 2)?></p>
        <p>Billing Information:</p>
        <form action="transaction.php" method="post">
            <label>Credit Card Number: </label>
            <input type="text" name="card" pattern="[0-9]{16}" placeholder="0000000000000000" title="Please enter your 16 digit credit card number."/>
            <label>*</label>
            <br>
            <label>Name on Card: </label>
            <input type="text" name="fullname"/>
            <label>*</label>
            <br>
            <label>Card Expiration Date: </label>
            <input type="text" name="expiration" pattern="(0[1-9]|1[0-2])/[0-9]{2}" placeholder="01/26" title="Please type two digits representing the month of the card expiration, followed by a /, follow by two digits representing the year of the card expiration. Ex. 01/26"/>
            <label>*</label>
            <br>
            <label>CVV: </label>
            <input type="text" name="cvv" pattern="[0-9]{3}" placeholder="000" title="Please enter your three digit CVV."/>
            <label>*</label>
            <br> 
            <label>Apt #: <label>
            <input type="text" name="apt"/>
            <br>
            <label>Street Address: </label>
            <input type="text" name="street"/>
            <label>*</label>
            <br>
            <label>City: </label>
            <input type="text" name="city"/>
            <label>*</label>
            <br>
            <label>State:</label>
            <Select name="state" pattern="[A-Z]{2}" title="Please select your state.">
                <option value="none" selected disabled hidden>Select an Option</option>    
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">District Of Columbia</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
                <option value="AS">American Samoa</option>
                <option value="GU">Guam</option>
                <option value="MP">Northern Mariana Islands</option>
                <option value="PR">Puerto Rico</option>
                <option value="UM">United States Minor Outlying Islands</option>
                <option value="VI">Virgin Islands</option>
                <option value="AA">Armed Forces Americas</option>
                <option value="AP">Armed Forces Pacific</option>
                <option value="AE">Armed Forces Others</option>
            </Select>
            <label>*</label>
            <br>
            <label>ZIP code: </label>
            <input type="text" name="zipcode" pattern="[0-9]{5}" placeholder="00000" title="Please enter your five digit ZIP code."/>
            <label>*</label>
            <br>
            <label>Email:</label>
            <input type="email" name="email" title="Please enter a valid email address."/>
            <label>*</label>
            <input type="hidden" name="glasses_id" value="<?php echo $glasses_id;?>"/>
            <input type="hidden" name="name" value="<?php echo $name;?>"/>
            <input type="hidden" name="price" value="<?php echo $price * 1.1;?>"/>
            <br>
            <input type="submit" value="Purchase"/>
        </form>
    </body>
</html>