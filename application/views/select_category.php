        <div id="category_form" class="section group">

            <p>Ad #<strong><?php echo $ad_number; ?></strong></p><br/>

            <?php
                $attribute = array('class' => 'categories', 'id' => 'category-selector');             
                echo form_open('category/add_category', $attribute);

                $data = array('type' => 'hidden', 'name' => 'ad-name', 'id' => 'adname', 'value' => $ad_number);
                echo form_input($data);
                
                $category = array('type' => 'hidden', 'name' => 'category', 'value' => '', 'id' => 'category');
                echo form_input($category);
                
                
                $js = 'id="select-category" onChange="set_category();"';

                echo form_dropdown('category', $categories,'', $js);
                echo form_close();   
            ?>
        </div>

<script type="text/javascript">
function set_category() {
    var Category            = document.getElementById('category');
    
    var CategorySelect      = document.getElementById('select-category');
    
    var selIndex            = CategorySelect.selectedIndex;
    
    Category.value          = CategorySelect.options[selIndex].value;
    
    // Submits Form
    document.getElementById('category-selector').submit();
}
</script>