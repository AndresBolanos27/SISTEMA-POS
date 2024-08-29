<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL . 'assets/css/ticked.css'; ?>">
    <!-- <link rel="stylesheet" href="<?php echo BASE_URL . 'assets/css/bootstrap.min.css'; ?>"> -->
</head>

<body>
    <center>
        <img src="<?php echo BASE_URL . 'assets/images/logo.png'; ?>" alt="">
    </center>
    <br>
    <div class="datos-empresa">
        <h2 class="text-center fw-bold"><?php echo $data['empresa']['nombre']; ?></h2>
        <p class="text-center"><?php echo $data['empresa']['telefono']; ?></p>
        <p class="text-center"><?php echo $data['empresa']['direccion']; ?></p>
    </div>
    <h5 class="title">Datos del Cliente</h5>
    <div class="datos-info">
        <p><strong><?php echo $data['venta']['identidad']; ?>: </strong> <?php echo $data['venta']['num_identidad']; ?></p>
        <p><strong>Nombre: </strong> <?php echo $data['venta']['nombre']; ?></p>
        <p><strong>Teléfono: </strong> <?php echo $data['venta']['telefono']; ?></p>
    </div>
    <h5 class="title">Detalle de los Productos</h5>
    <table>
        <thead>
            <tr>
                <th>Cant</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>SubTotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $productos = json_decode($data['venta']['productos'], true);
            foreach ($productos as $producto) { ?>
                <tr>
                    <td><?php echo $producto['cantidad']; ?></td>
                    <td><?php echo $producto['nombre']; ?></td>
                    <td><?php echo number_format($producto['precio'], 0); ?></td>
                    <td><?php echo number_format($producto['cantidad'] * $producto['precio'], 0); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td class="text-right" colspan="3">Descuento</td>
                <td class="text-right"><?php echo number_format($data['venta']['descuento'], 0); ?></td>
            </tr>
            <tr>
                <td class="text-right" colspan="3">Total con descuento</td>
                <td class="text-right"><?php echo number_format($data['venta']['total'] - $data['venta']['descuento'], 0); ?></td>
            </tr>
            <tr>
                <td class="text-right" colspan="3">Total sin descuento</td>
                <td class="text-right"><?php echo number_format($data['venta']['total'], 0); ?></td>
            </tr>
            <tr>
                <td class="text-right" colspan="3">Pago con</td>
                <td class="text-right"><?php echo number_format($data['venta']['pago'], 0); ?></td>
            </tr>
            <tr>
                <td class="text-right" colspan="3">Cambio</td>
                <td class="text-right"><?php echo number_format($data['venta']['pago'] - ($data['venta']['total'] - $data['venta']['descuento']), 0); ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <center>
        <h4>¡Gracias por tu compra!</h4>
    </center>

    <!-- <div class="mensaje">
        <h4><?php echo $data['venta']['metodo'] ?></h4>
        <?php echo $data['empresa']['mensaje']; ?>
        <?php if ($data['venta']['estado'] == 0) { ?>
            <h1>Venta Anulado</h1>
        <?php } ?>
    </div> -->

</body>

</html>