<?php
require_once 'vendor/autoload.php';

$app = new \Slim\Slim();

$db = new mysqli('serverBD','usuarioBD','contraseñaBD','nombreBD');

    // SIN set_charset() no muestra JSON
$db->set_charset("utf8");

// MOSTRAR TODOS LOS REGISTROS
$app->get("/partituras", function() use ($db,$app){

    $select = $db->query('SELECT * FROM partituras ORDER BY id DESC')->fetch_all(MYSQLI_ASSOC);
    //var_dump($select);
    echo json_encode($select);
});

// MOSTRAR REGISTRO POR ID
$app->get("/partitura/:id", function($id) use ($db,$app){
        
    $select = $db->query("SELECT * FROM partituras WHERE id = '$id'")->fetch_all(MYSQLI_ASSOC);
    //var_dump($select);
    echo json_encode($select);
    
})->conditions(array(
    // condicional con expresiones regulares
    'id' => '[\d]*'
));

// AÑADIR REGISTRO
$app->post("/partitura", function() use ($db,$app){

    // bind_param() Define a posteriori 0_o
    $titulo  = $app->request->post('titulo');
    $artista = $app->request->post('artista');
    $acordes = $app->request->post('acordes');
    $texto   = $app->request->post('texto');

    $insert = $db->prepare("INSERT INTO partituras (titulo,artista,acordes,texto) VALUES (?,?,?,?)");
    $insert->bind_param('ssss', $titulo, $artista, $acordes, $texto);

        $traza = "titulo : $titulo, artista : $artista, acordes : $acordes, texto : $texto";

    $insert->execute();
    $filas = $insert->affected_rows;
    $insert->close();
    echo json_encode($traza.$filas);
});

// EDITAR REGISTRO POR ID
$app->put("/partitura/:id", function($id) use ($db,$app){
  
    // bind_param() Define a posteriori 0_o
    $titulo  = $app->request->post('titulo');
    $artista = $app->request->post('artista');
    $acordes = $app->request->post('acordes');
    $texto   = $app->request->post('texto');
    $id      = $id;

    $update = $db->prepare("UPDATE partituras SET titulo = ?, artista = ?, acordes = ?, texto = ? WHERE id = ?");
    $update->bind_param('ssssi', $titulo, $artista, $acordes, $texto, $id);

    $traza = "ID : $id, titulo : $titulo, artista : $artista, acordes : $acordes, texto : $texto";
    
    $update->execute();
    $filas = $update->affected_rows;
    $update->close();
    echo json_encode($traza.$filas);
})->conditions(array(
    // condicional con expresiones regulares
    'id' => '[\d]*'
));

// BORRAR REGISTRO POR ID
$app->delete("/partitura/:id", function($id) use ($db,$app){
        
    /*
    $update = $db->prepare("DELETE FROM partituras WHERE id = ?");
    $update->bind_param('i', $id);
        $id = $id;

    $update->execute();
    $filas = $update->affected_rows;
    $update->close();
    echo json_encode($filas);
    */
})->conditions(array(
    // condicional con expresiones regulares
    'id' => '[\d]*'
));


$app->run();
