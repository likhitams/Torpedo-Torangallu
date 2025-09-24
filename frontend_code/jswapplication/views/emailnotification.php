<!-- Email Notification -->
  <?php 
  $connect = mysqli_connect("localhost","web",'W3bU$er!89',"suvetracg");
 $qry="select id from ladle_master";
 $res = mysqli_query($connect, $qry);
 while($row_query=mysqli_fetch_array($res))
      {
         $id=$row_query['id'];
        
  $cycleqry="select cycling_date,ladle_id from ladle_cyclingHistory where ladle_id='$id' order by id DESC limit 1";
  $cycleres = mysqli_query($connect, $cycleqry);
  while($row=mysqli_fetch_array($cycleres))
      {
        $cycling_date=$row['cycling_date'];
         
  $reportqry="select count(id),LADLENO from laddle_report where ladleid='$id' and  GROSS_DATE>='$cycling_date'"; 
   $repres = mysqli_query($connect, $reportqry);
    while($rowrep=mysqli_fetch_array($repres))
      {
        $count=$rowrep['count(id)'];
        $LADLENO=$rowrep['LADLENO'];


          }
         }
        }

         if($count>=6)
        {

          require 'PHPMailer-master/PHPMailerAutoload.php';
  
          $mail = new PHPMailer(true);
          //$mail->SMTPDebug = 3;                               // Enable verbose debug output
          $mail->isSMTP();                                      // Set mailer to use SMTP
          $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
          $mail->SMTPAuth = true;                               // Enable SMTP authentication
          $mail->Username = 'mokshitha.r@suveechi.in';                 // SMTP username
          $mail->Password = 'hzamubhmdyaptyre ';                           // SMTP password
          $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, ssl also accepted
          $mail->Port = 587;                                    // TCP port to connect to
          
          $mail->From = 'mokshitha.r@suveechi.in';
          $mail->FromName = ' Jsw Project';
          // $mail->addAddress('', ' Dolvi');     // Add a recipient
          // $mail->addAddress('mokshitha.r@suveechi.in');               // Name is optional
          $mail->addCC('mokshitha.r@suveechi.in');

          // $mail->addBCC('mmokshitha439@gmail.com');
          
          // Optional name
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = 'Jsw Project';
          $mail->Body    = $LADLENO.' '.$count.'Email Notification ';
          $mail->AltBody = 'Notification ';
          //$mail->addAttachment('test_attch.php');   // I took this from the phpmailer example on github but I'm not sure if I have it right.      
          // $mail->addAttachment('test_attch.php', 'test_attch.php');
          
          if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
          } else {
            echo '<script> alert("Message has been sent")</script>';
            exit();
          }

        }


  ?>
