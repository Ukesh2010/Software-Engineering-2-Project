<?php 
class Counseller extends Controller{
	
	  public function index()
    {
        $leadlist=$this->model->leadtofollowtoday();
        require APP . 'view/counseller/counseller_home.php';
     
    }
	
    public function addlead(){
        require APP. 'view/counseller/lead_add.php';
        
    }
    
    public function addleadaction(){
      echo  $this->model->addlead($_POST['first_name'],$_POST['middle_name'],$_POST['last_name'],$_POST['address'],$_POST['mobile_no']);
        // print_r($_POST);
         header('location: ' . URL . 'counseller/leadlist');
        
    }
    
    public function editlead($lead_id){
        $lead=$this->model->leadbyid($lead_id);
        require APP. 'view/counseller/lead_edit.php';
    }
	
    public function editleadaction($lead_id){
      echo  $this->model->editlead($lead_id,$_POST['first_name'],$_POST['middle_name'],$_POST['last_name'],$_POST['address'],$_POST['mobile_no']);
                 header('location: ' . URL . 'counseller/leadlist');
    }
    public function leadlist(){
        $leadlist=$this->model->leadlist();
        require APP. 'view/counseller/lead_list.php';
    }
    
    public function addfollowupaction($lead_id){
    echo $this->model->addnextfollowup($lead_id,$_POST['followup_date']);
        
        
    }
}
