class Mensajes {

    static MensajeExito(mensaje) {
        $('#mensaje').empty();
        $('#mensaje').removeClass();
        $('#mensaje').addClass('p-3 m-3 bg-success-subtle');
        $('#mensaje').append(`<h3>${mensaje}</h3>`);
        setTimeout(() => {
            $('#mensaje').empty();
            $('#mensaje').removeClass();
        }, 2000)
    }

    static MensajeAdvertencia(mensaje) {
        $('#mensaje').empty();
        $('#mensaje').removeClass();
        $('#mensaje').addClass('p-3 m-3 bg-warning-subtle');
        $('#mensaje').append(`<h3>${mensaje}</h3>`);
        setTimeout(() => {
            $('#mensaje').empty();
            $('#mensaje').removeClass();
        }, 2000)
    }

}