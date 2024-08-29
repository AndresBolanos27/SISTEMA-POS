<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT id, descripcion, precio_venta, foto, cantidad, mercado_pago_link FROM productos ORDER BY ventas DESC LIMIT 6";
$result = $conn->query($sql);

function convertirRuta($rutaAbsoluta) {
    $rutaBase = "C:/xampp/htdocs/pos/";
    $rutaRelativa = str_replace($rutaBase, '', $rutaAbsoluta);
    return 'http://localhost/pos/' . $rutaRelativa;
}

echo '<div class="container mx-auto px-4">';
echo '<h1 class="text-5xl font-bold text-center mb-8">Recomendados</h1>';
echo '<div class="flex flex-wrap -mx-4">';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rutaRelativa = convertirRuta($row["foto"]);
        $disponible = $row["cantidad"] > 0 ? '' : ' (No disponible)';
        echo '<div class="w-full sm:w-1/2 lg:w-1/3 px-6 mb-8">';
        echo '<div class="bg-white p-6 rounded-lg border">';
        echo '<div class="h-40 w-40 mx-auto mb-4 overflow-hidden rounded-full border-4 border-gray-200">';
        echo '<img src="' . $rutaRelativa . '" alt="' . $row["descripcion"] . '" class="w-full h-full object-cover">';
        echo '</div>';
        echo '<h2 class="text-xl font-bold text-center">' . $row["descripcion"] . $disponible . '</h2>';
        echo '<p class="text-green-500 text-center">$' . $row["precio_venta"] . '</p>';
        echo '<div class="flex justify-center mt-4 space-x-4">';
        echo '<button class="btn btn-outline btn-info flex items-center justify-center" onclick="openModal(' . $row["id"] . ')"><i class="fas fa-info-circle"></i></button>';
        echo '<button class="btn btn-outline btn-primary flex items-center justify-center" onclick="addToCart(' . $row["id"] . ', \'' . $row["descripcion"] . '\', ' . $row["precio_venta"] . ', ' . $row["cantidad"] . ', \'' . $row["mercado_pago_link"] . '\')"><i class="fas fa-shopping-cart"></i></button>';
        echo '<button class="btn btn-outline btn-success flex items-center justify-center"><i class="fas fa-heart"></i></button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No hay productos recomendados";
}

echo '</div>';
echo '</div>';

$result->data_seek(0); // Reset the result pointer
while ($row = $result->fetch_assoc()) {
    echo '<dialog id="modal_' . $row["id"] . '" class="modal modal-bottom sm:modal-middle">';
    echo '<div class="modal-box">';
    echo '<h3 class="font-bold text-lg">' . $row["descripcion"] . '</h3>';
    echo '<p class="py-4">Más información sobre ' . $row["descripcion"] . '.</p>';
    echo '<div class="modal-action">';
    echo '<button class="btn" onclick="closeModal(' . $row["id"] . ')">Cerrar</button>';
    echo '</div>';
    echo '</div>';
    echo '</dialog>';
}

$conn->close();
?>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    loadCartFromLocalStorage();
    loadOrderHistory();
});

function openModal(id) {
    document.getElementById('modal_' + id).showModal();
}

function closeModal(id) {
    document.getElementById('modal_' + id).close();
}

function addToCart(id, descripcion, precio, cantidad, link) {
    if (cantidad <= 0) {
        alert('No hay suficiente cantidad disponible de ' + descripcion);
        return;
    }

    const cartModal = document.getElementById('cart-modal-content');
    let existingItem = document.querySelector(`.cart-item[data-id='${id}']`);

    if (existingItem) {
        const quantityElement = existingItem.querySelector('.quantity');
        let currentQuantity = parseInt(quantityElement.textContent);
        if (currentQuantity + 1 > cantidad) {
            alert('No puedes agregar más cantidad de la disponible');
            return;
        }
        quantityElement.textContent = currentQuantity + 1;
    } else {
        const newItem = document.createElement('div');
        newItem.className = 'cart-item flex justify-between items-center mb-4 p-4 border rounded-lg shadow-sm';
        newItem.setAttribute('data-id', id);
        newItem.innerHTML = `
            <div>
                <h3 class="text-lg font-bold">${descripcion}</h3>
                <p class="text-green-500">$${precio}</p>
                <div class="flex items-center space-x-2">
                    <button class="btn btn-sm btn-primary" onclick="changeQuantity(${id}, -1, ${cantidad})">-</button>
                    <span class="quantity bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center">1</span>
                    <button class="btn btn-sm btn-primary" onclick="changeQuantity(${id}, 1, ${cantidad})">+</button>
                </div>
                <a href="${link}" target="_blank" class="mercado-pago-link" style="display: none;">Pagar con Mercado Pago</a>
            </div>
            <button class="btn btn-error btn-sm" onclick="removeFromCart(this)">Eliminar</button>
        `;
        cartModal.appendChild(newItem);
    }

    // Mostrar una alerta cuando el usuario agrega un producto al carrito
    alert('Producto agregado al carrito: ' + descripcion);

    // Guardar en localStorage
    saveCartToLocalStorage();
    updateCartCount();
}

function changeQuantity(id, amount, maxQuantity) {
    const item = document.querySelector(`.cart-item[data-id='${id}']`);
    const quantityElement = item.querySelector('.quantity');
    let currentQuantity = parseInt(quantityElement.textContent);
    let newQuantity = currentQuantity + amount;

    if (newQuantity <= 0) {
        item.remove();
    } else if (newQuantity > maxQuantity) {
        alert('No puedes agregar más cantidad de la disponible');
        return;
    } else {
        quantityElement.textContent = newQuantity;
    }

    // Guardar en localStorage
    saveCartToLocalStorage();
    updateCartCount();
}

function removeFromCart(button) {
    const item = button.closest('.cart-item');
    item.remove();

    // Guardar en localStorage
    saveCartToLocalStorage();
    updateCartCount();
}

function openCartModal() {
    document.getElementById('cart-modal').showModal();
}

function closeCartModal() {
    document.getElementById('cart-modal').close();
}

function openPaymentModal() {
    document.getElementById('payment-modal').showModal();
}

function closePaymentModal() {
    document.getElementById('payment-modal').close();
}

function openOrderHistoryModal() {
    document.getElementById('order-history-modal').showModal();
}

function closeOrderHistoryModal() {
    document.getElementById('order-history-modal').close();
}

function handlePayment() {
    const method = document.querySelector('input[name="payment-method"]:checked').value;
    const name = document.getElementById('name').value;
    const cedula = document.getElementById('cedula').value;
    const address = document.getElementById('address').value;

    if (name && cedula && address) {
        // Aquí se actualizarán las cantidades en la base de datos
        updateProductQuantities();
        saveOrderHistory();
        if (method === 'Contra Entrega') {
            showConfirmationMessage(`Pedido realizado con éxito. El domicilio ya va para allá.`);
        } else if (method === 'Transferencia') {
            showConfirmationMessage(`Pedido realizado con éxito. Por favor, realice la transferencia a la cuenta XXXX-XXXX-XXXX-XXXX y envíe el comprobante a este <a href="https://wa.me/1234567890">link de WhatsApp</a>.`);
        } else if (method === 'Mercado Pago') {
            showMercadoPagoLinks();
        }
        closePaymentModal();
        clearCart();
        alert('Compra exitosa');
        location.reload();
    } else {
        alert('Por favor, complete todos los campos.');
    }
}

function showMercadoPagoLinks() {
    const cart = JSON.parse(localStorage.getItem('cart'));
    let linksHTML = '<p>Realice el pago usando los enlaces de Mercado Pago en los productos:</p>';
    if (cart) {
        cart.forEach(item => {
            linksHTML += `<p><a href="${item.link}" target="_blank">${item.descripcion}</a></p>`;
        });
    }
    showConfirmationMessage(linksHTML);
}

function updateProductQuantities() {
    const cart = JSON.parse(localStorage.getItem('cart'));
    if (cart) {
        cart.forEach(item => {
            fetch('update_quantity.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: item.id,
                    quantity: item.quantity
                })
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    console.log(`Cantidad de producto ${item.id} actualizada`);
                } else {
                    console.error(`Error al actualizar cantidad de producto ${item.id}`);
                }
            });
        });
    }
}

function showConfirmationMessage(message) {
    document.getElementById('confirmation-message').innerHTML = message;
    document.getElementById('confirmation-modal').showModal();
}

function closeConfirmationModal() {
    document.getElementById('confirmation-modal').close();
}

function clearCart() {
    localStorage.removeItem('cart');
    document.getElementById('cart-modal-content').innerHTML = '';
    updateCartCount();
}

function saveOrderHistory() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const orderHistory = JSON.parse(localStorage.getItem('orderHistory')) || [];

    const newOrder = {
        date: new Date().toLocaleString(),
        items: cart
    };

    orderHistory.push(newOrder);
    localStorage.setItem('orderHistory', JSON.stringify(orderHistory));
}

function loadOrderHistory() {
    const orderHistory = JSON.parse(localStorage.getItem('orderHistory')) || [];
    const orderHistoryModalContent = document.getElementById('order-history-modal-content');
    orderHistoryModalContent.innerHTML = '';

    orderHistory.forEach(order => {
        const orderDiv = document.createElement('div');
        orderDiv.className = 'order-history-item mb-4 p-4 border rounded-lg shadow-sm';
        orderDiv.innerHTML = `
            <div>
                <h3 class="text-lg font-bold">Pedido del ${order.date}</h3>
                <ul class="list-disc pl-4">
                    ${order.items.map(item => `<li>${item.descripcion} - ${item.quantity} unidades</li>`).join('')}
                </ul>
            </div>
        `;
        orderHistoryModalContent.appendChild(orderDiv);
    });
}

function saveCartToLocalStorage() {
    const cartItems = document.querySelectorAll('.cart-item');
    const cart = [];

    cartItems.forEach(item => {
        const id = item.getAttribute('data-id');
        const descripcion = item.querySelector('h3').textContent;
        const precio = item.querySelector('p').textContent.replace('$', '');
        const quantity = item.querySelector('.quantity').textContent;
        const link = item.querySelector('.mercado-pago-link').href;

        cart.push({
            id: id,
            descripcion: descripcion,
            precio: precio,
            quantity: quantity,
            link: link
        });
    });

    localStorage.setItem('cart', JSON.stringify(cart));
}

function loadCartFromLocalStorage() {
    const cart = JSON.parse(localStorage.getItem('cart'));

    if (cart) {
        const cartModal = document.getElementById('cart-modal-content');
        cart.forEach(item => {
            const newItem = document.createElement('div');
            newItem.className = 'cart-item flex justify-between items-center mb-4 p-4 border rounded-lg shadow-sm';
            newItem.setAttribute('data-id', item.id);
            newItem.innerHTML = `
                <div>
                    <h3 class="text-lg font-bold">${item.descripcion}</h3>
                    <p class="text-green-500">$${item.precio}</p>
                    <div class="flex items-center space-x-2">
                        <button class="btn btn-sm btn-primary" onclick="changeQuantity(${item.id}, -1, ${item.maxQuantity})">-</button>
                        <span class="quantity bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center">${item.quantity}</span>
                        <button class="btn btn-sm btn-primary" onclick="changeQuantity(${item.id}, 1, ${item.maxQuantity})">+</button>
                    </div>
                    <a href="${item.link}" target="_blank" class="mercado-pago-link" style="display: none;">Pagar con Mercado Pago</a>
                </div>
                <button class="btn btn-error btn-sm" onclick="removeFromCart(this)">Eliminar</button>
            `;
            cartModal.appendChild(newItem);
        });

        updateCartCount();
    }
}

function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    let totalCount = 0;

    cart.forEach(item => {
        totalCount += parseInt(item.quantity);
    });

    document.getElementById('cart-count').textContent = totalCount;
}
</script>
