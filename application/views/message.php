<?php $usr = $this->ion_auth->user()->row(); ?>
<div class="section group">
    <h1><?php echo $message; ?></h1>
    <a href="<?php echo base_url(); ?>" class="goBack">Return to dashboard</a>
</div>