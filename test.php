<?php
$to = "shobhitbhosure7@gmail.com";
$subject = "Activate your account ";
$headers = "From: Instakart";
$body = "Hello $username,\n\nYou need to register your account in order to use our products and Services.\nClick on the link below to register\nhttp://instakart.rf.gd/login.php?username=$username&code=$confirm_code";
mail($to,$subject,$body,$headers);
echo "<p style='color:green'>You are registered Successfully !\n Please check your email to activate the account.</p>";											
?>