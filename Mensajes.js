class Mensajes {

    static mensajeExito(texto) {
        this.mensaje(texto, 'p-3 m-3 bg-success-subtle')
    }

    static mensajeAdvertencia(texto) {
        this.mensaje(texto, 'p-3 m-3 bg-warning-subtle')
    }

    static mensajeError(texto){
        this.mensaje(texto, 'p-3 m-3 bg-danger-subtle')
    }

    static mensaje(texto, clases){
        $('#mensaje').empty();
        $('#mensaje').removeClass();
        $('#mensaje').addClass(clases);
        $('#mensaje').append(`<h3>${texto}</h3>`);
        setTimeout(() => {
            $('#mensaje').empty();
            $('#mensaje').removeClass();
        }, 2000)
    }
    
   }