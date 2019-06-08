<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autocomplete extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
        // Checks if user is logged in by running the function at the bottom
    }
 
    function search() {
        
        $this->load->model('search_model');
         // process posted form data
        $keyword = $this->input->post('term');
        $data['response'] = 'false'; //Set default response
        $query = $this->search_model->get_autocomplete($keyword); //Search DB
        if( ! empty($query) )
        {
            $data['response'] = 'true'; //Set response
            $data['message'] = array(); //Create array
            foreach( $query as $row )
            {
                $data['message'][] = array( 
                                        'id'=> $row->idemail,
                                        'value' => $row->emailclient,
                                        ''
                                     );  //Add a row to array
            }
        }
        if('IS_AJAX')
        {
            echo json_encode($data); //echo json string if ajax request
             
        }
        else
        {
            $this->load->view('autocomplete/index',$data); //Load html view of search results
        }
    }
}