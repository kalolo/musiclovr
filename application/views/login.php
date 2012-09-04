<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<section class="login">
    <h2>Iniciar Sesión</h2>
    <form name="frm_login" action="" method="POST">
        <p>
            <label for="">E-mail:</label>
            <input type="text" name="lgn_username" >
        </p>
        <p>
            <label for="">Contraseña:</label>
            <input type="password" name="lgn_password">
        </p>
        <p>
            <input type="submit" value="Entrar">
        </p>
    </form>
    <?php
    if (isset($error)) {
        echo '<div id="error_msg">' . $error . '</div>';
    }
    ?>
</section>