<?php

class Counseller extends Controller {

    public function index() {
        session_start();
        if (isset($_SESSION['counseller'])) {
            $counsellerDetail = $_SESSION['counseller'];
            $leadlist = $this->model->leadtofollowtoday();
            $leadlist_temp = array();

            for ($i = 0; $i < count($leadlist); $i++) {
                $leadlist_temp[$i] = $leadlist[$i];
                $leadlist_temp[$i]->followupcount = $this->model->countFollowups($leadlist[$i]->lead_id)->total;
            }
            $leadlist = $leadlist_temp;
            require APP . 'view/counseller/counseller_home.php';
        } else {
            $_COOKIE['fail'] = TRUE;
            header('location:' . URL . 'home');
        }
    }

    public function addlead() {
        session_start();
        if (isset($_SESSION['counseller'])) {
            $counsellerDetail = $_SESSION['counseller'];
            require APP . 'view/counseller/lead_add.php';
        } else {
            $_COOKIE['fail'] = TRUE;
            header('location:' . URL . 'home');
        }
    }

    public function addleadaction() {
        session_start();
        if (isset($_SESSION['counseller'])) {
            $counsellerDetail = $_SESSION['counseller'];
            echo $this->model->addlead($_POST['first_name'], $_POST['middle_name'], $_POST['last_name'], $_POST['address'], $_POST['mobile_no'], $counsellerDetail->counseller_id);
            header('location: ' . URL . 'counseller/leadlist');
        }
    }

    public function editlead($lead_id) {
        session_start();
        if (isset($_SESSION['counseller'])) {
            $counsellerDetail = $_SESSION['counseller'];
            $lead = $this->model->leadbyid($lead_id);
            require APP . 'view/counseller/lead_edit.php';
        } else {
            $_COOKIE['fail'] = TRUE;
            header('location:' . URL . 'home');
        }
    }

    public function editleadaction($lead_id) {
        $this->model->editlead($lead_id, $_POST['first_name'], $_POST['middle_name'], $_POST['last_name'], $_POST['address'], $_POST['mobile_no']);
        header('location: ' . URL . 'counseller/leadlist');
    }

    public function leadlist() {
        session_start();
        if (isset($_SESSION['counseller'])) {
            $counsellerDetail = $_SESSION['counseller'];
            $leadlist = $this->model->leadlistbycid($counsellerDetail->counseller_id);
            $leadlist_temp = array();

            for ($i = 0; $i < count($leadlist); $i++) {
                $leadlist_temp[$i] = $leadlist[$i];
                $leadlist_temp[$i]->followupcount = $this->model->countFollowups($leadlist[$i]->lead_id)->total;
            }
            $leadlist = $leadlist_temp;

//            print_r($leadlist_temp);
            require APP . 'view/counseller/lead_list.php';
        }
    }

    public function addfollowupaction($lead_id) {
        $this->model->addnextfollowup($lead_id, $_POST['followup_date']);
        header('location: ' . URL . 'counseller/leadlist');
    }

    public function addfollowupdetail() {
//        print_r($_POST);
        $this->model->addnextfollowup($_POST['lead-id'], $_POST['nextfollowupdate']);
        echo $this->model->addfollowup($_POST['lead-id'], date("Y/m/d"), $_POST['followupdesc']);
    }

    public function followups() {
        header('Content-Type: application/json');
        echo json_encode($this->model->fetchFollowups($_POST['lead-id']));
    }

    public function changeStatus() {
        switch ($_POST['status']) {
            case 0:
                echo $this->model->changeStatus($_POST['lead-id'], 'postponed');
                break;
            case 1:
                echo $this->model->changeStatus($_POST['lead-id'], 'expired');
                break;
            case 2:
                echo $this->model->changeStatus($_POST['lead-id'], 'notinterested');
                break;
            case 3:
                echo $this->model->changetostudent($_POST['lead-id'], $_POST['status']);
                break;
        }
    }

    public function logout() {
        session_start();
        if (isset($_SESSION['counseller'])) {
            unset($_SESSION['counseller']);
        }
        if (isset($_SESSION['admin'])) {
            unset($_SESSION['admin']);
        }
        header('location: ' . URL . 'home');
    }

}
