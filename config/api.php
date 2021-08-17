<?php 
    include 'config.php';
    date_default_timezone_set('Asia/Karachi');
    $errors = array();
    session_start();
?>


<?php 
    //Login
    if(isset($_POST['login'])){
        $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']));
        $pass = htmlspecialchars(mysqli_real_escape_string($con, $_POST['password']));
        $remember = htmlspecialchars(mysqli_real_escape_string($con, $_POST['remember']));
        $pass = strtolower($pass);
        $email = strtolower($email);
        $enc_pass = md5($pass);

        if(empty($email) || empty($pass)){array_push($errors, "Fields are Empty");}

        if(strpos($email, '@') == false){ array_push($errors, "Email Format isn't correct"); }

        if(count($errors) == 0){
            $date = date("d, M Y h:i:s A");
            $sql = "SELECT * from admin_db WHERE email = '$email' AND password = '$enc_pass' LIMIT 1";
            $res = mysqli_query($con, $sql);

            if(mysqli_num_rows($res) == 1){
               $row = mysqli_fetch_assoc($res);
               $_SESSION['admin-auth'] = $row['fullname'];
               $update = "UPDATE admin_db SET last_login = '$date' WHERE email = '$email'";
               $upResult = mysqli_query($con, $update);
               if($remember == true){
                   $cookie_value = rand(1, 200000);
                   setcookie("AdminLoginID", $cookie_value, time() + 31556926, "/"); 
               }
               header('location: index.php');
            }else{
                array_push($errors, "Invalid Login Details!");
            }
        }
    }
?>


<?php 
    //Logout
    if(isset($_POST['logout'])){
        unset($_SESSION['admin-auth']);
        unset($_COOKIE['AdminLoginID']);
    }
?>


<?php 
    //Add Product
    if(isset($_POST['addproduct'])){
        $name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['name']));
        $stock = htmlspecialchars(mysqli_real_escape_string($con, $_POST['stock']));
        $catagory = htmlspecialchars(mysqli_real_escape_string($con, $_POST['catagory']));
        $price = htmlspecialchars(mysqli_real_escape_string($con, $_POST['price']));

        if(empty($name) || empty($stock)|| empty($catagory)|| empty($price)){array_push($errors, "Fields are Empty");}

        if(count($errors) == 0){
            $date = date("d, M Y h:i:s A");
            $sql = "INSERT into product_db (name, stock, catagory, price, created_at)
                    VALUES ('$name', '$stock', '$catagory', '$price', '$date')";
            $res = mysqli_query($con, $sql);

            if($res){
               $success = "<p class='w-full p-3 rounded-lg text-center bg-green-400'>Product Added</p>";
            }else{
                array_push($errors, "Something Went Wrong!");
            }
        }
    }
?>

<?php 
    //Upgrade Stock
    if(isset($_POST['update-stock'])){
        $name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['name']));
        $stock = htmlspecialchars(mysqli_real_escape_string($con, $_POST['stock']));
        $catagory = htmlspecialchars(mysqli_real_escape_string($con, $_POST['catagory']));

        if(empty($stock) || empty($name) || empty($catagory)){array_push($errors, "Fields are Empty");}
 
        $sql = "SELECT * from product_db WHERE name = '$name' AND catagory = '$catagory'";
        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res) == 0){
            array_push($errors, "You have selected Brand with wrong catagory");
        }

        if(count($errors) == 0){
            $date = date("d, M Y h:i:s A");
            $sql1 = "SELECT * from product_db WHERE name = '$name' AND catagory = '$catagory'";
            $res = mysqli_query($con, $sql1);
            if(mysqli_num_rows($res) > 0){
                while($row = mysqli_fetch_object($res)){
                    $fStock = $row->stock + $stock;
                }
            }
 
            $sql2 = "UPDATE product_db SET stock = '$fStock', stock_updated = '$date' WHERE name = '$name' AND catagory = '$catagory'";
            $res2 = mysqli_query($con, $sql2);

            $sql3 = "INSERT into record_db (name, catagory, stock, created_at) VALUES ('$name', '$catagory', '$stock', '$date')";
            $res3 = mysqli_query($con, $sql3);

            if($res && $res2 && $res3){
                $success = "<p class='w-full p-3 rounded-lg text-center bg-green-400'>Stock Updated!</p>";
            }else{
                array_push($errors, "Something Went Wrong!");
            }
        }
    }

?>


<?php 
    //Upgrade product
    if(isset($_POST['update-product'])){
        $id = htmlspecialchars(mysqli_real_escape_string($con, $_POST['id']));
        $name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['name']));
        $stock = htmlspecialchars(mysqli_real_escape_string($con, $_POST['stock']));
        $catagory = htmlspecialchars(mysqli_real_escape_string($con, $_POST['catagory']));
        $price = htmlspecialchars(mysqli_real_escape_string($con, $_POST['price']));

        if(empty($stock) || empty($price) || empty($name) || empty($catagory)){array_push($errors, "Fields are Empty");}

        if(count($errors) == 0){
            $date = date("d, M Y h:i:s A");

            $sql = "UPDATE product_db SET 
                    name = '$name', stock = '$stock', stock_updated = '$date', catagory = '$catagory', price = '$price'
                    WHERE pid = '$id'";
            $res = mysqli_query($con, $sql);

            
            
            if($res){
                $success = "<p class='w-full p-3 rounded-lg text-center bg-green-400'>Stock Updated!</p>";
            }else{
                array_push($errors, "Something Went Wrong!");
            }
        }
    }

?>


<?php 
    //Place Order
    if(isset($_POST['order'])){
        
        if(isset($_SESSION['cart'])){
            if(count($_SESSION['cart']) == 0){
                array_push($errors, "Cart is Empty - Add Products");
            }
        }
        if(count($errors) == 0){
            $date = date("d, M Y H:i:s");
            $p_total = 0;
            $name = "";
            $quantity = "";
            $catagory = "";
            $price = "";
            foreach($_SESSION['cart'] as $key => $pros){
                $name .= $pros['name']. '==';
                $quantity .= $pros['quantity']. '==';
                $catagory .= $pros['catagory']. '==';
                $pop =  $pros['price'] * $pros['quantity'];
                $p_total = $p_total + $pop;
                $price .= $pros['price']. '==';

                $pcata = $pros['catagory'];
                $pname = $pros['name'];

                $sql2 = "SELECT * from product_db WHERE name = '$pname' AND catagory = '$pcata'";
                $res2 = mysqli_query($con, $sql2);
                while($row = mysqli_fetch_object($res2)){
                    $id = $row->pid;
                    $quan = $row->stock;
                    $sold = $row->sold;
                    $tot = $quan - $pros['quantity'];
                    $st = $sold + $pros['quantity'];
                    $sql3 = "UPDATE product_db SET stock = '$tot', sold = '$st' WHERE pid = '$id'";
                    $res3 = mysqli_query($con, $sql3);
                }
            }
            $fullname = $_SESSION['cart'][0]['fullname'];

            $sql = "INSERT into orders_db (fullname, product, catagory, quantity, created_at, price_per_unit, total_price)
                    VALUES ('$fullname', '$name', '$catagory', '$quantity', '$date', '$price', '$p_total')";
            $res = mysqli_query($con, $sql);

        
            if($res && $res2){
                $success = "<p class='w-full p-3 rounded-lg text-center bg-green-400'>Order Placed</p>";
                unset($_SESSION['cart']);
            }else{
                array_push($errors, "Something Went Wrong!");
            }
        }
    }

?>

<?php 
    //Return Order
    if(isset($_POST['return'])){
        $fullname = htmlspecialchars(mysqli_real_escape_string($con, $_POST['fullname']));
        $name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['name']));
        $quantity = htmlspecialchars(mysqli_real_escape_string($con, $_POST['quantity']));
        $catagory = htmlspecialchars(mysqli_real_escape_string($con, $_POST['catagory']));
        $price = htmlspecialchars(mysqli_real_escape_string($con, $_POST['price']));

        if(empty($quantity) || empty($fullname) ||empty($name) || empty($catagory)|| empty($price)){array_push($errors, "Fields are Empty");}

        if(!is_numeric($quantity) || !is_numeric($price)){ array_push($errors, "Something is wrong with Data Types!"); }
        
        $sql = "SELECT * from product_db WHERE name = '$name' AND catagory = '$catagory' AND stock != 0";
        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res) == 0){
            array_push($errors, "You have selected Brand with wrong catagory! or We are Out Of Stock");
        }

        if(count($errors) == 0){
            $date = date("d, M Y h:i:s A");

            $sql = "INSERT into return_db (product, catagory, quantity, price, returned_at)
                    VALUES ('$name', '$catagory', '$quantity', '$price', '$date')";
            $res = mysqli_query($con, $sql);

            $sql2 = "SELECT * from product_db WHERE name = '$name' AND catagory = '$catagory'";
            $res2 = mysqli_query($con, $sql2);
            while($row = mysqli_fetch_object($res2)){
                $id = $row->pid;
                $quan = $row->stock;
                $sold = $row->sold;
                $tot = $quan + $quantity;
                $st = $sold - $quantity;
                $sql3 = "UPDATE product_db SET stock = '$tot', sold = '$st' WHERE pid = '$id'";
                $res3 = mysqli_query($con, $sql3);
            }
            if($res && $res2 && $res3){
                $success = "<p class='w-full p-3 rounded-lg text-center bg-green-400'>Order Returned!</p>";
            }else{
                array_push($errors, "Something Went Wrong!");
            }
        }
    }

?>