

let paso =1 ;
const pasoInicial = 1;
const pasoFinal = 3;
const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion(); //*Muestra la seccion de acuerdo al paso
    tabs();//*Cambia la seccion cuando se presionen los tabs
    botonesPaginador();//*Cambia la seccion cuando se presionen los botones de paginador
    paginaSiguiente();
    paginaAnterior();

    consultarAPI(); //*consultar la API EN EL backend de php

    idCliente();//*Genera un id unico para el cliente
    nombreCliente();//*Almacena el nombre del cliente al objeto de cita
    seleccionarFecha();//*Almacena la fecha de la cita al objeto de cita    
    seleccionarHora();//*Almacena la hora de la cita al objeto de cita

    mostrarResumen();//*Muestra el resumen de la cita o mensaje de error en caso de no pasar la validacion
}

function mostrarSeccion(){
    //*Ocultar seccion que tenga la clase mostrar
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
    }
    //* Seleccionar la seccion con el paso
    const pasoSelector =`#paso-${paso}` ;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    //*Eliminar la clase actual en el tab anterior
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }
    //*Mostrar el paso actual en el tab
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');
    botones.forEach(boton => {
        boton.addEventListener('click', function(e){
            paso = parseInt( e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();
        });
    });
}

function botonesPaginador(){
    const paginaSiguiente = document.querySelector('#siguiente');
    const paginaAnterior = document.querySelector('#anterior');
    if(paso === 1){
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if(paso === 3){
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
    } else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
}

function paginaSiguiente(){
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function(){
        paso++;
        if (paso > pasoFinal) return;
        mostrarSeccion();
        botonesPaginador();
    });
}

function paginaAnterior(){
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function(){
        paso--;
        if (paso < pasoInicial) return;
        mostrarSeccion();
        botonesPaginador();
    });
}

async function consultarAPI(){
    try {
        const url = '/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
        
    }
}

function mostrarServicios(servicios){
    servicios.forEach(servicio => {
        const {id, nombre, precio} = servicio;
        //*DOM Scripting
        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `S/ ${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id; //*data-id-servicio
        servicioDiv.onclick = function(){
            seleccionarServicio(servicio);
        };

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioDiv);

        //*Seleccionar el servicio para la
    });
}


function seleccionarServicio(servicio){
    const {id} = servicio;
    const {servicios} = cita;

    //*Comprobar si el servicio ya esta seleccionado
    if(servicios.some(agregado => agregado.id === id)){
        //*Eliminar el servicio del arreglo
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
        divServicio.classList.remove('seleccionado');
    } else {
        //*Agregar el servicio al arreglo
        cita.servicios = [...servicios, servicio];
        const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
        divServicio.classList.add('seleccionado');
    }
}

function idCliente(){
    const id = document.querySelector('#id').value;
    cita.id = id;
}

function nombreCliente(){
    const nombre = document.querySelector('#nombre').value;
    cita.nombre = nombre;
}

function seleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e){
        const dia = new Date(e.target.value).getUTCDay();
        if([6,0].includes(dia)){
            e.target.value = '';
            cita.fecha = '';
            mostrarAlerta('No se puede seleccionar un fin de semana', 'error','.formulario');
        } else {
            cita.fecha = e.target.value;
        }
    });
}


function seleccionarHora(){
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e){
        const horaCita = e.target.value; //* 10:30
        const hora = horaCita.split(':'); //*Separar la hora y los minutos
        if(hora[0] < 10 || hora[0] > 18){
            e.target.value = '';
            cita.hora = '';
            mostrarAlerta('Hora no válida', 'error','.formulario');
        } else {
            cita.hora = e.target.value
        }
    });
}

function mostrarAlerta(mensaje, tipo,elemento, desaparece = true){

    //*Si hay una alerta previa, entonces no crear otra
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia){
        alertaPrevia.remove();
    }

    //*Crear la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    //*Eliminar la alerta despues de 3 segundos
    if(desaparece){
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
}

function mostrarResumen(){
    const resumen = document.querySelector('.contenido-resumen');
    
    //*Limpiar el HTML previo
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }
    
    if(Object.values(cita).includes("")|| cita.servicios.length === 0){
        mostrarAlerta('Faltan datos de servicios, fecha u hora.', 'error','.contenido-resumen',false);
        return;
    }

    //* Formatear el div de resumen
    const {nombre, fecha, hora, servicios} = cita;

    //* Heading para servicios en resumen
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de servicios';
    resumen.appendChild(headingServicios);
    

    //*Iterando y mostrando los servicios
    servicios.forEach(servicio => {
        const {id,nombre, precio} = servicio;
        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio: S/</span> ${precio}`;

        servicioDiv.appendChild(textoServicio);
        servicioDiv.appendChild(precioServicio);

        resumen.appendChild(servicioDiv);
    });

    //* Heading para Cita del cliente
    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de Cita';
    resumen.appendChild(headingCita);
    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;


    //* Formatear la fecha en español
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));

    const opciones = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};
    const fechaFormateada = fechaUTC.toLocaleDateString('es-PE', opciones);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;

    //* Boton para crear la cita
    const botonReserver = document.createElement('BUTTON');
    botonReserver.classList.add('boton');
    botonReserver.textContent = 'Reservar Cita';
    botonReserver.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    resumen.appendChild(botonReserver);

}

async function reservarCita(){
    const {fecha, hora, servicios,id} = cita;
    const idServicios = servicios.map(servicio => servicio.id); //*Extraer los id de los servicios
    const datos = new FormData();
    datos.append('usuarioId', id);
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('servicios', idServicios);

    try {
          //* Peticion hacia la api
        const url = '/api/citas';
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });
        const resultado = await respuesta.json();

        if(resultado.resultado){
            Swal.fire({
                icon: "success",
                title: "Cita creada",
                text: "La cita se creo correctamente",
            }).then(() => {
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            });
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un error al crear la cita",
        });
    }

  


    // console.log([...datos]); //*Convertir el objeto a un arreglo para ver los datos
}
