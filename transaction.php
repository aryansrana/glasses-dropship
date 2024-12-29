<?php
    $glasses_id = filter_input(INPUT_POST, 'glasses_id', FILTER_VALIDATE_INT);
    $name = filter_input(INPUT_POST, 'name');
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $card = filter_input(INPUT_POST, 'card');
    $fullname = filter_input(INPUT_POST, 'fullname');
    $expiration = filter_input(INPUT_POST, 'expiration');
    $cvv = filter_input(INPUT_POST, 'cvv');
    $apt = filter_input(INPUT_POST, 'apt');
    $street = filter_input(INPUT_POST, 'street');
    $city = filter_input(INPUT_POST, 'city');
    $state = filter_input(INPUT_POST, 'state');
    $zipcode = filter_input(INPUT_POST, 'zipcode');
    $email = filter_input(INPUT_POST, 'email');

    if ($glasses_id === FALSE || $name === FALSE || $price === FALSE || $card === FALSE || $fullname === FALSE || $expiration === FALSE || $cvv === FALSE || $apt === FALSE || $street === FALSE || $city === FALSE || $state === FALSE || $zipcode === FALSE || $email === FALSE){
        echo "Something went wrong";
        include("catalog.php");
        exit();
    }
    if ($card == ""){
        echo "The credit card number is a required field. Please try again.";
        include("catalog.php");
        exit();
    }
    if (strlen($card) != 16){
        echo "The credit card number must only be 16 digits. Please try again.";
        include("catalog.php");
        exit();
    }
    if ($fullname == ""){
        echo "The name of your card is a required field. Please try again.";
        include("catalog.php");
        exit();
    }
    if(strlen($fullname) > 255){
        echo "Your name on card must be less than 256 characters. Please try again.";
        include("catalog.php");
        exit();
    }
    if ($expiration == ""){
        echo "The card expiration field is a required field. Please try again.";
        include("catalog.php");
        exit();
    }
    if(strlen($expiration) != 5){
        echo "Your card expiration must be 5 characters. Please try again. Example: 01/26";
        include("catalog.php");
        exit();
    }
    if ($cvv == ""){
        echo "The CVV field is a required field. Please try again.";
        include("catalog.php");
        exit();
    }
    if(strlen($cvv) != 3){
        echo "Your CVV must be three digits. Example: 001";
        include("catalog.php");
        exit();
    }
    if(strlen($apt) > 7){
        echo "Your apt # must be less than 8 characters.";
        include("catalog.php");
        exit();
    }
    if ($street == ""){
        echo "The street address field is a required field. Please try again.";
        include("catalog.php");
        exit();
    }
    if(strlen($street) > 63){
        echo "Your street address must be less than 64 characters. Please try again.";
        include("catalog.php");
        exit();
    }
    if ($city == ""){
        echo "The city field is a required field. Please try again.";
        include("catalog.php");
        exit();
    }
    if(strlen($city) > 63){
        echo "Your city must be less than 64 characters. Please try again.";
        include("catalog.php");
        exit();
    }
    if ($state == "none"){
        echo "The state field is a required field. Please try again and select a state or territory.";
        include("catalog.php");
        exit();
    }

    if(strlen($state) != 2){
        echo "Something went wrong with the state input. Please try again.";
        include("catalog.php");
        exit();
    }
    if ($zipcode == ""){
        echo "The ZIP code field is a required field. Please try again.";
        include("catalog.php");
        exit();
    }
    if(strlen($zipcode) != 5){
        echo "Your ZIP code must be 5 characters. Please try again.";
        include("catalog.php");
        exit();
    }
    if ($email == ""){
        echo "The email field is a required field. Please try again.";
        include("catalog.php");
        exit();
    }
    if(strlen($email) > 320){
        echo "Your email must be less than 321 characters. Please try again.";
        include("catalog.php");
        exit();
    }

    $price_f = number_format($price, 2);
    $fullname = strtoupper($fullname);

    $cnx = new mysqli('localhost', 'root', '112784', 'dropship');
    if($cnx->connect_error){
        die('Connection failed: ' . $cnx->connect_error);
    }
    
    if ($apt != ""){
        $statement = $cnx->prepare('INSERT INTO transactions(glasses_id, name, price, card, fullname, expiration, cvv, apt, street, city, state, zipcode, email, date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())');
        $statement->bind_param('isdssssssssss', $glasses_id, $name, $price_f, $card, $fullname, $expiration, $cvv, $apt, $street, $city, $state, $zipcode, $email);
    }
    else{
        $statement = $cnx->prepare('INSERT INTO transactions(glasses_id, name, price, card, fullname, expiration, cvv, street, city, state, zipcode, email, date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,NOW())');
        $statement->bind_param('isdsssssssss', $glasses_id, $name, $price_f, $card, $fullname, $expiration, $cvv, $street, $city, $state, $zipcode, $email);
    }
    
    $statement->execute();
    $statement->close();
    $cnx->close();
    echo $name . " was successfully purchased!";
    include("catalog.php");
    
?>
