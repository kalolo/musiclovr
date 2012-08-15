<div class="home-cat-desc block">
    <h3>Asignar la categoria activa</h3>
</div>


<div id="post-510" class="post-510 post type-post status-publish format-standard hentry category-memoriasdeunaepoca block">
    <div id="data_list">
        <form name="frm_active_category" action="" method="POST">
        <table>
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Categoria</th>
                    <th>Descripcion</th>
                    <th>Creada</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($arrCategories as $oCat) {
                    ?>
                    <tr>
                        <td><input type="radio" name="category" value="<?php echo $oCat->getId(); ?>" /></td>
                        <td><?php echo $oCat->getName(); ?></td>
                        <td><?php echo $oCat->getDescription(); ?></td>
                        <td><?php echo $oCat->getCreated(); ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
            <lable>Dias</label><input type="text" value="7" name="active_days" />
            <input type="submit" value="Activar!" />
        </form>
    </div>
</div>