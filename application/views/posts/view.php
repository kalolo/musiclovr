<div class="post">
    <h2 class="title"><a href="<?php echo base_url(); ?>post/<?php echo $oPost->getSlug(); ?>.html"><?php echo $oPost->getHeadline(); ?></a></h2>
    <div class="content">
        <?php echo $oPost->getBody(); ?>
        <div class="footer">
            <a href="<?php echo $oPost->getFullUrl(); ?>#respond" class="comments">
                <?php echo ($oPost->getTotalComments() > 0) 
                        ? $oPost->getTotalComments()
                        : '0'; 
                ?>
            </a>
            <?php 
                $oSong = $oPost->getSong();
                if (null != $oSong) {
                    include 'song_player.php';
                }
            ?>
        </div>
    </div>
    <div class="author">
        <img src="<?php echo $oPost->getUser()->getProfileImageUrl(); ?>" alt="">
        <span><?php echo $oPost->getUser()->getFullName(); ?></span>
    </div>
</div>