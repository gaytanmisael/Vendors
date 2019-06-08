<?php

class Category extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        if(!$this->ion_auth->logged_in()) {
            redirect('/','refresh');
        }
        
        $group = array(2);
        if(!$this->ion_auth->in_group($group)) {
            echo 'You don\'t have the clearance';
            exit();
        }
    }
    
    public function index() { 
        
        $this->load->model('designer_model');
        $ad_name = $this->input->post('ad-name');
        
        $search = $this->designer_model->search_ad($ad_name);        
        $dropdown = $this->designer_model->get_categories();
        
        if($search == true) {
            $data ['title']         = 'Error';
            $data ['message']       = 'Ad already has Category';
            $data ['main_content']  = 'message';
            $this->load->view('includes/template',$data);
        } else {
            $data['title']          = 'Select Category';
            $data['ad_number']      = $ad_name;
            $data['categories']     = $dropdown;
            $data['main_content']   = 'select_category';
            $this->load->view('includes/template', $data);
        }
    }
    
    function add_category() {
        $this->load->model('designer_model');
        
        $ad_number  = $this->input->post('ad-name');
        $category   = $this->input->post('category');
        
        $insert     = $this->designer_model->insert_category($ad_number, $category);
        
        if($insert == true) {            
            $data['title']              = 'Success';
            $data['message']            = 'Ad has been successfuly categorized';
            $data['main_content']       = 'message';
            $this->load->view('includes/template',$data);
        } else {
            $data['title']              = 'Failure';
            $data['message']            = 'For some reason ad could not be categorized, please let admin know for more info.';
            $data['main_content']       = 'message';
            $this->load->view('includes/template',$data);
        }
    
    }
}