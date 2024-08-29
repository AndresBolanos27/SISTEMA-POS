const tblNuevaVenta = document.querySelector('#tblNuevaVenta tbody');

const idCliente = document.querySelector('#idCliente');
const telefonoCliente = document.querySelector('#telefonoCliente');
const direccionCliente = document.querySelector('#direccionCliente');
const errorCliente = document.querySelector('#errorCliente');

const descuento = document.querySelector('#descuento');
const metodo = document.querySelector('#metodo');
const impresion_directa = document.querySelector('#impresion_directa');

const pagar_con = document.querySelector('#pagar_con');
const cambio = document.querySelector('#cambio');
const totalPagarHidden = document.querySelector('#totalPagarHidden');

document.addEventListener('DOMContentLoaded', function () {
    //cargar productos de localStorage
    mostrarProducto();

    //autocomplete clientes
    $("#buscarCliente").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: base_url + 'clientes/buscar',
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (data) {
                    response(data);
                    if (data.length > 0) {
                        errorCliente.textContent = '';
                    } else {
                        errorCliente.textContent = 'NO HAY CLIENTE CON ESE NOMBRE';
                    }
                }
            });
        },
        minLength: 2,
        select: function (event, ui) {
            telefonoCliente.value = ui.item.telefono;
            direccionCliente.innerHTML = ui.item.direccion;
            idCliente.value = ui.item.id;
        }
    });

    //completar venta
    btnAccion.addEventListener('click', function () {
        let filas = document.querySelectorAll('#tblNuevaVenta tr').length;
        if (filas < 2) {
            alertaPersonalizada('warning', 'CARRITO VACIO');
            return;
        } else if (metodo.value == '') {
            alertaPersonalizada('warning', 'EL METODO ES REQUERIDO');
            return;
        } else {
            const url = base_url + 'ventas/registrarVenta';
            //hacer una instancia del objeto XMLHttpRequest 
            const http = new XMLHttpRequest();
            //Abrir una Conexion - POST - GET
            http.open('POST', url, true);
            //Enviar Datos
            http.send(JSON.stringify({
                productos: listaCarrito,
                idCliente: idCliente.value,
                metodo: metodo.value,
                descuento: descuento.value,
                pago: pagar_con.value,
                // impresion: impresion_directa.checked
            }));

            //verificar estados
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    console.log(this.responseText);
                    alertaPersonalizada(res.type, res.msg);
                    if (res.type == 'success') {
                        localStorage.removeItem(nombreKey);
                        setTimeout(() => {
                            Swal.fire({
                                title: 'Desea Generar Reporte?',
                                showDenyButton: true,
                                showCancelButton: true,
                                confirmButtonText: 'Ticked',
                                denyButtonText: `Factura`,
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    const ruta = base_url + 'ventas/reporte/ticked/' + res.idVenta;
                                    window.open(ruta, '_blank');
                                } else if (result.isDenied) {
                                    const ruta = base_url + 'ventas/reporte/factura/' + res.idVenta;
                                    window.open(ruta, '_blank');
                                }
                                setTimeout(() => {
                                    enviarComprobante(res.idVenta);
                                }, 500);
                            })

                        }, 500);
                    }
                }
            }
        }
    })

    tblHistorial = $('#tblHistorial').DataTable({
        ajax: {
            url: base_url + 'ventas/listar',
            dataSrc: ''
        },
        columns: [
            { data: 'acciones' },
            { data: 'fecha' },
            { data: 'hora' },
            {
                data: 'total',
                render: function (data, type, row) {
                    // Formatear el valor como peso colombiano
                    return formatCurrency(data);
                }
            },
            { data: 'nombre' },
            { data: 'serie' },
            {
                data: 'productos',
                className: 'productos-column', // Agrega una clase CSS personalizada
                render: function (data, type, row) {
                    // Analizar los datos JSON en el campo "productos"
                    var productosData = JSON.parse(data);
    
                    // Verificar si es un arreglo y no está vacío
                    if (Array.isArray(productosData) && productosData.length > 0) {
                        // Construir una cadena que incluya el nombre y la cantidad con un salto de línea
                        var productosString = productosData.map(function (producto) {
                            return producto.nombre + ' (Cantidad: ' + producto.cantidad + ')';
                        }).join('<br>');
    
                        return productosString;
                    } else {
                        // Devolver una cadena vacía o manejar el caso cuando no hay productos
                        return '';
                    }
                }
            },
            { data: 'metodo' }
        ],
        language: {
            url: base_url + 'assets/js/espanol.json'
        },
        dom,
        buttons,
        responsive: {
            // Controla la visibilidad de las columnas en dispositivos más pequeños
            details: {
                type: 'column',
                target: 1 // Aquí especifica la columna "productos" que debe ser responsiva
            }
        },
        order: [[4, 'desc']]
    });
    

     function formatCurrency(value) {
            // Convierte el valor en formato colombiano sin decimales
            return new Intl.NumberFormat('es-CO').format(value);
        }

    //calcular cambio
    pagar_con.addEventListener('keyup', function (e) {
        if (totalPagar.value != '') {
            let totalDescuento = descuento.value != '' ? descuento.value : 0;
            let totalCambio = parseFloat(e.target.value) - (parseFloat(totalPagarHidden.value) - parseFloat(totalDescuento));
            cambio.value = totalCambio.toFixed(0);
        }
    })

    //calcular descuento
    descuento.addEventListener('keyup', function (e) {
        if (totalPagar.value != '') {
            let nuevoTotal = parseFloat(totalPagarHidden.value) - parseFloat(e.target.value);
            totalPagar.value = nuevoTotal.toFixed(2);
            let nuevoCambio = parseFloat(pagar_con.value) - parseFloat(nuevoTotal)
            cambio.value = nuevoCambio.toFixed(0);
        }
    })
})

//cargar productos
function mostrarProducto() {
    if (localStorage.getItem(nombreKey) != null) {
        const url = base_url + 'productos/mostrarDatos';
        //hacer una instancia del objeto XMLHttpRequest 
        const http = new XMLHttpRequest();
        //Abrir una Conexion - POST - GET
        http.open('POST', url, true);
        //Enviar Datos
        http.send(JSON.stringify(listaCarrito));
        //verificar estados
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                let html = '';
                if (res.productos.length > 0) {
                    res.productos.forEach(producto => {
                        html += `<tr>
                            <td>${producto.nombre}</td>
                            <td width="200">
                            <input type="number" class="form-control inputPrecio" data-id="${producto.id}" value="${producto.precio_venta}">
                            </td>
                            <td width="150">
                            <input type="number" class="form-control inputCantidad" data-id="${producto.id}" value="${producto.cantidad}" min="0" step="1" oninput="validarValor(this)">

                            </td>
                            <td>${producto.subTotalVenta}</td>
                            <td><button class="btn btn-danger btnEliminar" data-id="${producto.id}" type="button"><i class="fas fa-trash"></i></button></td>
                        </tr>`;
                    });
                    tblNuevaVenta.innerHTML = html;
                    totalPagar.value = res.totalVenta;
                    totalPagarHidden.value = res.totalVentaSD;

                    btnEliminarProducto();
                    agregarCantidad();
                    agregarPrecioVenta();
                } else {
                    tblNuevaVenta.innerHTML = '';
                }
            }
        }
    } else {
        tblNuevaVenta.innerHTML = `<tr>
            <td colspan="4" class="text-center">CARRITO VACIO</td>
        </tr>`;
    }
}

function validarValor(input) {
    if (input.value < 0) {
      input.value = 0;
    }
  }

function verReporte(idVenta) {
    Swal.fire({
        title: 'Desea Generar Reporte?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ticked',
        denyButtonText: `Factura`,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            const ruta = base_url + 'ventas/reporte/ticked/' + idVenta;
            window.open(ruta, '_blank');
        } else if (result.isDenied) {
            const ruta = base_url + 'ventas/reporte/factura/' + idVenta;
            window.open(ruta, '_blank');
        }
    })
}

function anularVenta(idVenta) {
    Swal.fire({
        title: 'Esta seguro de anular la venta?',
        text: "El stock de los productos cambiarán!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Anular!'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + 'ventas/anular/' + idVenta;
            //hacer una instancia del objeto XMLHttpRequest 
            const http = new XMLHttpRequest();
            //Abrir una Conexion - POST - GET
            http.open('GET', url, true);
            //Enviar Datos
            http.send();
            //verificar estados
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertaPersonalizada(res.type, res.msg);
                    if (res.type == 'success') {
                        tblHistorial.ajax.reload();
                    }
                }
            }
        }
    })
}

function enviarComprobante(idVenta) {
    Swal.fire({
        title: 'Enviar Ticked al correo?',
        text: "Asegurate que el correo este registrado!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Enviar!'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + 'ventas/enviarCorreo/' + idVenta;
            //hacer una instancia del objeto XMLHttpRequest 
            const http = new XMLHttpRequest();
            //Abrir una Conexion - POST - GET
            http.open('GET', url, true);
            //Enviar Datos
            http.send();
            //verificar estados
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertaPersonalizada(res.type, res.msg);
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);

                }
            }
        } else {
            window.location.reload();
        }

    })
}