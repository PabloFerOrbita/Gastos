class Mensajes {

    static mensajeExito(mensaje) {
        this.mensaje(mensaje, 'p-3 m-3 bg-success-subtle')
    }

    static mensajeAdvertencia(mensaje) {
        this.mensaje(mensaje, 'p-3 m-3 bg-warning-subtle')
    }

    static mensajeError(mensaje){
        this.mensaje(mensaje, 'p-3 m-3 bg-danger-subtle')
    }

    static mensaje(mensaje, clases){
        $('#mensaje').empty();
        $('#mensaje').removeClass();
        $('#mensaje').addClass(clases);
        $('#mensaje').append(`<h3>${mensaje}</h3>`);
        setTimeout(() => {
            $('#mensaje').empty();
            $('#mensaje').removeClass();
        }, 2000)
    }
    
   }