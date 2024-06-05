<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]> <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]> <html class="ie8 oldie"> <![endif]-->
<!--[if IE 9]> <html class="ie9 oldie"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <!-- 
  =============================================================================
  === PLANTILLA DESARROLLADA POR LA OFICINA DE MEDIOS DIGITALES - UNIMEDIOS ===
  =============================================================================
-->

    <!-- base href="http://subdominio.unal.edu.co/" -->
    <link rel="shortcut icon" href="<?php bloginfo('template_url')?>/images/favicon.ico" type="image/x-icon">


    <meta name="revisit-after" content="1 hour">
    <meta name="distribution" content="all">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.5, user-scalable=yes">
    <meta name="expires" content="1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="all">

    <!--[if lt IE 9]><script src="js/html5shiv.js" type="text/javascript"></script><![endif]-->
    <!--[if lt IE 9]><script src="js/respond.js" type="text/javascript"></script><![endif]-->


    <title><?php wp_title('•', true, 'right'); bloginfo('name'); ?></title>
    <?php wp_head(); ?>


    <!-- google analitics-->
    <script>
        (function (i, s, o, g, r, a, m) {
          i['GoogleAnalyticsObject'] = r;
          i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
          }, i[r].l = 1 * new Date();
          a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
          a.async = 1;
          a.src = g;
          m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-XXXXX-XX', 'auto');
        ga('require', 'displayfeatures');
        ga('send', 'pageview');
    </script>

</head>


<body <?php body_class(); ?>>
    <div id="services">
        <div class="indicator hidden-xs"></div>
        <ul class="dropdown-menu">
            <li>
                <a href="http://correo.unal.edu.co" target="_blank"><img src="<?php bloginfo('template_url')?>/images/icnServEmail.png" width="32" height="32" alt="Correo Electrónico">Correo Electrónico</a>
            </li>
            <li>
                <a href="http://www.sia.unal.edu.co" target="_blank"><img src="<?php bloginfo('template_url')?>/images/icnServSia.png" width="32" height="32" alt="Sistema de Información Académica">Sistema de Información Académica</a>
            </li>
            <li>
                <a href="http://www.sinab.unal.edu.co" target="_blank"><img src="<?php bloginfo('template_url')?>/images/icnServLibrary.png" width="32" height="32" alt="Biblioteca">Biblioteca</a>
            </li>
            <li>
                <a href="http://168.176.5.43:8082/Convocatorias/indice.iface" target="_blank"><img src="<?php bloginfo('template_url')?>/images/icnServCall.png" width="32" height="32" alt="Convocatorias">Convocatorias</a>
            </li>
            <li>
                <a href="http://identidad.unal.edu.co"><img src="<?php bloginfo('template_url')?>/images/icnServIdentidad.png" width="32" height="32" alt="Identidad U.N.">Identidad U.N.</a>
            </li>
        </ul>
    </div>
    <header id="unalTop">
        <div class="logo">
            <a href="http://unal.edu.co">
                <!--[if (gte IE 9)|!(IE)]><!-->
                <svg width="93%" height="93%">
          <image xlink:href="<?php bloginfo('template_url')?>/images/escudoUnal.svg" width="100%" height="100%" class="hidden-print"/>
        </svg>

                <!--<![endif]-->
                <!--[if lt IE 9]>
          <img src="images/escudoUnal.png" width="93%" height="auto" class="hidden-print"/> 
      <![endif]-->
                <img src="<?php bloginfo('template_url')?>/images/escudoUnal_black.png" class="visible-print" />
            </a>
        </div>
        <div class="seal">
            <img class="hidden-print" alt="Escudo de la República de Colombia" src="<?php bloginfo('template_url')?>/images/sealColombia.png" width="66" height="66" />

            <img class="visible-print" alt="Escudo de la República de Colombia" src="<?php bloginfo('template_url')?>/images/sealColombia_black.png" width="66" height="66" />
        </div>
        <div class="firstMenu">

            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
      <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
    </button>
            <div class="btn-group languageMenu hidden-xs">
                <div class="btn btn-default dropdown-toggle" data-toggle="dropdown">es<span class="caret"></span></div>
                <ul class="dropdown-menu">
                    <li><a href="index.html#">es</a></li>
                    <li><a href="index.html#">en</a></li>
                </ul>
            </div>
            <ul class="socialLinks hidden-xs">
                <li>
                    <a href="https://www.facebook.com/UNColombia" target="_blank" class="facebook" title="Página oficial en Facebook"></a>
                </li>
                <li>
                    <a href="https://twitter.com/UNColombia" target="_blank" class="twitter" title="Cuenta oficial en Twitter"></a>
                </li>
                <li>
                    <a href="https://www.youtube.com/channel/UCnE6Zj2llVxcvL5I38B0Ceg" target="_blank" class="youtube" title="Canal oficial de Youtube"></a>
                </li>
                <li>
                    <a href="http://agenciadenoticias.unal.edu.co/nc/sus/type/rss2.html" target="_blank" class="rss" title="Suscripción a canales de información RSS"></a>
                </li>
            </ul>
            <div class="navbar-default">
                <nav id="profiles">
                    <ul class="nav navbar-nav dropdown-menu">
                        <li class="item_Aspirantes #>"><a href="index.html#">Aspirantes</a></li>
                        <li class="item_Estudiantes #>"><a href="index.html#">Estudiantes</a></li>
                        <li class="item_Egresados #>"><a href="index.html#">Egresados</a></li>
                        <li class="item_Docentes #>"><a href="index.html#">Docentes</a></li>
                        <li class="item_Administrativos #>"><a href="index.html#">Administrativos</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div id="bs-navbar" class="navbar-collapse collapse navigation">
            <div class="site-url">
                <a href="http://oga.bogota.unal.edu.co/">oga.bogota.unal.edu.co</a>
            </div>
            <div class="buscador">
                <div class="gcse-searchbox-only" data-resultsUrl="http://unal.edu.co/resultados-de-la-busqueda/" data-newWindow="true"></div>
            </div>
            <div class="mainMenu">
                <?php
                    wp_nav_menu( array(
                        'theme_location'    => 'navbar-default',
                        'depth'             => 3,
                        'menu_class'        => 'nav navbar-nav',
                        'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                        'walker'            => new wp_bootstrap_navwalker())
                    );
                ?>
            </div>
            <div class="btn-group hidden-sm hidden-md hidden-lg hidden-print">
                <div class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="unalOpenMenuServicios" data-target="#services">Servicios<span class="caret"> </span>
                </div>
            </div>
            <div class="btn-group hidden-sm hidden-md hidden-lg hidden-print">
                <div class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="unalOpenMenuPerfiles" data-target="#profiles">Perfiles<span class="caret"> </span>
                </div>
            </div>
        </div>

    </header>