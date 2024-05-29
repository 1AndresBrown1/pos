<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $apiKey = 'sk-proj-hXr66e9ndZldWGo7vcgrT3BlbkFJ9yNAoiG5JQHRxxxRhhIb';
    $userMessage = $_POST['message'];

    if (stripos($userMessage, 'stock bajo') !== false) {
        if (stripos($userMessage, 'semana') !== false) {
            checkStock('week', 'low');
        } elseif (stripos($userMessage, 'mes') !== false) {
            checkStock('month', 'low');
        } elseif (stripos($userMessage, 'año') !== false) {
            checkStock('year', 'low');
        } else {
            checkStock('all', 'low');
        }
    } elseif (stripos($userMessage, 'stock alto') !== false) {
        if (stripos($userMessage, 'semana') !== false) {
            checkStock('week', 'high');
        } elseif (stripos($userMessage, 'mes') !== false) {
            checkStock('month', 'high');
        } elseif (stripos($userMessage, 'año') !== false) {
            checkStock('year', 'high');
        } else {
            checkStock('all', 'high');
        }
    } elseif (stripos($userMessage, 'producto con más ventas') !== false) {
        if (stripos($userMessage, 'día') !== false) {
            getTopSellingProduct('day');
        } elseif (stripos($userMessage, 'mes') !== false) {
            getTopSellingProduct('month');
        } elseif (stripos($userMessage, 'año') !== false) {
            getTopSellingProduct('year');
        } else {
            getTopSellingProduct('all');
        }
    } elseif (stripos($userMessage, 'consejo del día') !== false) {
        generateDailyAdvice();
    } else {
        sendMessageToOpenAI($userMessage);
    }
}

function sendMessageToOpenAI($userMessage) {
    $apiKey = 'sk-proj-hXr66e9ndZldWGo7vcgrT3BlbkFJ9yNAoiG5JQHRxxxRhhIb';
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'model' => 'gpt-3.5-turbo',
        'messages' => [['role' => 'user', 'content' => $userMessage]],
        'max_tokens' => 150,
        'temperature' => 0.7,
    ]));

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: ' . 'Bearer ' . $apiKey,
    ]);

    $result = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    if ($httpcode != 200) {
        echo 'Error: HTTP code ' . $httpcode;
        echo ' Response: ' . $result;
        exit;
    }

    $response = json_decode($result, true);

    if (isset($response['choices']) && isset($response['choices'][0]['message']['content'])) {
        echo $response['choices'][0]['message']['content'];
    } else {
        echo 'Error: Invalid response';
        echo ' Full response: ' . $result;
    }
}

function generateAdvice($context, $message) {
    $apiKey = 'sk-proj-hXr66e9ndZldWGo7vcgrT3BlbkFJ9yNAoiG5JQHRxxxRhhIb';
    $ch = curl_init();

    $prompt = "$context: $message Proporciona un consejo corto y útil para un fruver en Colombia.";

    curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'model' => 'gpt-3.5-turbo',
        'messages' => [['role' => 'user', 'content' => $prompt]],
        'max_tokens' => 100, // Reducir los tokens para consejos más cortos
        'temperature' => 0.7,
    ]));

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: ' . 'Bearer ' . $apiKey,
    ]);

    $result = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    if ($httpcode != 200) {
        echo 'Error: HTTP code ' . $httpcode;
        echo ' Response: ' . $result;
        exit;
    }

    $response = json_decode($result, true);

    if (isset($response['choices']) && isset($response['choices'][0]['message']['content'])) {
        return $response['choices'][0]['message']['content'];
    } else {
        return 'Error: Invalid response';
    }
}

function generateDailyAdvice() {
    $message = "Genera un consejo corto y útil para un negocio fruver en Colombia.";
    $advice = generateAdvice('Consejo del día', $message);
    echo $advice;
}

function checkStock($period, $type) {
    $servername = "localhost"; // Cambia esto según tu configuración
    $username = "root"; // Cambia esto según tu configuración
    $password = ""; // Cambia esto según tu configuración
    $dbname = "sistema"; // Cambia esto según tu configuración

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Comprobar conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Filtrar por periodo de tiempo
    $timeCondition = "";
    if ($period === 'week') {
        $timeCondition = "AND fecha >= DATE_SUB(NOW(), INTERVAL 1 WEEK)";
    } elseif ($period === 'month') {
        $timeCondition = "AND fecha >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
    } elseif ($period === 'year') {
        $timeCondition = "AND fecha >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
    }

    // Filtrar por tipo de stock
    $stockCondition = "";
    if ($type === 'low') {
        $stockCondition = "cantidad < 5";
    } elseif ($type === 'high') {
        $stockCondition = "cantidad > 100"; // Ajusta este valor según lo que consideres "stock alto"
    }

    $sql = "SELECT COUNT(*) as stock_count FROM productos WHERE $stockCondition $timeCondition";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Obtener la cantidad de productos con el stock especificado
        $row = $result->fetch_assoc();
        $message = "Hay " . $row['stock_count'] . " productos con un stock " . ($type === 'low' ? "menor a 5" : "mayor a 100") . " en el período seleccionado.";
        $advice = generateAdvice($type === 'low' ? 'Stock bajo' : 'Stock alto', $message);
        echo $message . " " . $advice;
    } else {
        echo "No hay productos con un stock " . ($type === 'low' ? "menor a 5" : "mayor a 100") . " en el período seleccionado.";
    }

    $conn->close();
}

function getTopSellingProduct($period) {
    $servername = "localhost"; // Cambia esto según tu configuración
    $username = "root"; // Cambia esto según tu configuración
    $password = ""; // Cambia esto según tu configuración
    $dbname = "sistema"; // Cambia esto según tu configuración

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Comprobar conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Filtrar por periodo de tiempo
    $timeCondition = "";
    if ($period === 'day') {
        $timeCondition = "WHERE fecha >= CURDATE()";
    } elseif ($period === 'month') {
        $timeCondition = "WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
    } elseif ($period === 'year') {
        $timeCondition = "WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
    }

    $sql = "SELECT codigo, descripcion, ventas as total_vendido 
            FROM productos 
            $timeCondition
            ORDER BY ventas DESC 
            LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Obtener el producto con más ventas
        $row = $result->fetch_assoc();
        $message = "El producto con más ventas " . ($period === 'day' ? "hoy" : ($period === 'month' ? "este mes" : ($period === 'year' ? "este año" : "en general"))) . " es " . $row['codigo'] . " - " . $row['descripcion'] . " con un total de " . $row['total_vendido'] . " unidades vendidas.";
        $advice = generateAdvice('Producto más vendido', $message);
        echo $message . " " . $advice;
    } else {
        echo "No se encontraron datos de ventas " . ($period === 'day' ? "hoy" : ($period === 'month' ? "este mes" : ($period === 'year' ? "este año" : "en general"))) . ".";
    }

    $conn->close();
}
