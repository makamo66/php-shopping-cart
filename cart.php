<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

?>

<!DOCTYPE html>
<html>
<head>

<title>Shopping Cart</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="js/cart.js?2"></script>




<script>

    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
	
</script>

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" type="text/css" href="css/style.css?162">
</head>
<body>
<div id="page-container">
<div id="header">
<a class="link" href="tutorial.php">Back to Tutorial</a>
</div>

<?php


if ( isset($_POST["element_id"]) ) {
	$id = $_POST["element_id"];
	}

if ( isset($_POST["quantity"]) ) {
	$quantity = $_POST["quantity"];
}

if ( isset($id)  && isset($quantity) ) {
    if (!isset($_SESSION["cart_items"][$id])) {
        $_SESSION["cart_items"][$id]  = 0;
    }
    $_SESSION["cart_items"][$id] += $quantity;
}

if (isset($_SESSION["cart_items"])){
$length = sizeof($_SESSION["cart_items"]);

for($i=0; $i<=$length; $i++){

if (isset($_POST["remove_$i"]) && $_POST["remove_$i"]=="delete" ){
unset($_SESSION["cart_items"][$i]);
}
}
}



if (isset($_POST["clearCart"])){
unset($_SESSION["cart_items"]);
}

if ( !empty($_SESSION["cart_items"])){
$total_price=0;

?>
<table border='1'>
<tr>
<th>Remove&nbsp;&nbsp;&nbsp;</th>
<th width='100'>Your Product&nbsp;&nbsp;</th>
<th>Quantity</th>
<th>Description</th>
<th>Price per item</th>
<th>Sub Total</th>
</tr>
<?php
$json_url = "js/shopping-cart.json";
$json = file_get_contents($json_url);
$data = json_decode($json, TRUE);


foreach( $_SESSION["cart_items"] as $cart_product_id =>$cart_product_quantity ) {

$product_id = $data["products"][$cart_product_id]["id"];
$product_name = $data["products"][$cart_product_id]["name"];
$thumbnail = $data["products"][$cart_product_id]["thumbnail"];
$price = $data["products"][$cart_product_id]["price"];
				

$price = number_format($price, 2, '.', '');

$number = number_format($cart_product_quantity*$price, 2, '.', '');
if($product_id == $cart_product_id) {
$code=<<<heredocs
<form method="post" name="yourForm">
<tr><td><button type="submit" id="my" value="delete" name="remove_{$cart_product_id}"  class="deletebtn">X</button></td>
<td><img src="{$thumbnail}"/></td>
<td>{$cart_product_quantity}</td>
<td>{$product_name}(s)&nbsp;&nbsp;</td>
<td>\${$price}</td>
<td>\${$number}</td>
</tr>

heredocs;
echo $code;

$total_price += ($cart_product_quantity*$price);
}
}
//}
if (isset($total_price) && !empty($_SESSION["price"]) && ($_SESSION["price"] != NULL)) {

$total_price = number_format($total_price, 2, '.', '');
echo "<tr><td></td><td></td><td></td><td></td><td>Grand Total </td><td>\$" . $total_price . "</td>";
}
?>
</form>
</table>
<?php

} else {
	echo "&nbsp;&nbsp;&nbsp;&nbsp;Your cart is empty";
}


?>
<br />
<?php
if ( isset($_SESSION["cart_items"]) && $_SESSION["cart_items"] != NULL) {
	
?>
<div class="finish">
<form action="action_page.php" name="myForm" method="POST">

&nbsp;&nbsp;&nbsp;&nbsp;<input class="w3-button w3-black checkout" type="submit" value="Check Out" />
</form>

&nbsp;&nbsp;&nbsp;&nbsp;
<form name="myForm2" method="POST">
 

&nbsp;&nbsp;&nbsp;&nbsp;<input class="w3-button w3-black clearcart" type="submit" value="Clear Cart" name="clearCart" />
</form> 
</div>
<?php
}

//session_destroy();
?>
<br />
  
  <h1>PHP Shopping Cart</h1>
    <div id="cart">
        
        <ul id="cartItemsList">
        </ul>
    </div>
	
<br style="clear: both;" />

<p class="footer">
&copy; <?php echo date("Y"); ?> <a href="http://maureenmoore.com">Maureen Moore</a> </p>
</div>
</body>
</html>