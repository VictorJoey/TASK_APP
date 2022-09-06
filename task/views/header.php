<!DOCTYPE html>
<html lang="en">

<head>
<title>Todo</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .box {
            max-width: 500px;
            padding-top: 100px;
        }
        .sin_sup{
            font-size:12px;
            float:right;
            margin-top:-20px;
        }
        .sin_sup a{
            font-size:14px;
            font-weight:bold;
        }
        .message{
            color:red;
            text-align:center;
        }
        .todo_text{
            color:#34495E;
            font-size:15px;
            margin-left:20px;
        }
        .delete_btn{
            background-color:maroon;
            color:#F5B7B1;
            font-size:11px;
            float:right;
            margin-left:20px;
            border-radius:7px;
            border: 1px solid maroon;
}
.done_btn{
            background-color:#7DCEA0;
            color:#fff;
            font-size:11px;
            float:right;
            margin-left:20px;
            border-radius:7px;
            border: 1px solid #7DCEA0;
        }

        .edit_btn{
            background-color:orange;
            color:#fff;
            font-size:11px;
            float:right;
            margin-left:20px;
            border-radius:7px;
            border: 1px solid orange;
        }
    </style>
</head>