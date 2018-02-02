<?require("include/session.inc.php"); ?>
<html xmlns:XS>
<head>
<title>UBDavid administration</TITLE>
</head>
<body>
<!-- <p align=center><img src=./ubdavidfolder/david_graphics/gubgen01_ubtextlogo.GIF></p> -->
<? if ($l_user->is_logged_in()) { ?>
<A HREF=/admin.php?f_action=student_list><strong>Students</strong></A> | 
<A HREF=/admin.php?f_action=lesson_list><strong>Lessons</strong></A> | 
<A HREF=/admin.php?f_action=award_list><strong>Awards</strong></A> | 
<A HREF=/admin.php?f_action=student_reports><strong>Reports</strong></A> | 
<? } ?>
<? if ($l_user->get_priv() == "SPONSOR" or $l_user->is_admin()) { ?>
<A HREF=/admin.php?f_action=grader_list><strong>Graders</strong></A> | 
<? } ?>
<? if ($l_user->is_admin()) { ?>
<A HREF=/admin.php?f_action=sponsor_list><strong>Sponsors</strong></A> | 
<A HREF=/admin.php?f_action=space_list><strong>Admin Accounts</strong></A> | 
<A HREF=/admin.php?f_action=pdfs_list><strong>PDF Mailouts</strong></A> | 
<? } ?>
<A HREF=/help.php><strong>Help</strong></A> | 
<? login_link(); ?>

<? if ($l_user->is_logged_in()) {
	 main_body();
} else { ?>
        <blockquote><p class=page-title>Login</p>
        <form method=post action=admin.php>
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
</body>
</html>
