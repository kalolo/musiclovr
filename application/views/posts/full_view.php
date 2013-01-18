<div class="category">
        <h3>Categoría: <?php echo $oPost->getCategory()->getName(); ?></h3>
        <p><?php echo $oPost->getCategory()->getDescription(); ?></p>
</div>

<div class="post single">
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
        <img src="<?php echo $oPost->getUser()->getProfileImageUrl(); ?>" alt="">
        <span><?php echo $oPost->getUser()->getFullName(); ?></span>
    </div>
</div>
<?php if($isOwner) { ?>
    <div id="edit_post">
        <a href="<?php echo base_url().'home/editpost/'.$oPost->getId(); ?>">Editar</a>
    </div>
    <?php } ?>
<?php
    include 'comments/new.php';
?>
