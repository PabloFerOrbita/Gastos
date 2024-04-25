class RellenarTabla {

    static rellenarGastos(data, categorias = []) {
        if (data.length < 1){
            return;
        }

        data = data.sort((a, b) => {
            return new Date(b.fecha) - new Date(a.fecha)
        });
        data.forEach(element => {
            let fila = $('<tr>');
            if (categorias.length > 0) {
                let categoria = categorias.find(categoria => categoria.id == element.categoria_id);
                $(fila).append(`<td>${this.aniomesdia_a_diamesanio(element.fecha)}</td><td>${element.importe}€</td><td>${element.descripcion.replaceAll('<', '&lt;').replaceAll('>', '&gt;')}</td><td>${categoria.nombre}</td><td><a type="button" class="btn btn-primary" href="modificarGasto.php?id=${element.id}">Modificar</a></td>`)
            } else {
                $(fila).append(`<td>${this.aniomesdia_a_diamesanio(element.fecha)}</td><td>${element.importe}€</td><td>${element.descripcion.replaceAll('<', '&lt;').replaceAll('>', '&gt;')}</td><td><a type="button" class="btn btn-primary" href="modificarGasto.php?id=${element.id}">Modificar</a></td>`)
            }
            $('#cuerpoTabla').append(fila);

        })
        $('#tabla').removeClass('d-none');
        
    }

    static rellenarCategorias(data) {
        if(data.length < 1){
            return;
        }

        data.forEach(element => {
            let fila = $(`<tr id="fila${element.id}">`);
            $(fila).append(`<td>${element.nombre.replaceAll('<', '&lt;').replaceAll('>', '&gt;')}</td><td><a class="btn btn-primary" href="modificarCategoria.php?id=${element.id}">Editar</a></td><td><button class="btn btn-danger eliminar" id="${element.id}">Eliminar</button></td>`);
            $('#cuerpoTabla').append(fila);
        })
        $('#tabla').removeClass('d-none');
    }

    static aniomesdia_a_diamesanio(fecha) {
        return fecha.split('-').reverse().join('-');
    }
}