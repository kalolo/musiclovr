<section class="main">
    <h2>Editar</h2>
    <form action="<?php echo base_url(); ?>home/editpost/<?php echo $oPost->getId(); ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $oPost->getId(); ?>" />
        <p>
            <label for="">Título:</label>
            <input type="text"name="headline" value="<?php echo $oPost->getHeadline(); ?>" >
        </p>
        <p>
            <label for="">Platícanos por qué escogiste esa rola:</label>
            <textarea name="post_body" id="text_area_post_body" rows="10"><?php echo $oPost->getBody(); ?></textarea>
        </p>
        <p>
            Sobrescribir rola<input type="checkbox" name="override" />
            <label for="">Archivo de la rola: <i>sólo mp3, pretty please :)</i></label>
            <input type="file" name="song" >
        </p>
        <p> 
            <input type="submit" name="edit_post" value="Actualizar">
        </p>
    </form>
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