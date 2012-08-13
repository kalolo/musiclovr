<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form name="frm_login" action="" method="POST">
    <h1>Login</h1>
    <p>Email: <input type="text" value="" name="lgn_username" /></p>
    <p>Contrase&ntilde;a: <input type="password" value="" name="lgn_password" /></p>
    <input type="submit" value="Login" />
</form>
<?php
if(isset($error)) {
   echo '<div id="error_msg">'. $error. '</div>';
}
?>