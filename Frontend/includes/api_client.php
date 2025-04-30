<?php

define('API_URL', 'web.dev-paul.com:5000/'); 
define('API_TIMEOUT', 40); 

function hacerRequestAPI($method, $endpoint, $data = []) {
    $url = rtrim(API_URL, '/') . '/' . ltrim($endpoint, '/');
    $headers = [
        'Content-Type: application/json',
        'Accept: application/json'
    ];
    
    if (isset($_SESSION['token'])) {
        $headers[] = 'Authorization: Bearer ' . $_SESSION['token'];
    }
    
    $ch = curl_init();
    
    $options = [
        CURLOPT_URL => $url,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_TIMEOUT => API_TIMEOUT,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_FAILONERROR => false
    ];
    
    if ($method === 'POST' || $method === 'PUT') {
        $options[CURLOPT_POSTFIELDS] = json_encode($data);
    }
    
    curl_setopt_array($ch, $options);
    
    $response = curl_exec($ch);
    $error = curl_error($ch);
    
    curl_close($ch);
    
    if ($error) {
        throw new Exception("Error en la conexión: " . $error);
    }
    
    $decoded = json_decode($response, true) ?? $response;
    
    
    return $decoded;
}

/**
 * Obtiene todos los libros
 * @return array Lista de libros
 */

function obtenerLibros() {
    return hacerRequestAPI('GET', 'libros');
}

/**
 * Obtiene un libro específico por ID
 * @param int $id ID del libro
 * @return array Datos del libro
 * @throws Exception Si el ID no es válido
 */

function obtenerLibro($id) {
    if (!is_numeric($id) || $id <= 0) {
        throw new Exception('ID de libro no válido');
    }
    return hacerRequestAPI('GET', 'libros/' . $id);
}

/**
 * Agrega un nuevo libro
 * @param array $datos Datos del libro a agregar
 * @return array Respuesta de la API
 * @throws Exception Si los datos son inválidos
 */

function agregarLibro($datos) {
    if (empty($datos)) {
        throw new Exception('Datos del libro no pueden estar vacíos');
    }
    return hacerRequestAPI('POST', 'libros', $datos);
}

/**
 * Actualiza un libro existente
 * @param int $id ID del libro a actualizar
 * @param array $datos Datos a actualizar
 * @return array Respuesta de la API
 * @throws Exception Si hay errores de validación o conexión
 */
function actualizarLibro($id, $datos) {
    if (!is_numeric($id) || $id <= 0) {
        throw new Exception('ID de libro no válido');
    }
    
    if (empty($datos)) {
        throw new Exception('Datos de actualización vacíos');
    }
    
    return hacerRequestAPI('PUT', 'libros/' . $id, $datos);
}

/**
 * Elimina un libro
 * @param int $id ID del libro a eliminar
 * @return array Respuesta de la API
 * @throws Exception Si el ID no es válido
 */
function eliminarLibro($id) {
    if (!is_numeric($id) || $id <= 0) {
        throw new Exception('ID de libro no válido');
    }
    return hacerRequestAPI('DELETE', 'libros/' . $id);
}
?>