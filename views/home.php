<?php 
//HEADER FILE------------------->>
require('header.php');
//HEADER FILE-------------------<<
?>

<body>
  <div class="container box">
    <h2>Todos</h2>
    <div class="message"><?php echo $_SESSION['message'];?></div>
    <div class="card">
      <div class="card-body">

        <a href="add.php" class="card-link" data-toggle="modal" data-target="#myModal">Add Todo</a>
        <a href="logout" class="card-link">Logout</a>
      </div>
    </div>
    <br>



    <?php
        

        $items_todo = '';
        if ($_SESSION['list_of_todos']['success'] == 1) {
          foreach ((array) $_SESSION['list_of_todos']['message'] as $item) { 
              $items_todo .= '
                              <div class="card">
                              <div class="card-body">
                                <p class="card-text">'.$item['todo'].'</p>
                                <a href="completed?'.$item['todo_id'].'" class="card-link">completed</a>
                                <a href="delete_this?'.$item['todo_id'].'" class="card-link">Delete</a>
                              </div>
                            </div>
                            <br>
                         ';
          }
      }
      else{
          $items_todo  = "You dont have anything to do!";
      }
        
    echo   $items_todo;
        ?>
  </div>



<br>
<br>
<br>
  
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="container">
          <br>
          <h2>Add Todo</h2>
          <form action="add-todo" method="post">
            <div class="form-group">
              <textarea class="form-control" name="new_todo" id="new_todo" placeholder="Enter Todo here..." cols="30" rows="4"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
            <br>
            <br>
          </form>
        </div>
      </div>
    </div>
  </div>
  
</body>

</html>
