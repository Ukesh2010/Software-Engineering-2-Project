<?php

class Model
{
    /**
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

public function addIntake($date){
    $sql="insert into intake(`intake_start_date`) values('$date')";
    $query=$this->db->prepare($sql);
    $query->execute();
    
}

public function addLead($first_name,$middle_name,$last_name,$address,$mobile_no){
    $sql="INSERT INTO `lead`(`lead_first_name`, `lead_middle_name`, `lead_last_name`, `lead_address`, `lead_mobile_no`) VALUES ('$first_name','$middle_name','$last_name','$address','$mobile_no')";
    $query=$this->db->prepare($sql);
   return $query->execute();
}

public function editlead($lead_id,$first_name,$middle_name,$last_name,$address,$mobile_no){
    $sql="UPDATE `lead` SET `lead_first_name`='$first_name',`lead_middle_name`='$middle_name',`lead_last_name`='$last_name',`lead_address`='$address',`lead_mobile_no`='$mobile_no' WHERE `lead_id`=$lead_id";
    $query=$this->db->prepare($sql);
   return $query->execute();
    
}

public function leadlist(){
        $sql = "SELECT * FROM `lead`";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
}


    public function addSong($artist, $track, $link)
    {
        $sql = "INSERT INTO song (artist, track, link) VALUES (:artist, :track, :link)";
        $query = $this->db->prepare($sql);
        $parameters = array(':artist' => $artist, ':track' => $track, ':link' => $link);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }



}
