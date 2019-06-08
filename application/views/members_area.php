<?php
    // Gets the username of the session that is used to check that all the work is from this user
    $usr = $this->session->userdata('username');

    // Query that gets file info displayed in the Divs
    $query = $this->db->query("SELECT p1.folder, p1.username, p2.dir_name, p2.filename, p2.last_time_ord FROM users AS p1 INNER JOIN usr_files AS p2 WHERE p1.folder = p2.dir_name AND p1.username = '" . $usr . "' ORDER BY p2.last_time_ord DESC");
?>
<div id="headcontainer">
    <div class="section group">
        <header>
            <div id="left" class="col span_1_of_3">
                <a href="<?php echo base_url();?>dashboard" class="logo">
                    <img src="<?php echo base_url(); ?>/css/logo.png" title="Nuestra Gente" alt="Nuestra Gente"/>
                </a>
            </div>

            <div id="middle" class="col span_1_of_3">
                <h1 class="main-user"><?php echo $usr; ?></h1>
            </div>

            <div id="right" class="col span_1_of_3">
                <?php echo anchor('login/logout', 'Sign Out'); ?>
            </div>
        </header>
    </div>
</div>

<div id="maincontainer">
    <div id="maincontent" class="dashboard">

        <div class="section group">
            <div class="col span_1_of_2">
                <strong>Imagen</strong>
            </div>
            
            <div class="col span_1_of_2">
                <strong>Nombre</strong>
            </div>
        </div>

    
    <?php
        foreach ($query->result() as $row)
        {
            echo '<div class="section group" id="section">';
            echo '<div class="col span_1_of_2">';    
            
            // The Link that Email_Controller uses to attach the picture to the Email
            $imageLink = '/vendors/' . $row->dir_name . '/' . $row->filename;
            
            // Name of the Image File
            $imageFile = $row->filename;
            
            // When the Files are uploaded to this server Thumbnails
            // echo '<img src="' . base_url() .  'vendors/' . $row->dir_name . '/tn/tn_' . $row->filename . '" class="img" />';
            
            // Anchor tag that activates FancyBox
            echo '<a href="http://nuestra-gente.com/vendors/' . $row->dir_name . '/' . $row->filename . '" class="big_pic" target="_blank" rel="gallery" title="' . $row->filename .'" >';

            // Files on Local Server as original pictures no thumbnails
            //echo '<img src="' . base_url() .  'vendors/' . $row->dir_name . '/' . $row->filename . '" class="img" />';
            echo '<img src="http://nuestra-gente.com/vendors/' . $row->dir_name . '/tn/tn_' . $row->filename . '" class="img" />';
            echo '</a>'; 
            echo '</div>';
            
            
            
            echo '<div class="col span_1_of_2">'; 
            echo '<p>' . $row->filename . '</p>';
            
            echo form_open('email/index');
            // Send Email BTN
            echo form_submit('submit', 'Enviar Email');
            
            // Hides Image URL to provide it too the Email Controller function send()
            $data = array('ImageName' => $imageLink);
            echo form_hidden($data);
            
            // Image name so that the controller Email can use the title name in the message box
            $image = array('imageFile' => $imageFile );
            echo form_hidden($image);
            
            echo form_close();
            
            
            echo '</div>';
            echo '</div>';
        }
    ?>
    </div>
</div>