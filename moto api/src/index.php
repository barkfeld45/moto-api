<?php
header("Content-Type: application/json");

// Conexão com o banco de dados
$mysqli = new mysqli("mysql", "user", "senha", "motos");

if ($mysqli->connect_errno) {
    echo json_encode(["error" => "Falha na conexão: " . $mysqli->connect_error]);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = trim($_SERVER['REQUEST_URI'], '/'); // Remove a barra no início e no final
$segments = explode('/', $requestUri); // Divide a URL por barras

// O primeiro segmento da URL será o recurso "motos"
$resource = $segments[1] ?? null;

// O segundo segmento será o ID (caso presente)
$id = $segments[2] ?? null;

if ($resource !== 'motos') {
    echo json_encode(["error" => "Recurso não encontradoo"]);
    exit();
}

switch ($method) {
    case 'GET':
        
        if ($id) {
            
            // Caso tenha ID, buscamos uma moto específica
            $stmt = $mysqli->prepare("SELECT * FROM motos WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            echo json_encode($result ?: ["error" => "Moto não encontrada"]);
        } else {
            // Caso não tenha ID, listamos todas as motos
            $result = $mysqli->query("SELECT * FROM motos");
            
            echo json_encode($result->fetch_all(MYSQLI_ASSOC));
        }
        break;

    case 'POST':
        // Recebe os dados enviados no corpo da requisição
        $input = json_decode(file_get_contents("php://input"), true);
        $stmt = $mysqli->prepare("INSERT INTO motos (marca, modelo, ano, cor, quilometragem) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisi", $input['marca'], $input['modelo'], $input['ano'], $input['cor'], $input['quilometragem']);
        $stmt->execute();
        echo json_encode(["message" => "Moto inserida", "id" => $stmt->insert_id]);
        break;

    case 'PUT':
        if (!$id) {
            echo json_encode(["error" => "ID necessário"]);
            break;
        }
        // Recebe os dados enviados no corpo da requisição
        $input = json_decode(file_get_contents("php://input"), true);
        $stmt = $mysqli->prepare("UPDATE motos SET marca=?, modelo=?, ano=?, cor=?, quilometragem=? WHERE id=?");
        $stmt->bind_param("ssisii", $input['marca'], $input['modelo'], $input['ano'], $input['cor'], $input['quilometragem'], $id);
        $stmt->execute();
        echo json_encode(["message" => "Moto atualizada"]);
        break;

    case 'DELETE':
        if (!$id) {
            echo json_encode(["error" => "ID necessário"]);
            break;
        }
        $stmt = $mysqli->prepare("DELETE FROM motos WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        echo json_encode(["message" => "Moto deletada"]);
        break;

    default:
        echo json_encode(["error" => "Método não suportado"]);
}
?>
