<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_CONTROLLER{
    
    function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        if(!$this->ion_auth->logged_in())
        {
            $data['message'] = '';
            $this->load->view('login_form', $data);
        } else {
            redirect('/dashboard/','refresh');
        }
    }
    
    function validate_credentials()
    {
        $msg ='';
        // Validate Credentials
        $this->form_validation->set_rules('username', 'Username', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() == true)
		{
			//check to see if the user is logging in
			//check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('/dashboard/','refresh');
                
			}
			else
			{
				//if the login was un-successful
				//redirect them back to the login page
				$msg = $this->session->set_flashdata('message', $this->ion_auth->errors());
				$data['title']              = 'Area de Vendedores - Login';
                $data['message']            = $msg;
                $this->load->view('login_form', $data);
			}
		}
		else
		{
            $msg = $this->session->set_flashdata('message', $this->ion_auth->errors());
				$data['title']              = 'Area de Vendedores - Login';
                $data['message']            = $msg;
                $this->load->view('login_form', $data);
		}
    }
    
    function logout()
	{
		$this->data['title'] = "Logout";

		//log the user out
		$logout = $this->ion_auth->logout();
        
        $this->db->close();

		//redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('/', 'refresh');
	}
}