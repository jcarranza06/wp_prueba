<?php

class custom_form_pesaje
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

    private function getHTMLPreguntaTABLE($pregunta, $indice_cat, $indice_sub, $indice_preg, $subgrupo)
    {
        $html = "";
        $html .= "<div id='formulario-pregunta-$indice_cat-$indice_sub-$indice_preg' class='pregunta-container'>";
        $html .= "<div class='texto_formulario'>" . $pregunta->texto . ($pregunta->obligatoria ? "<span class='mandatory'> * </span>" : "") . "</div> <div class='container-respuestas-custom-form'>";
        $html .= "
        <div class='table' id='table-formulario-pregunta-$indice_cat-$indice_sub-$indice_preg'>
            <div class='row'> ";
        foreach ($pregunta->columnas as $indice_res => $columna) {
            $nombreColumna = $columna->nombre;
            $html .= "
            <div class='header'>$nombreColumna</div>
                    ";
        }
        $html .= "
            </div>
            <div class='row'>";
        foreach ($pregunta->columnas as $indice_res => $columna) {
            $nombreColumna = $columna->nombre;
            $tipoTexto = $columna->tipo;
            $placeHolder = $columna->placeHolder;
            /*$html .= "
                    <div class='cell'><input class='input_custom_formulario' type='$tipoTexto' id='formulario-respuesta-$indice_cat-$indice_sub-$indice_preg-$indice_res-0' name='formulario-respuesta-$indice_cat-$indice_sub-$indice_preg' required minlength='1' maxlength='100' placeholder='$placeHolder'/></div>
                    ";*/
        }

        $html .= "
            </div>
        </div>
        
                        ";
        $html .= "</div> <button id='button-formulario-pregunta-$indice_cat-$indice_sub-$indice_preg'> Agregar </button>";
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
                <input class='input_custom_formulario' type='$tipoTexto' id='formulario-respuesta-$indice_cat-$indice_sub-$indice_preg-0' name='formulario-respuesta-$indice_cat-$indice_sub-$indice_preg' required minlength='1' maxlength='100' placeholder='$placeHolder' $able  $extra/>
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
        } elseif ($pregunta->tipo == "TABLE") {
            $html = $this->getHTMLPreguntaTABLE($pregunta, $indice_cat, $indice_sub, $indice_preg, $subgrupo);
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
        $funcion = 3;
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


            //insertar registro en formualrios respondidos
            $varInsertar = "INSERT INTO `{$wpdb->prefix}forms_responses` (`id_envio`, `form_attended`) VALUES (%d, '0');";
            $variables = [$inserted_form_id];
            $consulta = $wpdb->prepare(
                $varInsertar,
                $variables
            );
            //var_dump($consulta);
            $wpdb->query($consulta);

            return $inserted_form_id;
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

        if (isset($_POST['formulario-respuesta-captura'])) {

            $formulario_respuesta_puntaje = 0;//number_format(floatval($_POST['formulario-respuesta-puntaje']), 1);
            //$formulario_respuesta_captura = json_decode(str_replace('\\', '', $_POST['formulario-respuesta-captura']));
            $formulario_respuesta_captura = json_decode(str_replace('######', '\\', str_replace('\\', '', str_replace('\\\\\\', '######', $_POST['formulario-respuesta-captura']))));
            $correo = "";
            $facultad = "";
            $edificio = "";
            $celular = "";
            $rotulos = "";

            //echo("tamo activo");
            //echo($_POST['formulario-respuesta-captura']);
            //echo("\n");
            //echo(str_replace('######', '\\', str_replace('\\', '', str_replace('\\\\\\', '######', $_POST['formulario-respuesta-captura']))));
            //echo($formulario_respuesta_captura);
            $idLab = 0;

            if ($this->funcion == "autodiagnostico") {
                foreach ($formulario_respuesta_captura as $respuesta) {
                    if ($respuesta->id_elemento == "formulario-respuesta-0-0-0-0") {
                        $correo = $respuesta->respuesta;
                    }
                }
            } else {
                foreach ($formulario_respuesta_captura as $respuesta) {
                    if ($respuesta->id_elemento == "formulario-respuesta-0-0-0-0") {
                        $correo = $respuesta->respuesta;
                    } else if ($respuesta->id_elemento == "formulario-respuesta-0-1-1-0") {
                        $facultad = $respuesta->respuesta;
                    } else if ($respuesta->id_elemento == "formulario-respuesta-0-1-2-0") {
                        $edificio = $respuesta->respuesta;
                    } else if ($respuesta->id_elemento == "formulario-respuesta-0-1-3-0") {
                        $celular = $respuesta->respuesta;
                    } else if ($respuesta->id_elemento == "formulario-respuesta-1-2-0-0") {
                        $rotulos = $respuesta->respuesta;
                    }
                }
            }

            $inserted_form_id = $this->uploadFormResponse($formulario_respuesta_puntaje, $formulario_respuesta_captura);

            $permalink = get_permalink();

            $stringCambio = "";

            $extraSeguimiento = "";

            $correo = escapeshellarg($correo); // Reemplaza con el valor real o asegúrate de que esté definido
            $facultad = escapeshellarg($facultad);
            $edificio = escapeshellarg($edificio);
            $celular = escapeshellarg($celular);
            $rotulos = escapeshellarg(str_replace('"', '##8#8##8###', $rotulos));

            $pythonScript = 'C:\\Users\\juane\\OneDrive\\Escritorio\\recoleccion insumos\\prueba.py';
            // Construye el comando asegurándote de escapar la ruta del script de Python
            $command = escapeshellcmd("python \"$pythonScript\" $correo $facultad $edificio $celular $rotulos $inserted_form_id 2>&1");
            //echo $command;
            // Ejecuta el comando
            $output = shell_exec($command);
            //echo $output;
            $output = json_decode($output);
            //echo $output;
            $msgFormato = "";
            if ($output->tipe == "success") {
                $url = $output->url;
                $msgFormato = "<a href='$url'>Ver documento</a>";
            } else if ($output->tipe == "error") {
                $msgFormato = "Ha habido un error creando el archivo";
            }
            // Imprime la salida

            $HTMLBodyStructure = "
                <div class='mensaje-respuesta-container' style='background-color: rgba(255,255,255,0.95);border: 0;padding: 15px;font-size: 1.3em;flex-direction: column;align-items: center;border-radius: 10px; display: flex;  gap: 15px;line-height: 1;padding: 15px;color: rgba(0,0,0,0.75);max-width: 700px;margin: 0 auto;'>
                    <div>Se ha recibido su respuesta</div>
                    <br>
                    $msgFormato
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
            <div class='mensaje-respuesta-container' style='background-color: rgba(255,255,255,0.95);border: 0;padding: 15px;font-size: 1.3em;flex-direction: column;align-items: center;border-radius: 10px; display: flex;  gap: 15px;line-height: 1;padding: 15px;color: rgba(0,0,0,0.75);max-width: 700px;margin: 0 auto;'>
                <div>Se ha recibido su respuesta</div>
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

            // Imprime la salida

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
                    <button class='btn_custom_form notVisible' onclick='formulario.retroceder();' id='btn_formulario_retroceder'>Anterior</button>
                    <button class='btn_custom_form' onclick='formulario.avanzar();' id='btn_formulario_avanzar'>Siguiente</button>
                    <button onclick='formulario.verificarRespuestas();' class=' notVisible btn_custom_form' id='btn_formulario_enviar'>Enviar</button>
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

                <button class='btn_custom_form' onclick='cerrarPopUpIndicadiones()'>Continuar</button>
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