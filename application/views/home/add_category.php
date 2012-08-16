<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="home-cat-desc block">
    <h3>Agregar una nueva categoría</h3>
</div>


<div id="post-510" class="post-510 post type-post status-publish format-standard hentry category-memoriasdeunaepoca block">
    <div class="post-text">
        <form id="commentform" name="frm_add_category" action="" method="POST">
            <label>Nombre:</label><br />
            <input style="width: 200px;" type="text" value="" name="category_name" /><br />
            <label>Descripción:</label><textarea id="comment" rows="8" aria-required="true" name="category_description"></textarea>
            <br />   
            <input type="submit" name="btn_add" value="Agregar!" />
        </form>
    </div>
    
    <div id="category_list">
        <h3>Categorias:</h3>
        <?php foreach ($arrCategories as $oCat)  { ?>
        <p>
           <p><?php echo $oCat->getName(); ?><br />
           Descripci&oacute;n: <?php echo $oCat->getDescription(); ?><br />
           Fecha: <?php echo $oCat->getCreated(); ?><br />
           Por: <?php echo $oCat->getUser()->getFullName(); ?></p>
        </p>
        <?php } ?>
    </div>
</div>