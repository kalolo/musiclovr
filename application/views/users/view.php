<section class="main">
    <h2><img src="<?php echo $oUser->getProfileImageUrl(); ?>" /><?php echo $oUser->getFullName(); ?></h2>
    <section class="categories">
        <h3>Canciones:</h3>
        <ul>
            <?php foreach ($arrSongs as $oSong) { ?>
                <li>
                    <p><?php echo $oSong->getFileName() ?></p>
                </li>
            <?php } ?>
        </ul>
    </section>
</section>