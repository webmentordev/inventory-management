<?php if(count($errors) > 0): ?>
    <ul class="w-full p-3 bg-red-400 rounded-lg text-center text-white">
        <?php foreach($errors as $error): ?>
            <li class="my-2"><?php echo $error; ?></li>
        <?php endforeach ?>
    </ul>
<?php endif ?>