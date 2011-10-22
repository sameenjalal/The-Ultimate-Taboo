<?
$to="sameenjalal@gmail.com, vverna@eden.rutgers.edu, jgalaro@gmail.com";
$subject = "The Ultimate Taboo";
$body = "$_REQUEST['message_box']";
$headers = "From: TheUltimateTaboo@gmail.com\r\n";
mail($to, $subject, $body, $headers);
?>

