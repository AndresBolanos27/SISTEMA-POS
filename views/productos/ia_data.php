<?php
// Consejos sobre inventario para una tienda en línea de frutas y verduras
$consejos = [
    "Para maximizar la frescura de tus productos, asegúrate de rotar el inventario correctamente. Coloca los productos más antiguos en la parte delantera para que se vendan primero.",
    "Considera la temporada y las preferencias de tus clientes al planificar tu inventario. Ofrecer productos de temporada puede aumentar las ventas y reducir el exceso de inventario.",
    "Mantén un registro detallado del inventario para identificar rápidamente qué productos se están agotando y cuáles se están acumulando. Esto te ayudará a ajustar tus pedidos de manera más precisa.",
    "Ofrece promociones especiales en productos con inventario excedente para incentivar su compra. Por ejemplo, puedes ofrecer descuentos por volumen o crear paquetes promocionales.",
    "Explora la posibilidad de asociarte con agricultores locales para obtener productos frescos directamente del campo. Esto puede ayudarte a diversificar tu inventario y ofrecer productos únicos a tus clientes.",
];

// Función para obtener un consejo aleatorio sobre inventario
function obtenerConsejoInventario($consejos) {
    $indice = array_rand($consejos); // Selecciona un índice aleatorio del array
    return $consejos[$indice]; // Devuelve el consejo correspondiente al índice
}

// Ejemplo de uso:
echo obtenerConsejoInventario($consejos);
?>


<?php
                $api_chatgpt = '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';
                $mensaje = 'Estrategia de control de inventario';

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $api_chatgpt,
                ]);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n     \"model\": \"gpt-3.5-turbo\",\n     \"messages\": [{\"role\": \"user\", \"content\": \".$mensaje.\"}],\n     \"temperature\": 0.7\n   }");

                $response = curl_exec($ch);

                curl_close($ch);

                $respuesta = json_decode($response);
                var_dump($respuesta);


                echo '<br>';
                echo '<br>';
                echo '<h5> Consejo dinamico: ' . $mensaje . '</h5>';
                echo '<br>';
                echo '<h5> Respuesta dinamica: ' . '</h5>';
                echo '<br>';
                echo '<button type="button" class="btn btn-info">Otra respuesta</button>';
                ?>