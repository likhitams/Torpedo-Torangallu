
<!-- Email Notification -->
  <?php
  // Set the new timezone
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d h:i:s');
        // echo $date;
$fulmsg=  $fulmsg."<table border='2' >";
$fulmsg = $fulmsg."<tr>";
$fulmsg = $fulmsg."<th>Tlc NO</th><th>Total Trips</th><th>Count</th><th>Comment</th>";
$fulmsg = $fulmsg."</tr>";

   $connect = mysqli_connect("localhost","web",'W3bU$er!89',"suvetracg");
   // $connect = mysqli_connect("127.0.0.1","root",'',"suvetracg");
echo "hello";
 echo $qry="select id from ladle_master";
 $res = mysqli_query($connect, $qry);
 while($row_query=mysqli_fetch_array($res))
      {
         echo $id=$row_query['id'];
        $cycleqry="select cycling_date,ladle_id,count from email_cyclinghistory where ladle_id='$id' order by id DESC limit 1";
            $cycleres = mysqli_query($connect, $cycleqry);
            while($row=mysqli_fetch_array($cycleres))
                {
                      $cycling_date=$row['cycling_date'];
                      $ladle_id=$row['ladle_id'];
                      $countemail=$row['count'];

         
echo $reportqry="select count(id),LADLENO from laddle_report where ladleid='$id' and  GROSS_DATE>='$cycling_date'"; 
   $repres = mysqli_query($connect, $reportqry);
    while($rowrep=mysqli_fetch_array($repres))
      {
        echo $count=$rowrep['count(id)'];
        
         $totalemailcount=$count+$countemail;
         $LADLENO=$rowrep['LADLENO'];

        if($count>=30)
        {

          // echo  $val1.=$LADLENO.' '.'=>'.$count.' '.'Trips Completed'.'<br>';
         // echo  $val1.=$LADLENO.' '.'=>'.$count.' '.'Heats completed, Need for jam removal & hot inspection'.'<br>';
         //  echo "<br>";  
 
          $fulmsg = $fulmsg."<tr><td>$LADLENO</td><td>$totalemailcount</td><td>$count</td><td>30 heats completed, need for jam removal & hot inspection</td></tr>";
           echo $updateqry="update email_cyclinghistory set cycling_date='$date' ,count='$totalemailcount' where ladle_id='$id'";
        // $updtemail=mysqli_query($connect,$updateqry);
        }   
        
        

  }      

         
  }
}
$fulmsg = $fulmsg."</table>"; 

echo $fulmsg;

$fulmsg=$fulmsg;

require 'PHPMailer-master/PHPMailerAutoload.php';
$mail = new PHPMailer(true);
          //$mail->SMTPDebug = 3;                               // Enable verbose debug output
          $mail->isSMTP();                                      // Set mailer to use SMTP
          $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
          $mail->SMTPAuth = true;                               // Enable SMTP authentication
          $mail->Username = 'mokshitha.r@suveechi.in';                 // SMTP username
          $mail->Password = 'mokshitha@123 ';                           // SMTP password
          $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, ssl also accepted
          $mail->Port = 587;                                    // TCP port to connect to
          
          $mail->From = 'mokshitha.r@suveechi.in';
          $mail->FromName = ' JSW EMAIL NOTIFICATION';
              // Add a recipient
        $mail->addAddress('mokshitha.r@suveechi.in');               // Name is optional
          // $mail->addCC('srivathsa.hr@suveechi.in ');
          $mail->addCC('mokshitha.r@suveechi.in');
          // $mail->addBCC('mmokshitha439@gmail.com');
          
          // Optional name
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = 'DOLVI PROJECT';
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



  ?>
