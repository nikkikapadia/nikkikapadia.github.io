<?php if(count($errors) > 0): 

// used in registration validation

?>
    <div class="error">
        <?php foreach ($errors as $error): ?>
            <li><?php echo $error; ?></li>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
