<?php if (null != $oActiveCategory) { ?>
<div class="home-cat-desc block">
    <h3>Tema en curso: <?php echo $oActiveCategory->getName(); ?></h3>
    <p>
    <p><?php echo $oActiveCategory->getDescription(); ?></p>
</p>
</div>
<div class="post type-post status-publish format-standard hentry block">
    <div class="post-text">
        <form id="frm_new_post" action="" method="POST">
            <p>Titulo:<input type="text" value="" name="headline" /></p>
            <p>
                <textarea id="text_area_post_body" name="post_body" style="width: 100%; height: 200px;">
                ...
                </textarea>
            </p>
            <h4>Canción</h4><input type="file" name="song" />
            <br /><br />
            <input type="submit" name="add_post" value="Comparte, comparte, comparte!!" />
            <br />
        </form>
    </div>
</div>
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
