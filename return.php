<?php require_once('./config/api.php') ?>
<?php 
    if(!isset($_SESSION['admin-auth']) && !isset($_COOKIE['AdminLoginID'])){
        header('location: login.php');
    }
?>
<?php 

    $sql = "SELECT * FROM return_db";
    $total = mysqli_query($con, $sql);

    $price = 0;
    if(mysqli_num_rows($total) > 0){
        while($row = mysqli_fetch_object($total)){
            $price += $row->price;
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
                <h1 class="text-gray-500 mb-2 text-center text-2xl py-6">Returns Management</h1>
            </div>
            <div class="mygrid mygrid-2">
                <div class="box">
                    <h1>Total Returned Price</h1>
                    <p>PKR: <?php echo number_format($price); ?></p>
                </div>
            </div>
            <div class="border rounded-sm">
                <table class="w-full text-center table">
                    <tr class="border-b-2">
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Catagory</th>
                        <th>Returned_At</th>    
                    </tr>
                    <?php 
                        $sql = "SELECT * from return_db ORDER BY id desc LIMIT $offset, $limit";
                        $res = mysqli_query($con, $sql);
                        if(mysqli_num_rows($res) > 0){
                            while($row = mysqli_fetch_object($res)){
                    ?>
                    <tr>
                        <td><?php echo $row->product; ?></td>
                        <td><?php echo $row->price; ?> Units</td>
                        <td><?php echo $row->quantity; ?></td>
                        <td><?php echo $row->catagory; ?></td>
                        <td><?php echo $row->returned_at; ?></td>
                    </tr>

                    <?php } } ?>
                </table>

                <?php
                    $sql = "SELECT COUNT(*) from return_db";
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
                            <form action="return.php" method="GET">
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

            <?php 
                if(isset($_POST['return'])){
                    if($errors){
                        include('./config/errors.php');
                    }else{
                        echo $success;
                    }
                }
            ?>
            <form action="return.php" method="POST">
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
                    <button type="submit" name="return" class="bg-blue-500 text-white py-3 px-6 rounded-lg">Return</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>