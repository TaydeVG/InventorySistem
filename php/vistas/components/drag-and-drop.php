<link rel="stylesheet" href="../components/drag-and-drop.css">
<div class="drag-area py-3">
    <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
    <header>Arrastra y suelta la imagen aquí</header>
    <span>-o-</span>
    <button type="button" class="btn btn-primary">Seleccionar imagen</button>
    <input type="file" name="upl" class="d-none" id="upl">
</div>
<div class="img-cargada d-none">
    <div class="card">
        <div class="toast-header">
            <strong class="me-auto">Vistra previa</strong>
            <small id="imgName">intentar de nuevo <i class="fas fa-arrow-right"></i></small>
            <button type="button" class="btn-close" id="closePrev" aria-label="Close"></button>
        </div>
        <div class="toast-body text-center mb-0">
            <img class="img-prev rounded img-thumbnail shadow" src="" alt="image" />
            <span></span>
        </div>
    </div>
</div>
<script type="text/javascript" src="../components/drag-and-drop.js"></script>