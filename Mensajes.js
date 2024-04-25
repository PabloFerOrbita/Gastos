class Mensajes {

    static MensajeExito(mensaje) {
        this.Mensaje(mensaje, 'p-3 m-3 bg-success-subtle')
    }

    static MensajeAdvertencia(mensaje) {
        this.Mensaje(mensaje, 'p-3 m-3 bg-warning-subtle')
    }

    static MensajeError(mensaje){
        this.Mensaje(mensaje, 'p-3 m-3 bg-danger-subtle')
    }

    static Mensaje(mensaje, clases){
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