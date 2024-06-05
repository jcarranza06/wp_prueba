var containerBbtnModifyObjetive;
var containerBtnInsertObjetive;
var titleForm;
var btnCancelModify;
var dataS;
var selectFacultadObjetivo;
var inputNombreObjetivo;
var inputDescipcionObjetivo;
var checkBoxVisible;
var checkBoxVisible;
var idObjetivo;
var ShowModify;
var showInsert;
var clearForm;
var sendModify;
var pressInsert;
var updateList;
var sendDelete;

urlBase = "https://ogabogota.unal.edu.co/wp-content/themes/oficinagestion/"
urlBaseFunctions = 'https://ogabogota.unal.edu.co/wp-content/themes/oficinagestion/includes/functions/';
facultades =["Odontologia","Veterinaria","Medicina","Ingenieria","Derecho","Ciencias","Ciencias Humanas","Ciencias Economicas","Ciencias Agrarias", "Artes", "Enfermeria"]

const dataBase = {
    objetivos: {
        insertObjetive: function (objetive){
            url = new URL(urlBaseFunctions+"insert_objetivo.php")
            //const params = {FACULTAD: "ciencias", NOMBRE:"nuevo", DESCRIPCION: "descripcion",COLOR: "fa1245"};
            Object.keys(objetive).forEach(key => url.searchParams.append(key, objetive[key]));
            fetch(url)
            .then((response) => response.json())
            .then((data) => queryFinal(data));
        },
        modifyObjetive: function (objetive){
            url = new URL(urlBaseFunctions+"update_objetivo.php")
            //const params = {FACULTAD: "ciencias", NOMBRE:"nuevo", DESCRIPCION: "descripcion",COLOR: "fa1245"};
            Object.keys(objetive).forEach(key => url.searchParams.append(key, objetive[key]));
            console.log(url)
            fetch(url)
            .then((response) => response.json())
            .then((data) => queryFinal(data));
        },
        getObjetives: function (){
            url = new URL(urlBaseFunctions+"get_objetivos.php")
            fetch(url)
            .then((response) => response.json())
            .then((data) => setObjetiveList(data));
        },
        deleteObjetive: function (objetive){
            url = new URL(urlBaseFunctions+"delete_objetivo.php")
            Object.keys(objetive).forEach(key => url.searchParams.append(key, objetive[key]));
            console.log(url)
            fetch(url)
            .then((response) => response.json())
            .then((data) => queryFinal(data));
        }
    },
    metas: {
        getGoals: function (goal){
            url = new URL(urlBaseFunctions+"get_metas.php")
            Object.keys(goal).forEach(key => url.searchParams.append(key, goal[key]));
            fetch(url)
            .then((response) => response.json())
            .then((data) => setGoalList(data));
        },
        insertGoal: function (goal){
            url = new URL(urlBaseFunctions+"insert_meta.php")
            Object.keys(goal).forEach(key => url.searchParams.append(key, goal[key]));
            console.log(url)
            fetch(url)
            .then((response) => response.json())
            .then((data) => queryFinal(data));
        },
        modifyGoal: function (goal){
            url = new URL(urlBaseFunctions+"update_meta.php")
            //const params = {FACULTAD: "ciencias", NOMBRE:"nuevo", DESCRIPCION: "descripcion",COLOR: "fa1245"};
            Object.keys(goal).forEach(key => url.searchParams.append(key, goal[key]));
            console.log(url)
            fetch(url)
            .then((response) => response.json())
            .then((data) => queryFinal(data));
        },
        deleteGoal: function (goal){
            url = new URL(urlBaseFunctions+"delete_meta.php")
            Object.keys(goal).forEach(key => url.searchParams.append(key, goal[key]));
            console.log(url)
            fetch(url)
            .then((response) => response.json())
            .then((data) => queryFinal(data));
        }
    },
    avances: {
        getAvances: function (avance){
            url = new URL(urlBaseFunctions+"get_avances.php")
            Object.keys(avance).forEach(key => url.searchParams.append(key, avance[key]));
            console.log(url)
            fetch(url)
            .then((response) => response.json())
            .then((data) => setAvanceList(data));
        },
        insertAvance: function (avance){
            url = new URL(urlBaseFunctions+"insert_avance.php")
            Object.keys(avance).forEach(key => url.searchParams.append(key, avance[key]));
            console.log(url)
            fetch(url)
            .then((response) => response.json())
            .then((data) => queryFinal(data));
        },
        /*modifyAvance: function (avance){
            url = new URL(urlBaseFunctions+"update_avance.php")
            //const params = {FACULTAD: "ciencias", NOMBRE:"nuevo", DESCRIPCION: "descripcion",COLOR: "fa1245"};
            Object.keys(avance).forEach(key => url.searchParams.append(key, avance[key]));
            console.log(url)
            fetch(url)
            .then((response) => response.json())
            .then((data) => console.log(data));
        },*/
        deleteAvance: function (avance){
            url = new URL(urlBaseFunctions+"delete_avance.php")
            Object.keys(avance).forEach(key => url.searchParams.append(key, avance[key]));
            console.log(url)
            fetch(url)
            .then((response) => response.json())
            .then((data) => queryFinal(data));
        }
    }
}

function queryFinal(message){
    alert(message)
    updateList()
}

function init(){
    const valores = window.location.search;
    const urlParams = new URLSearchParams(valores);
    var objetivo = urlParams.get('objetivo');
    var meta = urlParams.get('meta');
    var nombre = urlParams.get('nombre');
    var facultad = urlParams.get('facultad');
    
    console.log(objetivo)
    if(meta != null){
        chargeContainer("avances", meta, nombre);
    }else if(objetivo != null){
        chargeContainer("metas", objetivo, nombre, facultad);
    }else {
        chargeContainer("objetivos",0)
    }
}

function inicializeComponents(){
    document.getElementById("btnInsertObjetive").onclick = function(){
        pressInsertObjetive();
    }
}

function chargeHTMLSection(id, doc, fun){
    // cargar documento (doc ej. 'test.html') html en id del DOM
    var xhr = new XMLHttpRequest();
        xhr.open('POST', doc);
        xhr.setRequestHeader('Content-Type', 'text/plain');
        xhr.send();
        xhr.onload = function (data) {
            document.getElementById(id).innerHTML = data.currentTarget.response;
            fun.initElements(data);
        };
}

function chargeContainer(name, obj, nombreMainTitle, facultadMainTitle){
    if(name === "avances"){
        iniciador = {
            initElements: function(){
                containerBbtnModifyAvance = document.getElementById("containerBbtnModifyAvance"); 
                containerBtnInsertAvance = document.getElementById("containerBtnInsertAvance"); 
                inputDescripcionAvance = document.getElementById("inputDescripcionAvance");
                mainTitle = document.getElementById("mainTitle")
                mainTitle.innerHTML = " "+ nombreMainTitle;
                btnCancelModify = document.getElementById("btnCancelModify");
                idAvance = document.getElementById("idAvance");
                idAvance.style.display='none';
                idMeta = document.getElementById("idMeta");
                idMeta.innerHTML = obj;
                idMeta.style.display='none';
                btnCancelModify.onclick = function(){
                    showInsert();    
                }
                titleForm = document.getElementById("titleForm");
                containerBbtnModifyAvance.style.display="none";
                ShowModify = function (index){
                    console.log(dataS[index])
                    containerBbtnModifyAvance.style.display = 'inline';
                    containerBtnInsertAvance.style.display = 'none';
                    titleForm.innerHTML = "<h2>Modificar "+dataS[index].NOMBRE+"</h2>";
                    selectPorcentaje.selectedIndex = ((dataS[index].PORCENTAJE / 10) - 1);
                    inputDescripcionAvance.value = dataS[index].DESCRIPCION;
                    idAvance.innerHTML = dataS[index].ID_AVANCE;
                    idMeta.innerHTML = obj;
                }
                clearForm = function (){
                    selectPorcentaje.selectedIndex = 0;
                    inputDescripcionAvance.value = ''
                    idAvance.innerHTML = ''
                    idMeta.innerHTML = ''
                }
                showInsert = function (){
                    containerBbtnModifyAvance.style.display = 'none';
                    containerBtnInsertAvance.style.display = 'inline';
                    titleForm.innerHTML = "<h2>Agregar avance</h2>"
                    clearForm();
                }
                sendModify = function (){
                    console.log("enviar");
                    avance = {
                        ID_AVANCE: idAvance.innerHTML,
                        DESCRIPCION: inputDescripcionAvance.value,
                        PORCENTAJE: ((selectPorcentaje.selectedIndex)*10)
                    }
                    console.log(avance)
                    dataBase.avances.modifyAvance(avance);
                }
                pressInsert = function (){
                    console.log("insert: ")
                    avance = {
                        ID_META: idMeta.innerHTML,
                        DESCRIPCION: inputDescripcionAvance.value,
                        PORCENTAJE: (selectPorcentaje.selectedIndex * 10)
                    }
                    //console.log(avance)
                    dataBase.avances.insertAvance(avance);
                }

                updateList = function (){
                    document.getElementById("avanceList").innerHTML='<tr><td class="">Avance</td><td class="">Descripcion</td><td class="">Fecha</td></tr>'
                    dataBase.avances.getAvances({ID_META: obj});
                }

                sendDelete = function (i){  
                    console.log("borrando "+i)
                    dataBase.avances.deleteAvance({ID_AVANCE: i});
                }
            }
        }

        chargeHTMLSection("content_container_planes_manejo",urlBaseFunctions+"administrador-planes-manejo/avances_planes_manejo.html", iniciador)
        meta = {ID_META: obj}
        console.log(obj)
        dataBase.avances.getAvances(meta);
    }else if(name === "metas"){
        iniciador = {
            initElements: function(){
                containerBbtnModifyGoal = document.getElementById("containerBbtnModifyGoal"); 
                containerBtnInsertGoal = document.getElementById("containerBtnInsertGoal"); 
                mainTitle = document.getElementById("mainTitle");
                selectColor = document.getElementById("selectColor");
                mainTitle.innerHTML = " "+ nombreMainTitle +" de " +facultadMainTitle;
                btnCancelModify = document.getElementById("btnCancelModify");
                inputNombreGoal = document.getElementById("inputNombreGoal");
                inputDescipcionGoal = document.getElementById("inputDescipcionGoal");
                idGoal = document.getElementById("idGoal");
                idGoal.style.display='none';
                idObjetivo = document.getElementById("idObjetivo");
                idObjetivo.innerHTML = obj;
                idObjetivo.style.display='none';
                btnCancelModify.onclick = function(){
                    showInsert();    
                }
                titleForm = document.getElementById("titleForm");
                containerBbtnModifyGoal.style.display="none";
                ShowModify = function (index){
                    console.log(dataS[index])
                    containerBbtnModifyGoal.style.display = 'inline';
                    containerBtnInsertGoal.style.display = 'none';
                    titleForm.innerHTML = "<h2>Modificar "+dataS[index].NOMBRE+"</h2>";
                    selectPonderacion.selectedIndex = (dataS[index].PONDERACION - 1);
                    inputNombreGoal.value = dataS[index].NOMBRE
                    selectColor.value = '#'+dataS[index].COLOR;
                    inputDescipcionGoal.value = dataS[index].DESCRIPCION
                    idGoal.innerHTML = dataS[index].ID_META
                    idObjetivo.innerHTML = dataS[index].ID_OBJETIVO
                }
                clearForm = function (){
                    selectPonderacion.selectedIndex = 0;
                    inputNombreGoal.value = ''
                    inputDescipcionGoal.value = ''
                    idGoal.innerHTML = ''
                    idObjetivo.innerHTML = ''
                }
                showInsert = function (){
                    containerBbtnModifyGoal.style.display = 'none';
                    containerBtnInsertGoal.style.display = 'inline';
                    titleForm.innerHTML = "<h2>Agregar Meta</h2>"
                    clearForm();
                }
                sendModify = function (){
                    console.log("enviar");
                    meta = {
                        ID_META: idGoal.innerHTML,
                        NOMBRE: inputNombreGoal.value,
                        DESCRIPCION: inputDescipcionGoal.value,
                        COLOR: selectColor.value.substring(1,selectColor.value.length),
                        PONDERACION: (selectPonderacion.selectedIndex + 1)
                    }
                    console.log(meta)
                    dataBase.metas.modifyGoal(meta);
                }
                pressInsert = function (){
                    console.log("insert: ")
                    meta = {
                        ID_OBJETIVO: idObjetivo.innerHTML,
                        NOMBRE: inputNombreGoal.value,
                        DESCRIPCION: inputDescipcionGoal.value,
                        COLOR: selectColor.value.substring(1,selectColor.value.length),
                        PONDERACION: (selectPonderacion.selectedIndex + 1)
                    }
                    dataBase.metas.insertGoal(meta);
                }
                updateList = function (){
                    document.getElementById("goalList").innerHTML='<tr><td class="">Nombre</td><td class="">Descripcion</td><td class="">Ponderacion</td></tr>'
                    dataBase.metas.getGoals({ID_OBJETIVO: obj});
                }

                sendDelete = function (i){  
                    console.log("borrando "+i)
                    dataBase.metas.deleteGoal({ID_META: i});
                }
            }
        }
        chargeHTMLSection("content_container_planes_manejo",urlBaseFunctions+"administrador-planes-manejo/metas_planes_manejo.html", iniciador)
        objetive = {ID_OBJETIVO: obj}
        dataBase.metas.getGoals(objetive);
    }else {
        iniciador = {
            initElements: function(datas){
                containerBbtnModifyObjetive = document.getElementById("containerBbtnModifyObjetive"); 
                containerBtnInsertObjetive = document.getElementById("containerBtnInsertObjetive"); 
                btnCancelModify = document.getElementById("btnCancelModify");
                selectColor = document.getElementById("selectColor")
                selectFacultadObjetivo = document.getElementById("selectFacultadObjetivo");
                inputNombreObjetivo = document.getElementById("inputNombreObjetivo");
                inputDescipcionObjetivo = document.getElementById("inputDescipcionObjetivo");
                ContainerCheckBoxVisible = document.getElementById("ContainerCheckBoxVisible");
                checkBoxVisible = document.getElementById("checkBoxVisible");
                ContainerCheckBoxVisible.style.display='none';
                idObjetivo = document.getElementById("idObjetivo");
                idObjetivo.style.display='none';
                btnCancelModify.onclick = function(){
                    showInsert();    
                }
                titleForm = document.getElementById("titleForm");
                containerBbtnModifyObjetive.style.display="none";
                ShowModify = function (index){
                    console.log(dataS[index])
                    containerBbtnModifyObjetive.style.display = 'inline';
                    containerBtnInsertObjetive.style.display = 'none';
                    titleForm.innerHTML = "<h2>Modificar "+dataS[index].NOMBRE+"</h2>";
                    selectFacultadObjetivo.selectedIndex = facultades.indexOf(dataS[index].FACULTAD)
                    inputNombreObjetivo.value = dataS[index].NOMBRE;
                    selectColor.value = '#'+dataS[index].COLOR;
                    inputDescipcionObjetivo.value = dataS[index].DESCRIPCION;
                    ContainerCheckBoxVisible.style.display='inline'
                    checkBoxVisible.checked = (dataS[index].VISIBLE === '1') ? true : false;
                    //checkBoxVisible.checked = dataS[index].VISIBLE;
                    idObjetivo.innerHTML = dataS[index].ID_OBJETIVO
                }
                clearForm = function (){
                    selectFacultadObjetivo.selectedIndex = 0;
                    inputNombreObjetivo.value = ''
                    inputDescipcionObjetivo.value = ''
                    idObjetivo.innerHTML = ''
                }
                showInsert = function (){
                    containerBbtnModifyObjetive.style.display = 'none';
                    containerBtnInsertObjetive.style.display = 'inline';
                    titleForm.innerHTML = "<h2>Agregar Objetivo</h2>"
                    ContainerCheckBoxVisible.style.display='none'
                    clearForm();
                }
                sendModify = function (){
                    f = 0
                    if (checkBoxVisible.checked){f=1}
                    objetivo = {
                        FACULTAD: facultades[selectFacultadObjetivo.selectedIndex],
                        NOMBRE: inputNombreObjetivo.value,
                        DESCRIPCION: inputDescipcionObjetivo.value,
                        COLOR: selectColor.value.substring(1,selectColor.value.length),
                        VISIBLE: f/*(checkBoxVisible.checked)? 1:0*/,
                        ID_OBJETIVO: idObjetivo.innerHTML
                    }
                    console.log(objetivo)
                    dataBase.objetivos.modifyObjetive(objetivo);
                }
                pressInsert = function (){
                    console.log("insert: ")
                    objetivo = {
                        FACULTAD: facultades[selectFacultadObjetivo.selectedIndex],
                        NOMBRE: inputNombreObjetivo.value,
                        DESCRIPCION: inputDescipcionObjetivo.value,
                        COLOR: selectColor.value.substring(1,selectColor.value.length)
                    }
                    dataBase.objetivos.insertObjetive(objetivo);

                }
                updateList = function (){
                    document.getElementById("ObjetiveList").innerHTML='<tr><td class="">Facultad</td><td class="">Nombre</td><td class="">Descripcion</td></tr>'
                    dataBase.objetivos.getObjetives();
                }

                sendDelete = function (i){  
                    console.log("borrando "+i)
                    dataBase.objetivos.deleteObjetive({ID_OBJETIVO: i});
                }
            }
        }
        chargeHTMLSection("content_container_planes_manejo",urlBaseFunctions+"administrador-planes-manejo/objetivos_planes_manejo.html", iniciador)
        dataBase.objetivos.getObjetives();
    }
}

function switchModify(){
    containerBbtnModifyObjetive.style.display = (containerBbtnModifyObjetive.style.display != 'inline') ? ShowModify(0): ShowInsert();
}

function setObjetiveList(objetives){
    dataS = objetives;
    table = document.querySelector("#ObjetiveList tbody");
    setTimeout(function(){
    	if(table == null) {location.reload()}
    }, 500);
    for (var i =0; i< objetives.length ; i++){
        tr = document.createElement("tr")
        facultad = document.createElement("td")
        nombre = document.createElement("td")
        descripcion = document.createElement("td")
        modificar = document.createElement("td")
        eliminar = document.createElement("td")
        visible = document.createElement("td")
        facultad.innerHTML = objetives[i].FACULTAD;
        nombre.innerHTML = objetives[i].NOMBRE;
        descripcion.innerHTML = objetives[i].DESCRIPCION;
        hrefimage = "<img src='"+urlBase+"images/nvisible_icon.png' width='30px'>"
        console.log(objetives[i].VISIBLE)
	console.log('entra')
        if(objetives[i].VISIBLE === '1'){hrefimage = "<img src='"+urlBase+"images/visible_icon.png' width='30px'>"}
        visible.innerHTML =hrefimage;
        //visible.innerHTML = (objetives[i].VISIBLE)? "<img src='"+urlBase+"images/visible_icon.png' width='30px'>":"<img src='"+urlBase+"images/nvisible_icon.png' width='30px'>";
        modificar.innerHTML ="modificar"
        eliminar.innerHTML ="eliminar"
        facultad.setAttribute("onclick", "pressObjetive("+objetives[i].ID_OBJETIVO+","+i+")")
        nombre.setAttribute("onclick", "pressObjetive("+objetives[i].ID_OBJETIVO+","+i+")")
        descripcion.setAttribute("onclick", "pressObjetive("+objetives[i].ID_OBJETIVO+","+i+")")
        modificar.setAttribute("onclick", "pressModify("+objetives[i].ID_OBJETIVO+","+i+")");
        eliminar.setAttribute("onclick", "pressDelete("+objetives[i].ID_OBJETIVO+")");
        tr.appendChild(facultad)
        tr.appendChild(nombre)
        tr.appendChild(descripcion)
        tr.appendChild(modificar)
        tr.appendChild(eliminar)
        tr.appendChild(visible)
        //tr.setAttribute("onclick", "pressObjetive("+objetives[i].ID_OBJETIVO+")");
        table.appendChild(tr)
    }
}

function setGoalList(goals){
    dataS = goals;
    table = document.querySelector("#goalList tbody");
    for (var i =0; i< goals.length ; i++){
        tr = document.createElement("tr")
        nombre = document.createElement("td")
        descripcion = document.createElement("td")
        modificar = document.createElement("td")
        eliminar = document.createElement("td")
        ponderacion = document.createElement("td")
        nombre.innerHTML = goals[i].NOMBRE;
        descripcion.innerHTML = goals[i].DESCRIPCION;
        ponderacion.innerHTML = goals[i].PONDERACION;
        modificar.innerHTML ="modificar"
        eliminar.innerHTML ="eliminar"
        nombre.setAttribute("onclick", "pressGoal("+goals[i].ID_META+","+i+")")
        descripcion.setAttribute("onclick", "pressGoal("+goals[i].ID_META+","+i+")")
        modificar.setAttribute("onclick", "pressModify("+goals[i].ID_META+","+i+")");
        eliminar.setAttribute("onclick", "pressDelete("+goals[i].ID_META+")");
        tr.appendChild(nombre)
        tr.appendChild(descripcion)
        tr.appendChild(ponderacion)
        tr.appendChild(modificar)
        tr.appendChild(eliminar)
        //tr.setAttribute("onclick", "pressObjetive("+goals[i].ID_OBJETIVO+")");
        table.appendChild(tr)
    }
}

function setAvanceList(avances){
    console.log("entra")
    dataS = avances;
    table = document.querySelector("#avanceList tbody");
    for (var i =0; i< avances.length ; i++){
        tr = document.createElement("tr")
        descripcion = document.createElement("td")
        fecha = document.createElement("td")
        //modificar = document.createElement("td")
        eliminar = document.createElement("td")
        porcentaje = document.createElement("td")
        descripcion.innerHTML = avances[i].DESCRIPCION;
        fecha.innerHTML = avances[i].FECHA;
        porcentaje.innerHTML = avances[i].PORCENTAJE + '%';
        //modificar.innerHTML ="modificar"
        eliminar.innerHTML ="eliminar"
        /*descripcion.setAttribute("onclick", "pressAvance("+avances[i].ID_avance+")")
        fecha.setAttribute("onclick", "pressAvance("+avances[i].ID_avance+")")*/
        //modificar.setAttribute("onclick", "pressModify("+avances[i].ID_avance+","+i+")");
        eliminar.setAttribute("onclick", "pressDelete("+avances[i].ID_AVANCE+")");
        tr.appendChild(porcentaje)
        tr.appendChild(descripcion)
        tr.appendChild(fecha)
        //tr.appendChild(modificar)
        tr.appendChild(eliminar)
        //tr.setAttribute("onclick", "pressObjetive("+avances[i].ID_OBJETIVO+")");
        table.appendChild(tr)
    }
}

function pressModify(id, index){
    console.log("modify: "+id);
    ShowModify(index);
}

function pressDelete(i){
    console.log("delete: "+i)
    if(confirm("Se borrará este elemento y todos los elementos hijos sin opcion de ser recuperados")){
        console.log('aceptado')
        sendDelete(i);
    }else{
        console.log('rechazado')
    }
}

function pressObjetive(i, index){
	form = document.getElementById("redirectionForm");
	form.action = "https://ogabogota.unal.edu.co/planes-de-manejo/administrador-planes-de-manejo/?objetivo="+i+"&nombre="+dataS[index].NOMBRE+"&facultad="+dataS[index].FACULTAD;
	form.submit();
    //window.location.href="https://ogabogota.unal.edu.co/planes-de-manejo/administrador-planes-de-manejo/?objetivo="+i+"&nombre="+dataS[index].NOMBRE+"&facultad="+dataS[index].FACULTAD;
}
function pressGoal(i, index){
	form = document.getElementById("redirectionForm");
	form.action = "https://ogabogota.unal.edu.co/planes-de-manejo/administrador-planes-de-manejo/?meta="+i+"&nombre="+dataS[index].NOMBRE;
	form.submit();
    //window.location.href="https://ogabogota.unal.edu.co/planes-de-manejo/administrador-planes-de-manejo/?meta="+i+"&nombre="+dataS[index].NOMBRE;
}


init();

//insertObjetive({FACULTAD: "ciencias", NOMBRE:"nuevo", DESCRIPCION: "descripcion",COLOR: "fa1245"});