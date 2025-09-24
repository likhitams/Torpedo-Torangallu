
<!-- Email Notification -->
  <?php
        date_default_timezone_set('Asia/Kolkata');
        $date = date('d-M-Y h:i A');
        


$fulmsg=  $fulmsg."<table border='2' >";
$fulmsg = $fulmsg."<tr>";
$fulmsg = $fulmsg."<th>Tlc NO</th><th>Cummulative</th><th>Partial</th><th>Complete</th><th>Comments</th>";
$fulmsg = $fulmsg."</tr>";

     $connect = mysqli_connect("localhost","web",'W3bU$er!89',"suvetracg");
     // $connect = mysqli_connect("127.0.0.1","root",'',"suvetracg");
 $qry="select * from ladle_master";
 $ladleDataFound = false; // Flag to check if any data is found
 $res = mysqli_query($connect, $qry);
 while($row_query=mysqli_fetch_array($res))
      {
            $id=$row_query['id'];
            $ladleno=$row_query['ladleno'];
            $load=$row_query['load'];
            $p_load=$row_query['p_load'];
            $m_load=$row_query['m_load'];
            $ladleno=$row_query['ladleno'];

if (
    $p_load >= 25 ||
    (($ladleno >= 'TLC 01' && $ladleno <= 'TLC 29' && $m_load >= 1500) || ($ladleno >= 'TLC 30' && $ladleno <= 'TLC 35' && $m_load >= 1400))
) 
{
    $ladleno = $row_query['ladleno'];

   $p_count = 25; 

if ($ladleno >= 'TLC 01' && $ladleno <= 'TLC 29') 
{
    $m_count = 1500; 
} 
elseif ($ladleno >= 'TLC 30' && $ladleno <= 'TLC 35')
{
    $m_count = 1400; 
} 
    $p_msg = $p_count . " heats completed, need for jam removal & hot inspection";
    $m_msg = $m_count . " heats completed, need full repair";

    $fulmsg .= "<tr><td>$ladleno</td><td>$load</td><td>$p_load</td><td>$m_load</td><td>$p_msg and $m_msg</td></tr>";
    $ladleDataFound = true;
}
 
}    

$fulmsg = $fulmsg."</table>"; 
// echo $ladleno;
if ($ladleDataFound)
 { // Check if any ladle data is foundecho $fulmsg;

$fulmsg=$fulmsg;

require 'PHPMailer-master/PHPMailerAutoload.php';
$mail = new PHPMailer(true);
          $mail->SMTPDebug = 3;                               // Enable verbose debug output
          $mail->isSMTP();                                      // Set mailer to use SMTP
          $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
          $mail->SMTPAuth = true;                               // Enable SMTP authentication
          $mail->Username = 'mokshitha.r@suveechi.in';                 // SMTP username
          // $mail->Password = 'mokshitha@123';                           // SMTP password
          $mail->Password = 'hflr zwem rujo jpdd';      

          $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, ssl also accepted
          $mail->Port = 587;                                    // TCP port to connect to
          
          $mail->From = 'mokshitha.r@suveechi.in';
          $mail->FromName = 'JSW EMAIL NOTIFICATION';
              // Add a recipient
         $mail->addAddress('mokshitha.r@suveechi.in');               // Name is optional]
         // $mail->addCC('bfoperation.dolvi@jsw.in');
          // $mail->addCC('jagdish.mashetty@jsw.in');
          // $mail->addCC('refractoryteam.dolvi@jsw.in');
          // $mail->addCC('manish.kade@jsw.in');
          // $mail->addCC('mukherjee.amitava@jsw.in');
          // $mail->addCC('gaurav.patil1@jsw.in');
          // $mail->addCC('ashok.thungani@jsw.in');
          // $mail->addCC('BF2OPERATION@jsw.in');
          // $mail->addCC('ashok.thungani@jsw.in');
          // $mail->addCC('bfoperation.dolvi@jsw.in');
          // $mail->addCC('ashok.thungani@jsw.in');
          // $mail->addCC('rajendra.raut@jsw.in');
          // $mail->addCC('sanjeev.jaiswal@jsw.in');
          // $mail->addCC('gangireddy.chavva@suveechi.in ');
          $mail->addCC('mokshitha.r@suveechi.in');
          // $mail->addcc('ganesh.s@samarthainfo.com');
          // $mail->addCC('shashank.mg@suveechi.in');
          // $mail->addCC('sanjay.b@suveechi.in');
          // $mail->addCC('srivathsa.hr@suveechi.in');
            

         
          // $mail->addBCC('');
          
          // Optional name
          $mail->isHTML(true);                                  // Set email format to HTML
          // $mail->Subject = 'JSW Dolvi - TLC - Heat count - Date:<Report Date in $date>, Time:<Report time in $time>';
          $mail->Subject = "JSW Dolvi - TLC - Heat Count -:Report Date & Time :$date";
          $mail->Body    = $fulmsg;
          $mail->AltBody = 'Notification ';
          //$mail->addAttachment('test_attch.php');   // I took this from the phpmailer example on github but I'm not sure if I have it right.      
          // $mail->addAttachment('test_attch.php', 'test_attch.php');
          
          if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
          } else {
            echo '<script> alert("Message has been sent")</script>';
          }

}

  ?>