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


//REQUIRE DATABASE AND SET OBJECT ---------------------------->>>
require __DIR__.'/db.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();
//REQUIRE DATABASE AND SET OBJECT ----------------------------<<<

// GET DATA FORM REQUEST ------------------------------------->>>
$data = json_decode(file_get_contents("php://input"));
$returnData = [];
// GET DATA FORM REQUEST -------------------------------------<<<

//AUTHENTICATE REQUEST METHOD -------------------------------->>>
if($_SERVER["REQUEST_METHOD"] != "POST"){
    $returnData = msg(0,404,'Page Not Found!'); }
//AUTHENTICATE REQUEST METHOD --------------------------------<<<

//CHECKING FOR BLANK FIELDS ---------------------------------->>>
elseif(
       !isset($data->user_id) 
    || !isset($data->new_todo) 
    || empty(trim($data->user_id))
    || empty(trim($data->new_todo))
       ){
        $returnData = msg(0,422,'Todo cant not be blank!');
       }
//CHECKING FOR BLANK FIELDS ----------------------------------<<<


else {
     $user_id = trim($data->user_id);
     $new_todo = trim($data->new_todo);
    
        try {
                //PREPARING SQL STMT ------------------=------>>>
                $insert_query = "INSERT INTO `todos`(`user_id`, `todo`, `status`) VALUES(:user_id, :new_todo, 'active')";
                $insert_stmt = $conn->prepare($insert_query);
                //PREPARING SQL STMT -------------------------<<<

                //BINDING DATA ------------------------------->>>
                $insert_stmt->bindValue(':user_id', htmlspecialchars(strip_tags($user_id)),PDO::PARAM_STR);
                $insert_stmt->bindValue(':new_todo', htmlspecialchars(strip_tags($new_todo)),PDO::PARAM_STR);
                //BINDING DATA -------------------------------<<<

                //INSERTING DATA ----------------------------->>>
                $insert_stmt->execute();
                $returnData = msg(1,201, '<p style="color:#10E32A">Todo item has been added successfully!</p>');
                //INSERTING DATA -----------------------------<<<
            }
        
            //HANDLING PHP DATA OBJECTS EXCEPTION------------->>>
            catch(PDOException $e){$returnData = msg(0,500,$e->getMessage()); }
            //HANDLING PHP DATA OBJECTS EXCEPTION-------------<<<
        }

//RESPONSE --------------------------------------------------->>>
echo json_encode($returnData);
//RESPONSE ---------------------------------------------------<<<

