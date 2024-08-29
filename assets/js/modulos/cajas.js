const monto_inicial = document.querySelector('#monto_inicial');
const btnAbrirCaja = document.querySelector('#btnAbrirCaja');

const formulario = document.querySelector('#formulario');
const monto = document.querySelector('#monto');
const descripcion = document.querySelector('#descripcion');
const btnRegistrarGasto = document.querySelector('#btnRegistrarGasto');

let tblGastos, myChart;

document.addEventListener('DOMContentLoaded', function () {
    //verficar estado
    btnAbrirCaja.addEventListener('click', function () {
        if (monto_inicial.value == '') {
            alertaPersonalizada('warning', 'EL MONTO ES REQUERIDO');
        } else {
            const url = base_url + 'cajas/abrirCaja';
            //hacer una instancia del objeto XMLHttpRequest 
            const http = new XMLHttpRequest();
            //Abrir una Conexion - POST - GET
            http.open('POST', url, true);
            //Enviar Datos
            http.send(JSON.stringify({
                monto: monto_inicial.value
            }));
            //verificar estados
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertaPersonalizada(res.type, res.msg);
                    window.location.reload();
                }
            }
        }
    })
    if (formulario && document.querySelector('#reporteMovimiento')) {

        //cargar datos con el plugin datatables
        $('#tblAperturaCierre').DataTable({
            ajax: {
                url: base_url + 'cajas/listar',
                dataSrc: ''
            },
            columns: [
                {
                    data: 'monto_inicial',
                    render: function (data, type, row) {
                        // Formatear el valor como peso colombiano
                        return formatCurrency(data);
                    }
                    
                },
                { data: 'fecha_apertura' },
                { data: 'fecha_cierre' },
                {
                    data: 'monto_final',
                    render: function (data, type, row) {
                        // Formatear el valor como peso colombiano
                        return formatCurrency(data);
                    }
                },
                { data: 'total_ventas' },
                { data: 'nombre' },
                { data: 'accion' }
            ],
            language: {
                url: base_url + 'assets/js/espanol.json'
            },
            dom,
            buttons,
            responsive: true,
            order: [[0, 'asc']],
        });

        function formatCurrency(value) {
            // Convierte el valor en formato colombiano sin decimales
            return new Intl.NumberFormat('es-CO').format(value);
        }


        //Inicializar un Editor
        ClassicEditor
            .create(document.querySelector('#descripcion'), {
                toolbar: {
                    items: [
                        'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        'alignment', '|',
                        'link', 'blockQuote', 'insertTable', 'mediaEmbed'
                    ],
                    shouldNotGroupWhenFull: true
                },
            })
            .catch(error => {
                console.error(error);
            });

        //registrar gasto
        formulario.addEventListener('submit', function (e) {
            e.preventDefault();
            if (monto.value == '') {
                alertaPersonalizada('warning', 'EL MONTO ES REQUERIDO');
            } else if (descripcion.value == '') {
                alertaPersonalizada('warning', 'LA DESCRIPCIÓN ES REQUERIDA');
            } else {
                const url = base_url + 'cajas/registraGasto';
                insertarRegistros(url, this, tblGastos, btnRegistrarGasto, false);
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        })

        //cargar datos con el plugin datatables
        tblGastos = $('#tblGatos').DataTable({
            ajax: {
                url: base_url + 'cajas/listarGastos',
                dataSrc: ''
            },
            columns: [
                { data: 'monto' },
                { data: 'descripcion' },
                { data: 'foto' }
            ],
            language: {
                url: base_url + 'assets/js/espanol.json'
            },
            dom,
            buttons,
            responsive: true,
            order: [[0, 'asc']],
        });

        movimientos()
    }
})

function movimientos() {
    const url = base_url + 'cajas/movimientos';
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
            var ctx = document.getElementById("reporteMovimiento").getContext('2d');

            myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ["Monto Inicial", "Ingresos", "Gastos", "Egresos", "Saldo", "Compras"],
                    datasets: [{
                        backgroundColor: [
                            '#0c62e0',
                            '#FFE6AC',
                            '#E7D1FC',
                            '#e4ad07',
                            '#83bdfa'

                        ],

                        hoverBackgroundColor: [
                            '#0c62e0',
                            '#FFE6AC',
                            '#E7D1FC',
                            '#e4ad07',
                            '#83bdfa'

                        ],

                        data: [res.montoInicial, res.ingresos, res.gastos, res.egresos, res.saldo, res.egresossolo],
                        borderWidth: [1, 1, 1, 1, 1,1]
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    cutoutPercentage: 0,
                    legend: {
                        position: 'bottom',
                        display: false,
                        labels: {
                            boxWidth: 8
                        }
                    },
                    tooltips: {
                        displayColors: false,
                    },
                }
            });

            let html = `<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                    <div><i class="fas fa-check-circle"></i> Monto Inicial</div> <span class="badge bg-primary rounded-pill">${res.moneda + ' ' + res.inicialDecimal}</span>
                </li>
                <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                    <div><i class="fas fa-check-circle"></i> Ingresos </div> <span style="background: #FFE6AC; color: black;
                    " class="badge rounded-pill">${res.moneda + ' ' + res.ingresosDecimal}</span>
                </li>
                <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                    <div><i class="fas fa-check-circle"></i> Gastos</div> <span style="background: #E7D1FC; color: black;
                    " class="badge rounded-pill">${res.moneda + ' ' + res.gastosDecimal}</span>
                </li>

                <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                    <div><i class="fas fa-check-circle"></i> Compras </div> <span style="background: #E7D1FC; color: black;
                    " class="badge rounded-pill">${res.moneda + ' ' + res.egresossoloDecimal}</span>
                </li>

                <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                    <div><i class="fas fa-check-circle"></i> Total Egresos </div> <span style="color: black;" class="badge bg-warning  rounded-pill">${res.moneda + ' ' + res.egresosDecimal}</span>
                </li>
                <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                    <div><i class="fas fa-check-circle"></i> Saldo </div> <span style="background: #83bdfa; color: black;" class="badge  rounded-pill">${res.moneda + ' ' + res.saldoDecimal}</span>
                </li>`;
            document.querySelector('#listaMovimientos').innerHTML = html;
        }
    }

}

function cerrarCaja() {
    Swal.fire({
        title: 'Esta seguro de cerrar la caja?',
        text: "Los movimientos comenzarán desde cerro!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Cerrar!'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + 'cajas/cerrarCaja';
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
                    if (res.type == 'success') {
                        window.location.reload();
                    }
                }
            }
        }
    })
}

