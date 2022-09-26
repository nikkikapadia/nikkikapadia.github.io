<?php if(count($lErrors) > 0): 

// used in login validation. any error passed into the lErrors array gets displayed

?>
    <div class="error">
        <?php foreach ($lErrors as $error): ?>
            <li><?php echo $error; ?></li>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
