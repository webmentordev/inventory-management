<?php require_once('./config/api.php') ?>
<?php 
    if(!isset($_SESSION['admin-auth']) && !isset($_COOKIE['AdminLoginID'])){
        header('location: login.php');
    }
?>
<?php 
    $sql = "SELECT * FROM product_db";
    $res = mysqli_query($con, $sql);

    $sql = "SELECT * FROM product_db";
    $total = mysqli_num_rows(mysqli_query($con, $sql));

    $price = 0;
    $stock = 0;
    if(mysqli_num_rows($res) > 0){
        while($row = mysqli_fetch_assoc($res)){
            $stock += $row['stock'];
            $price += $stock * $row['price'];
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
    <title>Products | Admin Panel</title>
</head>

<body class="bg-blue-500">
    <?php include('./views/nav.php') ?>
    <div class="w-full flex justify-center items-center">
        <div class="w-8/12 border-rounded p-6 bg-white rounded-lg">
            <div class="flex items-center justify-center">
                <h1 class="text-gray-500 mb-2 text-center text-2xl py-6">Products Management</h1>
                <a class="mx-3 py-2 px-4 text-white bg-blue-500 rounded-lg " href="addproduct.php">Add Product</a>
            </div>
            <div class="mygrid mygrid-2">
                <div class="box">
                    <h1>Total Stock Price</h1>
                    <p>PKR: <?php echo number_format($price); ?></p>
                </div>

                <div class="box">
                    <h1>Total Brands</h1>
                    <p><?php echo $total; ?> Brands</p>
                </div>
            </div>

            <div class="py-2">
                <form action="products.php" method="get" class="flex">
                    <input class="w-full p-3 bg-gray-200 rounded-lg" type="text" name="search" placeholder="Search Product">
                    <button type="submit"><i class="fas fa-search text-white bg-blue-500 py-4 px-4 rounded-lg ml-2"></i></button>
                </form>
            </div>

            <div class="border rounded-sm">
                <table class="w-full text-center table">
                    <tr class="border-b-2">
                        <th>Brand</th>
                        <th>Catagory</th>
                        <th>Price Per Unit</th>
                        <th>Stock</th>
                        <th>Sold</th>
                        <th>Returned</th>
                        <th>Created_At</th>
                        <th>Stock_Updated</th>
                        <th>Action</th>
                    </tr>
                    <?php 
                        if(isset($_GET['search'])){
                            $search = $_GET['search'];
                            $sql = "SELECT * from product_db WHERE name LIKE '%$search%'";
                        }else{
                            $sql = "SELECT * from product_db ORDER BY pid desc LIMIT $offset, $limit";
                        }
                        $res = mysqli_query($con, $sql);
                        if(mysqli_num_rows($res) > 0){
                            while($row = mysqli_fetch_object($res)){
                                $pname = $row->name;
                                $returnSQL = "SELECT * from return_db WHERE product = '$pname'";
                                $returnedResult = mysqli_num_rows(mysqli_query($con, $returnSQL));
                    ?>
                    <tr>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->catagory; ?></td>
                        <td><?php echo $row->price; ?></td>
                        <td><?php echo $row->stock; ?> Units</td>
                        <td><?php echo $row->sold; ?> Units</td>
                        <td><?php echo $returnedResult; ?></td>
                        <td><?php echo $row->created_at; ?></td>
                        <td><?php echo $row->stock_updated; ?></td>
                        <td><a href="product.php?p=<?php echo $row->pid; ?>">Update</a></td>
                    </tr>

                    <?php } } ?>
                </table>

                <?php
                    $sql = "SELECT COUNT(*) from product_db";
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
                            <form action="products.php" method="GET">
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