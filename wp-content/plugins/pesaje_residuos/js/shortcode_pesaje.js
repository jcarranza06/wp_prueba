class Pregunta {
    constructor(pregunta_, indice_categoria_, indice_subgrupo_, indice_pregunta_) {
        this.texto = pregunta_.texto;

        this.obligatoria = pregunta_.obligatoria
        this.tipo = pregunta_.tipo
        this.indice_categoria = indice_categoria_
        this.indice_subgrupo = indice_subgrupo_
        this.indice_pregunta = indice_pregunta_
        this.domElement = document.getElementById('formulario-pregunta-' + indice_categoria_ + '-' + indice_subgrupo_ + '-' + indice_pregunta_);
        this.domElementsRespuestas = document.getElementsByName("formulario-respuesta-" + indice_categoria_ + '-' + indice_subgrupo_ + '-' + indice_pregunta_);
        this.domElementsRespuestas.forEach(element => {
            element.onclick = (event) => { formulario.captureRespuestas() };
        });
    }
}

class RADIOSELECT extends Pregunta {
    constructor(pregunta_, indice_categoria_, indice_subgrupo_, indice_pregunta_) {
        super(pregunta_, indice_categoria_, indice_subgrupo_, indice_pregunta_);
        this.respuestas = []
        pregunta_.respuestas.forEach(respuesta => {
            this.respuestas.push(respuesta);
        });
    }

    vacear() {
        this.domElementsRespuestas.forEach((elemento, indice) => {
            elemento.checked = false
        });
    }

    getRespuesta() {
        let respuesta = null;
        let indice_seleccionado;
        let obj_seleccionado;
        this.domElementsRespuestas.forEach((elemento, indice) => {
            if (elemento.checked) {
                indice_seleccionado = indice
                respuesta = elemento.value;
                obj_seleccionado = this.respuestas[indice]
            }
        });
        return [respuesta, "formulario-respuesta-" + this.indice_categoria + '-' + this.indice_subgrupo + '-' + this.indice_pregunta + "-" + indice_seleccionado, obj_seleccionado];
    }

}

class SELECT extends Pregunta {
    constructor(pregunta_, indice_categoria_, indice_subgrupo_, indice_pregunta_) {
        super(pregunta_, indice_categoria_, indice_subgrupo_, indice_pregunta_);
        this.respuestas = []
        pregunta_.respuestas.forEach(respuesta => {
            this.respuestas.push(respuesta);
        });
    }

    vacear() {
        this.domElementsRespuestas[0].value = "seleccione";
    }

    validateText(text) {
        return text != ''
    }

    getRespuesta() {
        let respuesta = null;
        let indice_seleccionado;
        let texto = this.domElementsRespuestas[0].value
        if (this.validateText(texto) && texto != 'seleccione') {
            respuesta = texto
            indice_seleccionado = 0
        }
        return [respuesta, "formulario-respuesta-" + this.indice_categoria + '-' + this.indice_subgrupo + '-' + this.indice_pregunta + "-" + indice_seleccionado];
    }

}

class TEXT extends Pregunta {

    constructor(pregunta_, indice_categoria_, indice_subgrupo_, indice_pregunta_) {
        super(pregunta_, indice_categoria_, indice_subgrupo_, indice_pregunta_);
        this.tipoTexto = pregunta_.tipoTexto;
    }

    esCorreoElectronicoValido(correo) {
        // Expresión regular para validar un correo electrónico
        var patronCorreo = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;

        // Usar test() para verificar si la cadena coincide con el patrón
        return patronCorreo.test(correo);
    }

    validateText(text) {
        return text != ''
    }

    vacear() {
        this.domElementsRespuestas[0].value = "";
    }

    getRespuesta() {
        let respuesta = null;
        let indice_seleccionado;
        let texto = this.domElementsRespuestas[0].value
        let flagMail = !(this.tipoTexto == "email");
        if (!flagMail) {
            flagMail = this.esCorreoElectronicoValido(texto);
        }
        if (this.validateText(texto) && flagMail) {
            respuesta = texto
            indice_seleccionado = 0
        }
        return [respuesta, "formulario-respuesta-" + this.indice_categoria + '-' + this.indice_subgrupo + '-' + this.indice_pregunta + "-" + indice_seleccionado];
    }
}

class TABLE extends Pregunta {

    constructor(pregunta_, indice_categoria_, indice_subgrupo_, indice_pregunta_) {
        super(pregunta_, indice_categoria_, indice_subgrupo_, indice_pregunta_);
        this.buttonAddDomElement = document.getElementById("button-formulario-pregunta-" + indice_categoria_ + "-" + indice_subgrupo_ + "-" + indice_pregunta_)
        this.buttonAddDomElement.onclick = () => this.addRow();
        this.tableDomElement = document.getElementById("table-formulario-pregunta-" + indice_categoria_ + "-" + indice_subgrupo_ + "-" + indice_pregunta_)
        this.columnas = pregunta_.columnas
        this.columnasDomElements = []
        console.log("corriendo")
        console.log(pregunta_)
        this.cantidadPreguntas = 1;
        this.addRow()
    }

    esCorreoElectronicoValido(correo) {
        // Expresión regular para validar un correo electrónico
        var patronCorreo = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;

        // Usar test() para verificar si la cadena coincide con el patrón
        return patronCorreo.test(correo);
    }

    addRow() {
        console.log(this.tableDomElement)
        const div = document.createElement('div')
        div.classList.add('row')

        this.columnas.forEach((columna, index) => {
            console.log(index, columna);
            console.log(columna.tipo, columna.placeHolder);
            const cell = document.createElement('div')
            cell.classList.add('cell')
            cell.innerHTML = `
            <input class='input_custom_formulario' type='${columna.tipo}' id='formulario-respuesta-${this.indice_categoria}-${this.indice_subgrupo}-${this.indice_pregunta}-${index}-${this.cantidadPreguntas}' name='formulario-respuesta-${this.indice_categoria}-${this.indice_subgrupo}-${this.indice_pregunta}' required minlength='1' maxlength='100' placeholder='${columna.placeHolder}'/>
            `;
            div.appendChild(cell)
        })
        this.tableDomElement.appendChild(div);
        this.columnasDomElements.push(div)
        this.cantidadPreguntas++;

    }

    validateText(text) {
        return text != ''
    }

    vacear() {
        this.columnasDomElements.forEach((element) => {
            this.tableDomElement.removeChild(element)
        })
        this.columnasDomElements = []
    }

    verifyValidResponse(responses) {
        if (JSON.stringify(responses) === '[]') {
            return null;
        }



        console.log(responses);
        for (let response of responses) {
            for (let columna of this.columnas) {
                console.log(columna);
                if (columna.obligatoria) {
                    console.log('obligatoria');
                    console.log(columna.nombre);
                    console.log(response);
                    console.log(response[columna.nombre] === "");
                    if (response[columna.nombre] === "") {
                        console.log('sale');
                        return null;
                    }
                }
            }
        }
        return JSON.stringify(responses);
    }

    allAtributesNull(obj) {
        for (let key in obj) {
            if (obj[key] !== null && obj[key] !== "") {
                return false;
            }
        }
        return true;
    }

    clearRespuesta(responses) {
        const newResponses = []
        responses.forEach((response, index) => {
            if (!this.allAtributesNull(response)) {
                newResponses.push(response)
            }
        })
        return newResponses;
    }

    getRespuesta() {
        console.log('entra')
        let responses = []
        console.log(this.columnasDomElements)
        this.columnasDomElements.forEach((element, index) => {
            console.log('llega')
            const response = {}
            const cells = Array.from(element.children)
            cells.forEach((cell, indiceCelda) => {

                response[this.columnas[indiceCelda].nombre] = cell.children[0].value
            })
            responses.push(response)
        })

        responses = this.clearRespuesta(responses);
        return [this.verifyValidResponse(responses), "formulario-respuesta-" + this.indice_categoria + '-' + this.indice_subgrupo + '-' + this.indice_pregunta+"-0"];
    }
}


class Subgrupo {
    constructor(subgrupo_, indice_categoria, indice_subgrupo) {
        this.nombre = subgrupo_.nombre;
        this.preguntas = []
        subgrupo_.preguntas.forEach((pregunta, indice_pregunta) => {
            if (pregunta.tipo == "RADIOSELECT") {
                this.preguntas.push(new RADIOSELECT(pregunta, indice_categoria, indice_subgrupo, indice_pregunta));
            } else if (pregunta.tipo == "TEXT") {
                this.preguntas.push(new TEXT(pregunta, indice_categoria, indice_subgrupo, indice_pregunta));
            } else if (pregunta.tipo == "SELECT") {
                this.preguntas.push(new SELECT(pregunta, indice_categoria, indice_subgrupo, indice_pregunta));
            } else if (pregunta.tipo == "TABLE") {
                this.preguntas.push(new TABLE(pregunta, indice_categoria, indice_subgrupo, indice_pregunta));
            }
        });
        this.domElement = document.getElementById('formulario-subcategoria-' + indice_categoria + '-' + indice_subgrupo);
    }
}

class Categoria {
    constructor(categoria_, indice_categoria) {
        this.nombre = categoria_.nombre;
        this.se_cuenta_en_puntaje = categoria_.se_cuenta_en_puntaje;
        this.subgrupos = []
        categoria_.subgrupos.forEach((subgrupo, indice_subgrupo) => {
            this.subgrupos.push(new Subgrupo(subgrupo, indice_categoria, indice_subgrupo));
        });
        this.domElement = document.getElementById('formulario-categoria-' + indice_categoria);
    }

    hide() {
        this.domElement.style.display = 'none'
    }
    show() {
        this.domElement.style.display = 'flex'
    }
}

class Formulario {
    indice_visible = 0;

    constructor(formulario_) {
        this.nombre = formulario_.nombre;
        this.categorias = []
        //console.log(formulario_)
        formulario_.categorias.forEach((categoria, indice) => {
            //console.log(categoria)
            this.categorias.push(new Categoria(categoria, indice));
        });
        this.btnRetroceder = document.getElementById('btn_formulario_retroceder');
        this.btnAvanzar = document.getElementById('btn_formulario_avanzar');
        this.btnEnviar = document.getElementById('btn_formulario_enviar');
        this.capturaRespuestas = localStorage.getItem('a') ? JSON.parse(localStorage.getItem('a')) : {};
        this.formBody = document.getElementById("form-BodyStructure");
        this.navprogress_content = document.getElementsByClassName('navprogress_content')[0];
        let lista_recuperar = document.getElementById("lista_recuperar_formulario");
        for (let clave in this.capturaRespuestas) {
            if (this.capturaRespuestas.hasOwnProperty(clave)) {
                lista_recuperar.innerHTML += `<div onclick='formulario.recuperarFormulario(${clave})'>Laboratorio ${clave}</div>`;
            }
        }
    }

    vaciarFormulario() {
        this.categorias.forEach((categoria, indice_categoria) => {
            categoria.subgrupos.forEach(subgrupo => {
                subgrupo.preguntas.forEach(pregunta => {
                    pregunta.vacear();
                });
            });
        });
    }

    recuperarFormulario(clave) {
        //console.log(clave);
        this.vaciarFormulario()
        this.capturaRespuestas[clave].forEach(respuesta => {
            if (respuesta.clase === "TEXT") {
                document.getElementById(respuesta.id_elemento).value = respuesta.respuesta
            } else if (respuesta.clase === "RADIOSELECT") {
                document.getElementById(respuesta.id_elemento).checked = true;
            } else if (respuesta.clase === "SELECT") {
                document.getElementById(respuesta.id_elemento).value = respuesta.respuesta;
            }
        });
    }

    avanzar() {
        if (this.indice_visible < this.categorias.length - 1) {
            this.categorias[this.indice_visible].hide();
            document.getElementById("navprogress-content-" + this.indice_visible).classList.remove('main_nav_element');
            this.indice_visible++;
            document.getElementById("navprogress-content-" + this.indice_visible).classList.add('main_nav_element');
            this.categorias[this.indice_visible].show();
            this.check_buttons_visibility()
            window.scrollTo({
                top: this.formBody.offsetTop, // Obtén la posición superior del elemento
                behavior: 'smooth' // Opcional: animación de desplazamiento suave
            });
            this.navprogress_content.scrollTo({
                left: document.getElementById('navprogress-content-' + this.indice_visible).offsetLeft - (this.navprogress_content.clientWidth / 2), // Obtén la posición superior del elemento
                behavior: 'smooth' // Opcional: animación de desplazamiento suave
            });
        }
    }

    retroceder() {
        if (this.indice_visible > 0) {
            this.categorias[this.indice_visible].hide();
            document.getElementById("navprogress-content-" + this.indice_visible).classList.remove('main_nav_element');
            this.indice_visible--;
            document.getElementById("navprogress-content-" + this.indice_visible).classList.add('main_nav_element');
            this.categorias[this.indice_visible].show();
            this.check_buttons_visibility()

            window.scrollTo({
                top: this.formBody.offsetTop, // Obtén la posición superior del elemento
                behavior: 'smooth' // Opcional: animación de desplazamiento suave
            });

            this.navprogress_content.scrollTo({
                left: document.getElementById('navprogress-content-' + this.indice_visible).offsetLeft - (this.navprogress_content.clientWidth / 2), // Obtén la posición superior del elemento
                behavior: 'smooth' // Opcional: animación de desplazamiento suave
            });
        }
    }

    verificarEntradasObligatorias() {
        let entradas = []
        //let pasa = true;
        let flag = [true, null]
        this.categorias.forEach((categoria, indice_categoria) => {
            categoria.subgrupos.forEach(subgrupo => {
                subgrupo.preguntas.forEach(pregunta => {
                    if (pregunta.obligatoria) {
                        let [respuesta, id_domElement] = pregunta.getRespuesta();
                        console.log(pregunta)
                        entradas.push(respuesta);
                        if (respuesta == null) {
                            flag = [false, indice_categoria, pregunta.domElement];
                        }
                    }
                });
            });
        });
        return flag;
    }

    desmarcarElementosFaltantes() {
        let elementosFaltantes = document.getElementsByClassName('elementIsLeft');
        //console.log(elementosFaltantes);
        if (elementosFaltantes.length > 0) {
            Array.from(elementosFaltantes).forEach(elemento => {
                elemento.classList.remove('elementIsLeft');
            });
        }
    }

    marcarCategoriaCompleta(i, estaCompleta) {

        let categoria_widget = document.getElementById("navprogress-content-" + i)
        let categoria_widget_next = document.getElementById("navprogress-content-" + (i + 1))
        //console.log(i, estaCompleta, categoria_widget)
        if (estaCompleta) {
            categoria_widget.classList.add("categoria_nav_completa")
            if (categoria_widget_next) {
                categoria_widget_next.classList.add("categoria_nav_completa_next")
            }
        } else {
            categoria_widget.classList.remove("categoria_nav_completa")
            if (categoria_widget_next) {
                categoria_widget_next.classList.remove("categoria_nav_completa_next")
            }

        }
    }

    captureRespuestas() {
        this.desmarcarElementosFaltantes()
        let id;
        if (SolicitudesBack.tipoFormulario === 'autodiagnostico') {
            id = document.getElementById("formulario-respuesta-0-1-0-0");
        } else if (SolicitudesBack.tipoFormulario === 'seguimiento') {
            id = document.getElementById("formulario-respuesta-0-0-0-0");
        } else {
            id = document.getElementById("formulario-respuesta-0-2-0-0");
        }

        let retorna = [];
        if (id) {
            id = id.value;
            console.log(id)
            if (id != null && id != '') {
                this.capturaRespuestas[id] = []
                this.categorias.forEach((categoria, indice_categoria) => {
                    let categoriaCompleta = true;
                    categoria.subgrupos.forEach(subgrupo => {
                        subgrupo.preguntas.forEach(pregunta => {
                            let clase = ""

                            if (pregunta.constructor === TEXT) {
                                clase = "TEXT"
                            } else if (pregunta.constructor === RADIOSELECT) {
                                clase = "RADIOSELECT"
                            } else if (pregunta.constructor === SELECT) {
                                clase = "SELECT"
                            }

                            let [respuesta, id_domElement] = pregunta.getRespuesta();
                            if (respuesta != null) {
                                this.capturaRespuestas[id].push({ 'id_elemento': id_domElement, 'respuesta': respuesta, 'clase': clase, "categoria": categoria.nombre, "subgrupo": subgrupo.nombre, "pregunta": pregunta.texto });
                            } else {
                                categoriaCompleta = false;
                            }
                        });
                    });
                    this.marcarCategoriaCompleta(indice_categoria, categoriaCompleta)
                });

                localStorage.setItem('a', JSON.stringify(this.capturaRespuestas));
                //console.log(this.capturaRespuestas[id]);
                return this.capturaRespuestas[id];
            }
        }

    }

    verificarRespuestas() {
        let [valido, categoria_incompleta, domElement] = this.verificarEntradasObligatorias()
        if (valido) {
            this.enviar();
            console.log("enviando")
        } else {
            this.setVisible(categoria_incompleta);
            domElement.classList.add('elementIsLeft');

            let distanciaAlInicioDeLaPagina = 0;
            let elementoActual = domElement;
            while (elementoActual) {
                distanciaAlInicioDeLaPagina += elementoActual.offsetTop;
                elementoActual = elementoActual.offsetParent;
            }

            window.scrollTo({
                top: distanciaAlInicioDeLaPagina, // Obtén la posición superior del elemento
                behavior: 'smooth' // Opcional: animación de desplazamiento suave
            });
            alert('Faltan preguntas obligatorias por responder en esta sección');
            //console.log('no pasa')
        }
    }


    setVisible(indice) {
        if (this.indice_visible != indice) {
            this.categorias[this.indice_visible].hide();
            document.getElementById("navprogress-content-" + this.indice_visible).classList.remove('main_nav_element');
            this.indice_visible = indice;
            document.getElementById("navprogress-content-" + this.indice_visible).classList.add('main_nav_element');
            this.categorias[indice].show();
            this.check_buttons_visibility()

            this.navprogress_content.scrollTo({
                left: document.getElementById('navprogress-content-' + this.indice_visible).offsetLeft - (this.navprogress_content.clientWidth / 2), // Obtén la posición superior del elemento
                behavior: 'smooth' // Opcional: animación de desplazamiento suave
            });
        }
    }

    check_buttons_visibility() {
        if (this.indice_visible == 0) {
            this.hide_btn(this.btnRetroceder);
        } else {
            this.show_btn(this.btnRetroceder);
        }

        if (this.indice_visible >= this.categorias.length - 1) {
            this.hide_btn(this.btnAvanzar);
            this.show_btn(this.btnEnviar);
        } else {
            this.show_btn(this.btnAvanzar);
            this.hide_btn(this.btnEnviar);
        }
    }

    hide_btn(btn) {
        btn.style.display = 'none'
    }

    show_btn(btn) {
        btn.style.display = 'inline'
    }
}

class Formulario_especifico extends Formulario {
    constructor(formulario_) {
        super(formulario_);
    }

    ontype() {
        //console.log(document.getElementById('formulario-respuesta-0-2-0-0').value)
        let contenido;
        if (SolicitudesBack.tipoFormulario == 'autodiagnostico') {
            contenido = document.getElementById("formulario-respuesta-0-1-0-0");
        } else {
            contenido = document.getElementById('formulario-respuesta-0-2-0-0');
        }
        if (contenido !== "") {
            this.getLaboratorioDB(contenido.value);
        }
    }

    getLaboratorioDB(id_hermes) {
        console.log('entra a getFotos: ', id_hermes);

        const data = new URLSearchParams({
            action: 'peticionLaboratorio',
            id_hermes: id_hermes
        });
        console.log(data.toString());
        const options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded' // Cambiar el tipo de contenido a x-www-form-urlencoded
            },
            body: data.toString() // Convertir los datos a una cadena de consulta
        };

        fetch(SolicitudesBack.urlBack, options)
            .then(response => response.json())
            .then(response => this.setDataLab(response))
            //.then(response => console.log(response))
            .catch(error => {
                // Manejar errores
                throw new Error(error);
            });
        //.then(response => console.log(response));
    }

    setDataLab(data) {
        if (data.length > 0) {
            /*document.getElementById("formulario-respuesta-0-1-1-0").value = data[0].SEDE
            document.getElementById("formulario-respuesta-0-1-2-0").value = data[0].DEPARTAMENTO
            document.getElementById("formulario-respuesta-0-1-3-0").value = data[0].LABORATORIO*/
            if (SolicitudesBack.tipoFormulario == 'autodiagnostico') {
                document.getElementById("formulario-respuesta-0-1-2-0").value = data[0].SEDE
                document.getElementById("formulario-respuesta-0-1-4-0").value = data[0].DEPARTAMENTO
                document.getElementById("formulario-respuesta-0-1-5-0").value = data[0].LABORATORIO
            } else {
                document.getElementById("formulario-respuesta-0-2-2-0").value = data[0].SEDE
                document.getElementById("formulario-respuesta-0-2-4-0").value = data[0].DEPARTAMENTO
                document.getElementById("formulario-respuesta-0-2-5-0").value = data[0].LABORATORIO
            }

        }
    }

    getEvaluacion() {
        this.puntajeTotal = 0
        let categorias_a_contar_en_puntaje = 0

        this.categorias.forEach(categoria => {
            categorias_a_contar_en_puntaje += categoria.se_cuenta_en_puntaje
            //console.log(categorias_a_contar_en_puntaje)
        });

        let factor = 100 / categorias_a_contar_en_puntaje
        this.categorias.forEach((categoria, indice_categoria) => {
            //console.log(categoria)
            if (categoria.se_cuenta_en_puntaje) {
                categoria.puntaje = {
                    "suma": 0,
                    "Evaluados": 0
                }
                categoria.subgrupos.forEach(subgrupo => {
                    subgrupo.preguntas.forEach(pregunta => {
                        let [respuesta, id_elemento_dom, radiobuttonRespuesta] = pregunta.getRespuesta();
                        if (radiobuttonRespuesta) {
                            //console.log('definido');
                            if (radiobuttonRespuesta.contable) {
                                //console.log('contabe');
                                //console.log(pregunta.getRespuesta())
                                categoria.puntaje["suma"] += radiobuttonRespuesta.value;
                                categoria.puntaje["Evaluados"] += radiobuttonRespuesta.valePromedio;
                            }
                        }
                    });
                });
                this.puntajeTotal += categoria.puntaje["suma"] * (factor / categoria.puntaje["Evaluados"]);
                /*console.log('suma', categoria.puntaje["suma"])
                console.log('eva', categoria.puntaje["Evaluados"])
                console.log('pun', categoria.puntaje["suma"] * (factor / categoria.puntaje["Evaluados"]))*/
            }

        });
        //console.log("f: " + factor)
        console.log(this.puntajeTotal)
    }

    enviar() {
        //console.log('enviando')
        if (navigator.onLine) {
            console.log('conectado')
            const respuesta = window.confirm("¿Está seguro de enviar el siguiente formulario? Recuerde que sólo hay una posibilidad de envío");

            if (respuesta === true) {
                //this.getEvaluacion()
                let formDom = document.getElementById("form_send_data")
                //document.getElementById("formulario-respuesta-puntaje").value = this.puntajeTotal;
                document.getElementById("formulario-respuesta-captura").value = JSON.stringify(this.captureRespuestas());
                console.log("ahora si");
                console.log(this.captureRespuestas());
                console.log(JSON.stringify(this.captureRespuestas()))
                console.log(formDom)
                formDom.submit();
            } else {

            }
        } else {
            console.log("El usuario está desconectado de Internet.");
            alert('Conectese a internet para enviar')
        }
    }
}

window.addEventListener("load", (event) => {
    let formBody = document.getElementById("form-BodyStructure");
    if (formBody) {
        console.log(SolicitudesBack);
        //console.log(JSON.parse(SolicitudesBack.formulario));
        formulario = new Formulario_especifico(JSON.parse(SolicitudesBack.formulario));

        const tooltipTriggers = document.querySelectorAll('.preguntaTooltip');
        // Agrega un evento 'mouseover' a cada elemento para mostrar el tooltip
        tooltipTriggers.forEach(trigger => {
            trigger.addEventListener('mouseover', () => {
                const tooltipText = trigger.getAttribute('data-tooltip');
                const tooltip = document.createElement('div');
                tooltip.className = 'custom-tooltip';
                tooltip.textContent = tooltipText;
                trigger.appendChild(tooltip);

                // Configura Popper.js para posicionar el tooltip
                Popper.createPopper(trigger, tooltip, {
                    placement: 'top',
                });
            });

            // Agrega un evento 'mouseout' para ocultar el tooltip
            trigger.addEventListener('mouseout', () => {
                const tooltip = trigger.querySelector('.custom-tooltip');
                if (tooltip) {
                    tooltip.remove();
                }
            });
        });

    } else {
        //console.log("enviado");
    }

});

