<?
require_once("mainfile.php");

// Lesson-not-found message - have to define here, since if the lesson ID doesn't exist, there's
// no language ID to load the languagae file.
define("_NOT_EXIST_LESSON_EN","<h1>Error!</h1><P>The specified lesson does not exist in the database.  Please contact the owner of the website regarding this problem.</p>");
define("_NOT_EXIST_LESSON_SP","<h1>¡Error!</h1><P>La lección que usted especificó no existe en la base de datos.  Favor de contactar al dueño de la página Web acerca de este problema.</p>");


$p_VARS= $HTTP_POST_VARS;

// processing starts here -----------------------------------------------------
for($i=1;$i<=_MAXQUESTIONS; $i++) {
   ${"f_".$i} = $p_VARS[$i];
}

$f_student_id = get_student_id($id);
$f_lesson_id = get_lesson_id($lid);

$f_message = "";

//(1) check the lessons
IF (!ISSET($lid) OR $lid=="" OR check_lesson($lid)<0 ) {
 	$f_message .= _NOT_EXIST_LESSON_EN . _NOT_EXIST_LESSON_SP;
	echo display_message($f_message);
    die();
}
else {
    // get lesson basic information
    $l_sql = " select lesson_id, lesson, course, source, answer, pointvalue, language  from lessons where lid = '".$lid."' ";
	$result = sql_query($l_sql, $dbi);
	list($f_lesson_id, $f_lesson, $f_course, $f_source, $f_standard_answers, $f_pointvalue, $f_language) = sql_fetch_array($result);

}

// Import language file.
if ($f_language == 'S') {
	require_once("lang-spanish.php");
} elseif ($f_language == 'F') {
	require_once("lang-french.php");
} else {
	require_once("lang-english.php");
}


//(2) check the user id

IF (!ISSET($id) OR $id=="" OR !check_existing($id)) {
 	$f_message .= _NOT_EXIST_ID;
	echo display_message($f_message, $f_language);
    die();
} else {
    // get student basic information
    $l_sql = " select student_id, dateregistered, lastaccess, lname, fname, gender, birthday ";
	$l_sql .= " ,church, salvation, coname, address1, address2, city ";
	$l_sql .= " ,prov, pcode, country, phone, email, lessonpts, bonuspts, awards, events, comments, zone, jonathan ";
	$l_sql .= " from student where binary id = '".$id."' ";
	$result = sql_query($l_sql, $dbi);
	list($f_student_id, $f_dateregistered, $f_lastaccess, $f_lname, $f_fname, $f_gender, $f_birthday 
	,$f_church, $f_salvation, $f_coname, $f_address1, $f_address2, $f_city
	,$f_prov, $f_pcode, $f_country, $f_phone, $f_email, $f_lessonpts, $f_bonuspts, $f_awards, $f_events, $f_comments, $f_zone, $f_jonathan) = 
	sql_fetch_array($result);

	$l_sql = "select sum(a.points) from history a, student b where a.student_id = b.student_id and b.id = '" . $id . "'";
	$result = sql_query($l_sql, $dbi);
	list ($f_lessonpts) = sql_fetch_array($result);
	
}

//(3) check the password
IF (!ISSET($password) OR $password=="" OR check_password($id,$password)<0 ) {
 	$f_message .= _PASS_INCORRECT;
	echo display_message($f_message, $f_language);
    die();
}

//(4) to check the user hasn't already completed this quiz.
//(4.0) fix the data of history, this is one time running
//fix_history();

//(4.1) to check the student and lesson
IF ($f_student_id>0 and $f_lesson_id >0) {
	if (check_complete_lesson($f_student_id, $f_lesson_id)==0 ) {
	 	$f_message .= _COMPLETED_LESSON;
		echo display_message($f_message, $f_language);
	    die();
    }
}

//(5) to check if the student has finished the prerequisite lessons
IF ($f_student_id>0 and $lid <>"") {
	if (check_prerequisite($f_student_id, $lid)< 0  ) {
	 	$f_message .= _PREREQUISITE;
		echo display_message($f_message, $f_language);
	    die();
    }
}


//(6) to mark the quiz ---------------------------------------------------------------------
//(6.1) get the submitted answers
$f_submitted_answers = "";
for($i=1;$i<=_MAXQUESTIONS; $i++) {
   $t_answer = $_GET[$i];
   if (isset($t_answer) and $t_answer<>"") {
       $f_submitted_answers .= $t_answer;
   } else {
	$t_answer = $_POST[$i];
	if (isset($t_answer) and $t_answer<>"") {
		$f_submitted_answers .= $t_answer;
	}
   }
}

//(6.2) to check if there is any problem in database 
// e.g question number does not match answer number
if (strlen($f_submitted_answers) <> strlen($f_standard_answers)) {
    $f_message .= _ANSWER_UMMATCHED;
	echo display_message($f_message, $f_language);
    die();
}

//(6.3) to calculate score
$f_message .= "<h1>" . _LESSON_RESULTS . "</h1>";
$f_message .= "<p>" . _QUESTIONS_INCORRECT . "<b>&nbsp;&nbsp;";
$score =0;
for ($i=1;$i<=strlen($f_standard_answers);$i++) {
	 if (substr($f_submitted_answers,$i-1,1)== substr($f_standard_answers,$i-1,1)
	     or substr($f_standard_answers,$i-1,1)=="?")
		$score += 1;
	 else
	    $f_message .= $i. ", ";
}

if ($score == strlen($f_standard_answers))
	$f_message .= _NONE;

$f_message .= "</b></p>";

//(6.4) to determine if user passed the test
$f_your_score = $score*1000/strlen($f_standard_answers);
$f_passing_grade = _PASSINGGRADE * 1000;
if ( $f_your_score < $f_passing_grade) {
	$f_message .= _FAILED_MSG;
} else {
    $f_lessonpts +=$f_pointvalue;
    $l_totalpoint = $f_lessonpts + $f_bonuspts;
	$f_message .= "<h1>" . _CONGRATULATIONS . "!</h1><P>";
	$f_message .= str_replace(array('[LESSONPTS]','[TOTALPTS]'),array($f_pointvalue,$l_totalpoint),_SUCCESSFULLY_COMPLETED);
    	$f_message .= "</p>";

	$f_message .= "<p><H2><a href='http://" . $_SERVER["SERVER_NAME"] . "/" . $next . "'>";
	$f_message .= _TO_CONTINUE . "</a></H2>";

	
//	if ((($f_lessonpts + $f_bonuspts)/1000) > (($f_lessonpts + $f_bonuspts - $f_pointvalue)/1000)) {
//	   $t_level = floor(($f_lessonpts + $f_bonuspts)/1000);
//	   $f_message .= "<p>You have now reached level ".$t_level."! Keep up the good work!</p>";
//	
//	}

        switch ($f_lessonpts + $f_bonuspts) {
                case 200:
			$f_message .= _AWARD_LINK_200;
                        break;
                case 400:
                case 500:
                case 800:
                case 1000:
                case 1500:
                case 2000:
                case 2500:
                case 3000:
                case 3500:
                case 4000:
                case 4500:
                case 5000:
                case 5500:
                case 6000:
                case 6500:
                case 7000:
                case 7500:
                case 8000:
                case 8500:
                case 9000:
                case 9500:
                case 10000:
                case 11000:
                case 12000:
                case 13000:
                case 14000:
                case 15000:
                case 16000:
                case 17000:
                case 18000:
                case 19000:
                case 20000:
                case 21000:
			$f_message .= str_replace("[AWARDPTS]",$f_lessonpts + $f_bonuspts,_AWARD_LINK);
                        break;
                default:
                        break;
        } 
	
	// write update userfile
	$l_sql = " update student set ";
	$l_sql .= " lessonpts = '$f_lessonpts', lastaccess = now() ";
	$l_sql .= " where binary id = '".$id."' ";

	$result = sql_query($l_sql, $dbi);
	
	
	//update bookmark
	$f_bookmarkname = $next;
	$f_bmcategory = substr($lid, 0, 3);
	if ( $f_bmcategory=="uba" or $f_bmcategory=="ubk" or $f_bmcategory=="uby" 
	   or $f_bmcategory=="mca" or $f_bmcategory=="mck" or $f_bmcategory=="mcy" 
	   or $f_bmcategory=="kba" or $f_bmcategory=="kbk" or $f_bmcategory=="kby" 
	   or $f_bmcategory=="tel" ) {

	
		$l_sql = "select count(*) from bookmarks where student_id = '" .$f_student_id."' ";	
		$result = sql_query($l_sql, $dbi);
		list($rows) =  sql_fetch_array($result);
		if ($rows > 0) {
			$l_sql = " update bookmarks set ";
			$l_sql .= " ".$f_bmcategory." = 'http://".$_SERVER["SERVER_NAME"]."/".$f_bookmarkname."' ";
			$l_sql .= " where student_id = '".$f_student_id."' ";
			$result = sql_query($l_sql, $dbi);
		} else {
			$l_sql = "insert into bookmarks (student_id,$f_bmcategory) values ";
			$l_sql .= "($f_student_id,'http://".$_SERVER["SERVER_NAME"]."/".$f_bookmarkname."')";		
			$result = sql_query($l_sql, $dbi);	
		}
	   
	} else {
	   $f_message .= "<h3>Warning -- Non-fatal error: </h3><p>Bookmark ".$f_bmcategory." from LID (".$lid.") not recognized.</p>\n";
	}
	
	//update the history table
	$l_sql = " insert into history (";
	$l_sql .= " student_id, lesson_id, completed, points ";
	$l_sql .= " ) values ( ";
	$l_sql .= " $f_student_id, $f_lesson_id, now(), $f_pointvalue ";
	$l_sql .= " ) ";
	$result = sql_query($l_sql, $dbi);
	
}
   
//(7) to determin the nearest human marker
$b_found = false;

//(7.1) test the postal code
$f_temp = substr(strtoupper(trim($f_pcode)),0,3);
$l_sql = " select sponsor_id, email from grader ";
$l_sql .= " where type = 'PCODE' and location = '".$f_temp."'" ;
$result = sql_query($l_sql, $dbi);
list($f_sponsor_id, $f_locemail)=sql_fetch_array($result);
if ($f_locemail<>"") {
   $b_found = true;
   $f_sponsor_email = get_sponsor_email($f_sponsor_id);
}

//(7.1b) test the zone
$l_sql = " select sponsor_id, email from grader ";
$l_sql .= " where type = 'ZONE' and location = '".$f_zone."'" ;
$result = sql_query($l_sql, $dbi);
list($f_sponsor_id, $f_locemail)=sql_fetch_array($result);
if ($f_locemail<>"") {
   $b_found = true;
   $f_sponsor_email = get_sponsor_email($f_sponsor_id);
}

//(7.2) test the province
if ($b_found == false) {
	$f_temp = substr(strtoupper(trim($f_prov)),0,3);
	$l_sql = " select sponsor_id, email from grader ";
	$l_sql .= " where type = 'PROV' and location = '".$f_temp."'" ;
	$result = sql_query($l_sql, $dbi);
	list($f_sponsor_id, $f_locemail)=sql_fetch_array($result);
	if ($f_locemail<>"") {
	   $b_found = true;
	   $f_sponsor_email = get_sponsor_email($f_sponsor_id);
	}
}

//(7.3) test the country
if ($b_found == false) {
	$f_temp =strtoupper(trim($f_country));
	$l_sql = " select sponsor_id, email from grader ";
	$l_sql .= " where type = 'COUNTRY' and location = '".$f_temp."'" ;
	
	$result = sql_query($l_sql, $dbi);
	list($f_sponsor_id, $f_locemail)=sql_fetch_array($result);
	if ($f_locemail<>"") {
	   $b_found = true;
	   $f_sponsor_email = get_sponsor_email($f_sponsor_id);
	}
}

//(7.4) test the other location
if ($b_found == false) {
	$f_temp =strtoupper(trim($f_prov));
	$l_sql = " select sponsor_id, email from grader ";
	$l_sql .= " where type = 'OTHER' " ;
	$result = sql_query($l_sql, $dbi);
	list($f_sponsor_id, $f_locemail)=sql_fetch_array($result);
	if ($f_locemail<>"") {
	   $b_found = true;
	   $f_sponsor_email = get_sponsor_email($f_sponsor_id);
	}
}


if ($b_found == false) {
    $f_message .= _NO_EMAILADDRESS;
	echo display_message($f_message, $f_language);
    die();

}

// Get the Jonathan, if applicable.
$l_sql = 'select email from grader where type = \'JONA\' and location = \'' . mysql_real_escape_string($f_jonathan,$dbi) . '\'';
$result = sql_query($l_sql,$dbi);
list($f_jonathan_email) = sql_fetch_array($result);

// If there were multiple, overlapping graders for a given respondent,
// enforce a single recipient.
if (mysql_num_rows($result) > 1) {
	$f_locemail = 'lessons@davidjonathan.org';
}

// (8) mail a copy of the answer to the nearest marker
// test

$l_email_address = $f_locemail;

$l_subject = "UB David User Lesson";
	
$l_headers = "Content-Type: text/html; charset=iso-8859-1\n";

$l_headers .= "From: ".$f_fname." ".$f_lname."<".$f_email.">\n";

$l_message = "[This message was sent through a www-email gateway.]\n<br>";
$l_message .= $f_fname." ".$f_lname." (User ID ".$id.") has answered the following lesson:\n\n<br><br>";
$l_message .= "Lesson ID: ".$lid."\n<br>Lesson name: ".$f_lesson."\n<br>";
$l_message .= "Course name: ".$f_course."\n\n<br><br>";
$l_message .= "The user left the following comments (if any):\n".$comments."\n\n<br><br>";

if(isset($comments2) and $comments2<>"")
	$l_message .= "Here are the contents of the second comments field:\n".$comments2."\n\n<br><br>";
if(isset($comments3) and $comments3<>"")
    $l_message .= "Here are the contents of the third comments field:\n".$comments3."\n\n<br><br>";

$l_message .= "Users's answer: ".$f_submitted_answers."\n<br>";
$l_message .= "Correct answers: ".$f_standard_answers."\n<br>";
$l_message .= "User Statistics\n<br>----------------------------------------\n<br>";
$l_message .= "User ID: ".$id."\n<br>";
$l_message .= "Name: ".$f_fname." ".$f_lname."\n<br>";
$l_message .= "Registered: ".$f_dateregistered."\n<br>";
$l_message .= "Last access: ".$f_lastaccess."\n<br>";
$l_message .= "Gender: ".$f_gender."\n<br>";
$l_message .= "Birthday: ".$f_birthday."\n<br>";
$l_message .= "Church: ".$f_church."\n<br>";
$l_message .= "Salvation: ".$f_salvation."\n<br>";
$l_message .= "Care of: ".$f_coname."\n<br>";
$l_message .= "Address: ".$f_address1;
if ($f_address2<>"")
     $l_message .= ",".$f_address2."\n<br>";
else
     $l_message .= "\n<br>";
$l_message .= "City, Prov: ".$f_city." ".$f_prov."\n<br>";
$l_message .= "Postal Code: ".$f_pcode."\n<br>";
$l_message .= "Country: ".$f_country."\n<br>";
$l_message .= "Telephone: ".$f_phone."\n<br>";
$l_message .= "Email: ".$f_email."\n<br>";
$l_message .= "Lesson pts: ".$f_lessonpts."\n<br>";
$l_message .= "Bonus pts: ".$f_bonuspts."\n<br>";
$l_message .= "Awards: ".$f_awards."\n<br>";
$l_message .= "Events: ".$f_events."\n<br>";
$l_message .= "Comments: ".$f_comments."\n<br>";
$l_message .= "----------------------------------------\n<br>";

//the following should be open for production:

if (isset($l_email_address) and $l_email_address != 'v.durston@sasktel.net') {
mail ($l_email_address, $l_subject, $l_message, $l_headers, "-f $f_email");
}
if (isset($f_sponsor_email) and $f_sponsor_email != '' and $f_sponsor_email != 'v.durston@sasktel.net') {
     mail ($f_sponsor_email, $l_subject, $l_message, $l_headers);
}
if (isset($f_jonathan_email) and $f_jonathan_email != '' and $f_jonathan_email != 'v.durston@sasktel.net') {
	$l_message2 =	"One of your students has completed the following lesson:<br />\n";
	$l_message2 .=	"<br />\n";
	$l_message2 .=	"Name: ".$f_fname." ".$f_lname."<br />\n";
	$l_message2 .=	"Lesson ID: ".$lid."<br \>\n";
	$l_message2 .=	"Lesson name: ".$f_lesson."<br />\n";
	$l_message2 .=	"Comments: ".$comments."<br />\n";
	if(isset($comments2) && $comments2 != '') {
		$l_message2 .=	"Comments 2: ".$comments2."<br />\n";
	}
	if(isset($comments3) && $comments3 != '') {
		$l_message2 .=	"Comments 3: ".$comments3."<br />\n";
	}
	$l_message2 .=	"----------------------------------------<br />\n";
	mail ($f_jonathan_email, $l_subject, $l_message2, $l_headers);
}
mail ("lessons-all@ubdavid.org", $l_subject, $l_message, $l_headers, "-f $f_email");
if (!empty($comments)) {
    mail ("vaughan.durston@gmail.com", $l_subject, $l_message, $l_headers, "-f $f_email");
}

//mail ("v.durston@sasktel.net", $l_subject, $l_message, $l_headers, "-f $f_email");

//tylerD test
//mail ("tyler.durston@gmail.com", $l_subject, $l_message, $l_headers, "-f $f_email");

//(9) successfully
$f_message .= "<p>" . _EMAILED_TO . " ".$f_locemail.".</p>";
if (isset($f_sponsor_email) and $f_sponsor_email<>"")
     $f_message .= "<p>" . _ALSO_EMAILED_TO . " ".$f_sponsor_email." (" . _SPONSOR . ").</p>";
  
//$f_message .= "Successfully done.";
echo display_message($f_message, $f_language);
die();



// start of basic function ------------------------------------------------------------------------------
function get_sponsor_email($f_sponsor_id) {
     global $dbi;
	if ($f_sponsor_id>0) {
		$l_sql = " select email  from sponsor where sponsor_id = ".$f_sponsor_id." ";
		$result = sql_query($l_sql, $dbi);
		list($l_email) = sql_fetch_array($result);
		return $l_email;
	}
	else  
	   return "";
}


function check_prerequisite($f_student_id, $lid) {
     global $dbi;
	 
	 $f_couse_code = substr($lid, 0,5);
	 $f_lesson_num = trim( substr($lid, 5,2));
	 
	 // initialization
	 for ($i=1;$i<$f_lesson_num; $i++)
	    $f_complete[$i]="0";

    // get from the database as completed
	$l_sql = "SELECT lid ";
	$l_sql .= "FROM history a, lessons b ";
	$l_sql .= "WHERE a.lesson_id = b.lesson_id ";
	$l_sql .= "  AND a.student_id = " . $f_student_id." ";
	$l_sql .= "  AND b.lid like '".$f_couse_code."%' ";
	$l_sql .= "  AND a.completed is not null ";
	$l_sql .= "ORDER BY lid ";

	$result = sql_query($l_sql, $dbi);

	while (list($l_id) = sql_fetch_array($result)) {
	   $temp_lesson_num = trim(substr($l_id, 5,2));
	   if ($temp_lesson_num < 10) $temp_lesson_num = trim($temp_lesson_num,0);
	   $f_complete[$temp_lesson_num]="1";
	}
	
	// if any one missing return -1 (failed)
	for ($i=1;$i<$f_lesson_num; $i++) {
	    if ($f_complete[$i]=="0") 
		return -1;
	}
		
	// all previous course have been completed
	return 0;

}



function check_complete_lesson($l_student_id, $l_lesson_id) {
     global $dbi;
	$l_sql = " select history_id  from history where student_id = ".$l_student_id." ";
	$l_sql .= "and lesson_id = ".$l_lesson_id." and completed is not null ";
	$result = sql_query($l_sql, $dbi);
	list($l_id) = sql_fetch_array($result);
	if ($l_id >=1) 	    return 0;
	else  return -1;

}

function get_student_id($id) {
    global $dbi;
	$l_sql = " select student_id  from student where binary id = '".$id."' ";
	$result = sql_query($l_sql, $dbi);
	list($l_id) = sql_fetch_array($result);
	return $l_id;
}

function get_lesson_id($lid) {
    global $dbi;
	$l_sql = " select lesson_id  from lessons where lid = '".$lid."' ";
	$result = sql_query($l_sql, $dbi);
	list($l_id) = sql_fetch_array($result);
	return $l_id;
}


function check_existing($id) {
    global $dbi;
	$l_sql = " select count(student_id) from student where binary id = '".$id."'";
	$result = sql_query($l_sql, $dbi);
	list($l_count) = sql_fetch_array($result);
	if ($l_count>=1) 	    
		return true;
	else   
		return false;
}

function check_password($id,$password) {
    global $dbi;
	$l_sql = " select student_id  from student where binary id = '".$id."' and binary password = '".$password."' and source='Internet'";
	$result = sql_query($l_sql, $dbi);
	list($l_id) = sql_fetch_array($result);
	if ($l_id >=1) 	    return 0;
	else  return -1;
}

function check_lesson($lid) {
    global $dbi;
	$l_sql = " select lesson_id  from lessons where lid = '".$lid."' ";
	$result = sql_query($l_sql, $dbi);
	list($l_id) = sql_fetch_array($result);
	if ($l_id >=1) 	    return 0;
	else  return -1;
}

function display_message($f_message, $f_language = 'E') {
	$r_result  = get_header($f_language);
	$f_message = utf8_encode($f_message);
	$r_result .= $f_message;
	$r_result .= get_footer($f_language);
	return $r_result;
}

function get_header($f_language) {
	$r_result = "
	<HTML>
	<HEAD>
	  <TITLE>" . _BIBLE_BASED . "</TITLE>
	  <LINK REL=\"StyleSheet\" HREF=\"themes/my_theme/style/style.css\" TYPE=\"text/css\">
	</HEAD>
	<BODY BGCOLOR=\"#ffffff\">
	<P><CENTER>
	<IMG SRC=\"ubdavidfolder/david_graphics/gubgen01_ubtextlogo.GIF\" NATURALSIZEFLAG=\"0\" HEIGHT=\"55\" WIDTH=\"303\" ALIGN=\"BOTTOM\">
	<IMG SRC=\"mailboxfolder/mailbox_gen_graphics/gmcgen03_mctitle.GIF\" NATURALSIZEFLAG=\"3\" HEIGHT=\"95\" WIDTH=\"137\" ALIGN=\"BOTTOM\"></CENTER></P>
    ";
	$r_result .= "<table class=\"grader\"><tr><td>";
	switch ($f_language){
		case 'S':
			$r_result = implode("",file("header_sp.tpl"));
			break;
		case 'F':
			$r_result = implode("",file("header_fr.tpl"));
			break;
		default:
			$r_result = implode("",file("header.tpl"));
			break;
	}
	return $r_result;
}

function get_footer($f_language = 'E') {
	$r_result = "</td></tr></table>";
	$r_result .= "</body>";
	$r_result .= "</html>";
	
	if ($f_language == 'S') {
		$r_result = implode("",file("footer_sp.tpl"));
	} elseif ($f_language == 'F') {
		$r_result = implode("",file("footer_fr.tpl"));
	} else {
		$r_result = implode("",file("footer.tpl"));
	}
	return $r_result;
}

// this program is one-time use to fix data in History table.
// because the MySQL version < 4.0 can not update a table using columns in other tables.
// by LCR on March 24, 2003
function fix_history() {
    global $dbi;
	$l_sql = " select distinct sid , SUBSTRING(sid,1,length(sid)-4) as id from history order by sid ";
	$result = sql_query($l_sql, $dbi);
	while (list($l_sid, $l_id) = sql_fetch_array($result)) {
	    $l_student_id = get_student_id($l_id);
		$l_sql2 = "update history set student_id = ".$l_student_id." where sid = '".$l_sid."' ";
	    sql_query($l_sql2, $dbi);
	}

	$l_sql3 = " select distinct lid from history order by lid ";
	$result = sql_query($l_sql3, $dbi);
	while (list($l_lid) = sql_fetch_array($result)) {
	    $l_lesson_id = get_lesson_id($l_lid);
		if (isset($l_lid) and $l_lid<>"" and $l_lesson_id > 0) {
			$l_sql4 = "update history set lesson_id = ".$l_lesson_id." where lid = '".$l_lid."' ";
		    sql_query($l_sql4, $dbi);
		}
	}
	
	
}

?>