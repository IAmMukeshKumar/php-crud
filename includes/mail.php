<?php
$to = $_POST["email"];
$subject = 'Your Password';
$message = 'Your password is :' . random_password(12);
$from = "From:Do not reply.This message is send to you by machine <no-reply@no-reply.biz>";
mail($to, $subject, $message, $from);