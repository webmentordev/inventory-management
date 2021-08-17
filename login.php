<?php require_once('./config/api.php') ?>
<?php 
    if(isset($_SESSION['admin-auth']) || isset($_COOKIE['AdminLoginID'])){
        header('location: index.php');
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
    <title>Login | Admin Panel</title>
</head>

<body class="bg-blue-500">
    <div class="w-full flex justify-center items-center half">
        <div class="w-3/12 border-rounded px-6 py-8 bg-white rounded-lg">
            <h1 class="mb-6 text-gray-500 font-bold text-center text-3xl">Inventory Management</h1>
            <?php 
                if(isset($_POST['login'])){
                    if($errors){
                        include('./config/errors.php');
                    }
                }
            ?>
            <form action="login.php" method="post">
                <div class="my-4">
                    <input type="email" name="email" placeholder="Email Address" required autocomplete="off" class="p-3 rounded-lg bg-gray-200 w-full">
                </div>
                <div class="my-4">
                    <input type="password" name="password" placeholder="Password" required autocomplete="off" class="p-3 rounded-lg bg-gray-200 w-full">
                </div>
                <div class="my-4 ml-2">
                    <input type="checkbox" name="remember" id="remember">
                    <Label for="remember">Remember me</Label>
                </div>

                <div class="my-4">
                    <button type="submit" name="login" class="p-3 rounded-lg bg-blue-500 text-white w-full"><i class="fas fa-kite"></i> Login</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>