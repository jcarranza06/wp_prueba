console.log('tamo activos');

console.log(SolicitudesBack);

let modalTittle;
let tabla_fotos_modal;
let inputNuevaFoto;
let btnNuevaFoto;
let idAlbumSeleccionado;
let orden_fotos;
let timestamp;
let inputOrdenAnterior;
let ordenGeneral;

function setModalTittle(name_album) {
    modalTittle.innerHTML = name_album;
}

function agregarFotoAAlbum() {
    direccion_foto = inputNuevaFoto.value;
    if (direccion_foto === "") {
        console.log('no hay nada');
        return
    }

    timestamp = Date.now();
    const data = new URLSearchParams({
        action: 'peticionAddFotosAlbum',
        id_album: idAlbumSeleccionado,
        direccion_foto: direccion_foto,
        orden_fotos: JSON.stringify(orden_fotos),
        timestamp: timestamp
    });
    console.log(data.toString());
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded' // Cambiar el tipo de contenido a x-www-form-urlencoded
        },
        body: data.toString() // Convertir los datos a una cadena de consulta
    };

    /*fetch(SolicitudesBack.urlBack, options)
        .then(response => {
            if (response.ok) {
                console.log('respuesta exitosa');
                console.log(response);
                console.log(response.json())
                return response.json();
            } else {
                throw new Error('Error en la respuesta del servidor.');
            }
        })
        .then(response => {
            console.log('json ', response);
            getFotosAlbum(idAlbumSeleccionado, response);
            getAlbumes();
        })
        .catch(error => {
            // Manejar errores
            throw new Error(error);
        });*/
    fetch(SolicitudesBack.urlBack, options)
        .then(response => response.json())
        .then(response => {
            console.log('json ', response);
            getFotosAlbum(idAlbumSeleccionado, response);
            getAlbumes();
        })
        .catch(error => {
            // Manejar errores
            throw new Error(error);
        });
}
//id_album= (int) id de la foto en bd
//name = (string) nombre del album
//orden = (string) json del [] arreglo de orden
//visible = (bool) true si el album es visible, false para no visible
function setModal(id_album, name, orden, visible) {
    idAlbumSeleccionado = id_album;
    orden_fotos = JSON.parse(orden)
    console.log(orden)
    setModalTittle(name);
    getFotosAlbum(id_album, orden_fotos);
}

function moveAlbumPosition(ID_ALBUM, subir) {
    console.log('cambiando : ', ID_ALBUM, subir);
    orden_galeria = JSON.parse(inputOrdenAnterior.value);

    position = orden_galeria.indexOf(ID_ALBUM);
    if (subir) {
        if (position === (orden_galeria.length - 1)) {
            //no se puede subir
            return;
        }
        console.log('sube');
        [orden_galeria[position], orden_galeria[position + 1]] = [orden_galeria[position + 1], orden_galeria[position]]
    } else {
        if (position === 0) {
            //no se puede bajar
            return;
        }
        console.log('baja');
        [orden_galeria[position - 1], orden_galeria[position]] = [orden_galeria[position], orden_galeria[position - 1]]
    }
    console.log(orden_galeria);
    timestamp = Date.now();
    const data = new URLSearchParams({
        action: 'updateOrdenGaleria',
        id_album: ID_ALBUM,
        subir: subir,
        ordenGeneralAnterior: JSON.stringify(orden_galeria),
        timestamp: timestamp
    });
    console.log(inputOrdenAnterior.value);
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
        .then(response => {
            console.log('respuesta ', response);
            location.reload();
        })
        .catch(error => {
            // Manejar errores
            throw new Error(error);
        });
}

function changeAlbumVisibility(ID_ALBUM, visibilidad) {
    console.log('cambiando v : ', ID_ALBUM, !visibilidad);
    timestamp = Date.now();
    const data = new URLSearchParams({
        action: 'updateVisibilidadAlbum',
        ID_ALBUM: ID_ALBUM,
        visibilidad: !visibilidad,
        timestamp: timestamp
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
        .then(response => {
            console.log('respuesta ', response);
            location.reload();
        })
        .catch(error => {
            // Manejar errores
            throw new Error(error);
        });
}

function deleteAlbum(i) {
    timestamp = Date.now();
    const data = new URLSearchParams({
        action: 'peticionEliminarAlbum',
        nonce: SolicitudesBack.securityToken,
        id_album: i,
        timestamp: timestamp
    });

    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded' // Cambiar el tipo de contenido a x-www-form-urlencoded
        },
        body: data.toString() // Convertir los datos a una cadena de consulta
    };

    fetch(SolicitudesBack.urlBack, options)
        .then(response => {
            if (response.ok) {
                console.log('exitoso');
                console.log(response);
                location.reload();
            } else {
                throw new Error('Error en la respuesta del servidor.');
            }
        })
        .catch(error => {
            // Manejar errores
            throw new Error('Error');
        });
    //.then(response => console.log(response));
}

window.addEventListener("load", (event) => {
    startComponents();
});

function startComponents() {
    modalTittle = document.getElementById('modalTittle');
    tabla_fotos_modal = document.getElementById('tabla_fotos_modal');
    inputNuevaFoto = document.getElementById('inputNuevaFoto');
    btnNuevaFoto = document.getElementById('btnNuevaFoto');
    inputOrdenAnterior = document.getElementById('inputOrdenAnterior');
    ordenGeneral = JSON.parse(inputOrdenAnterior.value);
}

function deleteFoto(ID_FOTO_ALBUM, ordenJson) {
    console.log('eliminando f :', ID_FOTO_ALBUM)
    orden_fotos = JSON.parse(ordenJson);
    timestamp = Date.now();
    const data = new URLSearchParams({
        action: 'peticionDeleteFotoAlbum',
        id_album: idAlbumSeleccionado,
        id_foto: ID_FOTO_ALBUM,
        orden_fotos: JSON.stringify(orden_fotos),
        timestamp: timestamp
    });

    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded' // Cambiar el tipo de contenido a x-www-form-urlencoded
        },
        body: data.toString() // Convertir los datos a una cadena de consulta
    };

    fetch(SolicitudesBack.urlBack, options)
        .then(response => response.json())
        .then(response => {
            const indice = orden_fotos.indexOf(ID_FOTO_ALBUM); // Obtener el índice del número en el arreglo
            if (indice !== -1) {
                orden_fotos.splice(indice, 1); // Eliminar el número del arreglo
            }
            getFotosAlbum(idAlbumSeleccionado, orden_fotos);
            getAlbumes();
        })
        .catch(error => {
            // Manejar errores
            throw new Error(error);
        });
}

//ID_FOTO_ALBUM = (int) id de la foto en bd
//subir = (bool) indica true en caso de querer subir la foto una posicion, false para bajar
function moveFotoPosition(ID_FOTO_ALBUM, ID_ALBUM, subir) {
    console.log('moviendo foto: ', ID_FOTO_ALBUM, ' de album: ', ID_ALBUM)
    position = orden_fotos.indexOf(ID_FOTO_ALBUM);
    if (subir) {
        if (position === (orden_fotos.length - 1)) {
            //no se puede subir
            return;
        }
        console.log('sube');
        [orden_fotos[position], orden_fotos[position + 1]] = [orden_fotos[position + 1], orden_fotos[position]]
    } else {
        if (position === 0) {
            //no se puede bajar
            return;
        }
        console.log('baja');
        [orden_fotos[position - 1], orden_fotos[position]] = [orden_fotos[position], orden_fotos[position - 1]]
    }

    timestamp = Date.now();
    const data = new URLSearchParams({
        action: 'updateOrdenAlbum',
        id_album: idAlbumSeleccionado,
        nuevo_orden: JSON.stringify(orden_fotos),
        timestamp: timestamp
    });

    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded' // Cambiar el tipo de contenido a x-www-form-urlencoded
        },
        body: data.toString() // Convertir los datos a una cadena de consulta
    };

    fetch(SolicitudesBack.urlBack, options)
        .then(response => response.json())
        .then(response => {
            console.log('respuesta ', response);
            getFotosAlbum(idAlbumSeleccionado, orden_fotos);
            getAlbumes();
        })
        .catch(error => {
            // Manejar errores
            throw new Error(error);
        });
}

function updateFoto(ID_FOTO_ALBUM) {
    console.log('updating foto: ', ID_FOTO_ALBUM)
    textAreaDireccion = document.getElementById('textAreaUpdateFoto[' + ID_FOTO_ALBUM + ']');
    textAreaDescripcion = document.getElementById('textAreaDescripcionFoto[' + ID_FOTO_ALBUM + ']');
    console.log(textAreaDireccion.value)

    timestamp = Date.now();
    const data = new URLSearchParams({
        action: 'updateFotoAlbum',
        id_foto: ID_FOTO_ALBUM,
        nueva_direccion_foto: textAreaDireccion.value,
        nueva_descripcion_foto: textAreaDescripcion.value, 
        timestamp: timestamp
    });

    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded' // Cambiar el tipo de contenido a x-www-form-urlencoded
        },
        body: data.toString() // Convertir los datos a una cadena de consulta
    };

    fetch(SolicitudesBack.urlBack, options)
        .then(response => response.json())
        .then(response => {
            getFotosAlbum(idAlbumSeleccionado, orden_fotos);
        })
        .catch(error => {
            // Manejar errores
            throw new Error(error);
        });
}

function getFotosAlbum(id_album, orden) {
    console.log('entra a getFotos: ', id_album);
    orden_fotos = orden;
    tabla_fotos_modal.innerHTML = `
    <div class="position-relative">
        <div class="position-absolute top-50 start-50 translate-middle">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise svg-cargando" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
            </svg>
        </div>
    </div>
    `;
    timestamp = Date.now();
    const data = new URLSearchParams({
        action: 'peticionFotosAlbum',
        id_album: id_album,
        timestamp: timestamp
    });

    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded' // Cambiar el tipo de contenido a x-www-form-urlencoded
        },
        body: data.toString() // Convertir los datos a una cadena de consulta
    };

    fetch(SolicitudesBack.urlBack, options)
        .then(response => response.json())
        .then(response => startModal(response))
        .catch(error => {
            // Manejar errores
            throw new Error(error);
        });
    //.then(response => console.log(response));
}

function startModal(fotos) {
    console.log('starting modal')
    inputNuevaFoto.value = '';
    tabla_fotos_modal.innerHTML = "";
    console.log(fotos)
    console.log(orden_fotos)
    ordenFotosJson = JSON.stringify(orden_fotos);
    const objetoMapeado = {};
    fotos.forEach(foto => {
        objetoMapeado[foto.ID_FOTO_ALBUM] = foto;
    });
    orden_fotos.forEach(id_foto => {
        tabla_fotos_modal.innerHTML += `
    <tr>
        <td scope="col">
            <img class="imageForGaleryModalCell"
                src="${objetoMapeado[id_foto].DIRECCION_FOTO}"
                alt="">
        </td>
        <td scope="col">
            <span class="label-textArea-Album">Direccion</span>
            <textarea id="textAreaUpdateFoto[${objetoMapeado[id_foto].ID_FOTO_ALBUM}]"class="form-control" aria-label="With textarea">${objetoMapeado[id_foto].DIRECCION_FOTO}</textarea>
            <span class="label-textArea-Album">Descripcion</span>
            <textarea id="textAreaDescripcionFoto[${objetoMapeado[id_foto].ID_FOTO_ALBUM}]"class="form-control" aria-label="With textarea">${objetoMapeado[id_foto].DESCRIPCION_FOTO}</textarea>
        </td>
        <td scope="col">
            <button class="btn-primary" onclick="updateFoto(${objetoMapeado[id_foto].ID_FOTO_ALBUM})">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-arrow-return-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M1.5 1.5A.5.5 0 0 0 1 2v4.8a2.5 2.5 0 0 0 2.5 2.5h9.793l-3.347 3.346a.5.5 0 0 0 .708.708l4.2-4.2a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 8.3H3.5A1.5 1.5 0 0 1 2 6.8V2a.5.5 0 0 0-.5-.5z" />
                </svg>
            </button>
            <button class="btn-primary arrow-movement arrow-down" onclick="moveFotoPosition(${objetoMapeado[id_foto].ID_FOTO_ALBUM},${objetoMapeado[id_foto].ID_ALBUM}, true)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
                </svg>
            </button>
            <button class="btn-primary arrow-movement arrow-up" onclick="moveFotoPosition(${objetoMapeado[id_foto].ID_FOTO_ALBUM},${objetoMapeado[id_foto].ID_ALBUM}, false)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
                </svg>
            </button>
            <button class="btn-primary delete-btn-foto" onclick="deleteFoto(${objetoMapeado[id_foto].ID_FOTO_ALBUM}, '${ordenFotosJson}')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash"
                    viewBox="0 0 16 16">
                    <path
                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                    <path
                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                </svg>
            </button>
        </td>
    </tr>
        `;
    });
}

function getAlbumes() {
    console.log('entra getalbumes')
    timestamp = Date.now();
    const data = new URLSearchParams({
        action: 'peticionAlbumes',
        timestamp: timestamp
    });

    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded' // Cambiar el tipo de contenido a x-www-form-urlencoded
        },
        body: data.toString() // Convertir los datos a una cadena de consulta
    };

    fetch(SolicitudesBack.urlBack, options)
        .then(response => response.json())
        .then(response => setAlbumes(response))
        .catch(error => {
            // Manejar errores
            throw new Error('Error.');
        });

    function setAlbumes(albumes) {

        console.log('recibe', albumes)
        console.log('og: ', ordenGeneral)
        contenido_tabla_albumes = document.getElementById('contenido_tabla_albumes');
        contenido_tabla_albumes.innerHTML = '';
        const objetoMapeado = {};
        albumes.forEach(album => {
            objetoMapeado[album.id] = album;
        });
        ordenGeneral.forEach(id_album => {
            contenido_tabla_albumes.innerHTML += `
            <tr>
                <td>${objetoMapeado[id_album].id}</td>
                <td>${objetoMapeado[id_album].nombre}</td>
                <td>
                    <button class='page-title-action' type='button' data-bs-toggle='modal' data-bs-target='#ModalFotosGaleria' onclick='setModal(${objetoMapeado[id_album].id},\"${objetoMapeado[id_album].nombre}\", \"${objetoMapeado[id_album].orden}\", ${objetoMapeado[id_album].visible})'>Editar</button>
                    <button class='page-title-action' onclick='deleteAlbum(${objetoMapeado[id_album].id})'>Eliminar</button>
                    <button class='page-title-action' onclick='moveAlbumPosition(${objetoMapeado[id_album].id},true)'>Bajar</button>
                    <button class='page-title-action' onclick='moveAlbumPosition(${objetoMapeado[id_album].id},false)'>Subir</button>
                    <button class='page-title-action' onclick='changeAlbumVisibility(${objetoMapeado[id_album].id},$visible)'>${objetoMapeado[id_album].visible === '1' ? 'visible' : 'no visible'}</button>
                </td>
            </tr>
            `;
        });
    }
}