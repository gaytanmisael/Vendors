<link rel="stylesheet" href="<?php echo base_url(); ?>css/print.css"/>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>


<?php //echo $querycontent; ?>

<div id="maincontainer">
    <div id="maincontent" class="dashboard">
        
        <div class="section group">
            <?php $attributes = array('id' => 'form3'); echo form_open('report/generate_report',$attributes);?>
            
            <fieldset id="date-select" class="col span_1_of_3">
                <label for="from">Del:</label>
                <?php $dateFrom = array('type' => 'text', 'name' =>'from', 'id' => 'from'); echo form_input($dateFrom); ?>
            
                <label for="to">A:</label>
                <?php $dateTo = array('type' => 'text', 'name' => 'to', 'id' => 'to'); echo form_input($dateTo); ?>
            </fieldset>
        
            <div id="designers">
                <select id="designer-select" multiple="multiple" class="col span_1_of_3">
                    <option <?php if($designerSelected == '01,') { echo 'selected="selected"';} ?> value="01">Todos</option>
                    <?php
                        $designer = $this->db->query('SELECT p1.id, p1.first_name, p2.user_id, p2.group_id from users As p1 INNER JOIN users_groups as p2 where p2.group_id=2 and p1.id=p2.user_id and p1.active=1');
                
                        foreach ($designer->result() as $row)
                        {
                            if($designerSelected == $row->id . ',')
                            {
                                echo '<option selected="selected" value="' . $row->id . '">' . $row->first_name . '</option>';
                            } else {
                                echo '<option value="' . $row->id . '">' . $row->first_name . '</option>';
                            }
                        }
                    ?>
                </select>
            </div>
        
            <fieldset id="order-select" class="col span_1_of_3">
                <label for="horas">Horas</label>
                <input type="radio" name="sortBy" id="hours" <?php if($sortBySelected == '1') { echo 'checked';} ?> value="1"/>
            
                <label for="vendedores">Vendedores</label>
                <input type="radio" name="sortBy" id="vendors" <?php if($sortBySelected == '2') { echo 'checked';} ?> value="2"/>
            </fieldset>
        
            <div class="col span_1_of_3">
                <?php $submit = array('type' => 'submit', 'onclick' => 'set_values()', 'value' => 'Generate Report'); echo form_input($submit); ?>
            </div>
        
            <!-- Hidden Form that submits info to display ads -->
            <?php $data = array('type' => 'hidden','name' => 'fromDate',        'id' => 'fromDate',         'value' => '');     echo form_input($data); ?>
            <?php $data = array('type' => 'hidden','name' => 'toDate',          'id' => 'toDate',           'value' => '');     echo form_input($data); ?>
            <?php $data = array('type' => 'hidden','name' => 'designerId',      'id' => 'designerId',       'value' => '');     echo form_input($data); ?>
            <?php $data = array('type' => 'hidden','name' => 'hoursOrderBy',    'id' => 'sortBy',     'value' => '');     echo form_input($data); ?>
        
            <?php echo form_close(); ?>
        </div>

        

<style type="text/css">
.tftable {font-size:12px;color:#333333;width:1067px;border-width: 1px;border-color: #729ea5;border-collapse: collapse; display:block; margin:0px auto;}
.tftable th {font-size:12px;background-color:#acc8cc;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;text-align:left; text-align:center;}
.tftable tr:nth-child(even) {background-color:#d4e3e5;}
.tftable td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;}
</style>

<table class="tftable" border="1"> 
    <tr><th>Date Activity</th><th>Designer</th><th>Vendor</th><th>Email</th><th>FileSend</th></tr>
    <?php 
        
        $query = $this->db->query($querycontent);

        foreach ($query->result() as $row)
        {
            echo '<tr><td>' . $row->DateActivity . '</td><td>' . $row->Designer_Name . '</td><td>' . $row->username . '</td><td>' . $row->email . '</td><td>' . $row->FilesSend . '</td></tr>';
        }
    ?>
</table>
    
    </div>
</div>
<script>
$(document).ready(function() {
    <?php echo $setFromDate; ?>
    <?php echo $setToDate; ?>

});   
    
$("#from").datepicker({
    defaultDate: "+1w",
    onClose: function( selectedDate ) {
        $("#to").datepicker( "option", "minDate", selectedDate );
    }
});
    
$("#to").datepicker({
    defaultDate: "+1w",
    onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
    }
});
    
function set_values() {
    var fromDate                        = $('#from').datepicker("option", "dateFormat", "yymmdd").val();
    var toDate                          = $('#to').datepicker("option", "dateFormat", "yymmdd").val();
    var designerId                      = document.getElementById('designerId');
    var sortBy                          = document.getElementById('sortBy')
    
    var fDate                           = document.getElementById('fromDate');
    var tDate                           = document.getElementById('toDate');
    
    fDate.value                         = fromDate;
    tDate.value                         = toDate;
    designerId.value                    = get_selectedDesigner('designers');
    sortBy.value                        = $('input[name=sortBy]:checked').val();
}

function get_selectedDesigner(Container) {
    var aGroup = document.getElementById('designer-select');
    var resp = "";
    for (var i = 0; i < aGroup.length; i++) {
        if (aGroup[i].selected) resp += aGroup[i].value + ",";
    }
    return resp;
}
</script>