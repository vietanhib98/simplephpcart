<?php
session_start();
require_once ('database.php');
$database = new Database();

if (isset($_POST) &&!empty($_POST)) {
//    $_POST check xem n tồi tại hay không
//    !empty check xem có dữ liệu bên trong

    if (isset($_POST['action'])){
        switch ($_POST['action']) {
            case 'add':
                if (isset($_POST['quantity']) && isset($_POST['product_id'])) {
                    $sql = "SELECT * FROM products where id=". (int)$_POST['product_id'];
                    $product = $database->runQuery($sql);
                    $product = current($product);
                    echo '<br> $product';
                    echo'<pre>';
                    print_r($product);
                    echo '</pre>';
                    $product_id = $product['id'];
                    if ( isset($_SESSION['cart_item']) && !empty($_SESSION['cart_item'])){
                        if (isset($_SESSION['cart_item'][$product_id])){

                            //san pham da ton tai. trong gio hang`
                            $exist_cart_item = $_SESSION['cart_item'][$product_id];
                            $exist_quantity =  $exist_cart_item['quantity'];
                            $cart_item = array();
                            $cart_item['id'] = $product['id'];
                            $cart_item['product_name'] = $product['product_name'];
                            $cart_item['product_image'] = $product['product_image'];
                            $cart_item['price'] = $product['price'];
                            $cart_item['quantity'] = $exist_quantity + $_POST['quantity'];
                            $_SESSION['cart_item'][$product_id] = $cart_item;
                        } else {

                            //san pham chua ton tai trong gio hang`
                            $cart_item = array();
                            $cart_item['id'] = $product['id'];
                            $cart_item['product_name'] = $product['product_name'];
                            $cart_item['product_image'] = $product['product_image'];
                            $cart_item['price'] = $product['price'];
                            $cart_item['quantity'] = $_POST['quantity'];
                            $_SESSION['cart_item'][$product_id] = $cart_item;

                        }



                    }else {

                        $_SESSION['cart_item'] = array();

                        $cart_item = array();
                        $cart_item['id'] = $product['id'];
                        $cart_item['product_name'] = $product['product_name'];
                        $cart_item['product_image'] = $product['product_image'];
                        $cart_item['price'] = $product['price'];
                        $cart_item['quantity'] = $_POST['quantity'];
                        $_SESSION['cart_item'][$product_id] = $cart_item;

                    }
                }
                break;
            default:
                echo 'Action không tồn tại';
                die;
        }
    }
    echo '<br> $_POST';
    echo'<pre>';
    print_r($_POST);
    echo '</pre>';

    echo '<br> $_SESSION';
    echo'<pre>';
    print_r($_SESSION);
    echo '</pre>';
}


//
//        $sql = "SELECT * FROM products";
//        $products = $database->runQuery($sql);
header("Location: http://localhost/simplephpcart/index.php");
die();

