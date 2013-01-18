<section class="main">
    <section class="info">
        <h3>Imagen de perfil:</h3>
        <p>Intenta que la imagen de perfil sea cuadrada. Si usas la misma que en Twitter / Facebook mejor, porque es más reconocible.</p>
    </section>
    <h2>Mi perfil</h2>
    <form action="" method="POST">
        <input type="hidden" id="update_password" name="update_password" value="" />
        <p class="half">
            <label for="">Nombre:</label>
            <input type="text" value="<?php echo $oUser->getFirstname(); ?>" name="firstname" />
        </p>
        <p class="second half">
            <label for="">Apellido:</label>
            <input type="text" value="<?php echo $oUser->getLastname(); ?>" name="lastname" />
        </p>
        <p>
            <label for="">Twitter:</label>
            <input type="text" value="<?php echo $oUser->getTwitterHandler(); ?>" name="twitter_handler" />
            <input type="text" id="profile_iamge_url" value="<?php echo $oUser->getProfileImageUrl(); ?>" name="profile_image_url" />
        </p>
        <p>
            <input type="checkbox" id="toggle_password">Cambiar Contraseña
        </p>
        <div id="change_password">
            <p class="half">
                <label for="">Contraseña:</label>
                <input type="password" value="" name="password" />
            </p>
            <p class="second half">
                <label for="">Repetir contraseña:</label>
                <input type="password" value="" name="password2" />
            </p>
        </div>
        <p>
            <input type="submit" name="btn_add" value="Guardar cambios">
        </p>
    </form>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $('#change_password').hide();
        $('#toggle_password').click(function(){
            if(this.checked){
                $('#change_password').show()
                $('#update_password').val(1);
            } else {
                $('#change_password').hide()
                $('#update_password').val(0);
            }
        });
    });
</script>