<?php 

class Designer_model extends CI_Model {
    function get_Design_Key()
    {
        $date   = date('Ymd');
        
        $init   = "Select Key_Design_Act from design_activity WHERE Key_Design_Act like '" . $date . "%' order by Key_Design_Act desc limit 1";
        
        $query  = $this->db->query($init);
        
        
        if($query->num_rows() > 0 )
        { 
            foreach ($query->result() as $row)
            {
                $var1   = substr($row->Key_Design_Act, 8);
                $var2   = intval($var1) + 1;
                
                $var3   = str_pad($var2,3,"0",STR_PAD_LEFT);
            }            
            return $date . $var3;
        } else {
            return $date . '000';
        }
    }
    
    function search_ad($ad) {        
        $this->db->select('*')->from('ad_categories');
        $this->db->like('ad_name', $ad, 'after');
        $query = $this->db->get();
        
        if($query->num_rows() > 0 ) {
            return true;
        } else {
            return false;
        }
    }
    
    function insert_category($ad_name, $category) {
        $data = array(
            'ad_name' => $ad_name,
            'ad_subcategory' => $category,
        );
              
        if($this->db->insert('ad_categories',$data)) {
            return true;
        } else {
            return false;
        }
    }
    
    function get_categories() {
        $this->db->from('subcategory');
        $this->db->order_by('subcategory');
        $result = $this->db->get();
        
        $return = array();
        
        if($result->num_rows() > 0) {
            foreach($result->result_array() as $row) {
                $return[$row['id_subcategory']] = $row['subcategory'];
            }
        }
        
        return $return;
    }
}