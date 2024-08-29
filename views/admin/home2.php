<?php include_once 'views/templates/header.php'; ?>

<div style="padding: 12px;">

    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 d-flex justify-content-around">
        <!-- Usuarios -->
        <div class="col">
            <div class="card radius-10">
                <div class="card-body custom-card">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 ">Total Usuarios</p>
                            <h4 class="my-2 fw-bold"><?php echo $data['usuarios']['total']; ?></h4>
                            <a style="color: black;" class="mb-0 font-13" href="<?php echo BASE_URL . 'usuarios'; ?>">Ver Detalle</a>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto">
                            <a style="color: white;" href="<?php echo BASE_URL . 'usuarios'; ?>"><i class='fas fa-user'></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Usuarios -->
        <div class="col">
            <div class="card radius-10">
                <div class="card-body custom-card2">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0">Total Clientes</p>
                            <h4 class="my-2 fw-bold"><?php echo $data['clientes']['total']; ?></h4>
                            <a style="color: black;" class="mb-0 font-13" href="<?php echo BASE_URL . 'clientes'; ?>">Ver Detalle</a>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i class='fas fa-users'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card radius-10">
                <div class="card-body custom-card4">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0">Total Productos</p>
                            <h4 class="my-2 fw-bold"><?php echo $data['productos']['total']; ?></h4>
                            <a style="color: black;" class="mb-0 font-13" href="<?php echo BASE_URL . 'productos'; ?>">Ver Detalle</a>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto">
                            <i class='fas fa-list'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <br />
    <h4 class="">Total ventas:
        <?php
        // Establecer la conexión a la base de datos
        $conexion = new mysqli("localhost", "root", "", "sistema");

        // Verificar la conexión
        if ($conexion->connect_error) {
            die("Error en la conexión: " . $conexion->connect_error);
        }

        // Ejecutar la consulta SQL para obtener la suma de las ventas por año
        $sql = "SELECT DATE_FORMAT(fecha, '%Y') AS ano, SUM(pago) AS total
        FROM ventas
        GROUP BY DATE_FORMAT(fecha, '%Y')";
        $resultado = $conexion->query($sql);

        // Verificar si se obtuvieron resultados
        if ($resultado->num_rows > 0) {
            // Iterar sobre los resultados y mostrar el total de ventas por año
            while ($fila = $resultado->fetch_assoc()) {
                // Formatear el resultado en pesos colombianos
                $total_pesos = number_format($fila['total'], 0, ',', '.');

                // Mostrar el resultado
                echo '' . $fila['ano'] . ': <span style="color: white; background-color: #3730a3;" class="badge rounded-pill text-bg-primary">' . $total_pesos . ' COP</span>';
            }
        } else {
            echo "No se encontraron resultados.";
        }

        // Cerrar la conexión
        $conexion->close();
        ?> </h4>





    <h4 class="">Total ventas mes actual<?php
                                            // Establecer la conexión a la base de datos
                                            $conexion = new mysqli("localhost", "root", "", "sistema");

                                            // Verificar la conexión
                                            if ($conexion->connect_error) {
                                                die("Error en la conexión: " . $conexion->connect_error);
                                            }

                                            // Obtener el mes actual
                                            $mes_actual = date('m');

                                            // Ejecutar la consulta SQL para obtener el valor ganado por mes
                                            $sql = "SELECT MONTH(fecha) AS mes, SUM(pago) AS total_mes
        FROM ventas
        WHERE MONTH(fecha) = $mes_actual
        GROUP BY MONTH(fecha)";
                                            $resultado = $conexion->query($sql);

                                            // Verificar si se obtuvieron resultados
                                            if ($resultado->num_rows > 0) {
                                                // Iterar sobre los resultados y mostrar el valor total ganado por mes
                                                while ($fila = $resultado->fetch_assoc()) {
                                                    // Obtener el nombre del mes
                                                    $nombre_mes = date('F', mktime(0, 0, 0, $fila['mes'], 1));

                                                    // Mostrar el valor total ganado por mes dentro de un span
                                                    echo ": $nombre_mes: <span style='color: white; background-color: #3730a3;' class='badge rounded-pill text-bg-primary'>" . number_format($fila['total_mes'], 0, ',', '.') . " COP</span><br>";
                                                }
                                            } else {
                                                echo "No se encontraron resultados para el mes actual.";
                                            }

                                            // Cerrar la conexión
                                            $conexion->close();
                                            ?></h4>
    <br />



    <div class="card custom-card-table radius-10">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0">Compras y Ventas</h6>
                </div>
                <div class="form-group">
                    <label for="anio">Año</label>
                    <select style="border: none;" id="anio" onchange="comparacion()">
                        <?php
                        $fecha = date('Y');
                        for ($i = 2010; $i <= $fecha; $i++) { ?>
                            <option value="<?php echo $i; ?>" <?php echo ($fecha == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="d-flex align-items-center ms-auto font-13 gap-2 my-3">
                <span class=" px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #14abef"></i>Ventas</span>
                <span class=" px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #ffc107"></i>Compras</span>
            </div>
            <div class="chart-container-1">
                <canvas id="comparacion"></canvas>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-2 g-0 row-group text-center">
            <div class="col">
                <div class="p-3">
                    <h5 class="mb-0" id="totalVentas">00</h5>
                    <small class="mb-0">Total Ventas</small>
                </div>
            </div>
            <div class="col">
                <div class="p-3">
                    <h5 class="mb-0" id="totalCompras">00</h5>
                    <small class="mb-0">Total Compras</small>
                </div>
            </div>
        </div>
    </div>

    <!--end row-->

    <div class="row">
        <div class="col-12 col-lg-8">



            <!-- TOP -->
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Top Productos</h6>
                        </div>
                        <div class="dropdown ms-auto">
                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo BASE_URL . 'admin/topProductosPdf'; ?>" target="_blank"><i class="fas fa-file-pdf text-danger"></i> Reporte PDF</a>
                                </li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL . 'admin/topProductosExcel'; ?>"><i class="fas fa-file-excel text-success"></i> Reporte Excel</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="chart-container-2 mt-4">
                        <canvas id="topProductos"></canvas>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <?php foreach ($data['top'] as $top) { ?>
                        <li style="border: none;" class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                            <?php echo $top['descripcion']; ?> <span class="badge bg-dark rounded-pill"><?php echo $top['ventas']; ?></span>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- TOP -->


        </div>
        <div class="col-12 col-lg-4">


            <!-- <div style="display: none;" class="col d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-header bg-transparent">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Productos con Stock Mínimo</h6>
                            </div>
                            <div class="dropdown ms-auto">
                                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?php echo BASE_URL . 'admin/stockMinimoPdf'; ?>" target="_blank"><i class="fas fa-file-pdf text-danger"></i> Reporte PDF</a>
                                    </li>
                                    <li><a class="dropdown-item" href="<?php echo BASE_URL . 'admin/stockMinimoExcel'; ?>"><i class="fas fa-file-excel text-success"></i> Reporte Excel</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container-1">
                            <canvas id="stockMinimo"></canvas>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h2> <a style="font-size: 15px;" class="dropdown-item" href="<?php echo BASE_URL . 'admin/stockMinimoPdf'; ?>" target="_blank"><i class="fas fa-file-pdf text-danger"></i> Ver Stock Mínimo</a></h2>

                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto">
                                <i class="fa-solid fa-cart-plus"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="font-weight-bold mb-1 text-secondary">Gastos por Mes</p>
                            <div class="form-group">
                                <label for="anioGasto">Año</label>
                                <select id="anioGasto" onchange="reporteGastos()">
                                    <?php
                                    $fecha = date('Y');
                                    for ($i = 2010; $i <= $fecha; $i++) { ?>
                                        <option value="<?php echo $i; ?>" <?php echo ($fecha == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="chart-container-0">
                            <canvas id="gastos"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- code -->
            <!-- <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h4> <a style="color: black; font-size: 18px" class="mb-0 font-13" href="<?php echo BASE_URL . 'ventas'; ?>">Nueva venta</a></h4>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto">
                                <i class="fa-solid fa-cart-plus"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h4> <a style="color: black; font-size: 18px" class="mb-0 font-13" href="<?php echo BASE_URL . 'inventarios'; ?>">Añadir inventario</a></h4>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto">
                                <i class="fa-solid fa-plus"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h4> <a style="color: black; font-size: 18px" class="mb-0 font-13" href="<?php echo BASE_URL . 'cajas'; ?>">Abrir Caja</a></h4>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!--  -->
        </div>
    </div>
    <!--end row-->

    <br><br>

    <!--end row -->

    <?php include_once 'views/templates/footer.php'; ?>