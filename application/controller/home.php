<?php 
class Home extends Controller{
	
	  public function index()
    {
        $leadlist=$this->model->leadtofollowtoday();
        require APP . 'view/counseller/counseller_home.php';
     
    }

}