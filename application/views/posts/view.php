<div id="post-510" class="post-510 post type-post status-publish format-standard hentry category-memoriasdeunaepoca block">
    <h2>
        <span class="author"><?php echo $oPost->getUser()->getFullName(); ?></span>
        <a href="<?php echo base_url(); ?>post/<?php echo $oPost->getSlug(); ?>.html"><?php echo $oPost->getHeadline(); ?></a>
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
    </div>
        <p class="meta">
            <a href="<?php echo $oPost->getFullUrl(); ?>#respond">
                <?php echo ($oPost->getTotalComments() > 0) 
                        ? 'Comentarios '. $oPost->getTotalComments()
                        : 'Dejar comentario'; 
                ?>
            </a>
        </p>
</div>