<div id="post-510" class="post-510 post type-post status-publish format-standard hentry category-memoriasdeunaepoca block">
    <h2>
        <span class="author"><?php echo $oPost->getUser()->getUserName(); ?></span>
        <a href="<?php echo base_url(); ?>/post/<?php echo $oPost->getSlug(); ?>"><?php $oPost->getHeadline(); ?></a>
    </h2>
    <div class="post-text">
        <?php echo $oPost->getBody(); ?>
    </div>
    <p>SONG</p>
    <p class="meta">	
        <a href="<?php echo base_url(); ?>/post/<?php echo $oPost->getSlug(); ?>#respond">Dejar comentario</a>
    </p>
</div>