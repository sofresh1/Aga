<!doctype html>
<html lang=''>
<head>
   <meta charset='utf-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="public/css/style.css">
   <body background="img/22.png"> 


   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="script.js"></script>
   <title></title>
</head>
<body>

<center>

   <div id="header">
    <div id="content">
       <div id='cssmenu'>

       <img src="public/img/logo-white.png" style="width: 50px; height: 50px; float: left; margin-left: 30px" />

       <?php 
       require_once("security.php");
 
       if(!CheckLogin())
        {  
      ?>
        <form id='login' action='login.php' method='post' accept-charset='UTF-8'>
                <input type="submit" class="login-button" value="Connecter"></input>
            </form>
            <?php
    } else { 
                  
                  

      ?>
        <form id='logout' action='logout-submit.php' method='post' accept-charset='UTF-8'>
                <input type="submit" class="login-button" value="Deconnecter"></input>
            </form>
            <?php
      }; ?>
            
           <ul>
              <li><a href="index.php"><span>Accueil</span></a></li>
              <li><a href="presentation.php"><span>Presentation</span></a></li>
              <li><a href="faq.php"><span>FAQ</span></a></li>
              <?php 
                if(CheckLogin())
                  {
                    if(!isset($_SESSION)) 
                    { 
                        session_start(); 
                    }
                    $type =  $_SESSION['usertype'] ;
                  
              ?>
              <li><a href="contact.php"><span>Contact</span></a></li>
              <li class='last'><a href="<?php echo $type;?>" style="color: gold;"><span><?php echo "espace ".$type;?></span></a></li>
              <?php 
                } else {
              ?> 
              <li class='last'><a href="contact.php"><span>Contact</span></a></li>
            <?php 
                }
              ?>


           </ul>
       </div>
       </div>
   </div>
