<script src="../../../librerias/lib_js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="../../../librerias/lib_js/jQuery v3.3.1.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="../../../librerias/lib_js/Font Awesome Free 5.10.1.js"></script>
<script type="text/javascript" src="../../../librerias/lib_js/NotifyAlertas.js"></script>
<script type="text/javascript" src="../../../js/funcionesGenerales.js"></script>
<!-- Script para maneja de popover -->
<script>
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl, {
            trigger: 'focus',
            html:true,
        })
    });
</script>