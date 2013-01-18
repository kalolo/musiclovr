<div class="commentsblock block">
    <div id="comments-content" class="clearfix">
        <h3 id="comments">
                Comentarios <?php echo $oPost->getTotalComments(); ?>
            </h3>
        <ol class="commentlist">
        <?php
            $arrComments = $oPost->getComments();
            foreach ($arrComments as $oComment) {
                include 'view.php';
            }
        ?>
        </ol>
        <div id="respond">
            <h3 id="reply-title">¡Comenta! 
                <small>
                    <a rel="nofollow" id="cancel-comment-reply-link" href="<?php echo base_url(); ?>post/<?php echo $oPost->getSlug(); ?>/#respond" style="display:none;">Cancel reply</a>
                </small>
            </h3>
            <form action="<?php echo base_url(); ?>comment/add" method="post" id="commentform">
                <p class="comment-form-comment">
                    <textarea id="comment" name="comment" rows="8" aria-required="true"></textarea>
                </p>												
                <p class="form-submit">
                    <input name="submit" type="submit" id="submit" value="Post Comment" />
                    <input type='hidden' name='post_id' value='<?php echo $oPost->getId(); ?>' id='comment_post_ID' />
                </p>
            </form>
        </div><!-- #respond -->

    </div>
</div>
