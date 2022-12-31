<?php 
    require __DIR__.'/../vendor/autoload.php';

    use \App\utils\view;
    use \WilliamCosta\DotEnv\Ambiente;
    use \WilliamCosta\DatabaseManager\Database;

    Ambiente::load(__DIR__.'/../');

    //Define as configurações do banco de dados


    Database::config(
        getenv('DB_HOST'),
        getenv('DB_NAME'),
        getenv('DB_USER'),
        getenv('DB_PASS'),
        getenv('DB_PORT')
    );
    
    

    // define('URL','http://localhost/ustart'); Define uma url fixa

    define('URL',getenv('URL')); // Define uma constante de url

    // Definindo o valor padrão das variaveis
    // Varial comum em varios escopos podem ser definidas aqui
    view::init([
        // Pode ser usado nomeclatura de url_base
        'url'=> URL
    ]);

?>