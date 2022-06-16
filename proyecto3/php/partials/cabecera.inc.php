<?php
    if (isset($_COOKIE['color'])) {
        if (isset($_GET['color'])) {
            $_COOKIE['color'] = $_GET['color'];
        }else{
            $_COOKIE['color'] = "bg-info";
        }
    }else{
        if (isset($_GET['color'])) {
            setcookie('color', '', time()-1); 
            setcookie('color', $_GET['color'], 3600); 
        }else{
            setcookie('color', '', time()-1); 
            setcookie('color', "bg-info");
        }
    }

    $color = $_COOKIE['color'];
    
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
        $url = "https://";   
    else  
        $url = "http://";   
        
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];   

        
    // Append the requested resource location to the URL   
    $url.= $_SERVER['REQUEST_URI'];    
   
    $enlaceIndex;
    if ($currentPage == 'index') {
        $enlaceIndex =  "./index.php";                                
    } else {
        $enlaceIndex = "../index.php";                            
    }
    
    $enlaceForm;
    if ($currentPage == 'index') {
        $enlaceForm = "php/crearEvento.php";                                
    } else {
        $enlaceForm = "./crearEvento.php";                            
    }



    $enlaceActual;
    if ($currentPage == 'index') {
        $enlaceActual = $enlaceIndex;                                
    } else if($currentPage == 'form'){
        $enlaceActual = $enlaceForm;                 
    }else if($currentPage == 'detalles'){
        $enlaceActual = "php/detalleEvento.php";
    }

?>
    <header>
        <nav class="navbar navbar-expand navbar-dark <?php echo $color ?>">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Events</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= $enlaceIndex ?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $enlaceForm ?>">Crear eventos</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Cambiar color de tema
                            </a>

                            <ul class="dropdown-menu <?php echo $color ?>" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="nav-link" href="<?php echo $enlaceActual."?"; echo "color=bg-info";?>">Azul (bg-info)</a></li>
                                <li><a class="nav-link" href="<?php echo $enlaceActual."?"; echo "color=bg-danger";?>">Rojo (bg-danger)</a></li>
                                <li><a class="nav-link" href="<?php echo $enlaceActual."?"; echo "color=bg-success";?>">Verde (bg-success)</a></li>
                                <li><a class="nav-link" href="<?php echo $enlaceActual."?"; echo "color=bg-dark";?>">Negro (bg-dark)</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <small class="text-white">Nº Visitas: <?php echo $_COOKIE['visitas'];?></small>
        </nav>
    </header>

