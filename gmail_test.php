<?php

/* connect to gmail */
$gmailhostname = '{imap.gmail.com:993/imap/ssl}[Gmail]/All Mail';
$gmailusername = "cholten99@gmail.com";
$gmailpassword = "tmshoadmlfewnbyt";

/* try to connect */
$conn = imap_open($gmailhostname, $gmailusername, $gmailpassword) or die('Cannot connect to Gmail: ' . imap_last_error());

/* grab emails */
$email_search_string = "FROM 'no-reply@thelistserve.com'";
// $email_search_string = "FROM 'dave@dmi.me.uk'";
$emails = imap_search($conn, $email_search_string);

/* if emails are returned, cycle through each... */
if ($emails) { 

  /* put the newest emails on top */
  rsort($emails);

  /* for 5 emails... */
  $emails = array_slice($emails, 0, 3);

  foreach ($emails as $email_number) {    
    /* get information specific to this email */
    $overview = imap_fetch_overview($conn, $email_number, 0);
    $message = imap_body($conn, $email_number);

    /* output the email header information */
    print "From: " . quoted_printable_decode($overview[0]->from) . "<br>";
    print "Sent: " . quoted_printable_decode($overview[0]->date) . "<br>";
    print "Subject: " . quoted_printable_decode($overview[0]->subject) . "<br>";
    print "Message Size: " . strlen($message) . "<br>";
    print "Message: " . quoted_printable_decode($message);

// print "<pre>" . print_r(imap_fetchstructure($conn, $email_number)) . "</code>";
// print "<pre>" . quoted_printable_decode(print_r(imap_body($conn, $email_number))) . "</code>";

    print "<p><hr><p>";

  }
} 

/* close the connection */
imap_close($conn);

?>