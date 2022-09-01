<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


function msg($success,$status,$message,$extra = []){
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ],$extra);
}


        //REQUIRE DATABASE AND SET CONNECTION OBJECT ----------------------->>>
        require __DIR__.'/db.php';
        $db_connection = new Database();
        $conn = $db_connection->dbConnection();
        //REQUIRE DATABASE AND SET CONNECTION OBJECT -----------------------<<<

        // GET DATA FORM REQUEST ------------------------------------------->>>
        $data = json_decode(file_get_contents("php://input"));
        $returnData = [];
        // GET DATA FORM REQUEST -------------------------------------------<<<

        //AUTHENTICATE REQUEST METHOD -------------------------------------->>>
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            $returnData = msg(0,404,'Page Not Found!'); }
        //AUTHENTICATE REQUEST METHOD --------------------------------------<<<

        //CHECKING FOR BLANK FIELDS ---------------------------------------->>>
        elseif(
            !isset($data->user_id) 
        || !isset($data->todo_status) 
        || empty(trim($data->user_id))
        || empty(trim($data->todo_status))
            ){
            $returnData = msg(0,422,'Something went wrong! please try again');
            }
        //CHECKING FOR BLANK FIELDS ----------------------------------------<<<

        else {
            $user_id = trim($data->user_id);
            $todo_status = trim($data->todo_status);  

                    try {
                            //FETCHING TODOS DATA ------------------------->>>
                            $sql = "SELECT * FROM `todos` WHERE `user_id`= :user_id AND `status`= :todo_status ORDER BY `time_stamp` DESC";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindValue(':user_id', $user_id,PDO::PARAM_STR);
                            $stmt->bindValue(':todo_status', $todo_status,PDO::PARAM_STR);
                            $stmt->execute();
                            //FETCHING TODOS DATA -------------------------<<<

                                //SETTING UP RESPONSE FOR FETCHED DATA ---->>>
                                if ($stmt->rowCount() > 0) {
                                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    $returnData = msg(1,201, $data); 
                                    }

                                else {
                                    $returnData = msg(0,422,'You have nothing todo!'); 
                                }
                                //SETTING UP RESPONSE FOR FETCHED DATA ----<<<
                      }  
                        
                        
                    //HANDLING PHP DATA OBJECTS EXCEPTION------------------>>>
                    catch(PDOException $e){$returnData = msg(0,500,$e->getMessage()); }
                    //HANDLING PHP DATA OBJECTS EXCEPTION------------------<<<
                        }

    //RESPONSE ------------------------------------------------------------>>>
    echo json_encode($returnData);
    //RESPONSE ------------------------------------------------------------<<<















