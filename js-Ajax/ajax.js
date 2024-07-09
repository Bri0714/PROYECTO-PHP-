// formularios enviados por ajax

const formularios = document.querySelectorAll('.Formulario_ajax');
/* const formulario lo que hace es seleccionar el formulario que tiene la etiqueta form 
 */

function enviar_formulario_ajax(e){
    e.preventDefault() // previene que el formulario se envie por defecto en este caso el action de la etiqueta form estaria evitando que se envie el formulario por defecto .
    /* preventDefault se encarga de detener el comportamiento por defecto de un evento, en este caso el evento submit que es el que se encarga de enviar el formulario */
    
    let enviar = confirm("Quieres enviar el formulario?");
    /* confirm es una ventana emergente que nos permite confirmar si queremos enviar el formulario o no */

    if(enviar == true){


        let data = new FormData(this);
        let method = this.getAttribute("method");
        let action = this.getAttribute("action");

        let encabezados = new Headers();

        let config = {
            method: method,
            headers: encabezados,
            mode: 'cors',
            cache: 'no-cache',
            body: data
        }

        fetch(action,config)
        .then( response => response.text())
        .then( response => {
            let contenedor = document.querySelector(".form-rest");
            contenedor.innerHTML = response;
        });

        // el fetch se utiliza para enviar la informacion del formulario al servidor
        // el primer parametro es la url a la que se va a enviar la informacion
        // el segundo parametro es la configuracion del fetch
        // el metodo es el metodo que se va a utilizar para enviar la informacion
        // los headers son los encabezados que se van a enviar ejemplo el tipo de contenido y el modo de acceso 
        // el modo es el modo de acceso que se va a tener al servidor
        // el cache es el cache que se va a tener de la informacion
        // el body es la informacion que se va a enviar al servidor
        // el then se utiliza para recibir la respuesta del servidor
        // el primer then es para recibir la respuesta del servidor en texto
        // el segundo then es para mostrar la respuesta en una ventana emergente
    }
}

formularios.forEach( formulario => {
    formulario.addEventListener("submit",enviar_formulario_ajax)
});