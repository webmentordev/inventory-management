<?php require_once('./config/api.php') ?>
<?php 
    if(!isset($_SESSION['admin-auth']) && !isset($_COOKIE['AdminLoginID'])){
        header('location: login.php'); 
    }

    $p_total = 0;

    
?>

<?php 
    if(isset($_GET['print'])){
        $id = $_GET['print'];
        $sql = "SELECT * from orders_db WHERE oid = '$id'";
        $res2 = mysqli_query($con, $sql);
        while($row = mysqli_fetch_object($res2)){
            $name = $row->fullname;
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
    <title>Invoice | Admin Panel</title>
</head>

<body>
    <div>
        <div style="max-width: 650px; margin: auto; position: relative">
            <img class="haji" src="./img/hajilogo.png" style="left: 20%; top: 30%; transform: rotate(45deg); opacity: 0.05; position: absolute;">
            <h1 class="text-gray-500 mb-2 text-center text-2xl py-6">Invoice</h1>
            <?php if(isset($_SESSION['cart'])){
                if(count($_SESSION['cart']) != 0) {
                ?>

            <div class="flex justify-between">
                    <h2 class="mb-3 font-bold">Name: <span class="font-medium underline py-1"><?php echo $_SESSION['cart'][0]['fullname']; ?></span></h2>
                </div>
                <div class="border rounded-sm mb-2">
                    <table class="w-full text-center table">
                        <tr class="border-b-2">
                            <th>ProductName</th>
                            <th>Catagory</th>
                            <th>Quantity</th>
                            <th>Price Per Unit</th>
                            <th>Order Date</th>
                        </tr>
                        <?php if(isset($_SESSION['cart'])){
                                foreach($_SESSION['cart'] as $key => $pros){
                                    $pop =  $pros['price'] * $pros['quantity'];
                                    $p_total = $p_total + $pop;
                            ?>
                            <tr>
                                <td><?php echo $pros['name']; ?></td>
                                <td><?php echo $pros['catagory']; ?></td>
                                <td><?php echo $pros['quantity']; ?> Units</td>
                                <td><?php echo $pros['price']; ?></td>
                                <td><?php echo date("d, M Y H:i:s"); ?></td>
                            </tr>
                        <?php } }?>
                    </table>
                </div>
                <h1 class="font-bold">Total Price: <span class="font-medium underline"> <?php $pop =  $pros['price'] * $pros['quantity'];
                                    $p_total = $p_total + $pop; 
                                    echo $p_total; ?></span></h1>
            </div>
            <?php } }?>


            <div style="max-width: 650px; margin: auto;">
            <?php if(isset($_GET['print'])){?>
                <div class="flex justify-between">
                    <h2 class="mb-3 font-bold">Name: <span class="font-medium underline py-1"><?php if(isset($_GET['print'])){ echo $name; } ?></span></h2>
                </div>
                <div class="border rounded-sm mb-2">
                    <table class="w-full text-center table">
                        <tr class="border-b-2">
                            <th>ProductName</th>
                            <th>Catagory</th>
                            <th>Quantity</th>
                            <th>Price Per Unit</th>
                            <th>Order Date</th>
                        </tr>
                        <?php 
                            $res = mysqli_query($con, $sql);
                            while($row = mysqli_fetch_object($res)){
                                $total_price = $row->total_price;
                        ?>
                            <tr>
                                <td><?php echo $row->product; ?></td>
                                <td><?php echo $row->catagory; ?></td>
                                <td><?php echo $row->quantity; ?> Units</td>
                                <td><?php echo $row->price_per_unit; ?></td>
                                <td><?php echo date("d, M Y H:i:s"); ?></td>
                            </tr>
                        <?php }  ?>
                    </table>
                </div>
                <h1 class="font-bold">Total Price: <span class="font-medium underline"><?php echo number_format($total_price)?></span></h1>
                </div>
            <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>