<?php
$host = 'sql105.epizy.com';
$host_user = 'username';
$host_pass = 'password';
$conn = mysqli_connect($host,$host_user,$host_pass,'epiz_24120497_instakart');
$sSQL= 'SET CHARACTER SET utf8';
mysqli_query($conn, $sSQL);
?>