class RellenarTabla {

    static RellenarGastos(data, categorias = []) {
        data = data.sort((a, b) => {
            return new Date(b.fecha) - new Date(a.fecha)
        });
        data.forEach(element => {
            let fila = $('<tr>');
            if (categorias.length > 0) {
                let categoria = categorias.find(categoria => categoria.id == element.categoria_id);
                $(fila).append(`<td>${this.AMDaDMA(element.fecha)}</td><td>${element.importe}€</td><td>${element.descripcion.replaceAll('<', '&lt;').replaceAll('>', '&gt;')}</td><td>${categoria.nombre}</td><td><a type="button" class="btn btn-primary" href="modificarGasto.php?id=${element.id}">Modificar</a></td>`)
            } else {
                $(fila).append(`<td>${this.AMDaDMA(element.fecha)}</td><td>${element.importe}€</td><td>${element.descripcion.replaceAll('<', '&lt;').replaceAll('>', '&gt;')}</td><td><a type="button" class="btn btn-primary" href="modificarGasto.php?id=${element.id}">Modificar</a></td>`)
            }
            $('#cuerpoTabla').append(fila);

        })
        $('#tabla').removeClass('d-none');
    }


  AMDaDMA(fecha) {
        return fecha.split('-').reverse().join('-');
    }
}