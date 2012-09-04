<div class="home-cat-desc block">
        <h3>Tema: <?php echo $oPost->getCategory()->getName(); ?></h3>
        <p>
        <p><?php echo $oPost->getCategory()->getDescription(); ?></p>
    </p>
</div>
<div class="post type-post status-publish format-standard hentry block">
    <h2>
        <span class="author"><?php echo $oPost->getUser()->getFullName(); ?></span>
        <a href="<?php echo base_url(); ?>post/<?php echo $oPost->getSlug(); ?>"><?php echo $oPost->getHeadline(); ?></a>
    </h2>
    <div class="post-text">
        <?php echo $oPost->getBody(); ?>
    </div>
    <div class="post-text">
        <?php 
        $oSong = $oPost->getSong();
        if (null != $oSong) {
            include 'song_player.php';
        }
        ?>
    </div><br />
    <p class="meta">&nbsp;&nbsp;
    </p>
</div>
<?php
    include 'comments/new.php';
?>
