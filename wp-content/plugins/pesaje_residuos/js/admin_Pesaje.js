console.log('tamo activo')

function insertForm(){
    const data = new URLSearchParams({
        action: 'insertarCustomForm'
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
        //.then(response => location.reload())
        .catch(error => {
            // Manejar errores
            throw new Error(error);
        });
}

function deleteForm(id_form){
    console.log("borrando "+ id_form)
    const data = new URLSearchParams({
        action: 'eliminar_form_BD',
        id_form: id_form,
        nonce: SolicitudesBack.securityToken
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
        .then(response => location.reload())
        .catch(error => {
            // Manejar errores
            console.log(error)
            throw new Error(error);
        });

}
function modifyForm(id_form){
    console.log("editando "+ id_form)
    text = document.getElementById("inputFormularioJson-"+id_form).value;
    console.log(text)
    const data = new URLSearchParams({
        action: 'updateCustomFormJson',
        id_form: id_form,
        nonce: SolicitudesBack.securityToken,
        json_form: JSON.stringify(JSON.parse(text))
    });
    console.log(data)
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded' // Cambiar el tipo de contenido a x-www-form-urlencoded
        },
        body: data.toString() // Convertir los datos a una cadena de consulta
    };

    fetch(SolicitudesBack.urlBack, options)
        .then(response => response.json())
        //.then(response => location.reload())
        .catch(error => {
            // Manejar errores
            console.log(error)
            throw new Error(error);
        });
}