<?php
if (!isset($imasroot)) { //don't allow direct access to loginpage.php
	header("Location: index.php");
	exit;
}
//any extra CSS, javascript, etc needed for login page
	$placeinhead = "<link rel=\"stylesheet\" href=\"$imasroot/infopages.css\" type=\"text/css\" />\n";
	$placeinhead .= "<script type=\"text/javascript\" src=\"$imasroot/javascript/jstz_min.js\" ></script>";
	$nologo = true;
	require("header.php");
	if (!empty($_SERVER['QUERY_STRING'])) {
		 $querys = '?'.$_SERVER['QUERY_STRING'];
	 } else {
		 $querys = '';
	 }
	 $loginFormAction = $GLOBALS['basesiteurl'] . substr($_SERVER['SCRIPT_NAME'],strlen($imasroot)) . Sanitize::encodeStringForDisplay($querys);
	 if (!empty($_SESSION['challenge'])) {
		 $challenge = $_SESSION['challenge'];
	 } else {
		 //use of microtime guarantees no challenge used twice
		 $challenge = base64_encode(microtime() . rand(0,9999));
		 $_SESSION['challenge'] = $challenge;
	 }
	 $pagetitle = "About Us";
	 include("infoheader.php");
	 
?>
	

<div style="display: flex; flex-direction: row;justify-content: flex-start;">
<!--    <div class="text">-->
<!--        <p>--><?php //echo $installname; ?><!-- is a web based mathematics assessment and course management platform.  </p>-->
<!--        <img style="float: left; margin-right: 20px;" src="--><?php //echo $imasroot; ?><!--/img/screens.jpg" alt="Computer screens"/>-->
<!---->
<!--        <p>This system is designed for mathematics, providing delivery of homework, quizzes, tests, practice tests,-->
<!--            and diagnostics with rich mathematical content.  Students can receive immediate feedback on algorithmically generated questions with-->
<!--            numerical or algebraic expression answers.-->
<!--        </p>-->
<!---->
<!--        <p>If you already have an account, you can log on using the box to the right.</p>-->
<!--        <p>If you are a new student to the system, <a href="--><?php //echo $imasroot; ?><!--/forms.php?action=newuser">Register as a new student</a></p>-->
<!--        <p>If you are an instructor, you can <a href="--><?php //echo $imasroot;?><!--/newinstructor.php">request an account</a></p>-->
<!---->
<!--        <p>Also available:-->
<!--        <ul>-->
<!--            <li><a href="--><?php //echo $imasroot;?><!--/info/enteringanswers.php">Help for student with entering answers</a></li>-->
<!--            <li><a href="--><?php //echo $imasroot;?><!--/docs/docs.php">Instructor Documentation</a></li>-->
<!--        </ul>-->
<!---->
<!--        <br class=clear>-->
<!--        <p class="textright">--><?php //echo $installname;?><!-- is powered by <a href="http://www.imathas.com">IMathAS</a> &copy; 2006---><?php //echo date("Y");?><!-- David Lippman</p>-->
<!--    </div>-->
    <div style=" height: 65%; width:65%;">
        <img src="./loginpage.jpeg" style=" height: 95%; width:95%; ">
    </div>
    <div id="loginbox">
    <form style="width: 90%; display: flex; flex-direction: column;" method="post" action="<?php echo $loginFormAction;?>">
    <?php
        if ($haslogin) {
            if ($badsession) {
                if (isset($_COOKIE[session_name()])) {
                    echo 'Problems with session storage';
                }  else {
                    echo '<p>Unable to establish a session.  Check that your browser is set to allow session cookies</p>';
                }
            } else if (isset($line['password']) && substr($line['password'],0,8)=='cleared_') {
                echo '<p>Your password has expired since your account has been unused. Use the Reset Password link below to reset your password.</p>';
            } else {
                echo "<p>Login Error.  Try Again</p>\n";
            }
        }
    ?>
<!--    <b>Login</b>-->

    <div><noscript>JavaScript is not enabled.  JavaScript is required for <?php echo $installname; ?>.  Please enable JavaScript and reload this page</noscript></div>

    <div class="login-input-box">
    <input class="login-input" type="text"  id="username" placeholder="username" name="username" />
    <input class="login-input" type="password"  id="password" placeholder="password" name="password" />
    </div>
    <div><input class="login-submit-btn" style="font-size: 20px;" type="submit" value="Login"/></div>

    <div>
        <a href="<?php echo $imasroot; ?>/forms.php?action=newuser" class="student-sign-up-button">Register as a new student</a>
    </div>
    <div style="display: flex; flex-direction: row; justify-content:space-between; margin-top: 20px;">
        <a href="<?php echo $imasroot; ?>/forms.php?action=resetpw" >Forgot Password</a>
        <a href="<?php echo $imasroot; ?>/forms.php?action=lookupusername" style="margin-right: 30px;">Forgot Username</a>
    </div>
    <div  style="display: flex; flex-direction: row; justify-content: flex-start; margin: 5px 0;">
        <a href="<?php echo $imasroot;?>/newinstructor.php">Request an instructor Account</a>
    </div>
    <div class="aboutLinks">
    <div>
        <a href="#" onclick="openHelpYourMathPopup(event); return false;">About HelpYourMath</a>
    </div>
    <div id="helpYourMathPopup" class="popup-container" style="display:none;">
            <div class="popup-content">
                <div style="text-align: center; font-weight: bold;"><h4>About HelpYourMath</h4></div>
                <div class="popup-text">
                    <p>HelpYourMath operates as a non-profit and donation-sponsored, free educational source also known as an Open Education Resources (OER). With support from the college and the exceptional work and dedication of volunteer professors, tutors, and students, we have been able to create full curriculums for various college mathematics courses. The OER team was established and continues to grow every year.</p>
                    <p>HelpYourMath is an entirely self-functioning open source content site and channel. Although HelpYourMath was initially made to tailor the needs of the BMCC math curriculum, we are prepared to help students around the world from all walks of life. Our OER team believes that sharing is caring, and we are delighted to work with you.</p>
                </div>
                <div style="text-align: end;"><button onclick="closeHelpYourMathPopup(event);">Close</button></div>
            </div>
    </div>

        <script>
            function openHelpYourMathPopup(event) {
                event.preventDefault();
                document.getElementById('helpYourMathPopup').style.display = 'flex';
            }

            function closeHelpYourMathPopup(event) {
                event.preventDefault();
                document.getElementById('helpYourMathPopup').style.display = 'none';
            }
        </script>

        <div>
            <a href="#" onclick="openIMathASPopup(event); return false;">About IMathAS</a>
        </div>

        <div id="iMathASPopup" class="popup-container" style="display:none;">
            <div class="popup-content">
                <div style="text-align: center; font-weight: bold;"><h4>About IMathAS</h4></div>
                <div class="popup-text">
                    <p>IMathAS is a web based mathematics assessment and course management platform.</p>
                    <p>This system is designed for mathematics, providing delivery of homework, quizzes, tests, practice tests, and diagnostics with rich mathematical content. Students can receive immediate feedback on algorithmically generated questions with numerical or algebraic expression answers.</p>
                </div>
                <div style="text-align: end;"><button onclick="closeIMathASPopup(event);">Close</button></div>
            </div>
        </div>

        <script>
            function openIMathASPopup(event) {
                event.preventDefault();
                document.getElementById('iMathASPopup').style.display = 'flex';
            }

            function closeIMathASPopup(event) {
                event.preventDefault();
                document.getElementById('iMathASPopup').style.display = 'none';
            }
        </script>
    </div>

    <input type="hidden" id="tzoffset" name="tzoffset" value="">
    <input type="hidden" id="tzname" name="tzname" value="">
    <input type="hidden" id="challenge" name="challenge" value="<?php echo $challenge; ?>" />
    <script type="text/javascript">
    $(function() {
            var thedate = new Date();
            document.getElementById("tzoffset").value = thedate.getTimezoneOffset();
            var tz = jstz.determine();
            document.getElementById("tzname").value = tz.name();
            $("#username").focus();
    });
    </script>


    </form>
    </div>
</div>
<?php 
	require("footer.php");
?>
