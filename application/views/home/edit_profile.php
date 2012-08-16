<div class="home-cat-desc block">
    <h3>Editar mi perfil</h3>
</div>


<div class="post-510 post type-post status-publish format-standard hentry block">
    <div class="post-text">
        <form id="commentform" name="frm_edit_profile" action="" method="POST">
            <label>Nombre:</label><br />
            <input style="width: 300px;" type="text" value="<?php echo $oUser->getFirstname(); ?>" name="firstname" /><br />
            
            <label>Apellido:</label><br />
            <input style="width: 300px;" type="text" value="<?php echo $oUser->getLastname(); ?>" name="lastname" /><br />
            
            <label>Profile Image Url:</label><br />
            <input style="width: 300px;" type="text" value="<?php echo $oUser->getProfileImageUrl(); ?>" name="image_url" /><br />
            <input type="submit" name="btn_add" value="Editar!" />
        </form>
    </div>
</div>