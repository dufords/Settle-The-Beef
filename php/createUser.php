<?php
    /*
    Parameters: 
        UserName: Name for User, requirement
        Password: Password for use, requirement

        i.e. UserName=Eric&Password=temp
    
    Returns:
        ["Error"]: Error in creating user, possible user already exists
        ["Results"]
            ["UserID"]: User sucessfully created, returns ID
    */

    require_once("config.php");
    
    $conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
    $db_table = USERDB;

    $entries = $_POST;

    $error = mysqli_connect_error();
    if($error != null){
        $output = [ "Error"=>"Could not connect to database"];
        mysqli_close($conn);
        exit(json_encode($output));
    }
    
    if(!isset($entries["UserName"]) || !isset($entries["Password"])){
        $output = [ "Error"=>"The wrong things were submitted"];
        mysqli_close($conn);
        exit(json_encode($output));
    }

    $username = $entries["UserName"];
    $password = $entries["Password"];
    
    $sql = "select UserID from l_user where UserName = '".$username."'";
    $result = mysqli_query($conn, $sql);
    if(is_object($result) && $result->num_rows > 0){
        $output = [ "Error"=>"User already exists." ];
        mysqli_close($conn);
        exit(json_encode($output));
    }else{
        $sql = "SELECT max(UserID) as 'Max' from ".USERDB;
        $result = mysqli_query($conn, $sql);
        $row = $result->fetch_assoc();
        $newID = $row["Max"]+1;
        
        $sql = "INSERT INTO ".USERDB."(`UserName`, `UserID`, `Passwrd`) VALUES ('".$username."','".$newID."','".$password."')";
        if(mysqli_query($conn, $sql)){
            //setcookie("'".IDCOOKIE."'", $newID, time()+3600);
            //setcookie("'".NAMECOOKIE."'", $username, time()+3600);
            mysqli_close($conn);   
            
            $arr = ["UserID" => $newID];
            $toreturn = ["Results" => $arr];
            print json_encode($toreturn);
            exit(0);
        } else {
            $output = ["Error"=>mysqli_error($conn)];
            mysqli_close($conn);
            exit(json_encode($output));
        }
    }
?>