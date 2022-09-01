<?php
//HEADER FILE------------------->>
require('header.php');
//HEADER FILE-------------------<<
?>

<body>

<div class="container" style="max-width:500px; padding-top:100px">
<div class="message"><?php echo $_SESSION['message'];?></div>
  <h2>Signin</h2>
  <form action="login" method="post">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
    </div>
 
    <button type="submit" class="btn btn-primary">Signin</button>
  </form>
  <p class="sin_sup">dont have account yet? <a href="signup">Register</a></p>
</div>

</body>
</html>
