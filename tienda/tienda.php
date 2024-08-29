<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link rel="stylesheet" href="./recursos/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./recursos/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>

<body>

    <!-- NAV -->
    <div class="cumtom">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="./recursos/img/logotienda.png" alt="Bootstrap" width="200">
                </a> <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active fw-bold" aria-current="page" href="#">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Categorias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Servicios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Domicilios</a>
                        </li>

                    </ul>
                    <form class="d-flex justify-content-center" role="search">
                        <div class="d-flex align-items-center">
                            <!-- <input style="width: 180px;" class="form-control me-3" type="search" placeholder="Buscar" aria-label="Buscar"> -->
                            <i class="fa-solid fa-cart-shopping me-3 icono-shop"></i>
                            <button style="width: 150px;" class="btn btn-success" type="submit">Iniciar Sesión</button>
                        </div>
                    </form>

                </div>
            </div>
        </nav>
    </div>
    <!-- NAV -->

    <br>

    <!-- HOME -->
    <div class="cumtom mt-5">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-2 d-flex ms-2 me-2 mt-5 align-items-center">
            <div class="col">
                <h1 class="fw-bold mb-4">Las mejores frutas y <br>verduras de Corinto</h1>
                <p style="width: 85%; font-size: 18px;">Pide tu domicilio ahora, Lorem Ipsum is simply <br>dummy text of the printing and typesetting industry. </p>
                <div class="mt-5">
                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-success me-2" type="button">Haz tu pedido ahora!</button>
                        <button class="btn btn-custom-1" type="button">Visítanos</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class=" mb-4 d-flex justify-content-center img-custom">

                </div>
            </div>
        </div>
    </div>
    <!-- HOME -->

    <br><br>



    <!-- Recomendados (IA) -->
    <div class="cumtom mt-5">
        <h1 class="fw-bold mb-4">Recomendados</h1>
    
        </div>
    </div>
    <!-- Recomendados (IA) -->

    <br><br>


    <!-- HOME -->
    <div class="cumtom mt-5">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-2 d-flex ms-2 me-2 mt-5 align-items-center">
            <div class="col">
                <div class=" mb-4 d-flex justify-content-center img-custom2">

                </div>
            </div>
            <div class="col">
                <h1 class="fw-bold mb-4">Del campo.<br>a tu despensa.</h1>
                <p style="width: 85%; font-size: 18px;">Provedores de calidad, Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                <div class="mt-5">
                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-success me-2" type="button">Conoce más</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- HOME -->


    <br>
    <!-- Agrega el botón de chat -->
    <button id="chatBtn" class="btn"><i style="font-size: 50px; color:#052E16;" class="fa-solid fa-comment-dots"></i></button>
    <script src="./recursos/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>