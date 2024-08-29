<?php include_once 'views/templates/header.php'; ?>
<br>
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-2 d-flex ms-2 me-2 mt-4 align-items-center">
    <div class="col">
        <h2>Bienvenido: <span class="fw-bold"><?php echo $_SESSION['nombre_usuario']; ?></span> </h2>
        <p style="width: 85%; font-size: 18px;">Gestiona el inventario en tiempo real y aumenta la eficiencia operativa. Desde pequeñas tiendas hasta grandes cadenas.</p>
        <div>
            <span class="mb-3" style="display: flex; align-items: center;">
                <i class="fa-solid fa-tag me-2 rounded-circle p-2" style="font-size: 28px;"></i>
                <h5 class="fw-bold mb-0">Administra tu negocio</h5>
            </span>

            <!-- 
            <span class="mb-3" style="display: flex; align-items: center;">
                <i class="fa-solid fa-down-left-and-up-right-to-center me-2 rounded-circle p-2" style="font-size: 25px;"></i>
                <h5 class="fw-bold mb-0">Crea facturas y reportes</h5>
            </span>

            
            <span class="mb-3" style="display: flex; align-items: center;">
                <i class="fa-solid fa-cash-register me-2 rounded-circle p-2" style="font-size: 25px;"></i>
                <h5 class="fw-bold mb-0">Control de cajas</h5>
            </span> -->
        </div>
    </div>
    <div class="col">
        <div class=" mb-4 d-flex justify-content-center img-custom">

        </div>
    </div>
</div>


<br>
<div style="padding: 12px;">

    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 d-flex">
        <!-- Usuarios -->
        <div class="col mb-3">
            <div class="radius-10 custom-card p-3">
                <div class="mb-2" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="color: #172a54;" class="fw-bold">Usuarios</h3>
                    <i style="font-size: 50px; color: #1c2e4f;" class="fa-solid fa-circle-user"></i>
                </div>
                <hr style="border-color: #1c2e4f 2px;">
                <h5 style="color: #1c2e4f;">Total de usuarios:</h5>

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h1 style="color: #1c2e4f;" class="my-2 fw-bold"><?php echo $data['usuarios']['total']; ?></h1>
                    </div>
                    <div>
                        <a href=""><button style="background-color: #1c2e4f; color: white;" type="button" class="btn">Ver Usuarios</button></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Usuarios -->

        <!-- Usuarios -->
        <div class="col mb-3">
            <div class="radius-10 custom-card2 p-3">
                <div class="mb-2" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="color: #1c2e4f;" class="fw-bold">Clientes</h3>
                    <i style="font-size: 50px; color: #1c2e4f;" class="fa-solid fa-person"></i>
                </div>
                <hr>
                <h5 style="color: #1c2e4f;">Total de Clientes:</h5>

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h1 style="color: #1c2e4f;" class="my-2 fw-bold"><?php echo $data['clientes']['total']; ?></h1>
                    </div>
                    <div>
                        <a href=""><button style="background-color: #1c2e4f; color: white;" type="button" class="btn">Ver Clientes</button></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col mb-3">
            <div class="radius-10 custom-card3 p-3">
                <div class="mb-2" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="color: #1c2e4f;" class="fw-bold">Productos</h3>
                    <i style="font-size: 50px; color: #1c2e4f;" class="fa-solid fa-tag"></i>
                </div>
                <hr>
                <h5 style="color: #1c2e4f;">Total de Productos:</h5>

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h1 style="color: #1c2e4f;" class="my-2 fw-bold"><?php echo $data['productos']['total']; ?></h1>
                    </div>
                    <div>
                        <a href=""><button style="background-color: #1c2e4f; color: white;" type="button" class="btn">Ver Productos</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-2 d-flex ms-2 me-2 align-items-center">
        <div class="col-8">
            <div class="card custom-card-table radius-10">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-3  ">Compras y Ventas</p>
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
        </div>

        <div class="col-4">
            <div class="col d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="font-weight-bold mb-3 text-secondary">Gastos por Mes</p>
                            <div class="form-group">
                                <label for="anioGasto">Año</label>
                                <select style="border: none;" id="anioGasto" onchange="reporteGastos()">
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
        </div>
    </div>

    <div class="card radius-10">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Productos Recientes</h6>
                </div>
                <div class="dropdown ms-auto">
                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo BASE_URL . 'admin/recientesPdf'; ?>" target="_blank"><i class="fas fa-file-pdf text-danger"></i> Reporte PDF</a>
                        </li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL . 'admin/recientesExcel'; ?>"><i class="fas fa-file-excel text-success"></i> Reporte Excel</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th>Precio Compra</th>
                            <th>Precio Venta</th>
                            <th>Fecha</th>
                            <th>Categoria</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['nuevos'] as $nuevo) {
                            if ($nuevo['foto'] == null) {
                                $foto = BASE_URL . 'assets/images/productos/default.png';
                            } else {
                                $foto = BASE_URL . $nuevo['foto'];
                            }
                        ?>
                            <tr>
                                <td><?php echo $nuevo['descripcion']; ?></td>
                                <td>
                                    <span class="badge bg-primary text-white shadow-sm w-100">
                                        <?php echo 'COP ' . number_format($nuevo['precio_compra'], 0, '', '.') . ' COP'; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-success text-white shadow-sm w-100">
                                        <?php echo 'COP ' . number_format($nuevo['precio_venta'], 0, '', '.') . ' COP'; ?>
                                    </span>
                                </td>
                                <td><?php echo $nuevo['fecha']; ?></td>
                                <td><?php echo $nuevo['categoria']; ?></td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <?php include_once 'views/templates/footer.php'; ?>