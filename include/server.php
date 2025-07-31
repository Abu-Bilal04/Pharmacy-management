<?php
session_start();
include 'db_connection.php';

error_reporting(0);



if (isset($_POST['login'])) {
  
  $username = $_POST['username'];
  $password = $_POST['password'];

  
       $check_user = "SELECT * FROM admin WHERE username = '$username' AND password='$password'";
       $run = mysqli_query($dbcon,$check_user);
       if (mysqli_num_rows($run)>0) {
        $_SESSION['username'] = $username;
          echo "<script>window.open('backend/index.php?msg=success','_self')</script>";
        }else{
         echo "<script>window.open('index.php?msg=error','_self')</script>";
      } 
}


//add distributors to database
if (isset($_POST['add_distributor'])) {

  $company = $_POST['company'];
  $location = $_POST['location'];
  $phone = $_POST['phone'];
  $insert = "INSERT INTO distributors (company, location, phone) VALUES ('$company','$location','$phone')";
  if (mysqli_query($dbcon,$insert)) {
    echo "<script>window.open('distributors.php?msg=success','_self')</script>";
  
  }
  else{
    echo "<script>window.open('distributors.php?msg=error','_self')</script>";
  }
}


//add new purchases to database
if (isset($_POST['add_purchase'])) {

  $product = $_POST['product'];
  $company = $_POST['company'];
  $price = $_POST['price'];
  $package = $_POST['package'];
  $quantity = $_POST['quantity'];
  $transaction = $_POST['transaction'];
  $insert = "INSERT INTO purchases (product, company, price, package, quantity,transaction, timestamp) VALUES ('$product','$company','$price','$package','$quantity','$transaction','$timestamp')";
  if (mysqli_query($dbcon,$insert)) {
    echo "<script>window.open('purchases.php?msg=success','_self')</script>";
  
  }
  else{
    echo "<script>window.open('purchases.php?msg=error','_self')</script>";
  }
}


//add new expenses to database
if (isset($_POST['add_expense'])) {

  $item = $_POST['item'];
  $price = $_POST['price'];
  $transaction = $_POST['transaction'];
  $insert = "INSERT INTO expenses (item, price, transaction, timestamp) VALUES ('$item','$price','$transaction','$timestamp')";
  if (mysqli_query($dbcon,$insert)) {
    echo "<script>window.open('expenses.php?msg=success','_self')</script>";
  
  }
  else{
    echo "<script>window.open('expenses.php?msg=error','_self')</script>";
  }
}



if (isset($_POST['delete_distributor'])) {
  $id = $_POST['id'];


  $sql =  "DELETE FROM distributors WHERE id = '$id' ";
  if (mysqli_query($dbcon,$sql)) {
    echo "<script>window.open('distributors.php?msg=del_success','_self')</script>";
  
  }
  else{
    echo "<script>window.open('distributors.php?msg=del_error','_self')</script>";
  }
}



if (isset($_POST['change'])) {
  $dept = $_POST['dept'];
  $level = $_POST['level'];
  $newfee = $_POST['newfee'];


  $sql =  "UPDATE fee SET fee = '$newfee' WHERE dept = '$dept' AND level = '$level' ";
  if (mysqli_query($dbcon,$sql)) {
    echo "<script>window.open('change.php?msg=success','_self')</script>";
  
  }
  else{
    echo "<script>window.open('change.php?msg=error','_self')</script>";
  }
}


if (isset($_POST['del_ques'])) {
  $id = $_POST['id'];


  $sql =  "DELETE FROM question WHERE id = '$id' ";
  if (mysqli_query($dbcon,$sql)) {
    echo "<script>window.open('view_exam.php?msg=dsuccess','_self')</script>";
  
  }
  else{
    echo "<script>window.open('view_exam.php?msg=derror','_self')</script>";
  }
}



?>
