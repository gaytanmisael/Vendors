<?php $usr = $this->ion_auth->user()->row(); ?>
<div class="section group">
    <h1>¡Su Email a sido enviado!</h1>
    <?php echo anchor('dashboard/graphic_display', 'Regresar'); ?>
</div>