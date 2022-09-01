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

        <a href="" class="card-link" data-toggle="modal" data-target="#myModal">Add Todo</a>
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
                                <p class="card-text todo_text">'.$item['todo'].'</p>
                                 <button onclick="delete_todo(`'.$item['todo_id'].'`,`'.$item['todo'].'`)" data-toggle="modal" data-target="#delete_todo" type="button" class="delete_btn"> Delete</button>
                                 <button onclick="done(`'.$item['todo_id'].'`,`'.$item['todo'].'`)" data-toggle="modal" data-target="#done_todo" type="button" class="done_btn"> Done</button>
                              </div>
                            </div>
                            <br>
                         ';
          }
      }
      else{
          $items_todo  = "You dont have any post yet";
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







  
<div class="modal fade" id="done_todo" role="dialog">
  <br>
  <br>
  <br>
  <br>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="container">
          <br>
          <h3>Done?</h2>
          <p id="done_prompt" ></p>
          <form action="add-todo" method="post">
            <input type="text" id="done_todo_id" value="" style="display:none">
            <button type="submit" class="btn btn-success" style="float:right">Done</button>
            <br>
            <br>
            <br>
          </form>
        </div>
      </div>
    </div>
  </div>

















  <br>
<br>
<br>
  
<div class="modal fade" id="delete_todo" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="container">
        <br>
          <h3>Delete?</h2>
          <p id="delete_prompt" ></p>
          <form action="add-todo" method="post">
            <input type="text" id="delete_todo_id" value="" style="display:none">
            <button type="submit" class="btn btn-danger" style="float:right">Delete</button>
            <br>
            <br>
            <br>
          </form>
        </div>
      </div>
    </div>
  </div>
  






  <script>
    function done(id, text) {
      document.getElementById('done_todo_id').value=id;
      document.getElementById('done_prompt').innerHTML=text;
    }


    function delete_todo(id, text) {
      console.log(id);
      document.getElementById('delete_todo_id').value=id;
      document.getElementById('delete_prompt').innerHTML=text;
    }
  </script>
</body>

</html>
