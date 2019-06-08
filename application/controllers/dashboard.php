<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_CONTROLLER{

    public function __construct(){
        parent::__construct();

        // Check to see if Logged In
        if (!$this->ion_auth->logged_in()) {
            redirect('/','refresh');
        }
    }

    public function index()
    {
        if ($this->ion_auth->is_admin())
        {
            redirect('/auth/','refresh');
        }

        $group = array(2);
        if ($this->ion_auth->in_group($group))
        {
            $userId     = "34";

            $month      = date('m');
            $year       = date('Y');

            $usr        = $this->ion_auth->user()->row();

            $this->db->cache_on();
            $querycontent = "SELECT p1.id, p2.dir_name, p2.filename, p2.last_time_ord FROM users AS p1 INNER JOIN usr_files AS p2 WHERE p1.folder = p2.dir_name AND p1.id = '" . $userId ."' and last_time_ord like '" . $year . $month . "%' ORDER BY last_time_ord DESC";

            $data['querycontent']       = $querycontent;

            $data['yearsSelected']      = $year;
            $data['monthSelected']      = $month;
            $data['userIdSelected']     = $userId;
            $data['userId']             = $userId;

            $data['title']              = 'Ads - Diseñador Grafico';
            $data['main_content']       = 'graphic_dashboard';
            $this->load->view('includes/template',$data);

        }

        $group2 = array(3);
        if ($this->ion_auth->in_group($group2))
        {

            $month      = $this->input->post('month');
            $year       = $this->input->post('year');

            $month      = date('m');
            $year       = date('Y');

            $usr        = $this->ion_auth->user()->row();

            $querycontent = "SELECT dir_name, p2.filename, p2.last_time_ord FROM users AS p1 INNER JOIN usr_files AS p2 WHERE p1.folder = p2.dir_name AND p1.email = '" . $usr->email ."' and last_time_ord like '" . $year . $month . "%' ORDER BY last_time_ord DESC";

            $data['querycontent']       = $querycontent;

            $data['yearsSelected']      = $year;
            $data['monthSelected']      = $month;

            $data['title']              = 'Ads - Vendedores';
            $data['main_content']       = 'vendors_dashboard';
            $this->load->view('includes/template',$data);
        }
    }


    // Separate Function
    function vendors_display()
    {
        $month      = $this->input->post('month');
        $year       = $this->input->post('year');

        $usr        = $this->ion_auth->user()->row();

        if (!isset($month))
        {
            $month = date('m');
        }

        if (!isset($year))
        {
            $year = date('Y');
        }

        $querycontent = "SELECT dir_name, p2.filename, p2.last_time_ord FROM users AS p1 INNER JOIN usr_files AS p2 WHERE p1.folder = p2.dir_name AND p1.email = '" . $usr->email ."' and last_time_ord like '" . $year . $month . "%' ORDER BY last_time_ord DESC";

        $data['querycontent']       = $querycontent;

        $data['monthSelected']      = $month;
        $data['yearsSelected']      = $year;
        $data['title']              = 'Ads - Vendedores';
        $data['main_content']       = 'vendors_dashboard';
        $this->load->view('includes/template',$data);
    }

    function graphic_display()
    {
        $month      = $this->input->post('month');
        $year       = $this->input->post('year');
        $userId     = $this->input->post('userId');

        $usr        = $this->ion_auth->user()->row();


        $querycontent = "SELECT p1.folder, p2.dir_name, p2.filename, p2.last_time_ord FROM users AS p1 INNER JOIN usr_files AS p2 WHERE p1.folder = p2.dir_name AND p1.id = '" . $userId ."' and last_time_ord like '" . $year . $month . "%' ORDER BY last_time_ord DESC";

        $data['querycontent']       = $querycontent;

        $data['monthSelected']      = $month;
        $data['yearsSelected']      = $year;
        $data['userIdSelected']     = $userId;
        $data['userId']             = $userId;

        $data['title']              = 'Ads - Vendedores';
        $data['main_content']       = 'graphic_dashboard';
        $this->load->view('includes/template',$data);
    }
}
