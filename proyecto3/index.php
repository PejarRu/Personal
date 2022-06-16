<?php
//##############################
//MANIPULACION DE DATOS EN LA BD
//##############################
    //Conectamos a la BD
    require_once ("php/libs/conexion.php");
    $pdo = Conexion::getConexion();

    $consulta;
    if (isset($_POST)) {

        //foreach ($_POST as $key => $value) {
        //   echo $value."->".$_POST[$key];
        //}

        //CREAR EVENTO SI NO HAY NINGUN $_GET
        if ((!isset($_GET['id_modificar']))){
            //CREAMOS UN NUEVO EVENTO
            echo "Creacion;";
            $consulta = $pdo->prepare("INSERT INTO `eventos`(`titulo`, `descripcion`, `imagen`, `precio`, `fecha`) VALUES ('{$_POST['titulo']}', '{$_POST['descripcion']}', '{$_POST['imagen']}', '{$_POST['precio']}', '{$_POST['fecha']}')");
            
            //EJECUTAMOS INSERTADO
            try {
                $consulta->execute();      
            } catch (\Throwable $th) {
             }

        }else if(isset($_GET['id_modificar']) ) {
            //MODIFICAMOS EVENTO SI HAY id_modificar
            echo "Modificacion;";
            if (empty($_POST['imagen']) || !isset($_POST['imagen'])) {
                //SI NO SE ADJUNTA IMAGEN DEJAMOS LA ANTERIOR
                $consulta = $pdo->prepare("UPDATE `eventos` SET 
                `id`='{$_GET['id_modificar']}',
                `titulo`='{$_POST['titulo']}',
                `descripcion`='{$_POST['descripcion']}',
                `precio`='{$_POST['precio']}',
                `fecha`='{$_POST['fecha']}' 
                WHERE `id`={$_GET['id_modificar']}");
            }else{
                //SI SE ADJUNTA IMAGEN LA ACTUALIZAMOS
                $consulta = $pdo->prepare("UPDATE `eventos` SET 
                `id`='{$_GET['id_modificar']}',
                `titulo`='{$_POST['titulo']}',
                `descripcion`='{$_POST['descripcion']}',
                `imagen`='{$_POST['imagen']}',
                `precio`='{$_POST['precio']}',
                `fecha`='{$_POST['fecha']}' 
                WHERE `id`={$_GET['id_modificar']}");
            }

            //EJECUTAMOS MODIFICACION
            try {
                $consulta->execute();      
            } catch (\Throwable $th) {
            }
        }
        
        
        
        unset($_GET['id_modificar']);
        foreach ($_POST as $key => $value) {
            unset($_POST[$key]);
            unset($_POST[$value]);
        }
    }else{
        printf("NO hay post;");

        //BORRAR EVENTO SI HAY id_borrar
        if (isset($_GET['id_borrar'])) {
            echo "Evento borrado;";
            $consulta = $pdo->prepare("DELETE FROM eventos WHERE id={$_GET['id_borrar']}");
            unset($_GET['id_borrar']);

            //EJECUTAMOS BORRADO 
            try {
                $consulta->execute();      
            } catch (\Throwable $th) {
            }
        }
        
    }
    Conexion::cerrarConexion();

    
    
//##############################
//MANIPULACION DE DATOS EN LA BD
//##############################
//##############################
//           COOKIES
//##############################
//COOKIES DE VISITA
$currentPage = 'index';
$visitas = 1;
if (!isset($_COOKIE['visitas'])) {
    setcookie('visitas', $visitas);  
} 

if (!isset($_COOKIE['visitasIndex'])) {
    //DEFAULT VALUE
    setcookie('visitasIndex', '', time()-10); 
    setcookie('visitasIndex', $visitas); 
    
}else{
    $visitas = ++$_COOKIE['visitasIndex'];
    setcookie('visitasIndex', $visitas);  
    $_COOKIE['visitas'] = $_COOKIE['visitasIndex'];
}  
//##############################
//           COOKIES
//##############################
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Proyecto 3 - Convocatoria extraordinaria</title>
    <meta name="author" content="Antons Berzins">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</head>

<body>
    <?php 
    //Muestra la cabecera
    require_once('php/partials/cabecera.inc.php');
    ?>

    <main>
        <div class="container">
            <nav class="navbar navbar-light bg-light justify-content-between mt-3">
                <div class="container-fluid">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="orderDate">Ordenar por fecha</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="orderPrice">Ordenar por precio</a>
                        </li>
                    </ul>
                    <form class="d-flex mb-0" id="filtarEvento" name="filtarEvento">
                        <input class="form-control me-2" type="text" name="search" id="search" placeholder="Buscar" aria-label="Search">
                    </form>
                </div>
            </nav>
        </div>
        <div class="container">
            <article id="eventsContainer" class="mb-4 mt-4 row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                 <!-- TO-DO: Ejemplo card
                <div class="col">
                    <div class="card shadow">
                        <img src="imgs/losAngeles.jpg" class="card-img-top" alt="titulo del evento">
                        <div class="card-body">
                            <h4 class="card-title">Título</h4>
                            <p class="card-text">Descripción</p>
                            <a href="index.php?modificar=1" class="btn btn-primary">Modificar</a>
                            <a href="" class="btn btn-danger">Delete</a>
                        </div>
                        <div class="card-footer text-muted row m-0">
                            <div class="col">07/05/2022</div>
                            <div class="col text-end">40 €</div>
                        </div>
                    </div>
                    
                </div>
                -->
            <?php
                require_once('php/libs/conexion.php');

                // Establezco la conexión con la BBDD, mostramos un mensaje de conexión establecida, 
                //en la vida real este mensaje se omitiría
                $pdo = Conexion::getConexion();
                $consulta = $pdo->prepare("SELECT * FROM eventos");
                $consulta->execute();

                
                while($registro = $consulta->fetch()) {
                    $descripcionResumen = substr($registro['descripcion'],0,20);
                    echo 
                    "<div class='col'>
                        <div class='card shadow'>
                            <img src='imgs/{$registro['imagen']}' class='card-img-top' alt='{$registro['titulo']}'>
                                <div class='card-body'>
                                    <h4 class='card-title'>{$registro['titulo']}</h4>
                                    <p class='card-text'>{$descripcionResumen}<a class='card-text' href='php/detalleEvento.php?id_mostrar={$registro['id']}'>Ver más...</a></p>
                                    <a href='php/crearEvento.php?id_modificar={$registro['id']}' class='btn btn-primary'>Modificar</a>
                                    <a href='index.php?id_borrar={$registro['id']}' class='btn btn-danger'>Delete</a>
                                </div>

                                <div class='card-footer text-muted row m-0'>
                                    <div class='col'>{$registro['fecha']}</div>
                                    <div class='col text-end'>{$registro['precio']} €</div>
                                </div>
                        </div>
                    </div>";
                }

                Conexion::cerrarConexion();
            ?>
           

                
            </article>
        </div>
    </main>
    <?= 
    //MOSTRAMOS EL FOOTER
    require_once('php/partials/pie.inc.php')
    ?>
</body>
</html>