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
                                    <li id="menu-item-20" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-20"><a href="<?php echo base_url(); ?>home/new_post">Agregar rola</a></li>
                                    <li id="menu-item-20" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-20"><a href="<?php echo base_url(); ?>home/add_category">Nueva categoria</a></li>
                                    <li id="menu-item-20" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-20"><a href="<?php echo base_url(); ?>admin/active_category">Activar categoria</a></li>
                                    <li id="menu-item-20" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-20"><a href="<?php echo base_url(); ?>logout/">Salir!</a></li>
                                </ul>
                            </div>
                    </li>

                    <li id="categories-2" class="widget-container widget_categories"><h3 class="widget-title">Temas:</h3>		<ul>
                            
                            <?php foreach ($arrCategories as $oCat) { 
                                echo '<li class="cat-item cat-item-10">
                                         <a href="'.base_url().'categoria/'.$oCat->getSlug().'.html" title="'.$oCat->getDescription().'">'.$oCat->getName()."</a></li>\n";
                             } 
                             ?>
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