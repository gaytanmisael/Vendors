<?php
// search_model.php (Array of Strings)

class Search_model extends CI_Model{

    function get_autocomplete($q) {
      $this->db->select('*')->from('usr_clntemails');
      $this->db->like('emailclient',$q,'after');
      $query = $this->db->get();

      return $query->result();
    }
}
