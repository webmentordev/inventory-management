<nav class="flex justify-between bg-white p-6 mb-4">
    <ul class="flex p-2">
        <li>
            <a class="p-3" href="index.php">Home</a>
        </li>
        <li>
            <a class="p-3" href="products.php">Products</a>
        </li>
        <li>
            <a class="p-3" href="orders.php">Orders</a>
        </li>
        <li>
            <a class="p-3" href="return.php">Returns</a>
        </li>
    </ul>

    <ul class="flex">
        <li>
            <form action="index.php" method="post" class="inline">
                <button type="submit" name="logout" class="bg-blue-500 py-2 px-4 rounded-lg text-white">Logout</button>
            </form>
        </li>
        <li class="pt-2">
            <a class="p-3 underline" href="checkout.php">Go-To-Cart</a>
        </li>
    </ul>
</nav>

<?php 
    $limit = 15;
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page = 1;
    }
    $offset = ($page - 1) * $limit;
?>