<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_CONTROLLER{
    
    public function __construct()
    {   
        parent::__construct();
        
        $usr = $this->ion_auth->user()->row()->id;
        
        if (!$this->ion_auth->logged_in()  || $usr != '51')
		{
			redirect('auth', 'refresh');
		}
    }
    
    public function index()
    {                
        $fromDate       = $this->input->post('fromDate');
        $toDate         = $this->input->post('toDate');
        $designerId     = '';
        $sortBy         = $this->input->post('sortBy');
        
        $usr = $this->ion_auth->user()->row();
        
        $designId       = explode(",", $designerId);
        
        $boolfirst  = 1;
        $strCond    = "";
        for($i = 0, $size = count($designId); $i < $size-1; $i++)
        {
            if($designId[$i] != "1")
            {
                if($boolfirst == 1)
                {
                    $strCond       .= " and (";
                    $boolfirst      = 0;
                } else {
                    $strCond .= " or ";
                }
                
                $strCond .= "DesignerID = " . $designId[$i];
            }
        }
        
        if($boolfirst == 0)
        {
            $strCond .= ")";
        }
        
        if($sortBy == "1")
        {
            $sort = 'p1.Key_Design_Act';
        }  else {
            
            $sort = 'p1.DesignerID';
        }
        
        $querycontent = "SELECT p1.Key_Design_Act, p1.DateActivity, p1.Designer_Name, p1.DesignerID, p1.email, p1.FilesSend, p2.username FROM design_activity AS p1 INNER JOIN users AS p2 WHERE p1.vendorId=p2.id AND p1.Key_Design_Act BETWEEN  '" . $fromDate . "' AND '" . $toDate . "'" . $strCond . " ORDER BY " . $sort;
        
        $data['setFromDate']            = "$(\"#from\").datepicker(\"setDate\", new Date());";
        $data['setToDate']              = "$(\"#to\").datepicker(\"setDate\", new Date());";
        
        $data['fromDate']               = $fromDate;
        
        $data['querycontent']           = $querycontent;
        $data['designerSelected']       = '1';
        $data['sortBySelected']         = '1';
        $data['title']                  = 'Reporte';
        $data['main_content']           = 'report_view';
        $this->load->view('includes/template',$data);
    }
    
    function generate_report()
    {
        $fromDate       = $this->input->post('fromDate');
        $toDate         = $this->input->post('toDate');
        $designerId     = $this->input->post('designerId');
        $sortBy         = $this->input->post('sortBy');
        
        $usr = $this->ion_auth->user()->row();
        
        $designId       = explode(",", $designerId);
        
        $boolfirst  = 1;
        $strCond    = "";
        for($i = 0, $size = count($designId); $i < $size-1; $i++)
        {
            if($designId[$i] != "1")
            {
                if($boolfirst == 1)
                {
                    $strCond       .= " and (";
                    $boolfirst      = 0;
                } else {
                    $strCond .= " or ";
                }
                
                $strCond .= "DesignerID = " . $designId[$i];
            }
        }
        
        if($boolfirst == 0)
        {
            $strCond .= ")";
        }
        
        if($sortBy == "1")
        {
            $sort = 'p1.Key_Design_Act';
            $sortN = '1';
        } 
        if($sortBy == "2")
        {            
            $sort = 'p1.DesignerID';
            $sortN = '2';
        } 
        
        $querycontent = "SELECT p1.Key_Design_Act, p1.DateActivity, p1.Designer_Name, p1.DesignerID, p1.email, p1.FilesSend, p2.username FROM design_activity AS p1 INNER JOIN users AS p2 WHERE p1.vendorId=p2.id AND p1.Key_Design_Act BETWEEN  '" . $fromDate . "000' AND '" . $toDate . "999'" . $strCond . " ORDER BY " . $sort;
        
        $setYear                        = substr($fromDate, 0, 4); //Year
        $setMonth                       = substr($fromDate, 4, -2); //Month
        $setDay                         = substr($fromDate, 6, 8); // Day
        
        $setYearTo                      = substr($toDate, 0, 4); //Year
        $setMonthTo                     = substr($toDate, 4, -2); //Month
        $setDayTo                       = substr($toDate, 6, 8); //Day
        
        $data['setFromDate']            = '$( "#from" ).datepicker( "setDate", "' . $setMonth . '/' . $setDay . '/' . $setYear . '" );';
        $data['setToDate']              = '$( "#to" ).datepicker( "setDate", "' . $setMonthTo . '/' . $setDayTo . '/' . $setYearTo . '" )';
        $data['fromDate']               = $fromDate;
            
        $data['querycontent']           = $querycontent;
        $data['designerSelected']       = $designerId;
        $data['sortBySelected']         = $sortN;
        
        $data['title']                  = 'Reporte';
        $data['main_content']           = 'report_view';
        $this->load->view('includes/template',$data);
    }
}