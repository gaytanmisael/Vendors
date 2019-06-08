<div id="maincontainer">
    <div id="maincontent" class="dashboard">
        
        <?php $attributes = array('id' => 'form2'); echo form_open('dashboard/graphic_display',$attributes);?>
        
        <select id="userId-select" onchange="set_values()">
            <?php
                
                $this->db->cache_on();
                $userSelect = $this->db->query('SELECT u.id, concat(u.first_name, " " , u.last_name) as name from users u,users_groups g WHERE u.id=g.user_id and  u.active=1 and u.id !=1 and g.group_id=3 order by u.first_name asc;');
                foreach ($userSelect->result() as $row)
                {                
                    if($userIdSelected == $row->id)
                    {
                        echo '<option selected="selected" value="' . $row->id . '">' . $row->name . '</option>';
                    } else {
                        echo '<option value="' . $row->id . '">' . $row->name . '</option>';
                    }
                }
            ?>
        </select>
        
        <select id="month-select" onchange="set_values()">
            <option <?php if($monthSelected == '01') { echo 'selected="selected"';}?>value="01">Enero</option>
            <option <?php if($monthSelected == '02') { echo 'selected="selected"';}?>value="02">Febrero</option>
            <option <?php if($monthSelected == '03') { echo 'selected="selected"';}?>value="03">Marzo</option>
            <option <?php if($monthSelected == '04') { echo 'selected="selected"';}?>value="04">Abril</option>
            <option <?php if($monthSelected == '05') { echo 'selected="selected"';}?>value="05">Mayo</option>
            <option <?php if($monthSelected == '06') { echo 'selected="selected"';}?>value="06">Junio</option>
            <option <?php if($monthSelected == '07') { echo 'selected="selected"';}?>value="07">Julio</option>
            <option <?php if($monthSelected == '08') { echo 'selected="selected"';}?>value="08">Agosto</option>
            <option <?php if($monthSelected == '09') { echo 'selected="selected"';}?>value="09">Septiembre</option>
            <option <?php if($monthSelected == '10') { echo 'selected="selected"';}?>value="10">Octubre</option>
            <option <?php if($monthSelected == '11') { echo 'selected="selected"';}?>value="11">Noviembre</option>
            <option <?php if($monthSelected == '12') { echo 'selected="selected"';}?>value="12">Diciembre</option>
        </select>
        
        <!-- Hidden Form that submits info to display ads -->
        <?php $data = array('type' => 'hidden','name' => 'month', 'id' => 'month', 'value' => ''); echo form_input($data); ?>
        <?php $data = array('type' => 'hidden','name' => 'year', 'id' => 'year', 'value' => ''); echo form_input($data); ?>
        <?php $data = array('type' => 'hidden','name' => 'userId', 'id' => 'userId', 'value' => ''); echo form_input($data); ?>
        
        <select id="year-select" onchange="set_values()">
            <?php
                $years = $this->db->query('SELECT substring(last_time_ord,1,4) as years from usr_files group by substring(last_time_ord,1,4) order by substring(last_time_ord,1,4) desc;');
                
                foreach ($years->result() as $row)
                {
                    if($yearsSelected == $row->years)
                    {
                        echo '<option selected="selected" value="' . $row->years . '">' . $row->years . '</option>';
                    } else {
                        echo '<option value="' . $row->years . '">' . $row->years . '</option>';
                    }
                }
            ?>
        </select>
        <?php echo form_close(); ?>
    <div class="section group">
            <div class="col span_1_of_2">
                <strong>Imagen</strong>
            </div>
            
            <div class="col span_1_of_2">
                <strong>Nombre</strong>
            </div>
        </div>

    
    <?php
        
        $query = $this->db->query($querycontent);

        // echo $querycontent;

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
            echo '<a href="http://designers.nuestra-gente.com/vendors/' . $row->dir_name . '/' . $row->filename . '" class="big_pic" target="_blank" rel="gallery" title="' . $row->filename .'" >';

            // Files on Local Server as original pictures no thumbnails
            //echo '<img src="' . base_url() .  'vendors/' . $row->dir_name . '/' . $row->filename . '" class="img" />';
            echo '<img src="http://designers.nuestra-gente.com/vendors/' . $row->dir_name . '/' . $row->filename . '" class="img" width="25%" height="25%" />';
            echo '</a>'; 
            echo '</div>';
            
            
            
            echo '<div class="col span_1_of_2">'; 
            echo '<p>' . $row->filename . '</p>';
            
            echo form_open('graphic_email/index');
            // Send Email BTN
            echo form_submit('submit', 'Enviar Email');
            
            // Hides Image URL to provide it too the Email Controller function send()
            $data = array('ImageName' => $imageLink);
            echo form_hidden($data);
            
            // Image name so that the controller Email can use the title name in the message box
            $image = array('imageFile' => $imageFile );
            echo form_hidden($image);
            
            $vendorId = array('vendorId' => $userId);
            echo form_hidden($vendorId);
            
            echo form_close();
            
            
            echo '</div>';
            echo '</div>';
        }
    ?>
    </div>
</div>
<script>
    
// FancyBox for ads with IO - big_pic
$(".big_pic").fancybox();
    
function set_values() {
    var Month           = document.getElementById('month');
    var Year            = document.getElementById('year');
    var UserId          = document.getElementById('userId');
    
    var UserIdSelect    = document.getElementById('userId-select');
    var MonthSelect     = document.getElementById('month-select');
    var YearSelect      = document.getElementById('year-select');
    
    var selIndex        = YearSelect.selectedIndex;
    var selIndexMonth   = MonthSelect.selectedIndex;
    var selIndexUserId  = UserIdSelect.selectedIndex;
    
    Month.value         = MonthSelect.options[selIndexMonth].value;
    Year.value          = YearSelect.options[selIndex].value;
    UserId.value        = UserIdSelect.options[selIndexUserId].value;
    
    // Submits Form
    document.getElementById('form2').submit();
}
</script>