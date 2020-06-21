<?php
    /*
    Parameters:
        UserName: Username for user, required
        Password: Password for user, required
        
    Returns:
        ["Error"]: Some error, maybe wrong parameters
        ["Status"]: Shows errors in the user logging in, 1: incorrect username/password combo
        ["Results"]
            ["UserID"]: ID of the user that successfully signed in
    */
    require_once("config.php");
    
    $conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
    $error = mysqli_connect_error();
    $entries = $_POST;
    if($error != null){
        $output = ["Error"=>"Unable to connect to database: ".$error];
        mysqli_close($conn);
        exit(json_encode($output));
    }else if(!isset($entries["UserName"]) || !isset($entries["Password"])){
        $output = ["Error"=>"The wrong things were submitted"];
        mysqli_close($conn);
        exit(json_encode($output));
    }else{
        $username = $entries["UserName"];
        $password = $entries["Password"];
        $toreturn = [];

        $sql = "select UserID from ".USERDB." where UserName = '".$username."' and Passwrd = '".$password."' ";
        $result = mysqli_query($conn, $sql);
        if(is_object($result) && $result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $arr = ["UserID"=>$row["UserID"]];
                $toreturn["Results"] = $arr;
                //setcookie("'".IDCOOKIE."'", $userId, time()+3600);
                //setcookie("'".NAMECOOKIE."'", $username, time()+3600);
            }
            $toreturn["Status"] = 0;
        }else{
            $toreturn["Status"] = 1;
        }
        mysqli_close($conn);
        exit(json_encode($toreturn));
    }

?>