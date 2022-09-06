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


//REQUIRE DATABASE AND SET OBJECT ---------------------------------------->>>
require __DIR__.'/db.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();
//REQUIRE DATABASE AND SET OBJECT ----------------------------------------<<<

// GET DATA FORM REQUEST ------------------------------------------------->>>
$data = json_decode(file_get_contents("php://input"));
$returnData = [];
// GET DATA FORM REQUEST -------------------------------------------------<<<

//AUTHENTICATE REQUEST METHOD -------------------------------------------->>>
if($_SERVER["REQUEST_METHOD"] != "POST"){
    $returnData = msg(0,404,'Page Not Found!'); }
//AUTHENTICATE REQUEST METHOD --------------------------------------------<<<

//CHECKING EMPTY FIELDS -------------------------------------------------->>>
elseif(
       !isset($data->email) 
    || !isset($data->password) 
    || empty(trim($data->email))
    || empty(trim($data->password))
       ){
        $returnData = msg(0,422,'Please all Fields are Required to signin!');
       }
//CHECKING EMPTY FIELDS --------------------------------------------------<<<


else {
     $email = trim($data->email);
     $password = trim($data->password);

    //VALIDATING EMAIL --------------------------------------------------->>>
     if(!filter_var($email, FILTER_VALIDATE_EMAIL)){$returnData = msg(0,422,'Invalid Email Address!');}
    //VALIDATING EMAIL ---------------------------------------------------<<<
   
    //VALIDATING INPUT LENGHT -------------------------------------------->>>
    elseif(strlen($password) < 8){$returnData = msg(0,422,'Your password must be at least 8 characters long!');}
    elseif(strlen($email) < 2){$returnData = msg(0,422,'Please check your email format!');}
    //VALIDATING INPUT LENGHT --------------------------------------------<<<
    else {


        try {
            //CHECK IF EMAIL EXISTS -------------------------------------->>>
            $fetch_user_by_email = "SELECT * FROM `users` WHERE `email`=:email";
            $query_stmt = $conn->prepare($fetch_user_by_email);
            $query_stmt->bindValue(':email', $email,PDO::PARAM_STR);
            $query_stmt->execute();
            //CHECK IF EMAIL EXISTS --------------------------------------<<<
             


            //IF USER IS FOUND BY EMAIL ---------------------------------->>>
            if ($query_stmt->rowCount()){ 
                $row = $query_stmt->fetch(PDO::FETCH_ASSOC);
                $check_password = password_verify($password, $row['password']);
               
               //verifying password-->>

              //$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                 $check_password = password_verify($password, $row['password']);
              //verifying password--<<
                
                if($check_password){//if password is correct
                    $returnData = msg(0,201, $row['user_id']);
                }

                else { //if password is wrong
                    $returnData = msg(0,422,'Invalid Email Or Password!');
                }  

            }
            //IF USER IS FOUND BY EMAIL ----------------------------------<<<





            //IF USER IS NOT FOUNDED BY EMAIL ---------------------------->>>
            else { $returnData = msg(0,422,"This Email Doesn't Exit! <a href='signup' style='color:blue'>Register Instead?</a>");}
            //IF USER IS NOT FOUNDED BY EMAIL ----------------------------<<<

        }//------try ends here


        //HANDLING PHP DATA OBJECTS EXCEPTION----------------------------->>>
        catch(PDOException $e){$returnData = msg(0,500,$e->getMessage()); }
        //HANDLING PHP DATA OBJECTS EXCEPTION-----------------------------<<<


        }
}

//RESPONSE --------------------------------------------------------------->>>
echo json_encode($returnData);
//RESPONSE ---------------------------------------------------------------<<<