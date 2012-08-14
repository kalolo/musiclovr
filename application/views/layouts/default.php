<!DOCTYPE html>
<html dir="ltr" lang="en-US">
    <head>
        <base href="<?php echo base_url(); ?>" />
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
        <title>Music Lovr | Una comunidad de amantes de la música</title>
        <link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all" />
        <script charset="utf-8" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <meta name='robots' content='noindex,nofollow' />
        <style type="text/css" media="screen">
            html { margin-top: 28px !important; }
            * html body { margin-top: 28px !important; }
        </style>

        <script charset="utf-8">
            $(function(){
                $(".post p").filter(function() {
                    return $.trim($(this).text()) === ''
                }).remove()
            });
        </script>
    </head>
    <body class="home blog logged-in admin-bar">

        <div id="wrap" class="clearfix">
            <div id="sidebar-primary" class="block">

                <div class="logo">
                    <h1><a href="<?php echo base_url(); ?>" title="Music Lovr">Music Lovr</a></h1><p>Una comunidad de amantes de la música</p>
                </div><!--end Logo-->


                <ul class="sidebar">
                    <li id="nav_menu-2" class="widget-container widget_nav_menu">
                        <h3 class="widget-title">Welcome</h3>
                            <div class="menu-sidebar-container">
                                <ul id="menu-sidebar" class="menu">
                                    <li id="menu-item-14" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-14"><?php echo $logged_user->firstname." ".$logged_user->lastname; ?></li>
                                    <li id="menu-item-20" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-20"><a href="<?php echo base_url(); ?>home/add_new_song">Agregar rola</a></li>
                                    <li id="menu-item-20" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-20"><a href="<?php echo base_url(); ?>home/add_category">Nueva categoria</a></li>
                                    <li id="menu-item-20" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-20"><a href="<?php echo base_url(); ?>logout/">Salir!</a></li>
                                </ul>
                            </div>
                    </li>

                    <li id="categories-2" class="widget-container widget_categories"><h3 class="widget-title">Temas:</h3>		<ul>
                            <li class="cat-item cat-item-10"><a href="<?php echo base_url(); ?>temas/protesta/" title="Canciones de protesta, muy acorde a los días que se viven.">Canciones de protesta</a>
                            </li>
                            <li class="cat-item cat-item-1"><a href="<?php echo base_url(); ?>temas/covers/" title="Compártenos el mejor cóver que hayas escuchado.">Covers</a>
                            </li>
                            <li class="cat-item cat-item-12"><a href="<?php echo base_url(); ?>temas/memoriasdeunaepoca/" title="Una rola que te recuerde una época o situación específica. Pónganse personales :)">Memorias de una época</a>
                            </li>
                            <li class="cat-item cat-item-8"><a href="<?php echo base_url(); ?>temas/musicadecarretera/" title="Compártenos tu rola perfecta para esas horas en carretera.">Música para viajar en carretera</a>
                            </li>
                            <li class="cat-item cat-item-9"><a href="<?php echo base_url(); ?>temas/sexosas/" title="¿Necesitamos una descripción incómoda?">Rolas sexosas</a>
                            </li>
                            <li class="cat-item cat-item-6"><a href="<?php echo base_url(); ?>temas/soundtrack/" title="Una rola de película o serie de TV. Cuéntanos por qué elegiste esa rolita.">Soundtrack</a>
                            </li>
                            <li class="cat-item cat-item-7"><a href="<?php echo base_url(); ?>temas/unplugged/" title="Unplugged: Una rola que no necesariamente haya aparecido en MTV Unplugged, pero que sea la versión acústica de una rola que originalmente no lo es, tocada por la misma banda o artista. Recuerda contarnos en tu post el por qué de tu elección.">Unplugged</a>
                            </li>
                            <li class="cat-item cat-item-11"><a href="<?php echo base_url(); ?>temas/violencia/" title="Para que se pongan rudos.">Violencia</a>
                            </li>
                        </ul>
                    </li><li id="nav_menu-2" class="widget-container widget_nav_menu"><h3 class="widget-title">Links</h3><div class="menu-sidebar-container"><ul id="menu-sidebar" class="menu"><li id="menu-item-14" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-14"><a href="<?php echo base_url(); ?>/sample-page/">Contexto y reglas</a></li>
                                <li id="menu-item-20" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-20"><a href="<?php echo base_url(); ?>/instrucciones-para-publicar/">Instrucciones para publicar</a></li>
                            </ul></div></li>	</ul>
                <!--end Sidebar -->

            </div>
            <!--end Sidebar One-->
            <div id="main">

                <div id="content">
                    <?php echo $strContentView; ?>
                </div>
                <!--end Content-->
            </div>
            <!--end Main-->
            <div id="footer" class="clearfix">
                <p class="alignright">Powered by Coffee and Ópera Prima.</p>
            </div>
            <!--end Footer-->

        </div>
        <!--end Wrap-->
        <script type="text/javascript">
            (function() {
                var request, b = document.body, c = 'className', cs = 'customize-support', rcs = new RegExp('(^|\\s+)(no-)?'+cs+'(\\s+|$)');

                request = true;

                b[c] = b[c].replace( rcs, '' );
                b[c] += ( window.postMessage && request ? ' ' : ' no-' ) + cs;
            }());
        </script>

    </body>
</html>