<?php include __DIR__.'/layout/header.php'; ?>

<div class="container my-5">
    <h2>Bienvenido al Sistema de Gestión Académico</h2>
    <p>Gestión de alumnos, docentes y cursos de forma eficiente y centralizada.</p>
    <div class="text-start mt-3">
        <a class="btn btn-primary" href="index.php?accion=login" style="width: auto;">Inicio Sesion</a>
    </div>
</div>

<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="imagenes/Imagen01.jpg" class="d-block w-100" alt="Imagen 1">
      <div class="carousel-caption d-none d-md-block">
        <h5>Título 1</h5>
        <p>Descripción de la imagen 1.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="imagenes/Imagen02.jpg" class="d-block w-100" alt="Imagen 2">
      <div class="carousel-caption d-none d-md-block">
        <h5>Título 2</h5>
        <p>Descripción de la imagen 2.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="imagenes/Imagen03.jpg" class="d-block w-100" alt="Imagen 3">
      <div class="carousel-caption d-none d-md-block">
        <h5>Título 3</h5>
        <p>Descripción de la imagen 3.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="imagenes/Imagen04.jpg" class="d-block w-100" alt="Imagen 4">
      <div class="carousel-caption d-none d-md-block">
        <h5>Título 4</h5>
        <p>Descripción de la imagen 4.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="imagenes/Imagen05.jpg" class="d-block w-100" alt="Imagen 5">
      <div class="carousel-caption d-none d-md-block">
        <h5>Título 5</h5>
        <p>Descripción de la imagen 5.</p>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Anterior</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Siguiente</span>
  </a>
</div>


<?php include __DIR__.'/layout/footer.php'; ?>