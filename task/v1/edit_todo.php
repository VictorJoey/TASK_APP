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
            !isset($data->todo_id) 
        ||  !isset($data->new_todo_text) 
        ||  empty(trim($data->todo_id))
        ||  empty(trim($data->new_todo_text))
            ){
            $returnData = msg(0,422,'Something went wrong! please try again');
            }
        //CHECKING FOR BLANK FIELDS ----------------------------------------<<<

        else {
            $todo_id = trim($data->todo_id);
            $new_todo_text = trim($data->new_todo_text);
        
                    try {
                            ///UPDATING TODO DATA ------------------------->>>
                            $sql ="UPDATE todos SET todo = :todo  WHERE `todo_id`=:todo_id";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindValue(':todo_id', $todo_id,PDO::PARAM_STR);
                            $stmt->bindValue(':todo', $new_todo_text,PDO::PARAM_STR);
                            $stmt->execute();
                            $returnData = msg(1,201, '<p style="color:green">Edit was successfully</p>'); 
                            ///UPDATING TODO DATA --------------------------<<<
                      }  
                        
                        
                    //HANDLING PHP DATA OBJECTS EXCEPTION------------------>>>
                    catch(PDOException $e){$returnData = msg(0,500,$e->getMessage()); }
                    //HANDLING PHP DATA OBJECTS EXCEPTION------------------<<<
                        }

    //RESPONSE ------------------------------------------------------------>>>
    echo json_encode($returnData);
    //RESPONSE ------------------------------------------------------------<<<















