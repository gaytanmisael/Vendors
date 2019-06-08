<div id="email_form" class="section group">
    <h1 class="email_heading">Enviar Email</h1><br/>
    <?php 
        echo form_open('graphic_email/send');
        
        // Gets values for Hidden Input Types from members_area view
        $imageFile  = $this->input->post('imageFile');
        $imageName  = $this->input->post('ImageName');

        $vendorId   = $this->input->post('vendorId');

        // Picture preview in the form
        echo '<div class="picHolder" style="width:100%">';
        echo '<img src="' . base_url() . $imageName . '" class="img" width="25%" height="25%" style="padding:5px; background:white;">';
        $data = array('imageName' => $imageName);
        echo form_hidden($data);
        echo '</div>';
        
        // Email who you are going to send the Info
        $email_address = array('class' => 'email_address', 'id' => 'property_type', 'name' => 'email_address', 'placeholder' => 'Email Address', 'autocomplete' => 'on');
        echo form_input($email_address);

        
        $files = array('imageFile' => $imageFile);
        echo form_hidden($files);
        
        // Textarea in the form
        $data = array('name' => 'message', 'id' => 'message',  'value' => 'Ad:' . $imageFile . '
        Su ad a sido terminado/modificado.');
        echo form_textarea($data);

        $vId = array('vendorId' => $vendorId);
        echo form_hidden($vId);

        echo form_submit('submit', 'Enviar');

        echo form_close();
    ?>
    <br/>
    <?php echo validation_errors('<p class="error">'); ?>
</div>