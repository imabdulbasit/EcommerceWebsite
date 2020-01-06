
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<?php

include 'config/database.php';
include 'bootstrap.php';
include 'loginCode.php';
require_once( './objects/component.php');
$database = new Database();
$connection = $database->getConnection();
$page_title="Products";
include 'navigation.php';
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $fname = $_SESSION['firsname'];
        $lname = $_SESSION['lastname'];
        echo " <script> document.getElementById('login_register').innerHTML='$fname $lname';</script>";
        echo "  <script> document.getElementById('registerhref').href='index.php';
</script>";
}
if (isset($_POST['add'])){
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        $rn = $_SESSION['user_id']; 
            $q1 =  "select count(*) from shopping_cart where customer_id = $rn";
            $res = $connection->prepare($q1);
            $res->execute();
             $result = $res->fetchAll();
            $yy=0;
            print_r($result[0][0]);
            if($result[0][0] == 0){
            $q =  "INSERT INTO shopping_cart (customer_id)
            VALUES ($rn)";
            $res = $connection->prepare($q);
            $res->execute();}
            print_r($rn);
        $query44 = "SELECT cart_id  from shopping_cart where customer_id = $rn";
        $x = $connection->prepare($query44);
        $x->execute();
        $yy = $x->fetchAll();
        $cartid = $yy[0][0];
        $item_ID = $_POST['product_id'];
        $q =  "INSERT INTO shopping_item (cart_id , item_id ,item_quantity)
                VALUES ($cartid , $item_ID , 1)";
                
            $res =  $connection->prepare($q);
                 $res->execute();

    /// print_r($_POST['product_id']);
    if(isset($_SESSION['cart'])){
        $item_array_id = array_column($_SESSION['cart'], "product_id");
        if(in_array($_POST['product_id'], $item_array_id)){
            echo "<div class=\"alert alert-danger\" role=\"alert\">
            Product already added in the cart;
            </div>";
        }else{
            $count = count($_SESSION['cart']);
            $item_array = array(
                'product_id' => $_POST['product_id']
            );
            $_SESSION['cart'][$count] = $item_array;
            header("Refresh:0");
            
        }
}
    else
    {
        $item_array = array(
                'product_id' => $_POST['product_id']
        );
        // Create new session variable
        $_SESSION['cart'][0] = $item_array;
        header("Refresh:0");
    }


    } 
else {
    echo "<script>alert('Please login')</script>";
              echo "<script>window.location = 'login.php'</script>";
}
}
?>
<div class="container">
<div class="row text-center py-5">
<?php
if (isset($_GET['catid'])){
$catid = $_GET['catid'];
$query = "SELECT item_id , item_name , item_price, item_description from item where category_id = $catid";
$res = $connection->prepare($query);
$res->execute();
$result = $res->fetchAll();
// print_r($result[0][0]);
for ($x = 0; $x < sizeof($result); $x++) {
    component($result[$x][0],$result[$x][1],$result[$x][2],$result[$x][3]);

}


}
else {
  {
    $query = "SELECT item_id , item_name , item_price, item_description from item";
    $res = $connection->prepare($query);
    $res->execute();
    $result = $res->fetchAll();
    // print_r($result[0][0]);
    for ($x = 0; $x < sizeof($result); $x++) {
        component($result[$x][0],$result[$x][1],$result[$x][2],$result[$x][3]);

    }
  }
}
?>
</div>
</div>

</body>
</html>
