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
            <br />
            Cambiar Contraseña<input type="checkbox" name="update_password" id="toggle_password" />
            <div id="change_password">
                <br />
                <label>Contrasña:</label><br />
                <input style="width: 300px;" type="password" value="" name="password" /><br />
                <label>Repetir Contrasña:</label><br />
                <input style="width: 300px;" type="password" value="" name="password2" /><br />
            </div>
            <br />
            <input type="submit" name="btn_add" value="Editar!" />
            <?php 
                if (isset($error_msg)) {
                    echo '<div id="error_msg">'.$error_msg.'</div>';        
                }
            ?>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#change_password').hide();
        
        $('#toggle_password').click(function(){
           if(this.checked){
               $('#change_password').show()
           } else {
               $('#change_password').hide()
           }
        });
    });

</script>