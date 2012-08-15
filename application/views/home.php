<div class="home-cat-desc block">
    <?php if (isset($oLastActiveCat)) { ?>
        <h3><?php echo $oLastActiveCat->getName(); ?></h3>
        <p>
        <p><?php echo $oLastActiveCat->getDescription(); ?></p>
    </p>
<?php } ?>
</div>
<?php
    foreach ($arrPosts as $oPost) {
        include 'posts/view.php';
    }
?>