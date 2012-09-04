<?php if (null != $oActiveCategory) { ?>

    <section class="main">
        <h2>Agregar Rola</h2>
        <form action="<?php echo base_url(); ?>home/new_post" method="POST" enctype="multipart/form-data">
            <p>
                <label for="">Título:</label>
                <input type="text"name="headline">
            </p>
            <p>
                <label for="">Platícanos por qué escogiste esa rola:</label>
                <textarea name="post_boyd" id="text_area_post_body" rows="10">...</textarea>
            </p>
            <p>
                <label for="">Archivo de la rola: <i>sólo mp3, pretty please :)</i></label>
                <input type="file" name="song" >
            </p>
            <p>
                <input type="submit" name="add_post" value="¡Comparte!">
            </p>
        </form>
    </section>
    <section class="info">
        <h3>Tema en curso: <?php echo $oActiveCategory->getName(); ?></h3>
        <p><?php echo $oActiveCategory->getDescription(); ?></p>
    </section>

    <script type="text/javascript">
        //<![CDATA[
        bkLib.onDomLoaded(function() { 
            //nicEditors.allTextAreas() 
            new nicEditor({
                buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript','html','link','unlink','indent','outdent']
            }).panelInstance('text_area_post_body');
        });
        //]]>
    </script>
<?php } else { ?>
    <div class="post type-post status-publish format-standard hentry block">
        <h3>No hay tema activo :(</h3>
    </div>
<?php } ?>
