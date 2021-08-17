<?php require_once('./config/api.php') ?>
<?php
    
    if(!isset($_SESSION['admin-auth']) && !isset($_COOKIE['AdminLoginID'])){
        header('location: login.php');
    }


    if(isset($_GET['empty'])){
        unset($_SESSION['cart']);
    }

    if(isset($_GET['remove'])){
        $id = $_GET['remove'];
        foreach($_SESSION['cart'] as $k => $part){
            if($id == $part['id']){
                unset($_SESSION['cart'][$k]);
            }
        }
    }

    $total = 0;
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
            <h1 class="text-gray-500 mb-2 text-center font-bold text-2xl py-6">Checkout Cart</h1>
            <div class="table w-full">
                <a class="text-white bg-red-500 py-2 px-3 rounded-lg" href="checkout.php?empty=1">EmptyCart</a>
                <?php 
                    if(isset($_POST['order'])){
                        if($errors){
                            echo "<p class='bg-red-400 p-2 rounded-lg text-center text-white'>Cart is Empty. Add Product</p>";
                        }else{
                            echo $success;
                        }
                    }
                ?>
                <table class="w-full text-center pt-3">
                    <tr>
                        <th>Name</th>
                        <th>Catagory</th>
                        <th>PricePerUnit</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Remove</th>
                    </tr>

                    <?php if(isset($_SESSION['cart'])) :?>
                        <?php foreach($_SESSION['cart'] as $k => $item) :?>
                            <tr>
                                <td><?php echo $item['name']; ?></td>
                                <td><?php echo $item['catagory']; ?></td>
                                <td><?php echo $item['price'] ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td><?php echo $item['price'] * $item['quantity']; 
                                                $pro = $item['price'] * $item['quantity'];
                                                $total = $total + $pro;?></td>
                                <td><a href="checkout.php?remove=<?php echo $item['id']; ?>"><i class="fas fa-times"></i></a></td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </table>
                
                <div class="total">
                    <h2 class="font-bold">Total Rs: <span class="text-blue-500"><?php echo number_format($total); ?></span></h2>
                </div>

                <div class="flex justify-between">
                    <form action="checkout.php" method="post">
                        <button type="submit" name="order" class="bg-blue-500 text-white rounded-lg py-2 px-3">OrderNow</button>
                        
                    </form>

                    <a class="bg-blue-500 py-2 px-3 text-white" href="print.php" target="_blank"><i class="fas fa-print"></i></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>