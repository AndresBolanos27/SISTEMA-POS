<!DOCTYPE html>
<html data-theme="cupcake" lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>

    <link rel="stylesheet" href="./recursos/css/full.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./recursos/css/style.css">
</head>

<body>
    <div class="container m-auto">
        <div class="navbar">
            <div class="navbar-start">
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                        </svg>
                    </div>
                    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a class="text-lg font-bold">Inicio</a></li>
                          <li class="text-lg">
                        <details>
                            <summary>Categorias</summary>
                            <ul class="p-2">
                                <li><a>Fruver</a></li>
                                <li><a>Granero</a></li>
                                <li><a>Lácteos</a></li>
                            </ul>
                        </details>
                    </li>
                        <li><a class="text-lg">Servicios</a></li>
                    </ul>
                </div>
                <img src="./recursos/img/logotienda.png" alt="Logo" class="h-auto max-w-full" style="max-width: 200px;">
            </div>
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal px-1">
                    <li><a class="text-lg font-bold">Inicio</a></li>
                    <li class="text-lg">
                        <details>
                            <summary>Categorias</summary>
                            <ul class="p-2">
                                <li><a>Fruver</a></li>
                                <li><a>Granero</a></li>
                                <li><a>Lácteos</a></li>
                            </ul>
                        </details>
                    </li>
                    <li><a class="text-lg">Servicios</a></li>
                </ul>
            </div>
            <div class="navbar-end">

                <a style="background-color: #198754 !important; color: white; border:#198754 solid 1px" class="btn">Haz tu pedido</a>

            </div>
        </div>
    </div>


 <!-- Botón flotante del carrito -->
<button class="btn btn-circle btn-primary fixed bottom-4 right-4 shadow-lg" onclick="openCartModal()">
    <i class="fas fa-shopping-cart fa-2x"></i>
    <span id="cart-count" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">0</span>
</button>

<!-- Botón flotante del historial de pedidos -->
<button class="btn btn-circle btn-secondary fixed bottom-16 right-4 shadow-lg" onclick="openOrderHistoryModal()">
    <i class="fas fa-history fa-2x"></i>
</button>

<!-- Modal del carrito -->
<dialog id="cart-modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Carrito de Compras</h3>
        <div id="cart-modal-content" class="py-4">
            <!-- Aquí se agregarán los productos -->
        </div>
        <div class="modal-action">
            <button class="btn" onclick="closeCartModal()">Cerrar</button>
            <button class="btn btn-primary" onclick="openPaymentModal()">Finalizar compra</button>
        </div>
    </div>
</dialog>

<!-- Modal de pago -->
<dialog id="payment-modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Detalles de Pago y Envío</h3>
        <div class="py-4">
            <label>
                <input type="radio" name="payment-method" value="Contra Entrega" checked> Contra Entrega
            </label>
            <label>
                <input type="radio" name="payment-method" value="Transferencia"> Transferencia
            </label>
            <label>
                <input type="radio" name="payment-method" value="Mercado Pago"> Mercado Pago
            </label>
            <div class="mt-4">
                <label>Nombre: <input type="text" id="name" class="input input-bordered w-full"></label>
            </div>
            <div class="mt-4">
                <label>Cédula: <input type="text" id="cedula" class="input input-bordered w-full"></label>
            </div>
            <div class="mt-4">
                <label>Dirección: <input type="text" id="address" class="input input-bordered w-full"></label>
            </div>
        </div>
        <div class="modal-action">
            <button class="btn" onclick="closePaymentModal()">Cancelar</button>
            <button class="btn btn-primary" onclick="handlePayment()">Confirmar Pedido</button>
        </div>
    </div>
</dialog>

<!-- Modal de confirmación -->
<dialog id="confirmation-modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Confirmación de Pedido</h3>
        <div id="confirmation-message" class="py-4">
            <!-- Aquí se mostrará el mensaje de confirmación -->
        </div>
        <div class="modal-action">
            <button class="btn" onclick="closeConfirmationModal()">Cerrar</button>
        </div>
    </div>
</dialog>

<!-- Modal del historial de pedidos -->
<dialog id="order-history-modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Historial de Pedidos</h3>
        <div id="order-history-modal-content" class="py-4">
            <!-- Aquí se mostrarán los pedidos anteriores -->
        </div>
        <div class="modal-action">
            <button class="btn" onclick="closeOrderHistoryModal()">Cerrar</button>
        </div>
    </div>
</dialog>







</body>

</html>