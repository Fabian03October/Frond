<?php

echo "🔧 Configurando base de datos MySQL...\n";

try {
    // Conexión sin especificar base de datos para crearla
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', 'Castillejos16');
    
    // Crear la base de datos si no existe
    $pdo->exec("CREATE DATABASE IF NOT EXISTS cinefilos_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✅ Base de datos 'cinefilos_app' creada exitosamente.\n";
    
    // Verificar la conexión a la base de datos
    $pdo_test = new PDO('mysql:host=127.0.0.1;port=3306;dbname=cinefilos_app', 'root', 'Castillejos16');
    echo "✅ Conexión a la base de datos verificada.\n";
    
    echo "🚀 ¡Configuración completada! Ahora puedes ejecutar las migraciones.\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "💡 Asegúrate de que MySQL esté ejecutándose y las credenciales sean correctas.\n";
}
