<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email extends CI_Controller {
    
    // Checks to see if you havea credentials
    function __construct()
    {
        parent::__construct();
        // Check to see if Logged In
        if (!$this->ion_auth->logged_in()) {
            redirect('/','refresh');
        }
    }
    
    function index()
    {
        $data['main_content']       = 'email_form'; 
        $data['title']              = 'Enviar Email';
        $this->load->view('includes/template', $data);
    }
    
    function search()
    {
        $this->load->model('search_model');
        if (isset ($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->search_model->get_autocomplete($q);
        }
    }
    
    // Controller that sends email with Gmail
    function send()
    {
        $this->load->library('form_validation');
        
        // field name, error message, validation rules
        $this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
            
        } else {
            
            // $query uses this variable to see what user is logged in
            $usr = $this->ion_auth->user()->row();
            
            
            // Line 48 needs this query to send Email
            $query = $this->db->query("SELECT id, email, emailpass, first_name, last_name FROM users WHERE username='" . $usr->username . "'");
            
            
             // validation has passed send the email
            $message = $this->input->post('message');
            $email = $this->input->post('email_address');
            
            // Email Attachment
            $path = $_SERVER["DOCUMENT_ROOT"];
            $image = $this->input->post('imageName');
            $file = $path . $image;
            
            // Email Credential based on Login Info /* Needs $query on line 34 to run
            $userID = 0;
            foreach ($query->result() as $row)
            {
                $userID = $row->id;
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.googlemail.com',
                    'smtp_port' =>465,
                    'smtp_user' => $row->email,
                    'smtp_pass' => $row->emailpass
                );
                
                // MySQL query that checks to see if the Client Email exists
                $select_exists = $this->db->query("SELECT emailclient, idvendor FROM usr_clntemails WHERE emailclient='" . $email . "' AND idvendor=" . $userID);
            };
            
                    
            // Loading Email Library
            $this->load->library('email', $config);

            // Very Important do not comment or delete
            $this->email->set_newline("\r\n");

            // Email Configuration
            $this->email->from($row->email, $row->first_name . '' . $row->last_name);
            $this->email->to($email);
            // $this->email->cc('carlos@ngweekly.com');
            $this->email->subject('Revice su Ad');
            $this->email->message($message);
            $this->email->attach($file);

            if($select_exists->num_rows() == 0 )
            {
                // Adds Client Email if it those not exist to the DB to be used in auto complete
                $this->db->query("INSERT INTO usr_clntemails (idvendor, emailclient, clientname, c_status) VALUES (" . $userID .",'" . $email . "','','')");
            }
            
            if($this->email->send())
            {
                // REdirects you to this page if Email is Sent
                $data['title']          = 'Email Enviado';
                $data['main_content']   = 'sent_email';
                $this->load->view('includes/template',$data);
            } else {
                // Shows you why email could not be sent
                show_error($this->email->print_debugger());
            }
        }
    }
    
    
    /* Checks to see if you are logged in if not it displays You don't have permission */
    function is_logged_in()
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        
        if (!isset($is_logged_in) || $is_logged_in !== true)
        {
            echo 'You don\'t have permission to access this page. <a href="/">Login</a>';
            die();
        }
    }
}