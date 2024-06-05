let modalAlbumGaleria;
let modalAlbumGaleriaLabel;
let modalContentAlbumGaleria;
let modal_footer_galeria;
let dark_layer;
const objetoMapeadoAlbumes = {};

albumes = SolicitudesBack['albumes'];
ordenGeneral = JSON.parse(SolicitudesBack['orden_general'][0]['ORDEN']);
orders = {}
albumes.forEach(album => {
    orders[album.id] = JSON.parse(album.orden);
});

function getAlbumesHTML(albumes) {
    albumes.forEach(album => {
        svg = `
            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='white' class='bi bi-arrows-angle-expand' viewBox='0 0 16 16'>
                <path fill-rule='evenodd' d='M5.828 10.172a.5.5 0 0 0-.707 0l-4.096 4.096V11.5a.5.5 0 0 0-1 0v3.975a.5.5 0 0 0 .5.5H4.5a.5.5 0 0 0 0-1H1.732l4.096-4.096a.5.5 0 0 0 0-.707zm4.344-4.344a.5.5 0 0 0 .707 0l4.096-4.096V4.5a.5.5 0 1 0 1 0V.525a.5.5 0 0 0-.5-.5H11.5a.5.5 0 0 0 0 1h2.768l-4.096 4.096a.5.5 0 0 0 0 .707z'/>
            </svg>
        `;
        albumContainerHTML = `
            <div class='album-container' data-bs-toggle='modal' data-bs-target='#modalAlbumGaleria' onclick='abrirModal(${album.id})'>
                <span class='album-image-container'>
                    <img src='${album.ID_IMG_PORTADA}'>
                </span>
                <span class='btn-ver-album' type='button' class='btn' data-bs-toggle='modal' data-bs-target='#modalAlbumGaleria' onclick='abrirModal(${album.id})'>
                    ${svg}
                </span>
                <span class='album-tittle'>
                    ${album.nombre}
                </span>
            </div>
        `;
        album['HTML'] = albumContainerHTML;
    });
    return albumes;
}

window.addEventListener("load", (event) => {
    startComponents();
});

function startComponents() {
    console.log('tamo activo sc');
    albumes = getAlbumesHTML(albumes);
    album_row_1 = document.getElementById('album_row_1');
    album_row_2 = document.getElementById('album_row_2');
    album_row_3 = document.getElementById('album_row_3');
    console.log(albumes);
    modalAlbumGaleriaLabel = document.getElementById('modalAlbumGaleriaLabel');
    modalContentAlbumGaleria = document.getElementById('modalContentAlbumGaleria');
    modalAlbumGaleria = document.getElementById('modalAlbumGaleria');
    modal_footer_galeria = document.getElementById('modal_footer_galeria');
    dark_layer = document.getElementById('dark-layer');
    setAlbumsContent(albumes, [album_row_1, album_row_2, album_row_3], ordenGeneral);
}

function setAlbumsContent(albumes, rowHTMLElements, ordenAlbumes) {
    // cantidad de columnas
    rows = 3;

    selectedRowElement = 0;
    //cantidad maxima de elementos por columna
    n = Math.ceil(albumes.length / rows);

    albumes.forEach(album => {
        objetoMapeadoAlbumes[album.id] = album;
    });
    //contador
    c = 0;
    ordenAlbumes.forEach(id_album => {
        if (objetoMapeadoAlbumes[id_album]) {
            c += 1;
            rowHTMLElements[selectedRowElement].innerHTML += objetoMapeadoAlbumes[id_album]['HTML'];
            if (c >= n) {
                c = 0;
                selectedRowElement += 1;
            }
        }
    });
}

function abrirModal(id_album) {
    console.log('abriendo');
    modalAlbumGaleria.showModal();
    dark_layer.style.display='inline';
    console.log(objetoMapeadoAlbumes);
    modalAlbumGaleriaLabel.innerHTML = objetoMapeadoAlbumes[id_album].nombre;
    setHeight();
    setLoadingIcon();
    getFotosAlbum(id_album)
}

function setHeight(){
    alturaModal = modalAlbumGaleria.clientHeight
    alturaTitulo = modalAlbumGaleriaLabel.clientHeight+20
    alturaFooter = modal_footer_galeria.clientHeight
    alturaPaddingModal = 15;
    tolerancia = 15;
    alturaBody = alturaModal - alturaTitulo - alturaFooter - 2*alturaPaddingModal - tolerancia;
    modalContentAlbumGaleria.style.height = alturaBody+'px';
}

function setLoadingIcon() {
    modalContentAlbumGaleria.style.display='auto'
    modalContentAlbumGaleria.innerHTML = `
        <div><br><br><br><br><br><br></div>
        <div class='position-relative'>
            <div class='position-absolute top-50 start-50 translate-middle'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                    class='bi bi-arrow-clockwise svg-cargando' viewBox='0 0 16 16'>
                    <path fill-rule='evenodd' d='M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z' />
                    <path
                        d='M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z' />
                </svg>
            </div>
        </div>   
        <div><br><br><br><br><br><br></div>    
    `;
}

function getFotosAlbum(id_album) {
    console.log('entra a getFotos: ', id_album);

    const data = new URLSearchParams({
        action: 'peticionFotosAlbum',
        id_album: id_album
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
        .then(response => startModal(response, id_album))
        .catch(error => {
            // Manejar errores
            throw new Error(error);
        });
    //.then(response => console.log(response));
}

function startModal(fotos, id_album) {
    console.log(fotos)
    console.log(orders[id_album])
    rows = 3
    n = Math.ceil(fotos.length / rows);
    c = 0;
    let objetoMapeadoFotos = {};
    fotos.forEach(foto => {
        objetoMapeadoFotos[foto.ID_FOTO_ALBUM] = foto;
    });

    div = document.createElement('div');
    div.classList.add('modalrowAlbumGaleria');
    modalContentAlbumGaleria.innerHTML = ""
    modalContentAlbumGaleria.style.display='flex'
    orders[id_album].forEach(id_foto => {
        c += 1;
        div.innerHTML += `
            <div class='modalElementAlbumGaleria'>
                <img src='${objetoMapeadoFotos[id_foto].DIRECCION_FOTO}'">
                <span>${objetoMapeadoFotos[id_foto].DESCRIPCION_FOTO}</span>
            </div>
        `
        if (c >= n) {
            modalContentAlbumGaleria.appendChild(div);
            c = 0;
            div = document.createElement('div');
            div.classList.add('modalrowAlbumGaleria');
        }
    });
    modalContentAlbumGaleria.appendChild(div);

}

function closeModal(){
    modalAlbumGaleria.close();
    dark_layer.style.display='none';
}