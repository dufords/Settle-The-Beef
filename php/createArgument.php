<?php
    /*
    Parameters:
        Title: Title of the argument, required
        LeftSide: Text about the left side of the argument, required
        RightSide: Text about the right side of the argument, required
        UserID: ID about the user that posted the argument, required

    Return:
        ["Error"]: Error, maybe couldn't connect to the server 

        ["Results"]
            ["ArgID"]: ArgID that was created
    */
    require_once('config.php');

    $entries = $_POST;
    if(
        !isset($entries["Title"]) ||
        !isset($entries["LeftSide"]) ||
        !isset($entries["RightSide"]) ||
        !isset($entries["UserID"])
    ){
        $error = ["Error"=>"Parameters not set"];
        exit(json_encode($error));
    }

    $userID = $entries["UserID"];
    $db_table = ARGUMENTDB;
    $conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
    $toreturn = [];
    $error = mysqli_connect_error();
    if($error != null){
        $output = ["Error"=>"Unable to connect to database: ".$error];
        mysqli_close($conn);
        exit(json_encode($output));
    }else{
        $sql = "SELECT max(ArgID) as 'Max' from ".$db_table;
        $result = mysqli_query($conn, $sql);
        $row = $result->fetch_assoc();
        $newID = $row["Max"]+1;
        
        $title = addslashes($_POST["Title"]);
        $left = addslashes($_POST["LeftSide"]);
        $right = addslashes($_POST["RightSide"]);
        //Insert Data
        $sql = "INSERT INTO ".$db_table." (ArgID, UserID, Title ,LeftSide, RightSide, date)
            VALUES ('".$newID."', '".$userID."', '".$title."', '".$left."', '".$right."', now())";
        if(mysqli_query($conn, $sql)){
            $arr = ["ArgID"=>$newID];
            $toreturn["Results"] = $arr;
            mysqli_close($conn);
        } else {
            $error = ["Error" => $sql.": ".mysqli_error($conn)];
            mysqli_close($conn);
            exit(json_encode($error));   
        }
    }
    //mysqli_close($conn);
    print json_encode($toreturn);
?>