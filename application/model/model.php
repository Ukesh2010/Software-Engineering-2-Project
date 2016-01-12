<?php

class Model {

    /**
     * @param object $db A PDO database connection
     */
    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function addLead($first_name, $middle_name, $last_name, $address, $mobile_no, $counseller_id) {
        $sql = "SELECT * FROM `intake` ORDER by intake_start_date DESC LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute();
        $intake = $query->fetch();

        $intake_id = $intake->intake_id;
        $sql = "INSERT INTO `lead`(`lead_first_name`, `lead_middle_name`, `lead_last_name`, `lead_address`, `lead_mobile_no`,`counseller_id`,`intake_id`) VALUES ('$first_name','$middle_name','$last_name','$address','$mobile_no','$counseller_id','$intake_id')";
        $query = $this->db->prepare($sql);
        return $query->execute();
    }

    public function editlead($lead_id, $first_name, $middle_name, $last_name, $address, $mobile_no) {
        $sql = "UPDATE `lead` SET `lead_first_name`='$first_name',`lead_middle_name`='$middle_name',`lead_last_name`='$last_name',`lead_address`='$address',`lead_mobile_no`='$mobile_no' WHERE `lead_id`=$lead_id";
        $query = $this->db->prepare($sql);
        return $query->execute();
    }

    public function leadbyid($lead_id) {
        $sql = "SELECT * FROM `lead` where `lead_id`=$lead_id";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    public function leadtofollowtoday() {
        $today = date("Y/m/d");
        $sql = "SELECT * FROM `lead`  where status='active' AND isStudent='false' AND next_followup_date='$today' AND lead_id not in (SELECT lead_id from followup where followup_date='$today')";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function leadlist() {
        $sql = "SELECT * FROM `lead`";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function leadlistbycid($id) {
        $sql = "SELECT * FROM `lead` where `counseller_id`=$id";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function addnextfollowup($lead_id, $followup_date) {
        $sql = "UPDATE `lead` SET `next_followup_date`='$followup_date' WHERE `lead_id`=$lead_id";
        $query = $this->db->prepare($sql);
        return $query->execute();
    }

    public function addfollowup($lead_id, $followup_date, $feedback) {
        $sql = "INSERT INTO `followup`(`lead_id`, `followup_date`,`feedback`) VALUES ($lead_id,'$followup_date','$feedback')";
        $query = $this->db->prepare($sql);
        $temp = $query->execute();
//        print_r(countFollowups($lead_id));
        if (intval(countFollowups($lead_id)->total) >= 8) {
            changeStatus($lead_id, 'expired');
        }
        return $temp;
    }

    public function counsellerLogin($un, $pwd) {
        $sql = "SELECT * FROM `counseller` WHERE `counseller_username` = :un AND `counseller_password` = :pwd";
        $query = $this->db->prepare($sql);
        $parameters = array(':un' => $un, ':pwd' => $pwd);
        $query->execute($parameters);
        $result = $query->fetchAll();
        return count($result) <= 0 ? false : $result;
    }

    public function adminLogin($un, $pwd) {
        
    }

    public function countFollowups($lead_id) {
        $sql = "SELECT count(lead_id) as total FROM `followup` where `lead_id`=$lead_id";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    public function fetchFollowups($lead_id) {
        $sql = "SELECT *  FROM `followup` where `lead_id`=$lead_id";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function changeStatus($lead_id, $status) {
        $sql = "update `lead` set `status`='$status' where `lead_id`=$lead_id";
        $query = $this->db->prepare($sql);
        return $query->execute();
    }

    public function changetostudent($lead_id) {
        $sql = "update `lead` set `isStudent`=true where `lead_id`=$lead_id";
        $query = $this->db->prepare($sql);
        return $query->execute();
    }

    public function counsellerlist() {
        $sql = "SELECT * FROM `counseller`";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function addcounseller($username, $password, $fullname, $address, $email, $phoneno) {
        $sql = "INSERT INTO `counseller`(`counseller_username`, `counseller_password`, `counseller_fullname`, `counseller_address`, `counseller_email`, `counseller_phone_no`) VALUES ('$username','$password','$fullname','$address','$email','$phoneno')";
        $query = $this->db->prepare($sql);
        return $query->execute();
    }

    public function editcounseller($id, $username, $password, $fullname, $address, $email, $phoneno) {
        $sql = "UPDATE `counseller` set `counseller_username`='$username', `counseller_password`='$password', `counseller_fullname`='$fullname', `counseller_address`='$address', `counseller_email`='$email', `counseller_phone_no`='$phoneno' where `counseller_id`=$id";
        $query = $this->db->prepare($sql);
        return $query->execute();
    }

    public function deletecounseller($id) {
        $sql = "delete from `counseller` where `counseller_id`=$id";
        $query = $this->db->prepare($sql);
        return $query->execute();
    }

    public function counsellerreport() {
        $sql = "SELECT c.counseller_username,count(f.followup_date) as no_of_followup FROM `counseller` c join lead l on (c.counseller_id=l.counseller_id) join followup f on (f.lead_id=l.lead_id) ";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function statusreport($status) {
        $sql = "select count(lead_id) as no_of_leads, `status` from lead where `status` ='$status'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    public function activeleadreport() {
        $sql = "select i.intake_name, count(l.lead_id) as no_of_lead from intake i join lead l on (i.intake_id=l.intake_id) where l.status='active' group by i.intake_id";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getCurrentIntake() {
        $sql = "SELECT * FROM `intake` ORDER by intake_start_date DESC LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    public function addIntake($name, $date) {
        $sql = "INSERT INTO `intake`(`intake_start_date`, `intake_name`) VALUES ('$date','$name')";
        $query = $this->db->prepare($sql);
        return $query->execute();
    }

    public function addSong($artist, $track, $link) {
        $sql = "INSERT INTO song (artist, track, link) VALUES (:artist, :track, :link)";
        $query = $this->db->prepare($sql);
        $parameters = array(':artist' => $artist, ':track' => $track, ':link' => $link);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

}
