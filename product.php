<?php require_once('./config/api.php') ?>
<?php 
    if(!isset($_SESSION['admin-auth']) && !isset($_COOKIE['AdminLoginID']) && !isset($_GET['p']) && !isset($_SESSION['key'])){
        header('location: login.php');
    }
    if(isset($_GET['p'])){
        $_SESSION['key'] = $_GET['p'];
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
    <title>Update Product</title>
</head>

<body class="bg-blue-500">
    <?php include('./views/nav.php') ?>
    <div class="w-full flex justify-center items-center">
        <div class="w-8/12 border-rounded p-6 bg-white rounded-lg">
            <h1 class="text-gray-500 mb-2 text-center text-2xl py-6">Update Product</h1>
            <?php 
                if(isset($_POST['update-product'])){
                    if($errors){
                        include('./config/errors.php');
                    }else{
                        echo $success;
                    }
                }
            ?>

            <?php 
                if(isset($_GET['p'])){
                    $id = $_GET['p'];
                }else{
                    $id = $_SESSION['key'];
                }
                $sql = "SELECT * from product_db WHERE pid = '$id'";
                $res = mysqli_query($con, $sql);
                while($row = mysqli_fetch_object($res)){

            ?>
            <form action="product.php" method="POST">
                <input type="hidden" class="bg-gray-200 w-full p-3 rounded-lg" value="<?php echo $id; ?>" name="id" placeholder="ID">
                <div class="my-4">
                    <h1 class="font-bold text-gray-600 mb-2">Product Name:</h1>
                    <input type="text" class="bg-gray-200 w-full p-3 rounded-lg" value="<?php echo $row->name; ?>" name="name" placeholder="Brand">
                </div>
                
                <div class="my-4">
                    <h1 class="font-bold text-gray-600 mb-2">Product Catagory:</h1>
                    <input type="text" class="bg-gray-200 w-full p-3 rounded-lg" value="<?php echo $row->catagory; ?>" name="catagory" placeholder="Catagory">
                </div>
                
                <div class="my-4">
                    <h1 class="font-bold text-gray-600 mb-2">Product Stock:</h1>
                    <input type="number" class="bg-gray-200 w-full p-3 rounded-lg" value="<?php echo $row->stock; ?>" name="stock" placeholder="Stock">
                </div>
                
                <div class="my-4">
                    <h1 class="font-bold text-gray-600 mb-2">Product Price Per Unit:</h1>
                    <input type="number" class="bg-gray-200 w-full p-3 rounded-lg" value="<?php echo $row->price; ?>" name="price" placeholder="Stock">
                </div>
                
                <div class="my-4">
                 <button type="submit" name="update-product" class="bg-blue-500 text-white py-3 px-6 rounded-lg">Update</button>
                </div>
            </form>

            <?php } ?>
        </div>
    </div>
</body>

</html>