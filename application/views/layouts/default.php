<!DOCTYPE html>
<html dir="ltr" lang="en-US">
    <head>
        <base href="<?php echo base_url(); ?>" />
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
        <title>Music Lovr | Una comunidad de amantes de la música</title>
        <link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all" />
        <script charset="utf-8" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script charset="utf-8" src="assets/js/nicEdit-latest.js"></script>
        <meta name='robots' content='noindex,nofollow' />
        <script charset="utf-8">
            $(function(){
                $(".post p").filter(function() {
                    return $.trim($(this).text()) === ''
                }).remove()
            });
            $(window).load(function(){ $(".sidebar").height() > $(".main").height() ? $(".main").css("height",$(".sidebar").height() + "px") : $(".sidebar").css("height",$(".main").height() + "px") });
        </script>
        <script type="text/javascript" src="assets/js/audio-player.js"></script>  
        <script type="text/javascript">  
            AudioPlayer.setup("<?php echo base_url().'assets/swf/player.swf';?>", {  
                width: 290  
            });  
        </script>  
    </head>
    <body>

        <div class="wrap">
            <header>
                <a href="<?php echo base_url(); ?>" title="MusicLovr" class="logo">Music Lovr</a>
            </header>

            <div class="sidebar">
                <h3><?php echo $logged_user->firstname." ".$logged_user->lastname; ?></h3>
                <ul id="menu-sidebar" class="menu">
                    <li id="menu-item-20" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-20"><a href="<?php echo base_url(); ?>home/new_post">Subir rola</a></li>
                    <li id="menu-item-20" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-20"><a href="<?php echo base_url(); ?>home/add_category">Agregar categoría</a></li>
                    <li id="menu-item-14" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-14"><a href="<?php echo base_url(); ?>home/profile">Mi perfil</a></li>
                    <li id="menu-item-20" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-20"><a href="<?php echo base_url(); ?>logout/">Salir</a></li>
                </ul>

                <h3>Categorías</h3>
                <ul> 
                    <?php foreach ($arrActiveCategories as $oCat) { 
                        echo '<li><a href="'.base_url().'categoria/'.$oCat->getSlug().'.html" title="'.$oCat->getDescription().'">'.$oCat->getName()."</a></li>\n";
                     } 
                    ?>
                </ul>

                <h3>Links</h3>
                <ul id="menu-sidebar" class="menu">
                    <li><a href="<?php echo base_url(); ?>/sample-page/">Contexto y reglas</a></li>
                    <li><a href="<?php echo base_url(); ?>/instrucciones-para-publicar/">Instrucciones para publicar</a></li>
                </ul>
            </div>

                
            
            <div class="main">
                    <?php echo $strContentView; ?>
            </div>
            

        </div>
    </body>
</html>
