<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<section class="main">
    <h2>Agregar nuevo tema</h2>
    <form id="commentform" name="frm_add_category" action="" method="POST">
        <p>
            <label for="">Nombre:</label>
            <input type="text" value="" name="category_name" />
        </p>
        <p>
            <label for="">Descripción:</label>
            <textarea id="comment" rows="10" aria-required="true" name="category_description"></textarea>
        </p>
        <p>
            <input type="submit" name="btn_add" value="Agregar!" />
        </p>
    </form>
    <section class="categories">
        <h3>Temas:</h3>
        <ul>

            <?php foreach ($arrCategories as $oCat) { ?>
                <li>
                    <h4><?php echo $oCat->getName(); ?></h4>
                    <p>Descripci&oacute;n: <?php echo $oCat->getDescription(); ?></p>
                    <p class="meta">Agregada por: <?php echo $oCat->getUser()->getFullName(); ?></p>
                </li>
            <?php } ?>
        </ul>
    </section>
</section>
<section class="info">
    <h3>Al agregar temas:</h3>
    <p>Intenta que sea lo suficientemente subjetivo para que cada quien se aviente un viaje. Ejemplo: es mejor "Recuerdos de la infancia" que "Canciones cantadas por payasos".</p>
</section>