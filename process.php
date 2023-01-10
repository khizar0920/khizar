<?php
ob_start();
include("include/classes/session.php");

class Process
{
 
   function __construct(){
      global $session;
  
      if(isset($_POST['sublogin'])){
         $this->procLogin();
      }

     else if(isset($_POST['addAdmin'])){
        $this->procAddAdmin();
     }

      
      else if($session->logged_in){
         $this->procLogout();
      }
       else{
          header("Location: login.php");
       }
   }



      function procLogout(){
      global $session;
      $retval = $session->logout();
      header("Location: login.php");
   }

   function procLogin(){
      global $session, $form;
      $result = $session->login($_POST['user'], $_POST['pass']);
      
      if($result){
         header("Location: dashboard.php");
      }
      else{
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: login.php");
      }
   }






 
   function procAddAdmin(){
    global $session, $form;

$result = $session->registerAdmin($_POST['name'], $_POST['user'], $_POST['phone'], $_POST['email'], $_POST['cnic'], $_POST['address'], $_POST['region'], $_POST['occupation']);

if ($result == 0) {
           $_SESSION['reguname'] = $_POST['name'];
         $_SESSION['regsuccess'] = true;
  header("Location: add-admin.php?reg=success");
}
      else if($result == 1){
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: add-admin.php?reg=form_error");
      }
    
      else if($result == 2){
         $_SESSION['reguname'] = $_POST['name'];
         $_SESSION['regsuccess'] = false;
         header("Location: add-admin.php?reg=form_error");
      } 
   }



 




   function procRegister(){
      global $session, $form;
      if(ALL_LOWERCASE){
         $_POST['user'] = strtolower($_POST['user']);
      }
      $retval = $session->register($_POST['user'], $_POST['pass'], $_POST['email']);
      
     
      if($retval == 0){
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = true;
         header("Location: ".$session->referrer);
      }
   
      else if($retval == 1){
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: ".$session->referrer);
      }
    
      else if($retval == 2){
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = false;
         header("Location: ".$session->referrer);
      }
   }
   
 

};

$process = new Process;

?>
