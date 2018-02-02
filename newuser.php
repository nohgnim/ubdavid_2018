<?
	require_once("mainfile.php");
	require_once("lang-english.php");

	$ok = true;

	//$email = "dean.holroyd@directwest.com";


	$msg = "";
	// Make sure the user_id is ok
	$l_sql = "select student_id from student ";
	$l_sql .= "where id ='" . $_POST['id'] . "'";

	$result = sql_query($l_sql, $dbi);

	list($student_id) = sql_fetch_array($result);

	// Look for missing information
	if ($_POST['fname'] == '') {$msg.='You must enter your first name<br>';}
	if ($_POST['lname'] == '') {$msg.='You must enter your last name<br>';}
	if ($_POST['id'] == '') {$msg.='You must enter a User ID<br>';}
	if ($_POST['password'] == '') {$msg.='You must enter a password<br>';}

	if ($_POST['email'] == '') {$msg.='You must prrovide us with your e-mail<br>';}
	if ($_POST['prov'] == '') {$msg.='You must provide us with your e-mail<br>';}
	if ($_POST['pcode'] == '') {$msg.='You must provide us with your e-mail<br>';}
	if ($_POST['country'] == '' or $_POST['country'] == 'XX') 
		{$msg.='You must provide us with your e-mail<br>';}

	if ($msg == "") {
		$l_msg = "Thank you for registering with U.B. David and I'll B. Jonathan.  Please \n" .
		     "keep this message or write down the following information for future \n" .
		     "reference.  You will need your username and password to access the site \n" .
		     "and take lessons.\n\n" .
		     "Username: %s\n" .
		     "Password: %s\n\n" .
		     "If you have any questions, please contact the address listed on our \n" .
		     "website, \n\n";

		$header = "From: U.B.  David and I'll B. Jonathan <berneda@davidjonathan.org>\n";
                $header = "Reply-To: U.B.  David and I'll B. Jonathan <berneda@davidjonathan.org>\n";
		$header .= "Content-type: text/html\n";
		$header .= "X-Mailer: PHP/" . phpversion() . "\n";

		$email_from = "berneda@davidjonathan.org";
		$subject = "Registration confirmation\n\n";

		mail ($email, $subject, $l_msg, $header, "-f $email_from");
		header ("location: /ubdavidfolder/registration/Reg.Thankyou.html");
	} else {
		echo "<HTML><head><title>New User Registration</title></head><BODY>";
		echo $msg;
		echo "Please click on your browser's <tt>BACK</tt> button " .
		     "and be sure to enter this information.\n<p>";
		echo "</BODY></HTML>";
	}

?>
