<?php
session_start();
include 'db_connection.php';

error_reporting(0);



if (isset($_POST['login'])) {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  
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
  $company = trim($_POST['company']);
  $location = trim($_POST['location']);
  $phone = trim($_POST['phone']);

  $check_company = "SELECT * FROM  distributors WHERE company = '$company'";
  $real_company = mysqli_query($dbcon,  $check_company);
  $finalResultForCompany = mysqli_fetch_assoc($real_company);

  if ($finalResultForCompany)
  echo "<script>window.open('distributors.php?msg=companyExist','_self')</script>";
  else{
  $insert = "INSERT INTO distributors (company, location, phone) VALUES ('$company','$location','$phone')";
  if (mysqli_query($dbcon,$insert)) {
    echo "<script>window.open('distributors.php?msg=success','_self')</script>";
  
  }
  else{
    echo "<script>window.open('distributors.php?msg=error','_self')</script>";
  }
}
}


//add new purchases to database
if (isset($_POST['add_purchase'])) {
  $product = trim($_POST['product']);
  $company = trim($_POST['company']);
  $price = floatval($_POST['price']);
  $package = intval($_POST['package']);
  $quantity = intval($_POST['quantity']);
  $transaction = trim($_POST['transaction']);
  $timestamp = date('Y-m-d H:i:s'); // Get current date and time

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
  $item = trim($_POST['item']);
  $price = floatval($_POST['price']);
  $transaction = trim($_POST['transaction']);
  $timestamp = date('Y-m-d H:i:s');

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


//add new sale to database
if (isset($_POST['add_sale'])) {
  $product = trim($_POST['product']);
  $price = floatval($_POST['price']);
  $quantity = intval($_POST['quantity']);
  $payment_type = trim($_POST['payment_type']);
  $timestamp = date('Y-m-d H:i:s'); // Get current date and time

  $insert = "INSERT INTO sales (product, price, quantity, payment_type, timestamp) 
             VALUES ('$product', '$price', '$quantity', '$payment_type', '$timestamp')";
             
  if (mysqli_query($dbcon, $insert)) {
    echo "<script>window.open('sales.php?msg=success','_self')</script>";
  } else {
    echo "<script>window.open('sales.php?msg=error','_self')</script>";
  }
}





if (isset($_POST['update_profile'])) {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);


  $sql =  "UPDATE admin SET email = '$email', password = '$password', username = '$username' ";
  if (mysqli_query($dbcon,$sql)) {
    echo "<script>window.open('profile.php?msg=success','_self')</script>";
  
  }
  else{
    echo "<script>window.open('profile.php?msg=error','_self')</script>";
  }
}





?>
