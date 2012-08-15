<li class="comment byuser comment-author-mariana even thread-even depth-1" id="li-comment-318">
    <div id="comment-318">
        <div class="comment-gravatar">
            <img src='<?php echo $oComment->getUser()->getProfileImageUrl(); ?>' class='avatar avatar-50 avatar-default' height='50' width='50' style='width: 50px; height: 50px;' alt='avatar' />
        </div>

        <div class="comment-body">
            <div class="comment-meta commentmetadata">
                <cite class="fn"><?php echo $oComment->getUser()->getFullName(); ?></cite>
                <span class="moreinfo"><?php echo $oComment->getCreated(); ?></span>
            </div>
            <p><?php echo $oComment->getBody(); ?></p>
            <div class="reply"></div>
        </div>
    </div>
</li>
