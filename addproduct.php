<?php require_once('./config/api.php') ?>
<?php 
    if(!isset($_SESSION['admin-auth']) && !isset($_COOKIE['AdminLoginID'])){
        header('location: login.php');
    }
?>
<?php 
    $sql = "SELECT * FROM product_db";
    $res = mysqli_query($con, $sql);

    $sql = "SELECT COUNT(*) FROM product_db";
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
    <title>Add Product | Admin Panel</title>
</head>

<body class="bg-blue-500">
    <?php include('./views/nav.php') ?>
    <div class="w-full flex justify-center items-center">
        <div class="w-6/12 border-rounded p-6 bg-white rounded-lg">
            <h1 class="text-gray-500 mb-2 text-center text-2xl py-6">Insert Products</h1>
            <?php 
                if(isset($_POST['addproduct'])){
                    if($errors){
                        include('./config/errors.php');
                    }else{
                        echo $success;
                    }
                }
            ?>
            <?php 
                if(isset($_POST['update-stock'])){
                    if($errors){
                        include('./config/errors.php');
                    }else{
                        echo $success;
                    }
                }
            ?>
            <form action="addproduct.php" method="POST">
                <div class="my-4">
                    <input type="text" class="bg-gray-200 w-full p-3 rounded-lg" name="name" placeholder="Product Name">
                </div>
                <div class="my-4">
                    <input type="number" class="bg-gray-200 w-full p-3 rounded-lg" name="stock" placeholder="Stock">
                </div>
                <div class="my-4">
                    <input type="text" class="bg-gray-200 w-full p-3 rounded-lg" name="catagory" placeholder="Catagory">
                </div>
                <div class="my-4">
                    <input type="number" class="bg-gray-200 w-full p-3 rounded-lg" name="price" placeholder="Price Per Unit">
                </div>
                <div class="my-4">
                 <button type="submit" name="addproduct" class="bg-blue-500 text-white py-3 px-6 rounded-lg">Submit</button>
                </div>
            </form>

            <h1 class="text-gray-500 mb-2 text-center text-2xl py-6">Update Product Stock</h1>
            <?php 
                if(isset($_POST['update-product'])){
                    if($errors){
                        include('./config/errors.php');
                    }else{
                        echo $success;
                    }
                }
            ?>
            <form action="addproduct.php" method="POST">
                <div class="my-4 flex">
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
                    <input type="number" class="ml-2 bg-gray-200 w-full p-3 rounded-lg" name="stock" placeholder="Add-In-Stock">
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
                 <button type="submit" name="update-stock" class="bg-blue-500 text-white py-3 px-6 rounded-lg">Update</button>
                </div>
            </form>

            <div class="border rounded-sm">
                <table class="w-full text-center table">
                    <tr class="border-b-2">
                        <th>Brand</th>
                        <th>Catagory</th>
                        <th>Stock</th>
                        <th>Created_At</th>
                    </tr>
                    <?php 
        
                        $sql = "SELECT * from record_db";
                        $res = mysqli_query($con, $sql);
                        if(mysqli_num_rows($res) > 0){
                            while($row = mysqli_fetch_object($res)){  
                    ?>
                    <tr>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->catagory; ?></td>
                        <td><?php echo $row->stock; ?> Units</td>
                        <td><?php echo $row->created_at; ?></td>
                    </tr>

                    <?php } } ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>