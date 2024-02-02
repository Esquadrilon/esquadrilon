<?php
    function Toast($title, $message, $css) {
    ?>
        <div id="toast" class="toast fade show position-absolute mt-4 me-4 top-1 end-0 z-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="100" data-bs-autohide="true">
            <div class="toast-header <?php echo $css; ?>">
                <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <image href="\esquadrilon\assets\img\logo-branca.svg" width="20" height="20" />
                </svg>
                <strong class="me-auto"><?php echo $title; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body bg-dark">
                <?php echo $message; ?>
            </div>
        </div>
        <script>
            setTimeout(function() {
                var toast = new bootstrap.Toast(document.getElementById("toast"));
                toast.hide();
            }, 5000);
        </script>
        <?php
    }

    if (isset($_REQUEST['success'])) {
        Toast('Sucesso', $_REQUEST['success'], 'bg-success');
    } elseif (isset($_REQUEST['error'])) {
        Toast('Erro', $_REQUEST['error'], 'bg-danger');
    }
?>
