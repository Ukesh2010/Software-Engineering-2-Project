<?php
class Test extends Controller
{
     public function index()
    {
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/index.php';
        require APP . 'view/_templates/footer.php';
    }
	
	public function login(){
       print_r($this->model->getAllSongs()) ;
		require APP. 'view/_templates/header.php';
		
	}

}