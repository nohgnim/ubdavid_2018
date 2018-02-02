<?require("include/session.inc.php"); ?>
<html xmlns:XS>
<head>
<title>UBDavid administration</TITLE>
		<link href="dj.css" rel="stylesheet" type="text/css" media="all">
	</head>
<body>
<p align=center>
<img src=./ubdavidfolder/david_graphics/gubgen01_ubtextlogo.GIF>
</p>
<table>
<tr><td valign=top>
<? if ($l_user->is_logged_in()) { ?>
<A HREF=admin.php?f_action=student_list><strong>Students</strong></A> |
<A HREF=admin.php?f_action=lesson_list><strong>Lessons</strong></A> |
<? } ?>
<? if ($l_user->get_priv() == "SPONSOR" or $l_user->is_admin()) { ?>
<A HREF=admin.php?f_action=grader_list><strong>Graders</strong></A> |
<? } ?>
<? if ($l_user->is_admin()) { ?>
<A HREF=admin.php?f_action=sponsor_list><strong>Sponsors</strong></A> |
<A HREF=admin.php?f_action=space_list><strong>Admin Accounts</strong></A> |
<? } ?>
<? login_link(); ?>
</td>
</tr><tr>
<td valign=top>

<? if ($l_user->is_logged_in()) { ?>
					<center>
						<h1><strong>Help</strong></h1>
					</center>
					<h1><strong>Graders</strong></h1>
					<p><a href="#logging">Logging In</a></p>
					<p><a href="#opening">Opening Screen</a></p>
					<p><b><a href="#menu students">Menu:  STUDENTS</a></b></p>
					<div class="bullettext">
						<ul>
							<li><a href="#re-sorting">re-sorting
							</a><li><a href="#total points">total points
							</a><li><a href="#edit">edit
							</a><li><a href="#add lesson">adding lesson info
							</a><li><a href="#add Bible">adding Bible
							</a><li><a href="#add books">adding Books or Awards
							</a><li><a href="#completion">completion date
							</a><li><a href="#media CDs">media CD lessons</a> (special note)<li><b><a href="#select students">hot link: Select Students</a></b>
							<li><a href="#all students">hot link: All Students</a>
							<li><a href="#print">hot link:  print</a>
							<li><a href="#add">button:  add</a> (a student)
						</ul>
					</div>
					<p><b><a href="#menu lessons">Menu:  LESSONS</a></b></p>
					<p><b><a href="#menu awards">Menu:  AWARDS</a></b></p>
					<p><b><a href="#menu reports">Menu:  REPORTS</a></b></p>
					<div class="bullettext">
						<ul>
							<li><a href="#data report">data output report
							</a><li><a href="#screen report">screen output report
							</a><li><a href="#mail labels">mail labels output report
						</a></ul>
					</div>
					<p><b><a href="#menu help">Menu:  HELP</a></b></p>
					<p><b><a href="#menu logout">Menu:  LOGOUT</a></b></p>
					<p><a href="#graders online">Additional note for graders handling <b>online lessons</b></a></p>
					<h2><a id="logging" name="logging"></a>LOGGING IN</h2>
					<p>This is the website address (URL) for the database:<br>
					</p>
					<p>http://www.ubdavid.org/admin.php<br>
						<br>
					</p>
					<p>To make it easier to use regularly, once your browser is at this page click on &ldquo;Favorites&rdquo; and choose &ldquo;Add to Favorites&rdquo;.  At the next dialogue box choose (or create) any folder you wish, select it and press &ldquo;OK&rdquo;.  You may find that the &ldquo;Links&rdquo; folder is handiest because the next time you want to use the database you can simply click on &ldquo;Links&rdquo; near the top right of your browser and it will appear there as &ldquo;UBDavid administration&rdquo;.<br>
						<br>
					</p>
					<p>At the log-in page, enter your &ldquo;Username&rdquo; and &ldquo;Password&rdquo; as given to you.  The first time you enter these, Internet Explorer will ask if you want Windows to &lsquo;remember&rsquo; your password.  Click &ldquo;yes&rdquo; if your computer is not used by other people you don&rsquo;t know/trust.  Then the next time you log in you will simply need to type your Username and the password will be inserted automatically.<br>
					</p>
					<h2><a id="opening" name="opening"></a>OPENING SCREEN</h2>
					<p>At the top of the screen you will now see 6 menu items:  Students, Lessons, Awards, Reports, Help, and logout.  The database automatically opens to &ldquo;Students&rdquo; so the first screen you see will be the first set  of records (15) of your students. You can move through your student records by pressing the &ldquo;First&rdquo;, &ldquo;Last&rdquo;, &ldquo;Prev&rdquo; and &ldquo;Next&rdquo; buttons. You&rsquo;ll see a &ldquo;total&rdquo; figure at the bottom indicating how many student records you are currently accessing.  If all your students do not show up in the opening screen try clicking &ldquo;All students&rdquo; at the bottom.  The system &lsquo;remembers&rsquo; your last &ldquo;selection&rdquo; parameters so if you were working on a sub-set of your records the last time it is likely that the next time you log in that sub-set (selection of students) will show up initially.<br>
					</p>
					<h2><a id="menu students" name="menu students"></a>MENU: STUDENTS</h2>
					<p>The student records are arranged under 12 columns:  Source, Surname, first name, E-mail, City, prov, Postal Code, Birthday, Country, Last Access, Total Points, and Edit.  These headings are self-explanatory except perhaps for &ldquo;Last Access&rdquo; which refers to the last date the student accessed/added to their record by doing online lessons, or the last date the record was revised and saved by you, the grader, or the database administrator.<br>
						<br>
					</p>
					<p>Just ignore the &ldquo;<b>Source</b>&rdquo; column &#150; this was put in place to assist with the initial merging of the database records.<br>
						<br>
					</p>
					<h3><a id="re-sorting" name="re-sorting"></a>Re-Sorting</h3>
					<p>Normally the student records will be sorted by &ldquo;<b>Surname</b>&rdquo; in alphabetical ascending order. However, you can re-sort the records by clicking once on any of these blue underlined column headers. For example, if you click &ldquo;City&rdquo; the records will re-sort according to this field, in ascending alphabetical order. If you click &ldquo;City&rdquo; once again, the sort will be in descending alphabetical order (i.e. beginning with &ldquo;Z&rdquo; or the last alphabetical letter used by this field in your records). Remember that the database will &lsquo;remember&rsquo; your last &lsquo;screen&rsquo; (student selection and sort order) when you log out. This means that the next time you log in your opening screen will show your student records in whatever sort order you had them in last time just before logging out.</p>
					<h3><a id="total points" name="total points"></a>Total Points</h3>
					<p>Do not be alarmed that all your students appear to have &ldquo;0&rdquo; points under the &ldquo;Total Points&rdquo; column.  Most of the database screens do not calculate this field for all your students because of the heavy computing load this would put on the system, but their total points are still in their own records, as we will see when we get to &ldquo;Edit&rdquo;.  You can also see the actual total points of your student records when you use a report in a particular way (see that section for more information).</p>
					<h3><a id="edit" name="edit"></a>Edit</h3>
					<p>Each student record has much more information in it than what you see on this opening screen.  To access all of a student&rsquo;s information, click on &ldquo;Edit&rdquo;.  We would strongly recommend whenever using &ldquo;edit&rdquo; that you right click instead of the usual left click.  This will open a little option list in Internet Explorer.  The second option is &ldquo;Open in New Window&rdquo;.  (If you&rsquo;re using Mozilla Firefox as your browser, the right click will open a similar set of options but choose the first one:  &ldquo;Open Link in New Window&rdquo;.)  Select this option by clicking on it with your left button, which will then open that student&rsquo;s record in a new window, leaving your original screen still in place.  When you have viewed and/or made changes to a record using this method, closing that window puts you are back at the original window with the listing of your students just as they were.  This method makes it much easier to work with student records, especially when you have made a selection of a particular subset of students (we&rsquo;ll cover &ldquo;selecting students&rdquo; later).<br>
						<br>
					</p>
					<p>OK, once you have gone into EDIT for a particular record, you will see a new screen with that student&rsquo;s information. The top section gives their <b>personal information</b> &#150; name, address, etc. The &ldquo;Initial Contact&rdquo; field is primarily being used to indicate camps where students are first given a D&amp;J lesson. The student&rsquo;s lesson points, bonus points and total points are showing here correctly. You can change/correct/add to any of the information fields here. After you do so, be sure to click on any of the SAVE buttons to save this new information into the record.<br>
						<br>
					</p>
					<p>The next section of the student record is &ldquo;<b>User&rsquo;s Lesson History</b>&rdquo; which show which lessons and books they have received and/or completed along with the relevant points for each.<br>
						<br>
					</p>
					<p>Just below this is the &ldquo;<b>Awards</b>&rdquo; section which lists awards sent to this student and any comments made about these at the time.<br>
						<br>
					</p>
					<p>Next is a text entry block called &ldquo;<b>Events</b>&rdquo; which you can use to report camps, retreats, etc. which the student has attended. You can also use this for other information you want to record about the student which doesn&rsquo;t fit elsewhere.<br>
						<br>
					</p>
					<p>A similar text entry block called &ldquo;<b>Comments</b>&rdquo; is at the bottom. Again, this can be used for any information you want to record. Remember that both of these text entry blocks are limited to 500 characters each so make your entries succinct. And <b>be sure to click SAVE</b> after making any entries.</p>
					<h3><a id="add lesson" name="add lesson"></a>Adding Lesson Info</h3>
					<p>To add LESSON information to the student&rsquo;s &ldquo;User&rsquo;s Lesson History&rdquo; you use the &ldquo;<b>Add Lesson</b>&rdquo; hot link. This brings up another screen with &ldquo;Lesson Codes:&rdquo; and a data input box at the top. This is where you TYPE IN the actual lesson code for whatever lesson is now being sent to that student. You can add multiple lessons at the same time by typing each lesson code separated only by a comma between them (no spaces). There is a hot link there called &ldquo;List Lesson codes&rdquo; which brings up a listing of the codes in a separate window so you can see exactly what code each lesson series requires. You may want to leave this &ldquo;codes&rdquo; window open during your &ldquo;editing&rdquo; session so that you can refer to it whenever you are updating student records.  Please note that these codes are <b>not</b> in <i>alphabetical</i> order.  They are listed in the order in which the lessons were added to the system and consequently the codes for some courses are split up (eg. &quot;Best Friends&quot; and &quot;Explorers 2&quot; have additional lesson codes way down near the end of the list).  Once you get used to the lesson codes, you could use the other hot link &ldquo;Lesson Code Help&rdquo; to refresh your memory, as this listing just gives the basic code for each lesson series, rather than individual codes for every lesson. Don&rsquo;t forget to press <b>SAVE</b> after you have typed in your lesson code(s)!</p>
					<p>When you have added any lessons (or books etc.) to a student record, and are returned to the main page of the student's record be sure to <b>press SAVE again</b> on this page so that the &quot;Last Access&quot; date is updated.  This is especially important for the Alberta office which uses this information to print out the student labels each week, but it will also be valuable for all records in ensuring that they show the most recent date for changes/additions.</p>
					<p>You should not normally need to use the &ldquo;List Internet Lesson codes&rdquo; listing because these codes are entered automatically by the system when a student does online lessons.</p>
					<h3><a id="add Bible" name="add Bible"></a>Adding Bible</h3>
					<p>If you want to <b>add a BIBLE record</b> you use the <b>ADD LESSON link</b> from the student record page and type in one of the 5 &ldquo;Bible&rdquo; codes into the &ldquo;Lesson Codes:&rdquo; field.</p>
					<h3><a id="add books" name="add books"></a>Adding Books or Awards</h3>
					<p>When want to <b>add BOOK or AWARD information</b> you click the appropriate hot link within the student record. This brings up another screen similar to the &ldquo;Add Lesson&rdquo; screen but with &ldquo;Book Codes:&rdquo; or &ldquo;Award Codes:&rdquo; at the top. You simply press the drop-down arrow at the right end of that box and the listing of all the books/awards can then be seen. Click on the one you want added to the student record, change the &ldquo;Date Sent:&rdquo; if necessary, add any &ldquo;Comments&rdquo; you wish into the entry field there, and then click &ldquo;Save&rdquo;.</p>
					<h3><a id="completion" name="completion"></a>Completion Date</h3>
					<p>&ldquo;Saving&rdquo; any lesson, award or book entry will take you back to the student&rsquo;s main record page again. You will see your new entry now showing up under &ldquo;User&rsquo;s Lesson History&rdquo; or &ldquo;Awards&rdquo;. If it is a lesson you&rsquo;ve added to the record, you will see an empty rectangle against it under the &ldquo;Completed&rdquo; column. Do not click in or enter anything in this &ldquo;Completed&rdquo; box until they actually complete the assignment for that lesson. When they do, then click inside the &ldquo;Completed&rdquo; box on the student&rsquo;s record. This will automatically insert today&rsquo;s date (you can change it if you wish by using EDIT). And then press the &ldquo;<b>SAVE</b>&rdquo; button so that this information and related points are added to the student's record (don&rsquo;t forget &#150; a very important step!).</p>
					<h3><a id="media CDs" name="media CDs"></a>Media CD lessons</h3>
					<p>Here&rsquo;s an additional note concerning our <b>media CD lessons</b> which go to campers. Camp directors want to know the results from their own campers as they receive lessons and CDs. In the case of CDs, if the student chooses to do the questions using the Acrobat file which is then printed and mailed to one of our offices, there is a place there for them to identify who gave them the CD. Please note this information whenever you see an incoming lesson printed from a CD and record the appropriate camp code in the online database in the student&rsquo;s record in the &ldquo;Initial contact&rdquo; field - eg. CSRC-ON/05 (the camp code can be followed by a slash and the year the student began). Current camp codes will be made available to you directly from the Calgary office.<br>
						<br>
					</p>
					<p>For those handling <i><b>Internet</b></i> lessons, please note that the students using our <b>CDs</b> have the option of doing the questions <b>online</b>. In this case they are now being asked to identify the camp or organization that gave them the CD by putting that name in a &ldquo;comments&rdquo; field at the beginning of Lesson 1 in each CD series. It will be near the top of the email, right below the Course name, like this:<br>
					</p>
					<blockquote>
						<p>The user left the following comments (if any): Camp Little Red</p>
					</blockquote>
					<p>In this case, the grader would enter the Camp Little Red code in that student&rsquo;s &ldquo;Initial contact&rdquo; field.</p>
					<p><b><i>This is very important information.</i></b> If we don't record this into the student records then we cannot report to the camps accurately.<br>
						<br>
					</p>
					<h3><a id="select students" name="select students"></a>Hot Link:  SELECT STUDENTS</h3>
					<p>At the bottom of your main &ldquo;students&rdquo; screen you&rsquo;ll see this underlined hot link: &ldquo;Select Students&rdquo;.  When you click this link a new screen will open with a series of fields you can use to narrow down the set/selection of students you wish to work with.<br>
						<br>
					</p>
					<p>Once again, just ignore the &ldquo;Source&rdquo; option here.<br>
						<br>
					</p>
					<p>The &ldquo;Prov/State&rdquo;, &ldquo;Country&rdquo; and &ldquo;Grader&rdquo; options use dropdown lists from which you choose specific selections (the &ldquo;Grader&rdquo; option is only useful for the database administrator and will not be relevant to individual graders because your total record population is already restricted to your own grader set up).  Dropdowns are also available for specifying birthdays (first line) and birthdates (second line here), as well as &ldquo;Last Access&rdquo; dates.  For the other fields, you can enter names, etc. in as you wish.<br>
						<br>
					</p>
					<p>These type-in fields allow the use of the <i>wildcard character</i> &ldquo;<b>%</b>&rdquo;. In other words, you can use the percentage sign in place of one or more characters to expand your selection. For example, if you&rsquo;re trying to find a &ldquo;Kaitlyn&rdquo; but you&rsquo;re not sure if the name is spelled with a &ldquo;K&rdquo; or a &ldquo;C&rdquo; you could type &ldquo;%aitlyn&rdquo; into the &ldquo;Firstname&rdquo; field, press SHOW ME! and a new screen will show up listing all the &ldquo;Caitlyn&rdquo; and &ldquo;Kaitlyn&rdquo; students in your records. This wildcard character is especially useful in selecting camp students when you want to find all students from a particular camp, regardless of the year. In the &ldquo;Initial Contact&rdquo; field you could just enter &ldquo;CBC%&rdquo;, for example, and the results would bring up all students from the &ldquo;CBC&rdquo; camp whose records began in any year. To find only those who got their first lessons at the CBC camp in 2004 you would enter &ldquo;CBC/04&rdquo; without the wildcard character.</p>
					<h3><a id="all students" name="all students"></a>Hot Link:  All Students</h3>
					<p>Click here to bring up the listing of ALL&nbsp;your students. This is useful after you've been working on a sub-set, or editing one student, etc. and you now want to work from the full listing of all your students.</p>
					<h3><a id="print" name="print"></a>Hot Link:  Print</h3>
					<p>Clicking on &quot;Print&quot; will produce a new screen without the menu headings, ready for printing. The result will be a printout of only what you seen on your current screen. Since the record is generally wider than tall you will probably find that the printing will work best if you first go to &quot;File - Page Setup&quot; and set your printable page for &quot;landscape&quot;. Then click the printer icon on your browser to actually print the screen record. (Note: clicking the hot link &quot;print&quot; when you're in your &quot;Student&quot; list will not trigger your printer; you have to use your browser's print function to get a printout result. The &quot;print&quot; hot link simply prepares the page to print the record without extraneous info.)</p>
					<h3><a id="add" name="add"></a>Button:  Add</h3>
					<p>If you want to add a new student to your list press this &quot;Add&quot; button. It will open up a blank form with all the necessary information fields which you can then fill in. As you do so, just ignore the &quot;Source&quot; field, and leave the &quot;Sponsor&quot; field as is (it should show &quot;Default&quot;).</p>
					<h2><a id="menu lessons" name="menu lessons"></a>MENU: LESSONS</h2>
					<p>This menu shows the listings of all our lessons, both Internet and paper.  You probably don&rsquo;t need to access this menu item here since the lesson codes are available from the &ldquo;Add Lesson&rdquo; page when editing a student record anyway.<br>
					</p>
					<h2><a id="menu awards" name="menu awards"></a>MENU: AWARDS</h2>
					<p>This menu shows the listings of all our awards.  Again, you probably don&rsquo;t need to access this menu item.<br>
					</p>
					<h2><a id="menu reports" name="menu reports"></a>MENU: REPORTS</h2>
					<p>This brings up a selection page much like that for &ldquo;Select Students&rdquo;.  However there are some important differences here.  One is that you can select students by &ldquo;Status&rdquo; &#150; either &ldquo;active&rdquo; or &ldquo;inactive&rdquo;.  Another unique feature here is that you can produce a report based on, or using specific ranges of, &ldquo;total points&rdquo;.  If you simply want whatever report you&rsquo;re producing to show the total points of your students, you can force the system to calculate this field and show the proper results by entering a zero (&ldquo;0&rdquo;) in the &ldquo;from&rdquo; field beside &ldquo;Total Points:&rdquo;.  If you only want to see students who have a particular level of points, or are within a certain range of points, you then specify that figure(s) in the &ldquo;from&rdquo; and &ldquo;to&rdquo; fields.<br>
						<br>
					</p>
					<p>For report &ldquo;Output&rdquo; you have three choices:  &ldquo;Data&rdquo;, &ldquo;Screen&rdquo; or &ldquo;Mail Labels&rdquo;.</p>
					<h3><a id="data report" name="data report"></a>Data Output Report</h3>
					<p>If you select &ldquo;Data&rdquo; then the resulting report will be a comma-separated-value (csv) file, automatically named &ldquo;members.csv&rdquo;.  You can change the name of the report and specify the location in which you want it saved in your computer, from the dialogue boxes that result after pressing SHOW ME!  This report file is a spreadsheet with column headings automatically entered and your student data showing up in rows.  Such files can be read by Microsoft Excel or most other spreadsheet programs.  If you want to use the report in connection with mail merge in Word, it would be advisable to resave the opened &ldquo;csv&rdquo; file in Excel as an Excel (.xls) file.  All the data in the report is available as a data source for use in merging within Word (or similar word processing software) to produce envelopes or labels, etc.</p>
					<h3><a id="screen report" name="screen report"></a>Screen Output Report</h3>
					<p>The &ldquo;Screen&rdquo; output is probably the one you will use most often, so this is the default option.  When you have specified whatever parameters you wish for your resulting records, pressing SHOW ME! will produce the report in a new screen.  Depending on what parameters you selected and the size of your student records, you could end up with a very long report screen showing the results.  There are two ways of working with this sort of large/long result.  If you want to see just 15 students at a time, then press the MENU item &ldquo;Students&rdquo;.  This will break your report into screens of 15 records, with the usual navigation buttons at the bottom for moving from screen to screen.  If you wish to edit a particular record you can click &ldquo;Edit&rdquo; at the right end of that student&rsquo;s record, which will open up a new screen with their information.  When you&rsquo;re done editing, click on &ldquo;Return to list&rdquo; and you will go back to the report list again.<br>
						<br>
					</p>
					<p>A second way is to leave the report in its original long screen, grab the small rectangle in the right-hand navigation bar of that window and drag it up and down as you look for specific student names.  This can be a much quicker way to move through long report records.  However, if you wish to EDIT a student record from this report screen, right click on &ldquo;Edit&rdquo; and open that record in a new window.  If you left click on &ldquo;Edit&rdquo; that student&rsquo;s record will replace the report screen and when you &ldquo;Return to list&rdquo; the report screen will be in the shorter 15-student per screen style.</p>
					<h3><a id="mail labels" name="mail labels"></a>Mail Labels Output Report</h3>
					<p>The &ldquo;Mail Labels&rdquo; output produces a report in Rich Text Format (rtf) file.  Once again, as with the data output (csv) report you can specify the name and location of the saved report.  This type of file can be opened by Word and other word processing software.  When opened, the report will show your data in &ldquo;name &amp; address&rdquo; blocks in a column down the page.  You may want to manipulate the result to match your mailing labels.  The default result, if you set up your Word document as 3-columns, will be fairly close to Avery label #5160 but will probably need some tweaking.  If you want mailing labels you may find it easier to use the &ldquo;data&rdquo; output for your report and then do a mail merge using that file as the data source.  The &ldquo;Mail Labels&rdquo; output is probably best used as a simple catalogue listing giving names and addresses.<br>
					</p>
					<h2><a id="menu help" name="menu help"></a>MENU: HELP</h2>
					<p>There is nothing under this heading yet.  We should be able to put this manual up here so that it is available online as people work with the database.<br>
					</p>
					<h2><a id="menu logout" name="menu logout"></a>MENU: LOGOUT</h2>
					<p>When you are finished working on the database, click &ldquo;logout&rdquo; to complete your session.<br>
						<br>
					</p>
					<h3><a id="graders online" name="graders online"></a>Additional Note for Graders handling online lessons:</h3>
					<p>Since ONLINE student lesson submissions are generated automatically by the database system as an email to the respective grader(s) these emails are sometimes caught by spam filters in email programs.  To make sure that you&rsquo;re getting the emails from students you could add &ldquo;ubdavid.org&rdquo; to your email program&rsquo;s &ldquo;white list&rdquo; or &ldquo;safe senders&rdquo; list.<br>
					</p>
					<p> <? if ($l_user->get_priv() == "SPONSOR" or $l_user->is_admin()) { ?></p>
					<P><strong>Sponsors</strong></P>
					
		This is where the help text will go.
		<p>Only sponsors and administrators will see this part.</p>
	<? } ?>
	<? if ($l_user->is_admin()) { ?>
		<P><strong>Administrator</strong></P>
			<p>This is where the help text will go.</p>
			<p>Only administrators will see this part.</p>
	<? } ?>

<? } else { ?>
        <blockquote><p class=page-title>Login</p>
        <form method=post action=help.php>
        <input type=hidden name=f_action value="user_login">
        <input type=hidden name=f_next_action value="student_list">
        <?$error?>
        <table border=0>
                <tr valign=top>
                        <td align=right>Username:</td>
                        <td><input type=text class=text name=user_name size=30 maxlength=30></td>
                </tr><tr valign=top>
                        <td align=right>Password:</td>
                        <td><input type=password class=text name=user_password size=30 maxlength=30></td>
                </tr><tr valign=top>
                        <td colspan=2 align=center><input type=submit value="Login"></td>
                </tr>
        </table>
        </form>
<? } ?>
</td></tr>
</body>
</html>
