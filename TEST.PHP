        <?php
        // Conexión a la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "sistema";

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta para obtener el número de productos con cantidad por debajo de 10
        $sql_productos_bajo_stock = "SELECT COUNT(*) AS count FROM productos WHERE cantidad < 10";
        $result_productos_bajo_stock = $conn->query($sql_productos_bajo_stock);
        $row_productos_bajo_stock = $result_productos_bajo_stock->fetch_assoc();
        $count_productos_bajo_stock = $row_productos_bajo_stock["count"];

        // Consulta para obtener el número de productos con cantidad por encima de 50
        $sql_productos_alto_stock = "SELECT COUNT(*) AS count FROM productos WHERE cantidad > 50";
        $result_productos_alto_stock = $conn->query($sql_productos_alto_stock);
        $row_productos_alto_stock = $result_productos_alto_stock->fetch_assoc();
        $count_productos_alto_stock = $row_productos_alto_stock["count"];

        // Consulta para obtener el número de productos con cantidad igual a 0
        $sql_productos_sin_stock = "SELECT COUNT(*) AS count FROM productos WHERE cantidad = 0";
        $result_productos_sin_stock = $conn->query($sql_productos_sin_stock);
        $row_productos_sin_stock = $result_productos_sin_stock->fetch_assoc();
        $count_productos_sin_stock = $row_productos_sin_stock["count"];

        // Consulta para obtener el producto con más ventas
        $sql_mas_ventas = "SELECT * FROM productos ORDER BY ventas DESC LIMIT 1";
        $result_mas_ventas = $conn->query($sql_mas_ventas);
        $row_mas_ventas = $result_mas_ventas->fetch_assoc();
        $producto_mas_ventas = $row_mas_ventas["descripcion"];

        // Consulta para obtener el producto con menos ventas
        $sql_menos_ventas = "SELECT * FROM productos ORDER BY ventas ASC LIMIT 1";
        $result_menos_ventas = $conn->query($sql_menos_ventas);
        $row_menos_ventas = $result_menos_ventas->fetch_assoc();
        $producto_menos_ventas = $row_menos_ventas["descripcion"];

        echo "Número de productos con cantidad por debajo de 10: " . $count_productos_bajo_stock . "<br>";
        echo "Número de productos con cantidad por encima de 50: " . $count_productos_alto_stock . "<br>";
        echo "Número de productos sin stock: " . $count_productos_sin_stock . "<br>";
        echo "Producto con más ventas: " . $producto_mas_ventas . "<br>";
        echo "Producto con menos ventas: " . $producto_menos_ventas;

        // Cerrar conexión a la base de datos
        $conn->close();
        ?>


<!-- Agrega este código al final del body de tu HTML -->
<div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border border-0">
                <h2 class="modal-title" id="chatModalLabel">Mi asistente</h2>
            </div>
            <div class="modal-body">
                <?php
                // Conexión a la base de datos
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "sistema";

                // Crear conexión
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Verificar conexión
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                // Consulta para obtener la cantidad de productos con stock mayor a 90
                $sql_stock_alto_count = "SELECT COUNT(*) AS count FROM productos WHERE cantidad > 90";
                $result_stock_alto_count = $conn->query($sql_stock_alto_count);
                $row_stock_alto_count = $result_stock_alto_count->fetch_assoc();
                $count_stock_alto = $row_stock_alto_count["count"];

                // Consulta para obtener la cantidad de productos con stock menor a 5
                $sql_stock_bajo_count = "SELECT COUNT(*) AS count FROM productos WHERE cantidad < 5";
                $result_stock_bajo_count = $conn->query($sql_stock_bajo_count);
                $row_stock_bajo_count = $result_stock_bajo_count->fetch_assoc();
                $count_stock_bajo = $row_stock_bajo_count["count"];

                // Verificar si hay productos con stock alto y obtener el mensaje generado por la IA
                if ($count_stock_alto > 0) {
                    // Generar mensaje para vender más esos productos con stock alto usando OpenAI GPT
                    $api_chatgpt = 'sk-proj-hXr66e9ndZldWGo7vcgrT3BlbkFJ9yNAoiG5JQHRxxxRhhIb';

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $api_chatgpt,
                    ]);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n     \"model\": \"gpt-3.5-turbo\",\n     \"messages\": [{\"role\": \"user\", \"content\": \"Estos productos no se están vendiendo en mi drogeria Imagina que eres el propietario de una droguería de barrio y quieres aumentar tus ventas.creame una  en menos de 400 caracteres estrategia personalizada, para vender la  amplia gama de productos y ayudame con ideas para  las ofertas especiales, para atraer a más clientes locales y aumentar el volumen de ventas en tu tienda\"}],\n     \"temperature\": 0.7\n   }");
                    $response = curl_exec($ch);
                    curl_close($ch);

                    $respuesta_stock_alto = json_decode($response);

                    // Verificar si la respuesta está definida
                    if (isset($respuesta_stock_alto->choices[0]->message->content)) {
                        $mensaje_respuesta_stock_alto = $respuesta_stock_alto->choices[0]->message->content;

                        // Mostrar el resumen de productos con stock alto y el mensaje generado por la IA
                        echo '<div class="card" id="stock-alto-card">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">Resumen de Stock</h5>';
                        echo '<p class="card-text">Productos con stock alto: <span class="badge bg-primary" id="stock-alto-count">' . $count_stock_alto . '</span></p>';
                        echo '<p class="card-text">Mensaje para productos con stock alto:</p>';
                        echo '<p class="card-text" id="mensaje-stock-alto">' . $mensaje_respuesta_stock_alto . '</p>'; // Mostrar respuesta generada
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<div class="alert alert-warning" role="alert">';
                        echo "No se pudo obtener la respuesta para los productos con stock alto.";
                        echo '</div>';
                    }
                }

                // Verificar si hay productos con stock bajo y obtener el mensaje generado por la IA
                if ($count_stock_bajo > 0) {
                    // Generar mensaje para vender más esos productos con stock bajo usando OpenAI GPT
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $api_chatgpt,
                    ]);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n     \"model\": \"gpt-3.5-turbo\",\n     \"messages\": [{\"role\": \"user\", \"content\": \"Porque es importante tener en cuenta los productos con bajo stock en el inventario de mi drogeria dame un consejos, 400 caracteres\"}],\n     \"temperature\": 0.7\n   }");
                    $response = curl_exec($ch);
                    curl_close($ch);

                    $respuesta_stock_bajo = json_decode($response);

                    // Verificar si la respuesta está definida
                    if (isset($respuesta_stock_bajo->choices[0]->message->content)) {
                        $mensaje_respuesta_stock_bajo = $respuesta_stock_bajo->choices[0]->message->content;

                        // Mostrar el resumen de productos con stock bajo y el mensaje generado por la IA
                        echo '<div class="card mt-3" id="stock-bajo-card">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">Resumen de Stock</h5>';
                        echo '<p class="card-text">Productos con stock bajo: <span class="badge bg-warning" id="stock-bajo-count">' . $count_stock_bajo . '</span></p>';
                        echo '<p class="card-text">Mensaje para productos con stock bajo:</p>';
                        echo '<p class="card-text" id="mensaje-stock-bajo">' . $mensaje_respuesta_stock_bajo . '</p>'; // Mostrar respuesta generada
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<div class="alert alert-warning mt-3" role="alert">';
                        echo "No se pudo obtener la respuesta para los productos con stock bajo.";
                        echo '</div>';
                    }
                }

                // Cerrar conexión a la base de datos
                $conn->close();
                ?>

                <script>
                    // Función para actualizar las respuestas de OpenAI cada 10 segundos
                    setInterval(function() {
                        // Realizar una solicitud a la API de OpenAI para obtener nuevas respuestas
                        // Actualizar los elementos HTML con las nuevas respuestas generadas
                        var api_chatgpt = 'sk-proj-hXr66e9ndZldWGo7vcgrT3BlbkFJ9yNAoiG5JQHRxxxRhhIb';

                        // Actualizar respuesta para productos con stock alto
                        var ch1 = curl_init();
                        curl_setopt(ch1, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
                        curl_setopt(ch1, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt(ch1, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt(ch1, CURLOPT_HTTPHEADER, [
                            'Content-Type: application/json',
                            'Authorization: Bearer ' + api_chatgpt,
                        ]);
                        curl_setopt(ch1, CURLOPT_POSTFIELDS, JSON.stringify({
                            "model": "gpt-3.5-turbo",
                            "messages": [{
                                "role": "user",
                                "content": "Estos productos no se están vendiendo en mi drogeria Imagina que eres el propietario de una droguería de barrio y quieres aumentar tus ventas.creame una  en menos de 400 caracteres estrategia personalizada, para vender la  amplia gama de productos y ayudame con ideas para  las ofertas especiales, para atraer a más clientes locales y aumentar el volumen de ventas en tu tienda"
                            }],
                            "temperature": 0.7
                        }));
                        var response1 = curl_exec(ch1);
                        curl_close(ch1);
                        var respuesta_stock_alto = JSON.parse(response1);

                        if (respuesta_stock_alto && respuesta_stock_alto.choices && respuesta_stock_alto.choices.length > 0 && respuesta_stock_alto.choices[0].message && respuesta_stock_alto.choices[0].message.content) {
                            document.getElementById("mensaje-stock-alto").innerHTML = respuesta_stock_alto.choices[0].message.content;
                        }

                        // Actualizar respuesta para productos con stock bajo
                        var ch2 = curl_init();
                        curl_setopt(ch2, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
                        curl_setopt(ch2, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt(ch2, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt(ch2, CURLOPT_HTTPHEADER, [
                            'Content-Type: application/json',
                            'Authorization: Bearer ' + api_chatgpt,
                        ]);
                        curl_setopt(ch2, CURLOPT_POSTFIELDS, JSON.stringify({
                            "model": "gpt-3.5-turbo",
                            "messages": [{
                                "role": "user",
                                "content": "Porque es importante tener en cuenta los productos con bajo stock en el inventario de mi drogeria dame un consejos, 400 caracteres"
                            }],
                            "temperature": 0.7
                        }));
                        var response2 = curl_exec(ch2);
                        curl_close(ch2);
                        var respuesta_stock_bajo = JSON.parse(response2);

                        if (respuesta_stock_bajo && respuesta_stock_bajo.choices && respuesta_stock_bajo.choices.length > 0 && respuesta_stock_bajo.choices[0].message && respuesta_stock_bajo.choices[0].message.content) {
                            document.getElementById("mensaje-stock-bajo").innerHTML = respuesta_stock_bajo.choices[0].message.content;
                        }
                    }, 10000); // 10 segundos en milisegundos
                </script>
            </div>
        </div>
    </div>
</div>

<!-- Agrega tus scripts al final del body aquí -->




<!-- Agrega este código al final del body de tu HTML -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var chatBtn = document.getElementById("chatBtn");
        var modal = document.getElementById("chatModal");

        chatBtn.addEventListener("click", function() {
            // Abre el modal cuando se hace clic en el botón
            $(modal).modal("show");
        });
    });
</script>



<div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border border-0">
                <h2 class="modal-title" id="chatModalLabel">Mi asistente</h2>
            </div>
            <div class="modal-body">
                <?php
      
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "sistema";


                $conn = new mysqli($servername, $username, $password, $dbname);

           
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

           
                $sql_stock_alto_count = "SELECT COUNT(*) AS count FROM productos WHERE cantidad > 90";
                $result_stock_alto_count = $conn->query($sql_stock_alto_count);
                $row_stock_alto_count = $result_stock_alto_count->fetch_assoc();
                $count_stock_alto = $row_stock_alto_count["count"];
                $sql_stock_bajo_count = "SELECT COUNT(*) AS count FROM productos WHERE cantidad < 5";
                $result_stock_bajo_count = $conn->query($sql_stock_bajo_count);
                $row_stock_bajo_count = $result_stock_bajo_count->fetch_assoc();
                $count_stock_bajo = $row_stock_bajo_count["count"];

               
                if ($count_stock_alto > 0) {
             
                    $api_chatgpt = 'sk-proj-hXr66e9ndZldWGo7vcgrT3BlbkFJ9yNAoiG5JQHRxxxRhhIb';

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $api_chatgpt,
                    ]);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n     \"model\": \"gpt-3.5-turbo\",\n     \"messages\": [{\"role\": \"user\", \"content\": \"Estos productos no se están vendiendo en mi drogeria Imagina que eres el propietario de una droguería de barrio y quieres aumentar tus ventas.creame una  en menos de 400 caracteres estrategia personalizada, para vender la  amplia gama de productos y ayudame con ideas para  las ofertas especiales, para atraer a más clientes locales y aumentar el volumen de ventas en tu tienda\"}],\n     \"temperature\": 0.7\n   }");
                    $response = curl_exec($ch);
                    curl_close($ch);

                    $respuesta_stock_alto = json_decode($response);

                  
                    if (isset($respuesta_stock_alto->choices[0]->message->content)) {
                        $mensaje_respuesta_stock_alto = $respuesta_stock_alto->choices[0]->message->content;

                 
                        echo '<div class="card" id="stock-alto-card">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">Resumen de Stock</h5>';
                        echo '<p class="card-text">Productos con stock alto: <span class="badge bg-primary" id="stock-alto-count">' . $count_stock_alto . '</span></p>';
                        echo '<p class="card-text">Mensaje para productos con stock alto:</p>';
                        echo '<p class="card-text" id="mensaje-stock-alto">' . $mensaje_respuesta_stock_alto . '</p>'; 
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<div class="alert alert-warning" role="alert">';
                        echo "No se pudo obtener la respuesta para los productos con stock alto.";
                        echo '</div>';
                    }
                }

       
                if ($count_stock_bajo > 0) {

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $api_chatgpt,
                    ]);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n     \"model\": \"gpt-3.5-turbo\",\n     \"messages\": [{\"role\": \"user\", \"content\": \"Porque es importante tener en cuenta los productos con bajo stock en el inventario de mi drogeria dame un consejos, 400 caracteres\"}],\n     \"temperature\": 0.7\n   }");
                    $response = curl_exec($ch);
                    curl_close($ch);

                    $respuesta_stock_bajo = json_decode($response);

                   
                    if (isset($respuesta_stock_bajo->choices[0]->message->content)) {
                        $mensaje_respuesta_stock_bajo = $respuesta_stock_bajo->choices[0]->message->content;

                        echo '<div class="card mt-3" id="stock-bajo-card">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">Resumen de Stock</h5>';
                        echo '<p class="card-text">Productos con stock bajo: <span class="badge bg-warning" id="stock-bajo-count">' . $count_stock_bajo . '</span></p>';
                        echo '<p class="card-text">Mensaje para productos con stock bajo:</p>';
                        echo '<p class="card-text" id="mensaje-stock-bajo">' . $mensaje_respuesta_stock_bajo . '</p>'; 
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<div class="alert alert-warning mt-3" role="alert">';
                        echo "No se pudo obtener la respuesta para los productos con stock bajo.";
                        echo '</div>';
                    }
                }

                $conn->close();
                ?>

                <script>
                    setInterval(function() {
                       
                        var api_chatgpt = 'sk-proj-hXr66e9ndZldWGo7vcgrT3BlbkFJ9yNAoiG5JQHRxxxRhhIb';

                    
                        var ch1 = curl_init();
                        curl_setopt(ch1, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
                        curl_setopt(ch1, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt(ch1, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt(ch1, CURLOPT_HTTPHEADER, [
                            'Content-Type: application/json',
                            'Authorization: Bearer ' + api_chatgpt,
                        ]);
                        curl_setopt(ch1, CURLOPT_POSTFIELDS, JSON.stringify({
                            "model": "gpt-3.5-turbo",   
                            "messages": [{
                                "role": "user",
                                "content": "Estos productos no se están vendiendo en mi drogeria Imagina que eres el propietario de una droguería de barrio y quieres aumentar tus ventas.creame una  en menos de 400 caracteres estrategia personalizada, para vender la  amplia gama de productos y ayudame con ideas para  las ofertas especiales, para atraer a más clientes locales y aumentar el volumen de ventas en tu tienda"
                            }],
                            "temperature": 0.7
                        }));
                        var response1 = curl_exec(ch1);
                        curl_close(ch1);
                        var respuesta_stock_alto = JSON.parse(response1);

                        if (respuesta_stock_alto && respuesta_stock_alto.choices && respuesta_stock_alto.choices.length > 0 && respuesta_stock_alto.choices[0].message && respuesta_stock_alto.choices[0].message.content) {
                            document.getElementById("mensaje-stock-alto").innerHTML = respuesta_stock_alto.choices[0].message.content;
                        }

                        var ch2 = curl_init();
                        curl_setopt(ch2, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
                        curl_setopt(ch2, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt(ch2, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt(ch2, CURLOPT_HTTPHEADER, [
                            'Content-Type: application/json',
                            'Authorization: Bearer ' + api_chatgpt,
                        ]);
                        curl_setopt(ch2, CURLOPT_POSTFIELDS, JSON.stringify({
                            "model": "gpt-3.5-turbo",
                            "messages": [{
                                "role": "user",
                                "content": "Porque es importante tener en cuenta los productos con bajo stock en el inventario de mi drogeria dame un consejos, 400 caracteres"
                            }],
                            "temperature": 0.7
                        }));
                        var response2 = curl_exec(ch2);
                        curl_close(ch2);
                        var respuesta_stock_bajo = JSON.parse(response2);

                        if (respuesta_stock_bajo && respuesta_stock_bajo.choices && respuesta_stock_bajo.choices.length > 0 && respuesta_stock_bajo.choices[0].message && respuesta_stock_bajo.choices[0].message.content) {
                            document.getElementById("mensaje-stock-bajo").innerHTML = respuesta_stock_bajo.choices[0].message.content;
                        }
                    }, 10000); 
                </script>
            </div>
        </div>
    </div>
</div>





<script>
    document.addEventListener("DOMContentLoaded", function() {
        var chatBtn = document.getElementById("chatBtn");
        var modal = document.getElementById("chatModal");

        chatBtn.addEventListener("click", function() {
            $(modal).modal("show");
        });
    });
</script> -
