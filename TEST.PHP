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


