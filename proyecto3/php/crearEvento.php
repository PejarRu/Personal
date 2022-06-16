<?php
$currentPage = 'form';
    //COOKIES DE VISITAS
    $visitas = 1;
    if (!isset($_COOKIE['visitas'])) {
        setcookie('visitas', $visitas);  
    } 

    if (!isset($_COOKIE['visitasCrear'])) {
        //DEFAULT VALUE
        setcookie('visitasCrear', '', time()-10); 
        setcookie('visitasCrear', $visitas); 
        
    }else{
        $visitas = ++$_COOKIE['visitasCrear'];
        setcookie('visitasCrear', $visitas);  
        $_COOKIE['visitas'] = $_COOKIE['visitasCrear'];
    }  

    if (isset($_GET['id_modificar']) ) {
        $modificamos = true;
    }else{
        $modificamos = false;
    }
?>

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
    require_once('./partials/cabecera.inc.php');
?>
    <main>
        <div class="container">
            <h2 class="my-2">Crear nuevo evento</h2>
            <form action='<?php echo $enlaceIndex ?>' <?php 
            //RELLENACION DEL FORMULARIO CON VALORES ANTIGUOS
            $tituloOld = "";
            $fechaOld = "";        
            $descripcionOld;
            $precioOld = "";
            $imagenOld = "";

            if ($modificamos) {

                //CONECTANDO A LA BASE DE DATOS
                require_once('./libs/conexion.php');

                $pdo = Conexion::getConexion();
                $consulta = $pdo->prepare("SELECT * FROM eventos WHERE id={$_GET['id_modificar']}");
                $consulta->execute();
                            
                $registro = $consulta->fetch();

                //PREPARACION DE VARIBALES
                $tituloOld = $registro['titulo'];
                $fechaOld = $registro['fecha'];
                $descripcionOld = $registro['descripcion'];            
                $precioOld = $registro['precio'];
                $imagenOld  = $registro['imagen'];
                //CIERRE DE CONEXION
                Conexion::cerrarConexion();

                echo "?id_modificar=".$_GET['id_modificar'];
                 
            }
            ?>' method="post" class="mt-4" id="newEvent" name="newEvent">
                <div class="mb-3">
                    <label for="title" class="form-label">Título del evento</label>
                    <input type="text" value="<?php echo isset($tituloOld) ? $tituloOld : "" ?>" class="form-control" name="titulo" id="titulo" placeholder="Introduce el título del evento">
                    <div class="invalid-feedback">Título obligatorio, puede contener letras y espacios.</div>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Fecha</label>
                    <input type="date" value="<?php echo isset($fechaOld) ? $fechaOld : "" ?>" class="form-control" id="fecha" name="fecha">
                    <div class="invalid-feedback">El campo fecha es obligatorio (Mayor a fecha actual).</div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo isset($descripcionOld) ? $descripcionOld : "" ;?></textarea>
                    <div class="invalid-feedback">El campo descripción es obligatorio.</div>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Precio (en €)</label>
                    <input type="number" value="<?php echo isset($precioOld) ? $precioOld : "" ?>" class="form-control" id="precio" name="precio" step="0.01" />
                    <div class="invalid-feedback">El precio debe ser un número positivo.</div>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Imagen</label>
                    <input type="file" placeholder="<?php echo isset($imagenOld) ? $imagenOld : "" ?>" class="form-control" id="imagen" name="imagen">
                    <div class="invalid-feedback">Debes introducir una imagen.</div>
                </div>
                <img src="" alt="" id="imgPreview"  class="img-thumbnail mb-3 d-none">
                <div>
                    <!--
                    <button type="submit" class="btn btn-danger">Modificar</button>
                    --> 
                    <?php
                        if ($modificamos) {
                            echo "<button type='submit' class='btn btn-danger' >Modificar</button>";
                        } else {
                            echo "<button type='submit' class='btn btn-primary' >Crear</button>";
                        }
                    ?>

                </div>
            </form>
        </div>
    </main>
    
    <?= 
    //MOSTRAMOS EL FOOTER
    require_once('partials/pie.inc.php')
    ?>
</body>

</html> 
