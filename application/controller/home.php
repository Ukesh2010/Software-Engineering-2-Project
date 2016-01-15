<?php

class Home extends Controller {

    public function index() {
        session_start();
        if (isset($_SESSION['counseller'])) {
            header('location: ' . URL . 'counseller');
        } else if (isset($_SESSION['admin'])) {
            header('location: ' . URL . 'admin');
        }
        $fail = false;
        if (isset($_SESSION['fail'])) {
            $fail = true;
            unset($_SESSION['fail']);
        }
        require APP . 'view/home.php';
    }

    public function login() {
        session_start();
        switch (isset($_POST['type']) ? $_POST['type'] : 3) {
            case 0:
                if ($_POST['username'] == "admin" && $_POST['password'] == "admin") {
                    $_SESSION['admin'] = TRUE;
                    header('location: ' . URL . 'admin');
                } else {
                    $_SESSION['fail'] = TRUE;
                    header('location: ' . URL . 'home');
                }
                break;
            case 1:
                $result = $this->model->counsellerlogin($_POST['username'], $_POST['password']);
                if (is_bool($result)) {
                    $_SESSION['fail'] = TRUE;
                    header('location: ' . URL . 'home');
                } else {
                    $_SESSION['counseller'] = $result[0];
                    header('location: ' . URL . 'counseller');
                }
                break;
            default :
                echo "hehe";
                break;
        }
    }

}
