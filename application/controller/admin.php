<?php

class Admin extends Controller {

    public function index() {
        $intake = $this->model->getCurrentIntake();
        $counsellerlist = $this->model->counsellerlist();
        require APP . 'view/admin/admin_home.php';
    }

    public function activeleadreport() {
        require APP . 'view/admin/activeleadreport.php';
    }

    public function activeleadreportdata() {
        header('Content-Type: application/json');
        echo json_encode($this->model->activeleadreport());
    }

    public function counsellerreport() {
        $report = $this->model->counsellerreport();
        require APP . 'view/admin/counseller_report.php';
    }

    public function counsellerreportdata() {
        header('Content-Type: application/json');
        echo json_encode($this->model->counsellerreport());
    }

    public function customizedreport() {
        require APP . 'view/admin/customizedreport.php';
    }

    public function statusreport() {
        require APP . 'view/admin/statusreport.php';
    }

    public function statusreportdata() {
        header('Content-Type: application/json');
        $data = array();
        array_push($data, $this->model->statusreport('active'));
        array_push($data, $this->model->statusreport('expired'));
        array_push($data, $this->model->statusreport('notinterested'));
        array_push($data, $this->model->statusreport('postponed'));

        echo json_encode($data);
    }

    public function addcounseller() {
        echo $this->model->addcounseller($_POST['username'], $_POST['password'], $_POST['fullname'], $_POST['address'], $_POST['email'], $_POST['mobno']);
    }

    public function editcounseller() {
        echo $this->model->editcounseller($_POST['id'], $_POST['username'], $_POST['password'], $_POST['fullname'], $_POST['address'], $_POST['email'], $_POST['mobno']);
    }

    public function deletecounseller() {
        echo $this->model->deletecounseller($_POST['id']);
    }

    public function addintake() {
        echo $this->model->addIntake($_POST['intake-name'], $_POST['intake-start-date']);
    }

    public function report() {
        
    }

}
