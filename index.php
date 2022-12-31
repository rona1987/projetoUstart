<?php 
    require __DIR__.'/includes/app.php';
    use \App\http\router;
    // Iniciando a ROTA
    $router = new router(URL);
    
    // Incluir as rotas
    include __DIR__ .'/routes/pages.php';

    // Imprimir response da rota
    $router->run()->send_response();

?>