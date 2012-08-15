<div class="home-cat-desc block">
        <h3>Canciones del tema: <?php echo $oCategory->getName(); ?></h3>
        <p>
        <p><?php echo $oCategory->getDescription(); ?></p>
    </p>
</div>
<?php
    foreach ($arrPosts as $oPost) {
        include 'posts/view.php';
    }
?>
