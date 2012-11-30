<div class="category">
        <h3>Categoría: <?php echo $oPost->getCategory()->getName(); ?></h3>
        <p><?php echo $oPost->getCategory()->getDescription(); ?></p>
</div>

<div class="post">
    <h2 class="title"><?php echo $oPost->getHeadline(); ?></h2>
    <div class="content">
        <?php echo $oPost->getBody(); ?>
        <div class="footer">
            <?php 
                $oSong = $oPost->getSong();
                if (null != $oSong) {
                    include 'song_player.php';
                }
            ?>
        </div>
    </div>
    <div class="author">
        <span><?php echo $oPost->getUser()->getFullName(); ?></span>
    </div>
</div>

<?php
    include 'comments/new.php';
?>
