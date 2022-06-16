<?php
$currentPage = 'detalles';
//COOKIES DE VISITA
$visitas = 1;
if (!isset($_COOKIE['visitas'])) {
    setcookie('visitas', $visitas);  
} 

if (!isset($_COOKIE['visitasVer'])) {
    //DEFAULT VALUE
    setcookie('visitasVer', '', time()-10); 
    setcookie('visitasVer', $visitas); 
    
}else{
    $visitas = ++$_COOKIE['visitasVer'];
    setcookie('visitasVer', $visitas);  
    $_COOKIE['visitas'] = $_COOKIE['visitasVer'];
}  
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Proyecto 3 - Convocatoria extraordinaria</title>
    <meta name="author" content="Tu nombre">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</head>

<body>
    <?= require_once("partials/cabecera.inc.php");?>
    <!--
    <main class="Container">
        <h2>Detalle del evento</h2>
        <article class="row row-cols-1 g-4 w-50" id="evento">
            <div class="col">
                <div class="card h-70">
                    <img src="imgs/scorpions.jpg" class="card-img-top" title="TITULO" alt="TITULO">
                    <div class="card-body">
                        <h5 class="card-title">TITULO</h5>
                        <h6 class="card-subtitle mb-2 text-muted">PRECIO€</h6>
                        <p class="card-text">DESCRIPCION</p>
                        <a href="#" class="card-link">Modificar</a>
                        <a href="#" class="card-link">Borrar</a>
                    </div>
                </div>
            </div>
        </article>
    </main>
    -->
            <?php
                if (isset($_GET['id_mostrar'])) {
                    require_once('libs/conexion.php');
                    

                    // Establezco la conexión con la BBDD, mostramos un mensaje de conexión establecida, 
                    //en la vida real este mensaje se omitiría
                    $pdo = Conexion::getConexion();
                    
                    $consulta = $pdo->prepare("SELECT * FROM eventos WHERE id={$_GET['id_mostrar']}");
                    
                    try{
                        $consulta->execute();
                    }catch(Throwable $th){
                        echo $th;
                    }

                    while($registro = $consulta->fetch()) {
            ?>
                        <main class='Container'>
                            <h2>Detalle del evento</h2>
                            <article class='row row-cols-1 g-4 w-50' id='<?=$registro['id']?>'>
                                <div class='col'>
                                    <div class='card h-70'>
                                        <img src='../imgs/<?=$registro['imagen']?>' class='card-img-top' title='<?=$registro['titulo']?>' alt='<?=$registro['titulo']?>'>
                                        <div class='card-body'>
                                            <h5 class='card-title'><?=$registro['titulo']?></h5>
                                            <h6 class='card-subtitle mb-2 text-muted'><?=$registro['precio']?>€</h6>
                                            <p class='card-text'><?=$registro['descripcion']?></p>
                                            <a href='crearEvento.php?id_modificar=<?=$registro['id']?>' class='card-link'>Modificar</a>
                                            <a href='../index.php?id_borrar=<?=$registro['id']?>' class='card-link'>Borrar</a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </main>
                        
                    
                <?php }} Conexion::cerrarConexion(); ?>

    <?= require_once('partials/pie.inc.php'); ?>
</body>

</html>