<?php require_once('./config/api.php') ?>
<?php 
    if(!isset($_SESSION['admin-auth']) && !isset($_COOKIE['AdminLoginID'])){
        header('location: login.php');
    }
?>
<?php 

    $sql = "SELECT * FROM orders_db";
    $total = mysqli_query($con, $sql);

    $price = 0;
    if(mysqli_num_rows($total) > 0){
        while($row = mysqli_fetch_object($total)){
            $price += $row->total_price;
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
    <title>Orders | Admin Panel</title>
</head>

<body class="bg-blue-500">
    <?php include('./views/nav.php') ?>
    <div class="w-full flex justify-center items-center">
        <div class="w-8/12 border-rounded p-6 bg-white rounded-lg">
            <div class="flex items-center justify-center">
                <h1 class="text-gray-500 mb-2 text-center text-2xl py-6">Orders Manager</h1>
            </div>

            

            <div class="mygrid mygrid-2">
                <div class="box">
                    <h1>Total Orders Price</h1>
                    <p>PKR: <?php echo number_format($price); ?></p>
                </div>
            </div>
            <div class="border rounded-sm">
                <table class="w-full text-center table">
                    <tr class="border-b-2">
                        <th>Fullname</th>
                        <th>Quantity</th>
                        <th>Product</th>
                        <th>Catagory</th>
                        <th>Price/Unit</th>
                        <th>Total Price</th>
                        <th>Created_At</th>    
                        <th>Invoice</th>
                    </tr>
                    <?php 
                        $sql = "SELECT * from orders_db ORDER BY oid desc LIMIT $offset, $limit";
                        $res = mysqli_query($con, $sql);
                        if(mysqli_num_rows($res) > 0){
                            while($row = mysqli_fetch_object($res)){
                    ?>
                    <tr>
                        <td><?php echo $row->fullname; ?></td>
                        <td><?php echo $row->quantity; ?> Units</td>
                        <td><?php echo $row->product; ?></td>
                        <td><?php echo $row->catagory; ?></td>
                        <td><?php echo $row->price_per_unit; ?></td>
                        <td>PKR: <?php echo $row->total_price; ?></td>
                        <td><?php echo $row->created_at; ?></td>
                        <td><a href="print.php?print=<?php echo $row->oid; ?>" target="_blank"><i class="fas fa-print"></i></a></td>
                    </tr>

                    <?php } } ?>
                </table>

                <?php
                    $sql = "SELECT COUNT(*) from orders_db";
                    $res = mysqli_query($con, $sql);
                    $total_rows = mysqli_fetch_array($res)[0];
                    $total_page = ceil($total_rows / $limit);
                ?>
                <div class="pagination">
                    <ul>
                        <li>
                            <a class="nav-link" href="<?php if($page <= 1){echo '#';}else{echo "?page=".$page -1;} ?>"><i class="fas fa-caret-left"></i></a>
                        </li>
                        <li>
                            <form action="orders.php" method="GET">
                                <select name="page" onchange="this.form.submit()">
                                    <?php 
                                        echo "<option value='$page'>Active:".$page."</option>";
                                        for($i = 1; $i <= $total_page; $i++){
                                            echo "<option value='$i'>".$i."</option>";
                                        }
                                    ?>
                                </select>
                            </form>
                        </li>
                        <li>
                            <a class="nav-link" href="<?php if($page == $total_page ){echo '#';}else{echo "?page=".$page + 1;} ?>"><i class="fas fa-caret-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

</html>