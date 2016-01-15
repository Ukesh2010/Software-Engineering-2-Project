<?php

class Admin extends Controller {

    public function index() {
        session_start();
        if (isset($_SESSION['admin'])) {
            $intake = $this->model->getCurrentIntake();
            $counsellerlist = $this->model->counsellerlist();
            require APP . 'view/admin/admin_home.php';
        } else {
            header('location: ' . URL . 'home');
        }
    }

    public function activeleadreport() {
        require APP . 'view/admin/activeleadreport.php';
    }

    public function activeleadreportdata() {
        header('Content-Type: application/json');
        echo json_encode($this->model->activeleadreport());
    }

    public function activeleadreportdata2() {
        header('Content-Type: application/json');
        echo json_encode($this->model->activeleadreport2());
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
        $intakes = $this->model->getIntakes();
        $counsellers = $this->model->counsellerlist();
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

    public function customizedreportdata() {
        header('Content-Type: application/json');
        switch (intval($_POST['type'])) {
            case 0:
                echo json_encode($this->model->customizedreport_counwise($_POST['counseller_id']));
                break;
            case 1:
                echo json_encode($this->model->customizedreport_semwise($_POST['intake_id']));
                break;
        }
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
