<?php require_once('./config/api.php') ?>
<?php 
    if(!isset($_SESSION['admin-auth']) && !isset($_COOKIE['AdminLoginID'])){
        header('location: login.php');
    }
?>
<?php 
    $sql = "SELECT * FROM product_db";
    $res = mysqli_query($con, $sql);

    $sql2 = "SELECT * FROM product_db";
    $total = mysqli_num_rows(mysqli_query($con, $sql2));

    $sql3 = "SELECT DISTINCT name FROM product_db";
    $brand = mysqli_num_rows(mysqli_query($con, $sql3));

    $sql4 = "SELECT * FROM return_db";
    $returned = mysqli_num_rows(mysqli_query($con, $sql4));

    $sql5 = "SELECT * FROM orders_db";
    $ordered = mysqli_num_rows(mysqli_query($con, $sql5));

    $price = 0;
    $stock = 0;
    if(mysqli_num_rows($res) > 0){
        while($row = mysqli_fetch_assoc($res)){
            $stock += $row['stock'];
            $price += $stock * $row['price'];
        }
    }

    $sql = "SELECT * FROM orders_db";
    $totalRes = mysqli_query($con, $sql);

    $orderprice = 0;
    if(mysqli_num_rows($totalRes) > 0){
        while($row = mysqli_fetch_object($totalRes)){
            $orderprice += $row->total_price;
        }
    }


    if(isset($_POST['add-to-cart'])){
        $cart_errors = array();
        $fullname = htmlspecialchars(mysqli_real_escape_string($con, $_POST['fullname']));
        $name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['name']));
        $quantity = htmlspecialchars(mysqli_real_escape_string($con, $_POST['quantity']));
        $catagory = htmlspecialchars(mysqli_real_escape_string($con, $_POST['catagory']));
        $price = htmlspecialchars(mysqli_real_escape_string($con, $_POST['price']));

        if(empty($quantity) || empty($fullname) ||empty($name) || empty($catagory)|| empty($price)){array_push($errors, "Fields are Empty");}

        if(!is_numeric($quantity) || !is_numeric($price)){ array_push($cart_errors, "Something is wrong with Data Types!"); }

        $sql = "SELECT * from product_db WHERE name = '$name' AND catagory = '$catagory' AND stock != 0";
        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res) == 0){
            array_push($cart_errors, "You have selected Brand with wrong catagory! or We are Out Of Stock");
        }

        if(count($cart_errors) == 0){
            $_SESSION['cart'][] = array(
                'id' => rand(100,100000),
                'fullname' => $fullname,
                'name' => $name,
                'catagory' => $catagory,
                'price' => $price,
                'quantity' => $quantity,
            );
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="./img/logo.jpg" type="image/x-icon">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="./css/styling.css">
    <title>Home Page | Admin Panel</title>
</head>

<body class="bg-blue-500">
    <?php include('./views/nav.php') ?>
    <div class="w-full flex justify-center items-center">
        <div class="w-6/12 border-rounded p-6 bg-white rounded-lg">
            <h1 class="text-gray-500 mb-2 text-center text-2xl py-6">Welcome <span class="font-bold"><?php if(isset($_SESSION['admin-auth'])){ echo $_SESSION['admin-auth']; } ?></span>, To Inventory Management</h1>
            <div class="mygrid">
                <div class="box">
                    <h1>Total Stock Price</h1>
                    <p>PKR: <?php echo number_format($price); ?></p>
                </div>
                <div class="box">
                    <h1>Total Brands</h1>
                    <p><?php echo $brand; ?> Brands</p>
                </div>

                <div class="box">
                    <h1>Total Catagories</h1>
                    <p><?php echo $total; ?> Catagories</p>
                </div>

                <div class="box">
                    <h1>Total Returned</h1>
                    <p><?php echo $returned; ?> Units</p>
                </div>

                <div class="box">
                    <h1>Total Stock</h1>
                    <p><?php echo $stock; ?> Units</p>
                </div>

                <div class="box">
                    <h1>Total Orders Completed</h1>
                    <p><?php echo $ordered; ?> Orders</p>
                </div>

                <div class="box">
                    <h1>Total Orders Price</h1>
                    <p>PKR: <?php echo $orderprice; ?></p>
                </div>
            </div>

            <?php 
                if(isset($_POST['add-to-cart'])){
                    if($cart_errors){
                        echo "<p class='bg-red-400'>Fields are empty or Wrong Product/Catagory Combination</p>";
                    }
                }
            ?>
            <form action="index.php" method="POST">
                <div class="my-4">
                    <input type="text" class="bg-gray-200 w-full p-3 rounded-lg" id="fullname" name="fullname" placeholder="Fullname" required>
                </div>
                <div class="my-4">
                <input list="name-list" name="name" class="bg-gray-200 w-full p-3 rounded-lg" autocomplete="off" placeholder="Product Name" required />
                    <datalist id="name-list">
                        <?php 
                            $sql = "SELECT DISTINCT name from product_db";
                            $res = mysqli_query($con, $sql);
                            if(mysqli_num_rows($res) > 0){
                                while($row = mysqli_fetch_object($res)){
                                    echo "<option value='".$row->name."' />";
                                }
                            }else{
                                echo "<option value='No Data Found' />";
                            }
                        ?>
                    </datalist>     
                </div>
                <div class="my-4">
                    <input type="number" class="bg-gray-200 w-full p-3 rounded-lg" id="quantity" name="quantity" placeholder="Quantity" required>
                </div>
                <div class="my-4">
                    <input list="catagory-list" name="catagory" class="bg-gray-200 w-full p-3 rounded-lg" autocomplete="off" placeholder="Catagory Name" required />
                        <datalist id="catagory-list">
                            <?php 
                                $sql = "SELECT DISTINCT catagory from product_db";
                                $res = mysqli_query($con, $sql);
                                if(mysqli_num_rows($res) > 0){
                                    while($row = mysqli_fetch_object($res)){
                                        echo "<option value='".$row->catagory."' />";
                                    }
                                }else{
                                    echo "<option value='No Data Found' />";
                                }
                            ?>
                        </datalist>     
                </div>
                <div class="my-4">
                    <input type="number" class="bg-gray-200 w-full p-3 rounded-lg" id="price" name="price" placeholder="Price Per Unit" required>
                </div>
                <div class="my-4">
                    <button type="submit" name="add-to-cart" class="bg-blue-500 text-white py-3 px-6 rounded-lg relative">Add-To-Cart <i class="fas fa-shopping-cart fa-fw"></i> <span class="absolute -mt-6 ml-2 py-1 px-3 rounded-full bg-red-500"><?php if(isset($_SESSION['cart'])){ echo count($_SESSION['cart']); }else{ echo '0';} ?></span></button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>