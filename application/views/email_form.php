<div id="email_form" class="section group">
    <h1 class="email_heading">Enviar Email</h1><br/>
    <?php 
        echo form_open('email/send');
        
        // Gets values for Hidden Input Types from members_area view
        $imageFile = $this->input->post('imageFile');
        $imageName = $this->input->post('ImageName');

        // Picture preview in the form
        echo '<div class="picHolder" style="width:100%">';
        echo '<img src="' . base_url() . $imageName . '" class="img" width="25%" height="25%" style="padding:5px; background:white;">';
        $data = array('imageName' => $imageName);
        echo form_hidden($data);
        echo '</div>';
        
        // Email who you are going to send the Info
        $email_address = array('class' => 'email_address', 'id' => 'property_type', 'name' => 'email_address', 'placeholder' => 'Email Address');
        echo form_input($email_address);
        
        // Textarea in the form
        $data = array('name' => 'message', 'id' => 'message',  'value' => 'Ad:' . $imageFile . '
        Su ad a sido terminado/modificado.');
        echo form_textarea($data);

        echo form_submit('submit', 'Enviar');

        echo form_close();
    ?>
    <br/>
    <?php echo validation_errors('<p class="error">'); ?>
</div>

<!-- This Script is for autocomplete, that can be found in the Autocomplete_folder -->

 <style>
.ui-autocomplete {
max-height: 100px;
overflow-y: auto;
/* prevent horizontal scrollbar */
overflow-x: hidden;
}
/* IE 6 doesn't support max-height
* we use height instead, but this forces the menu to always be this tall
*/
* html .ui-autocomplete {
height: 100px;
}
</style>
<script type='text/javascript'>
$(this).ready( function() {
            $(".email_address").autocomplete({
                minLength: 1,
                source: 
                function(req, add){
                    $.ajax({
                        url: "<?php echo base_url(); ?>autocomplete/search",
                        dataType: 'json',
                        type: 'POST',
                        data: req,
                        success:    
                        function(data){
                            if(data.response =="true"){
                                add(data.message);
                            }
                        },
                    });
                },    
            });
        });
</script>