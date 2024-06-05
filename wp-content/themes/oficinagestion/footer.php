<footer class="clear">
        <nav class="col-md-3 col-lg-3 col-sm-3 col-xs-4 col-xxs-6 gobiernoLinea">
            <a href="http://www.legal.unal.edu.co" target="_top">Régimen Legal</a>
            <a href="http://www.unal.edu.co/dnp" target="_top">Talento humano</a>
            <a href="http://www.unal.edu.co/contratacion/" target="_top">Contratación</a>
            <a href="http://www.unal.edu.co/dnp/" target="_top">Ofertas de empleo</a>
            <a href="http://rendiciondecuentas.unal.edu.co/" target="_top">Rendición de cuentas</a>
            <a href="http://docentes.unal.edu.co/concurso-profesoral/" target="_top">Concurso docente</a>
            <a href="http://www.pagovirtual.unal.edu.co/" target="_top">Pago Virtual</a>
            <a href="http://www.unal.edu.co/control_interno/index.html" target="_top">Control interno</a>
            <a href="http://unal.edu.co/siga/" target="_top">Calidad</a>
            <a href="http://unal.edu.co/buzon-de-notificaciones/" target="_self">Buzón de notificaciones</a>
        </nav>
        <nav class="col-md-3 col-lg-3 col-sm-3 col-xs-4 col-xxs-6 gobiernoLinea">
            <a href="http://correo.unal.edu.co" target="_top">Correo institucional</a>
            <a href="#">Mapa del sitio</a>
            <a href="http://redessociales.unal.edu.co" target="_top">Redes Sociales</a>
            <a href="https://ogabogota.unal.edu.co/preguntas-frecuentes/">FAQ</a>
            <a href="http://unal.edu.co/quejas-y-reclamos/" target="_self">Quejas y reclamos</a>
            <a href="http://unal.edu.co/atencion-en-linea/" target="_self">Atención en línea</a>
            <a href="http://unal.edu.co/encuesta/" target="_self">Encuesta</a>
            <a href="https://ogabogota.unal.edu.co/contacto/">Contáctenos</a>
            <a href="http://www.onp.unal.edu.co" target="_top">Estadísticas</a>
            <a href="https://ogabogota.unal.edu.co/glosario-ambiental/">Glosario</a>
        </nav>
        <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4 col-xxs-12 footer-info">
            <p class="col-sm-12 col-md-6 contacto">
                <b>Contacto página web:</b><br/>Carrera 45 # 26-85<br/>Edificio 610: Centro de Integración de Servicios Universitarios<br/>Bogotá D.C., Colombia<br/>(+57 1) 316 5000 Ext. 12710
            </p>
            <p class="col-sm-12 col-md-6 derechos">
                © Copyright 2020<br/> Algunos derechos reservados.<br/>
                <a title="Comuníquese con el administrador de este sitio web" href="mailto:oga_bog@unal.edu.co">oga_bog@unal.edu.co</a><br/>
                <a href="#">Acerca de este sitio web</a><br/> Actualización:

                <script> function date_ddmmmyy(date)
                {
                  var d = date.getDate();
                  var m = date.getMonth() + 1;
                  var y = date.getYear();

                  if(y >= 2000){y -= 2000;}
                  if(y >= 100){y -= 100;}

                  return "" + (d<10?"0"+d:d) + "/" + m + "/" + (y<10?"0"+y:y);
                }

                function date_lastmodified()
                {
                  var lmd = document.lastModified;
                  var s   = "Unknown";
                  var d1;

                  if(0 != (d1=Date.parse(lmd)))
                  {
                    s = "" + date_ddmmmyy(new Date(d1));
                  }

                  return s;
                }

                document.write( date_lastmodified() );
            </script>


            </p>
        </div>

        <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12 logos">
            <div class="col-xs-6 col-sm-12 col-md-6 no-padding">
                <a class="col-xs-6 col-sm-12" href="http://www.orgulloun.unal.edu.co">
                    <img class="hidden-print" alt="Orgullo UN" src="<?php bloginfo('template_url')?>/images/log_orgullo.png" width="78" height="21" />
                    <img class="visible-print" alt="Orgullo UN" src="<?php bloginfo('template_url')?>/images/log_orgullo_black.png" width="94" height="37" />
                </a>

                <a class="col-xs-6 col-sm-12 imgAgencia" href="http://www.agenciadenoticias.unal.edu.co/inicio.html">
                    <img class="hidden-print" alt="Agencia de noticias" src="<?php bloginfo('template_url')?>/images/log_agenc.png" width="94" height="25" />
                    <img class="visible-print" alt="Agencia de noticias" src="<?php bloginfo('template_url')?>/images/log_agenc_black.png" width="94" height="37" />
                </a>
            </div>
            <div class="col-xs-6 col-sm-12 col-md-6 no-padding">
                <a class="col-xs-6 col-sm-12" href="https://www.sivirtual.gov.co/memoficha-entidad/-/entidad/T0356">
                    <img alt="Trámites en línea" src="<?php bloginfo('template_url')?>/images/log_gobiern.png" width="67" height="51" />
                </a>

                <a class="col-xs-6 col-sm-12" href="http://www.contaduria.gov.co/">
                    <img alt="Contaduría general de la republica" src="<?php bloginfo('template_url')?>/images/log_contra.png" width="67" height="51" />
                </a>
            </div>

        </div>
    </footer>
    <?php wp_footer(); ?>
</body>

</html>