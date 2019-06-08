<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Graphic_email extends CI_Controller {
    
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
        $data['main_content']       = 'graphic_email_form'; 
        $data['title']              = 'Enviar Email';
        $this->load->view('includes/template', $data);
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
            $message    = '<p style="background-color: yellow;">'.$this->input->post('message').'</p>';
            $email      = $this->input->post('email_address');
            
            $vendorId   = $this->input->post('vendorId');
            
            $imageName = $this->input->post('imageFile');
            
            // Email Attachment
            $path = $_SERVER["DOCUMENT_ROOT"];
            $image = $this->input->post('imageName');
            $file = $path . $image;
            
            $config = array(
                'protocol'          => 'smtp',
                'smtp_host'         => 'ssl://smtp.googlemail.com',
                'smtp_port'         => 465,
                'smtp_user'         => 'gd@ngweekly.com',
                'smtp_pass'         => 'Revista8545',
                'bcc_batch_mode'    => 'TRUE',
                'bcc_batch_size'    => '5'
            );
                    
            // Loading Email Library
            $this->load->library('email', $config);

            // Very Important do not comment or delete
            $this->email->set_newline("\r\n");
            $this->email->set_mailtype("html");

            // Email Configuration
            $this->email->from('gd@ngweekly.com', 'Diseno' . ' ' . 'Grafico');
            
            $this->email->to($email);
            
            //$list = array('carlos@ngweekly.com');
            //$this->email->cc('carlos@ngweekly.com');
            
            $this->email->subject('Revise su Ad ' . $imageName);
            $this->email->message($message);
            $this->email->attach($file);
            
            
            $this->load->model('Designer_model');
            $getLast    = $this->Designer_model->get_Design_Key();
            
            $dateHour   = date('Ymd h:i a');
            
            if($this->email->send())
            {
                $query = "INSERT INTO design_activity (Key_Design_Act, DateActivity, DesignerID, Designer_name, vendorID, email, FilesSend, C_status)  VALUES ('" . $getLast .  "','" . $dateHour . "','" . $usr->id . "','" . $usr->first_name . "','" . $vendorId . "','" . $email . "','" . $image . "',' ')";
                
                $this->db->query($query);
                

                // REdirects you to this page if Email is Sent
                $data['title']              = 'Email Enviado';
                $data['query']              = $query;
                $data['img']                = $image;
                $data['main_content']       = 'sent_email';
                $this->load->view('includes/template',$data);
            } else {
                // Shows you why email could not be sent
                show_error($this->email->print_debugger());
            }
        }
    }
}