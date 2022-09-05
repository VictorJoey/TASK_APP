<?php
/*---------------  SIMPLE PHP ROUTER  ---------------------
--------------- (Sky 29th- august 2022) -------------------
+----------------------------------------------------------+
|-> this script uses REQUEST_URI to decide which view to   |
|   display, it eliminates the need for {.php } extension. |
|-> htaccess forces all request through the index.php file |
|-> switch statement is used to for the decission making   |
|   procces.                                               |
+----------------------------------------------------------+
*/


session_start();
$request = $_SERVER['REQUEST_URI'];
$base_url = "http://localhost/task1/";
$API_url = "http://localhost/task1/v1/";
$_SESSION['todo_status'] ="";
$_SESSION['notify_time_keeper'] = time();





        switch ($request) {

            case '/task1/':
            case '/task1/account':
            case '/task1/active':

                //LOGIN AUTHENTICATION------------------------------------------------>>>
                if((!isset($_SESSION['user_id']))){
                    require __DIR__ . '/views/signin.php';
                 }
                //LOGIN AUTHENTICATION------------------------------------------------<<<  


                //IF USER IS LOGGED IN, GET USER DATA--------------------------------->>> 
                else {     


                    $_SESSION['todo_status'] =  '<p style="text-align:left; color:gray; font-size:13px">List of Active Todos</p>';
                    $submited_data =   array(
                                        'user_id' => $_SESSION['user_id'],
                                        'todo_status' => 'active'
                                        );                                        
                    $_SESSION['list_of_todos'] = submit_data($API_url.'get_todos.php', $submited_data);



                   $submited_data_completed =   array(
                                        'user_id' => $_SESSION['user_id'],
                                        'todo_status' => 'completed'
                                        );                
                    $_SESSION['list_of_todos_completed'] = submit_data($API_url.'get_todos.php', $submited_data_completed);

        



                    $_SESSION['number_of_active_todos'] = count( $_SESSION['list_of_todos']['message']);
                    $_SESSION['number_of_completed_todos'] = count( $_SESSION['list_of_todos_completed']['message']);
                               
                            require __DIR__ . '/views/home.php';
                 }
                  //IF USER IS LOGGED IN, GET USER DATA-------------------------------<<< 
            break;




            case '/task1/completed':
    
                    //LOGIN AUTHENTICATION------------------------------------------------>>>
                    if((!isset($_SESSION['user_id']))){
                        require __DIR__ . '/views/signin.php';
                     }
                    //LOGIN AUTHENTICATION------------------------------------------------<<<  
    
    
                    //IF USER IS LOGGED IN, GET USER DATA--------------------------------->>> 
                    else {     
    
    

                        $_SESSION['todo_status'] =  '<p style="text-align:left; color:gray; font-size:13px">List of Active Todos</p>';
                        $submited_data =   array(
                                            'user_id' => $_SESSION['user_id'],
                                            'todo_status' => 'completed'
                                            );                                        
                        $_SESSION['list_of_todos'] = submit_data($API_url.'get_todos.php', $submited_data);
    
    
    
                       $submited_data_active =   array(
                                            'user_id' => $_SESSION['user_id'],
                                            'todo_status' => 'active'
                                            );                
                        $_SESSION['list_of_todos_active'] = submit_data($API_url.'get_todos.php', $submited_data_active);

    
                        $_SESSION['number_of_completed_todos'] = count( $_SESSION['list_of_todos']['message']);
                        $_SESSION['number_of_active_todos'] = count( $_SESSION['list_of_todos_active']['message']); require __DIR__ . '/views/home.php';
                        require __DIR__ . '/views/home.php';
                    }
                      //IF USER IS LOGGED IN, GET USER DATA-------------------------------<<< 
             break;
    

                






            case '/task1/signin'://handles user signin page 
                        require __DIR__ . '/views/signin.php';
                        $_SESSION['message'] = '';
            break;

            case '/task1/signup'://handles user signup page
                $_SESSION['message'] = '';
                        require __DIR__ . '/views/signup.php';
            break;  
                
            case '/task1/logout'://handle user logout
                            session_start();
                            session_destroy();
                            header('location: signin');
             break;




            case '/task1/add-todo'://adding a new todo item 
                        //SETTING NEW TODO DATA IN ARRAY AND CALLING SUMMIT FUNCTION---->>>
                            $submited_data =   array(
                                    'user_id' => $_SESSION['user_id'],
                                    'new_todo' => $_POST['new_todo']
                            );
                            $response = submit_data($API_url.'add_todo.php', $submited_data);
                        //SETTING NEW TODO DATA IN ARRAY AND CALLING SUMMIT FUNCTION---<<<


                            //SETTING MESSAGE FOR NEW TODO SUCCESS OR FAILURE ---------->>>
                            $_SESSION['notify_time_keeper'] = time();
                            $_SESSION['message'] =  $response['message'];
                                header('location: account');
                            //SETTING MESSAGE FOR NEW TODO SUCCESS OR FAILURE ---------->>>   
            break;  







            case '/task1/delete'://delete todo item 
                        //SETTING DELETE TODO DATA IN ARRAY AND CALLING SUMMIT FUNCTION--->>>
                            $submited_data =   array(
                                    'todo_id' => $_POST['todo_id'],
                            );
                            $response = submit_data($API_url.'delete_todo.php', $submited_data);
                        //SETTING DELETE TODO DATA IN ARRAY AND CALLING SUMMIT FUNCTION--<<<


                            //SETTING MESSAGE FOR DELETED TODO SUCCESS OR 
                            $_SESSION['notify_time_keeper'] = time();
                            $_SESSION['message'] =  $response['message'];
                                header('location: account');
                            //SETTING MESSAGE FOR DELETED TODO SUCCESS OR FAILURE -------<<<   
            break;  




            case '/task1/done'://update todo as completed
                        //SETTING COMPLETED TODO DATA IN ARRAY--------------------------->>>
                            $submited_data =   array(
                                    'todo_id' => $_POST['todo_id'],
                            );
                            $response = submit_data($API_url.'done_todo.php', $submited_data);
                         //SETTING COMPLETED TODO DATA IN ARRAY--------------------------<<<


                            //SETTING MESSAGE FOR COMPLETED TODO SUCCESS OR FAILURE ----->>> 
                            $_SESSION['notify_time_keeper'] = time();
                            $_SESSION['message'] =  $response['message'];
                                header('location: account');
                            //SETTING MESSAGE FOR COMPLETED TODO SUCCESS OR FAILURE -----<<<   
            break;  







            
            case '/task1/edit-todo'://Edit todo
                        //SETTING EDIT TODO DATA IN ARRAY-------------------------------->>>
                            $submited_data =   array(
                                    'todo_id' => $_POST['todo_id'],
                                    'new_todo_text' => $_POST['new_todo_text'],
                            );
                            $response = submit_data($API_url.'edit_todo.php', $submited_data);
                        //SETTING EDIT TODO DATA IN ARRAY--------------------------------<<<


                            //SETTING MESSAGE FOR EDIT TODO SUCCESS OR FAILURE ---------->>> 
                            $_SESSION['notify_time_keeper'] = time();
                            $_SESSION['message'] =  $response['message'];
                                header('location: account');
                            //SETTING MESSAGE FOR EDIT TODO SUCCESS OR FAILURE ----------<<<   
            break;  








            case '/task1/register': //handle new registration
                            //SETTING SIGNUP DATA IN ARRAY AND CALLING SUMMIT FUNCTION-->>>
                            $submited_data =   array(
                                    'email' => $_POST['email'],
                                    'password' => $_POST['password']
                            );
                            $response = submit_data($API_url.'add_user.php', $submited_data);
                            //SETTING SIGNUP DATA IN ARRAY AND CALLING SUMMIT FUNCTION--<<<

                            //IF REGISTRATION IS SUCCESSFUL ---------------------------->>>    
                            if ($response['status'] == 201) {
                                $_SESSION['notify_time_keeper'] = time();
                                $_SESSION['message'] =  $response['message'];
                                require __DIR__ . '/views/signin.php';
                            }
                            //IF REGISTRATION IS SUCCESSFUL ----------------------------<<<   

                            //IF REGISTRATION IS FAILS --------------------------------->>>   
                            else {
                                $_SESSION['notify_time_keeper'] = time();
                                $_SESSION['message'] =  $response['message'];
                                require __DIR__ . '/views/signup.php';
                            }
                            //IF REGISTRATION IS FAILS ---------------------------------<<<
            break;  




            case '/task1/login': //handle user signin/login
                            //SETTING SIGNIN DATA IN ARRAY AND CALLING SUMMIT FUNCTION -->>>
                            $submited_data =   array(
                                    'email' => $_POST['email'],
                                    'password' => $_POST['password']
                            );
                            $response = submit_data($API_url.'user_signin.php', $submited_data);
                            //SETTING SIGNIN DATA IN ARRAY AND CALLING SUMMIT FUNCTION --<<<


                            //IF SINGIN IS SUCCESSFUL ---------------------------------->>>    
                            if ($response['status'] == 201) {
                                $_SESSION['user_id'] =  $response['message'];
                                header('location: account');
                            }
                            //IF SINGIN IS SUCCESSFUL ----------------------------------<<< 

                            //IF REGISTRATION IS FAILS --------------------------------->>>   
                            else {
                                $_SESSION['notify_time_keeper'] = time();
                                $_SESSION['message'] =  $response['message'];
                                require __DIR__ . '/views/signin.php';
                            }
                            //IF REGISTRATION IS FAILS ---------------------------------<<<
            break;  



            default://handle 404 requests
                            http_response_code(404);
                            require __DIR__ . '/views/404.php';
            break;
        }





//DATA SUBMISSION FUNCTION------------------------------------------------------>>>
        function submit_data($url, $submited_data)
        {
            //SPECIFYING METHOD AS POST AND JSON CONTENT TYPE  ----------------->>>  
            $data_settings = array('http' =>
                array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/json',
                    'content' => json_encode($submited_data, true)
                    )
            );
            //SPECIFYING METHOD AS POST AND JSON CONTENT TYPE  -----------------<<<

            //CREATING CONTEXT STREAM/ SENDING DATA DECODING RESPONSE ---------->>>
            $stream  = stream_context_create($data_settings);
            $result = file_get_contents($url, false, $stream);
            return json_decode($result, true);
            //CREATING CONTEXT STREAM/ SENDING DATA DECODING RESPONSE ----------<<<
        }
//DATA SUBMISSION FUNCTION------------------------------------------------------>>>        
