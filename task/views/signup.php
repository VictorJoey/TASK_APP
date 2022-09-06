<?php
//HEADER FILE------------------->>
require('header.php');
//HEADER FILE-------------------<<
?>

<body>

<div class="container" style="max-width:500px; padding-top:100px">



<div class="message">
      <?php
    
    
    if(!isset( $_SESSION['message'] )){

    }
    else{
        if(time() - $_SESSION['notify_time_keeper'] > 5){
         }

        else{ 
            echo $_SESSION['message'];
        }
    } 
    
    
    
    ?>
    
  </div>

  
  <h2>Register </h2>
  <form action="register" method="post">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
    </div>
    <button type="submit" class="btn btn-primary">Signup</button>
  </form>
  <p class="sin_sup">already have an account? <a href="signin">Signin</a></p>
</div>
</body>
</html>
