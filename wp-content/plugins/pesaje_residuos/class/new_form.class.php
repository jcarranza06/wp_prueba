<?php

class new_form
{
    private $archivoJSON;
    private $funcion;
    private $formularioJSON;
    //public $formularioJSON = '{"nombre":"formulario","categorias":[{"nombre":"INFRAESTRUCTURA","subgrupos":[{"nombre":"tomacorrientes","preguntas":[{"texto":"¿Existen tomacorrientes Sí cercanía agua, no están rotos, están en buen estado","tipo":"bool","respuestas":["Si","No"],"obligatoria":true},{"texto":"Están señalizados los paneles eléctricos con riesgo eléctrico","tipo":"bool","respuestas":["Si","No"],"obligatoria":true}]}]}]}';

    private $formulario;


    private function getCategoriasHTML()
    {
        $categorias_HTML = "";
        $lastColorM = "";
        foreach ($this->formulario->categorias as $indice_cat => $categoria) {
            $i1 = $indice_cat + 1;
            $color = $categoria->color;
            $main = ($indice_cat < 1) ? "main_nav_element" : "";
            $categorias_HTML .= "<div class='navprogress_elements  $main' id='navprogress-content-$indice_cat' style='--colorM: $color;--lastColorM: $lastColorM;'onclick='formulario.setVisible($indice_cat)'><div class='navwidget'>$i1</div>" . $categoria->nombre . "</div>";
            $lastColorM = $color;
        }

        return $categorias_HTML;
    }

    private function getHTMLPreguntaRADIOSELECT($pregunta, $indice_cat, $indice_sub, $indice_preg, $subgrupo)
    {
        $html = "";
        $simboloAyuda = "
              <svg width='16' height='16' fill='currentColor' class='bi bi-question-circle' viewBox='0 0 16 16'>
                <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                <path d='M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z'/>
              </svg>
        ";
        $html .= "<div id='formulario-pregunta-$indice_cat-$indice_sub-$indice_preg' class='pregunta-container'>";
        $html .= "<div class='texto_formulario'>" . $pregunta->texto . ($pregunta->obligatoria ? "<span class='mandatory'> * </span>" : "") . "</div><br> <div class='container-respuestas-custom-form'>";
        foreach ($pregunta->respuestas as $indice_res => $respuesta) {
            $name = $subgrupo->nombre . $pregunta->texto;
            $respuestaText = $respuesta->text;
            $id = $name . $respuestaText;
            $html .= "
                            <label class='label_custom_radio_formulario' for='formulario-respuesta-$indice_cat-$indice_sub-$indice_preg-$indice_res'>$respuestaText</label>
                            <input class='input_custom_radio_formulario' type='radio' id='formulario-respuesta-$indice_cat-$indice_sub-$indice_preg-$indice_res' name='formulario-respuesta-$indice_cat-$indice_sub-$indice_preg' value='$respuestaText'><!--<br>-->
                        ";
        }
        $html .= "</div>";
        $html .= "</div>";
        return $html;
    }

    private function getHTMLPreguntaSELECT($pregunta, $indice_cat, $indice_sub, $indice_preg, $subgrupo)
    {
        $html = "";
        $html .= "<div id='formulario-pregunta-$indice_cat-$indice_sub-$indice_preg' class='pregunta-container'>";
        $html .= "<div class='texto_formulario'>" . $pregunta->texto . ($pregunta->obligatoria ? "<span class='mandatory'> * </span>" : "") . "</div> <div class='container-respuestas-custom-form'>";
        $html .= "
                <select class='input_custom_select_formulario' id='formulario-respuesta-$indice_cat-$indice_sub-$indice_preg-0' name='formulario-respuesta-$indice_cat-$indice_sub-$indice_preg' required >
                    <option value='seleccione'>seleccione</option>";
        foreach ($pregunta->respuestas as $indice_res => $respuesta) {
            $name = $subgrupo->nombre . $pregunta->texto;
            $respuestaText = $respuesta->text;
            $id = $name . $respuestaText;
            $html .= "
                            <option value='$respuestaText'>$respuestaText</option>
                        ";
        }

        $html .= "
                </select>
                        ";
        $html .= "</div>";
        $html .= "</div>";
        return $html;
    }

    private function getHTMLPreguntaTEXT($pregunta, $indice_cat, $indice_sub, $indice_preg, $subgrupo)
    {
        $html = "";
        $tooltipClass = "";
        $tooltipText = "";
        if (property_exists($pregunta, 'tooltip') && $pregunta->tooltip) {
            $tooltipClass = "preguntaTooltip";
            $tooltipText = $pregunta->tooltipText;
        }
        $html .= "<div id='formulario-pregunta-$indice_cat-$indice_sub-$indice_preg' class='pregunta-container'>";
        $html .= "<div class='texto_formulario  $tooltipClass' data-tooltip='$tooltipText'>" . $pregunta->texto . ($pregunta->obligatoria ? "<span class='mandatory'> * </span>" : "") . "</div> <div class='container-respuestas-custom-form'>";
        $extra = property_exists($pregunta, 'extra') ? $pregunta->extra : "";
        $able = $pregunta->able ? "" : "disabled";
        $placeHolder = $pregunta->placeHolder;
        $tipoTexto = $pregunta->tipoTexto;
        //var_dump($pregunta);
        $html .= "
                <input class='input_new_formulario' type='$tipoTexto' id='formulario-respuesta-$indice_cat-$indice_sub-$indice_preg-0' name='formulario-respuesta-$indice_cat-$indice_sub-$indice_preg' required minlength='1' maxlength='100' placeholder='$placeHolder' $able  $extra/>
            ";
        $html .= "</div>";
        $html .= "</div>";
        return $html;
    }

    private function getHTMLPregunta($pregunta, $indice_cat, $indice_sub, $indice_preg, $subgrupo)
    {
        $html = "";
        if ($pregunta->tipo == "RADIOSELECT") {
            $html = $this->getHTMLPreguntaRADIOSELECT($pregunta, $indice_cat, $indice_sub, $indice_preg, $subgrupo);
        } elseif ($pregunta->tipo == "TEXT") {
            $html = $this->getHTMLPreguntaTEXT($pregunta, $indice_cat, $indice_sub, $indice_preg, $subgrupo);
        } elseif ($pregunta->tipo == "SELECT") {
            $html = $this->getHTMLPreguntaSELECT($pregunta, $indice_cat, $indice_sub, $indice_preg, $subgrupo);
        }
        return $html;
    }

    private function createContentHtml()
    {
        $content_form_HTML = "";

        foreach ($this->formulario->categorias as $indice_cat => $categoria) {
            $cat_visible = $indice_cat < 1 ? "visible" : "notVisible";
            $color = $categoria->color;
            $hex = str_replace("#", "", $color);

            // Dividir el valor hexadecimal en componentes rojo, verde y azul
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
            $content_form_HTML .= "<div class='categoria_container  $cat_visible' style='--colorCategoria: $color;--colorCategoriaR: $r;--colorCategoriaG: $g;--colorCategoriaB: $b;' id='formulario-categoria-$indice_cat'>";
            foreach ($categoria->subgrupos as $indice_sub => $subgrupo) {
                $titulo_subgrupo = $subgrupo->nombre;

                $content_form_HTML .= "
                    <div class='subcategoria_container' id='formulario-subcategoria-$indice_cat-$indice_sub'>
                    <div class='titulo_cubcategoria'>  $titulo_subgrupo </div>
                    <div class='container_preguntas_subcategoriacategoria'>
                ";

                foreach ($subgrupo->preguntas as $indice_preg => $pregunta) {
                    $content_form_HTML .= $this->getHTMLPregunta($pregunta, $indice_cat, $indice_sub, $indice_preg, $subgrupo);
                }
                $content_form_HTML .= "</div>";
                $content_form_HTML .= "</div>";
            }
            $content_form_HTML .= "</div>";
        }
        return $content_form_HTML;
    }

    private function uploadFormResponse($formulario_respuesta_puntaje, $formulario_respuesta_captura)
    {
        //var_dump($_POST['formulario-respuesta-captura']);
        //var_dump($formulario_respuesta_puntaje);
        //var_dump($formulario_respuesta_captura);
        if ($this->funcion == "autodiagnostico") {
            $funcion = 1;
        } else {
            $funcion = 2;
        }
        global $wpdb;
        $datos = [
            'id_envio' => null,
            'id_formulario' => $funcion,
            'puntaje' => $formulario_respuesta_puntaje,
            "fecha" => current_time('mysql', 1)
        ];
        $resultadoInsertForm = $wpdb->insert("{$wpdb->prefix}forms_send", $datos);

        if ($resultadoInsertForm) {
            $inserted_form_id = $wpdb->insert_id;
            //var_dump($inserted_form_id);

            $varInsertar = "INSERT INTO `{$wpdb->prefix}forms_respuestas` (`id_respuesta`, `id_envio`, `categoria`, `subgrupo`, `pregunta`, `respuesta`, `id_elemento`, `clase`) VALUES (NULL, %d, %s, %s, %s, %s, %s, %s)";
            for ($i = 0; $i < count($formulario_respuesta_captura) - 1; $i++) {
                $varInsertar .= ', (NULL, %d, %s, %s, %s, %s, %s, %s)';
            }
            $variables = [];
            for ($i = 0; $i < count($formulario_respuesta_captura); $i++) {
                array_push($variables, $inserted_form_id);
                array_push($variables, $formulario_respuesta_captura[$i]->categoria);
                array_push($variables, $formulario_respuesta_captura[$i]->subgrupo);
                array_push($variables, $formulario_respuesta_captura[$i]->pregunta);
                array_push($variables, $formulario_respuesta_captura[$i]->respuesta);
                array_push($variables, $formulario_respuesta_captura[$i]->id_elemento);
                array_push($variables, $formulario_respuesta_captura[$i]->clase);
            }

            $consulta = $wpdb->prepare(
                $varInsertar,
                $variables
            );
            //var_dump($consulta);
            $wpdb->query($consulta);
        } else {

        }
    }

    private function sendConfirmationMail($correo, $HTMLBodyStructure)
    {
        $to = "$correo";
        $subject = 'Confirmación formulario';
        $message = "<!DOCTYPE html>
                        <html lang='en'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <title>Document</title>
                        </head>
                        <body>
                            $HTMLBodyStructure
                        </body>
                        </html>";
        $headers = "MIME-Version: 1.0" . "\r\n";

        # ojo, es una concatenación:
        $headers .= "Content-type:text/html; charset=UTF-8" . "\r\n";
        $headers .= 'De: Tu Nombre <juanescs08@gmail.com>';

        $enviado = wp_mail($to, $subject, $message, $headers);

        if ($enviado) {
            echo '<div style="font-weight:bold;">El correo de confirmación se envió correctamente.</div>';
        } else {
            echo '<div style="font-weight:bold;"> Hubo un problema al enviar el correo de confirmación. </div>';
        }
    }

    private function getObjetoAlQuePertenecePuntuacion($puntuacion)
    {

        $arregloDeVAloraciones = [
            (object) ['maximaPuntuacion' => 20, 'valoracion' => 'Se puede hacer mejor', 'icono' => 'https://ogabogota.unal.edu.co/wp-content/uploads/2023/10/Se-puede-hacer-mejor.png'],
            (object) ['maximaPuntuacion' => 40, 'valoracion' => 'Se puede fortalecer', 'icono' => 'https://ogabogota.unal.edu.co/wp-content/uploads/2023/10/Se-puede-fortalecer.png'],
            (object) ['maximaPuntuacion' => 60, 'valoracion' => 'Oportunidad para mejorar', 'icono' => 'https://ogabogota.unal.edu.co/wp-content/uploads/2023/10/Oportunidad-de-mejorar.png'],
            (object) ['maximaPuntuacion' => 80, 'valoracion' => 'Se puede dar más', 'icono' => 'https://ogabogota.unal.edu.co/wp-content/uploads/2023/10/Se-puede-dar-mas.png'],
            (object) ['maximaPuntuacion' => 100, 'valoracion' => 'Alcanzando la meta', 'icono' => 'https://ogabogota.unal.edu.co/wp-content/uploads/2023/10/Alcanzando-la-meta.png']
        ];

        $indice = 0;
        $continuar = true;

        while ($continuar && $indice < count($arregloDeVAloraciones)) {
            if ($puntuacion <= $arregloDeVAloraciones[$indice]->maximaPuntuacion) {
                $continuar = false;
            } else {
                $indice++; // Incrementa el índice para pasar al siguiente objeto
            }
        }

        return $arregloDeVAloraciones[$indice];
    }

    public function getHTMLBody()
    {

        if (isset($_POST['formulario-respuesta-puntaje']) && isset($_POST['formulario-respuesta-captura'])) {

            $formulario_respuesta_puntaje = number_format(floatval($_POST['formulario-respuesta-puntaje']), 1);
            $formulario_respuesta_captura = json_decode(str_replace('\\', '', $_POST['formulario-respuesta-captura']));
            $correo = "";
            $dato1Indicador1 = 0;
            $dato2Indicador1 = 0;
            $dato1Indicador2 = 0;
            $dato2Indicador2 = 0;
            $dato1Indicador3 = 0;
            $dato2Indicador3 = 0;
            $idLab = 0;

            if ($this->funcion == "autodiagnostico") {
                foreach ($formulario_respuesta_captura as $respuesta) {
                    if ($respuesta->id_elemento == "formulario-respuesta-0-0-3-0") {
                        $correo = $respuesta->respuesta;
                    }
                    if ($respuesta->id_elemento == "formulario-respuesta-0-1-0-0") {
                        $idLab = intval($respuesta->respuesta);
                    }
                    if ($respuesta->id_elemento == "formulario-respuesta-5-0-0-0") {
                        $dato1Indicador1 = intval($respuesta->respuesta);
                    }
                    if ($respuesta->id_elemento == "formulario-respuesta-5-0-1-0") {
                        $dato2Indicador1 = intval($respuesta->respuesta);
                    }
                    if ($respuesta->id_elemento == "formulario-respuesta-5-0-2-0") {
                        $dato1Indicador2 = intval($respuesta->respuesta);
                    }
                    if ($respuesta->id_elemento == "formulario-respuesta-5-0-3-0") {
                        $dato2Indicador2 = intval($respuesta->respuesta);
                    }
                    if ($respuesta->id_elemento == "formulario-respuesta-5-0-4-0") {
                        $dato1Indicador3 = intval($respuesta->respuesta);
                    }
                    if ($respuesta->id_elemento == "formulario-respuesta-5-0-5-0") {
                        $dato2Indicador3 = intval($respuesta->respuesta);
                    }
                }
            } else {
                foreach ($formulario_respuesta_captura as $respuesta) {
                    if ($respuesta->id_elemento == "formulario-respuesta-0-1-3-0") {
                        $correo = $respuesta->respuesta;
                    }
                    if ($respuesta->id_elemento == "formulario-respuesta-0-2-0-0") {
                        $idLab = intval($respuesta->respuesta);
                    }
                    if ($respuesta->id_elemento == "formulario-respuesta-5-0-0-0") {
                        $dato1Indicador1 = intval($respuesta->respuesta);
                    }
                    if ($respuesta->id_elemento == "formulario-respuesta-5-0-1-0") {
                        $dato2Indicador1 = intval($respuesta->respuesta);
                    }
                    if ($respuesta->id_elemento == "formulario-respuesta-5-0-2-0") {
                        $dato1Indicador2 = intval($respuesta->respuesta);
                    }
                    if ($respuesta->id_elemento == "formulario-respuesta-5-0-3-0") {
                        $dato2Indicador2 = intval($respuesta->respuesta);
                    }
                    if ($respuesta->id_elemento == "formulario-respuesta-5-0-4-0") {
                        $dato1Indicador3 = intval($respuesta->respuesta);
                    }
                    if ($respuesta->id_elemento == "formulario-respuesta-5-0-5-0") {
                        $dato2Indicador3 = intval($respuesta->respuesta);
                    }
                }
            }


            $indicador1 = number_format($dato1Indicador1 / $dato2Indicador1, 2) * 100;
            $indicador2 = number_format($dato1Indicador2 / $dato2Indicador2, 2) * 100;
            $indicador3 = number_format($dato1Indicador3 / $dato2Indicador3, 2) * 100;

            $this->uploadFormResponse($formulario_respuesta_puntaje, $formulario_respuesta_captura);

            $permalink = get_permalink();

            $stringCambio = "";

            $extraSeguimiento = "";
            if ($this->funcion != "autodiagnostico") {
                //echo 'tamo en seguimiento';
                global $wpdb;
                $sqlObtenerFotoshermes = $wpdb->prepare("SELECT s.`id_envio`, s.`id_formulario`, s.`puntaje`, ids_labs.`respuesta` FROM `{$wpdb->prefix}forms_send` as s join ( SELECT `id_envio`, `pregunta`, `respuesta` FROM `{$wpdb->prefix}forms_respuestas` WHERE `id_elemento` = 'formulario-respuesta-0-1-0-0' ) AS ids_labs ON s.`id_envio` = ids_labs.`id_envio` WHERE s.`id_formulario` = 1 and ids_labs.`respuesta` = %d ORDER BY `fecha` LIMIT 1;", $idLab);
                $laboratorio = $wpdb->get_results($sqlObtenerFotoshermes, ARRAY_A);
                if ($laboratorio) {

                    if (count($laboratorio) > 0) {
                        $valor_anterioor = floatval($laboratorio[0]['puntaje']);
                        $cambio = $formulario_respuesta_puntaje - $valor_anterioor;
                        //var_dump($laboratorio);
                        //var_dump($valor_anterioor);
                        if ($cambio > 0) {
                            $stringCambio = " Ha mejorado su porcentaje de cumplimiento general en: $cambio %";
                        } else {
                            $stringCambio = " Ha reducido su porcentaje de cumplimiento general en: $cambio %";
                        }

                    }
                } else {
                }
            }


            $calificacion = $this->getObjetoAlQuePertenecePuntuacion($formulario_respuesta_puntaje);
            $imagenURL = $calificacion->icono;
            $valoracion = $calificacion->valoracion;
            $HTMLBodyStructure = "
                <div class='mensaje-respuesta-container' style='background-color: rgba(255,255,255,0.95);border: 0;padding: 15px;font-size: 1.3em;flex-direction: column;align-items: center;border-radius: 10px; display: flex;  gap: 15px;line-height: 1;padding: 15px;color: rgba(0,0,0,0.75);max-width: 700px;margin: 0 auto;'>
                    <div class='img-valoracion-container'>  <img id='img-valoracion' style='max-width: 400px;' class='img-valoracion' src='$imagenURL' alt='$valoracion'> </div>
                    <div class='calificacion-valoracion-container' style='font-size: 1.4em;text-align: center;font-weight: 500;'>  ¡ $valoracion ! </div>
                    <div class='puntaje-muestra'>Su porcentaje de cumplimiento general es: $formulario_respuesta_puntaje %</div>
                    <div class='indicadores-muestra'> Porcentaje Etiquetado: $indicador1 %</div>
                    <div class='indicadores-muestra'> Porcentaje fichas de datos de seguridad: $indicador2 %</div>
                    <div class='indicadores-muestra'> Porcentaje Etiquetado  de RESPEL: $indicador3 %</div>
                    
                    <div class='indicadores-muestra'>$stringCambio</div>
                    <br><br>
                </div>
                <style type='text/css'>
                    @media (max-width: 768px) {
                        img#img-valoracion {
                            max-width: 100%;
                        }
                    }

                </style>
            ";
            $HTMLBodyStructureMail = "
                <div class='mensaje-respuesta-container' style='background-color: rgba(255,255,255,0.95);border: 0;padding: 15px;font-size: 1.3em;align-items: center;border-radius: 10px;  gap: 15px;line-height: 1;padding: 15px;color: rgba(0,0,0,0.75);'>
                    <div class='img-valoracion-container'>  <img id='img-valoracion' style='max-width: 400px;' class='img-valoracion' src='$imagenURL' alt='$valoracion'> </div>
                    <h1 class='calificacion-valoracion-container' style='font-size: 1.4em;text-align: center;font-weight: 500;'>  ¡ $valoracion ! </h1>
                    <h3 class='puntaje-muestra'>Su porcentaje de cumplimiento general es: $formulario_respuesta_puntaje %</h3>
                    <h3 class='indicadores-muestra'> Porcentaje Etiquetado: $indicador1 %</h3>
                    <h3 class='indicadores-muestra'> Porcentaje fichas de datos de seguridad: $indicador2 %</h3>
                    <h3 class='indicadores-muestra'> Porcentaje Etiquetado  de RESPEL: $indicador3 %</h3>
                    <h3> $stringCambio </h3>
                    <br><br>
                </div>
                <style type='text/css'>
                    @media (max-width: 768px) {
                        img#img-valoracion {
                            max-width: 100%;
                        }
                    }

                </style>
            ";

            $this->sendConfirmationMail($correo, $HTMLBodyStructureMail);

        } else {
            /*$titulo = "<div> <p class='titulo_formulario'>" . $this->formulario->nombre . " </p>
            <p>
                <div class='menu_recuperar_formulario'>
                    <button class='boton_recuperar_formulario'> Borradores </button>
                    <div class='listas_recuperar_formulario' id='lista_recuperar_formulario'>
                        <!--<li><div>Opción 1</div></li>-->
                    </div>
                </div>
            </p>
        
        </div>";*/
            $titulo = "<div> <p class='titulo_formulario'> </p>
                            <p>
                                <div class='menu_recuperar_formulario'>
                                    <button class='boton_recuperar_formulario'> Borradores </button>
                                    <div class='listas_recuperar_formulario' id='lista_recuperar_formulario'>
                                        <!--<li><div>Opción 1</div></li>-->
                                    </div>
                                </div>
                            </p>
                        </div>";

            $categorias_HTML = $this->getCategoriasHTML();
            $navprogress_bar = "
            <div class='navprogress_container'>
                <span>Navegación</span>
                <div class='navprogress_content'>
                    $categorias_HTML
                </div>
            </div>
        ";
            $content_html = $this->createContentHtml();
            $section_content = "
            <div class='navform_container'>
                <!--<div class='categoria_container'>
                    <div class='subcategoria_container'>
                        <div class='titulo_cubcategoria'> Un titulo</div>
                        <div class='container_preguntas_subcategoriacategoria'>
                        <div>Ha tenido ganas ce comer </div>
                        <div>
                            <input type='radio' id='html' name='fav_language' value='HTML'>
                            <label for='html'>HTML</label><br>
                            <input type='radio' id='html' name='fav_language' value='HTML'>
                            <label for='html'>HTML</label><br>
                        </div>
                        </div>
                    </div>
                    
                </div>-->
                $content_html
            </div>
        ";

            $navbuttons = "
            <div class ='form_navbuttons_container'>
                <div>
                    <button class='btn_new_form notVisible' onclick='formulario.retroceder();' id='btn_formulario_retroceder'>Anterior</button>
                    <button class='btn_new_form' onclick='formulario.avanzar();' id='btn_formulario_avanzar'>Siguiente</button>
                    <button onclick='formulario.verificarRespuestas();' class=' notVisible btn_new_form' id='btn_formulario_enviar'>Enviar</button>
                </div>
            </div>
        ";

            $popUp = "
            <div id='dark-layer'></div>
            <dialog id='popup'>
                
                <div class='popUpContainer'> Tenga en cuenta antes de iniciar: <div>

                    <ul>
                        <li>Las preguntas marcadas con asterisco ( <span class='mandatory'> * </span>) son obligatorias.</li>
                        <li>Sí al enviar falta diligenciar algún campo obligatorio, va a ser devuelto a este.</li>
                        <li>Puede utilizar el menu para moverse entre secciones: <br> <img src='https://ogabogota.unal.edu.co/wp-content/uploads/2023/10/imgnavelement.png'> </li>
                        <li>En caso de perder su progreso, busque y seleccione el id del laboratorio en 'borradores': <br> <img src='https://ogabogota.unal.edu.co/wp-content/uploads/2023/10/borradores.png'> </li>
                    </ul>
            
                </div>
                <svg id='btnCerrarPopup' width='20' height='20'>
                <line x1='0%' y1='0%' x2='100%' y2='100%' stroke='#aaaaaa' style='fill:#667955;stroke:gray;stroke-width:5'/>
                <line x1='0%' y1='100%' x2='100%' y2='0%' stroke='#aaaaaa' style='fill:#667955;stroke:gray;stroke-width:5'/>
                </svg>

                <button class='btn_new_form' onclick='cerrarPopUpIndicadiones()'>Continuar</button>
            </dialog>
            
            <script>
                
                /*Pop Up*/
                const popup = document.querySelector('#popup');
                const btnCerrarPopup = document.querySelector('#btnCerrarPopup')
                popup.showModal();  // mostrar el popUp

                let darkl = document.querySelector('#dark-layer')// para no mostrar 
                darkl.style.display='inline';
                darkl.addEventListener('click', () => {
                    cerrarPopUpIndicadiones()
                })
                btnCerrarPopup.addEventListener('click', () => {
                    cerrarPopUpIndicadiones()
                })
                function cerrarPopUpIndicadiones() {
                    popup.close();
                    document.querySelector('#dark-layer').style.display='none'
                }
                
                
            </script>
            
            ";

            //var_dump($this -> formulario ->categorias);
            $HTMLBodyStructure = "
            
            <div class='form-BodyStructure' id='form-BodyStructure'>
                $popUp
                $titulo
                $navprogress_bar
                <form method='post' action='' id='form_send_data' style='display: none;'>
                <input type='text' id='formulario-respuesta-puntaje' name='formulario-respuesta-puntaje' required/>
                <input type='text' id='formulario-respuesta-captura' name='formulario-respuesta-captura' required/>
                </form>
                $section_content
                $navbuttons
                <!--<script src='https://unpkg.com/@popperjs/core@2/dist/umd/popper.js'></script>-->
            </div>  
            
        ";
        }

        return $HTMLBodyStructure;
    }

    public function getJsonFormulario()
    {
        return $this->formularioJSON;
    }

    public function __construct($funcion)
    {
        $this->funcion = $funcion;
        if ($this->funcion == "autodiagnostico") {
            $this->archivoJSON = plugins_url('datos.json', __FILE__); // Ruta al archivo JSON
        } else {
            $this->archivoJSON = plugins_url('datos1.json', __FILE__); // Ruta al archivo JSON
        }

        $context = stream_context_create(
            array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ),
            )
        );

        $this->formularioJSON = file_get_contents($this->archivoJSON, false, $context);
        $this->formulario = json_decode($this->formularioJSON);
    }
}

?>