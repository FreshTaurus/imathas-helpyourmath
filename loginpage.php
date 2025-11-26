<?php
if (!isset($imasroot)) { //don't allow direct access to loginpage.php
	header("Location: index.php");
	exit;
}
//any extra CSS, javascript, etc needed for login page
	$placeinhead = "<link rel=\"stylesheet\" href=\"css/clean-style.css?v=" . time() . "\" type=\"text/css\" />\n";
	$placeinhead .= "<script type=\"text/javascript\" src=\"javascript/jstz_min.js\" ></script>";
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
	

<!-- Main login wrapper -->
<div class="login-content-div" >
    <div id="loginbox">
        <!-- Login hero text -->
        <div class="login-header">
            <h1 class="login-title">Welcome Back</h1>
            <p class="login-subtitle">Sign in to your account to continue</p>
        </div>
    <!-- Primary login form -->
    <form method="post" action="<?php echo $loginFormAction;?>">
    <?php
        if ($haslogin) {
            if ($badsession) {
                if (isset($_COOKIE[session_name()])) {
                    echo '<div class="error-message"><p>Problems with session storage</p></div>';
                }  else {
                    echo '<div class="error-message"><p>Unable to establish a session.  Check that your browser is set to allow session cookies</p></div>';
                }
            } else if (isset($line['password']) && substr($line['password'],0,8)=='cleared_') {
                echo '<div class="error-message"><p>Your password has expired since your account has been unused. Use the Reset Password link below to reset your password.</p></div>';
            } else {
                echo '<div class="error-message"><p>Login Error.  Try Again</p></div>';
            }
        }
    ?>

    <!-- Warn users if JavaScript is disabled -->
    <div><noscript>JavaScript is not enabled.  JavaScript is required for <?php echo $installname; ?>.  Please enable JavaScript and reload this page</noscript></div>

    <!-- Username/password fields -->
    <div class="login-input-box">
        <div class="input-wrapper">
            <label for="username" class="input-label"><?php echo $loginprompt; ?></label>
            <input class="login-input" type="text" id="username" placeholder="Enter your username" name="username" autocomplete="username" />
        </div>
        <div class="input-wrapper">
            <label for="password" class="input-label">Password</label>
            <input class="login-input" type="password" id="password" placeholder="Enter your password" name="password" autocomplete="current-password" />
        </div>
    </div>
    <div class="login-submit-btn-div">
        <input class="login-submit-btn" type="submit" value="Sign In"/>
    </div>

    <!-- Student self-registration -->
    <div class="student-sign-up-button">
        <a href="<?php echo $imasroot; ?>/forms.php?action=newuser">Register as a new student</a>
    </div>
    <!-- Account recovery links -->
    <div class="reset-link">
        <a href="<?php echo $imasroot; ?>/forms.php?action=resetpw" >Forgot Password</a>
        <a href="<?php echo $imasroot; ?>/forms.php?action=lookupusername">Forgot Username</a>
    </div>
    
    <!-- About/marketing popups -->
    <div class="aboutLinks">
<!--    <div>-->
<!--        <a href="#" onclick="openHelpYourMathPopup(event); return false;">About HelpYourMath</a>-->
<!--    </div>-->
    <div id="helpYourMathPopup" class="popup-container" style="display:none;">
            <div class="popup-content">
                <div style="text-align: center; font-weight: bold;"><h4>About <a href="http://www.helpyourmath.com">HelpYourMath</a></h4></div>
                <div class="popup-text">
                    <p>HelpYourMath operates as a non-profit and donation-sponsored, free educational source also known as an Open Education Resources (OER). With support from the college and the exceptional work and dedication of volunteer professors, tutors, and students, we have been able to create full curriculums for various college mathematics courses. The OER team was established and continues to grow every year.</p>
                    <p>HelpYourMath is an entirely self-functioning open source content site and channel. Although HelpYourMath was initially made to tailor the needs of the BMCC math curriculum, we are prepared to help students around the world from all walks of life. Our OER team believes that sharing is caring, and we are delighted to work with you.</p>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/DLpKrC3Rsvk?si=ZxpQI0kDwG9Z31Fk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <div style="text-align: end;"><button onclick="closeHelpYourMathPopup(event);">Close</button></div>
            </div>
    </div>

        <!-- HelpYourMath modal behavior -->
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

<!--        <div style="margin-right: 40px;">-->
<!--            <a href="#" onclick="openIMathASPopup(event); return false;">About IMathAS</a>-->
<!--        </div>-->

        <div id="iMathASPopup" class="popup-container" style="display:none;">
            <div class="popup-content">
                <div style="text-align: center; font-weight: bold;"><h4>About <a href="http://www.imathas.com">IMathAS </a></h4></div>
                <div class="popup-text">
                    <p>IMathAS is a web based mathematics assessment and course management platform.</p>
                    <p>This system is designed for mathematics, providing delivery of homework, quizzes, tests, practice tests, and diagnostics with rich mathematical content. Students can receive immediate feedback on algorithmically generated questions with numerical or algebraic expression answers.</p>
                </div>
                <div style="text-align: end;"><button onclick="closeIMathASPopup(event);">Close</button></div>
            </div>
        </div>

        <!-- IMathAS modal behavior -->
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

    <!-- Hidden fields for timezone + challenge -->
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
<!-- Footer attribution + instructor link -->
<div class="login-copyright">
    <p>The OER Platform is powered by <a href="#" onclick="openHelpYourMathPopup(event); return false;">HelpYourMath</a> © 2017-2025 HelpYourMath Team | <a href="<?php echo $imasroot; ?>/newinstructor.php" class="instructor-request-link">Request instructor Account</a></p>



    <p>The Homework Platform is powered by <a href="#" onclick="openIMathASPopup(event); return false;">IMathAS</a> © 2006-2025 David Lippman</p>
</div>
<!-- Inline styles for the footer CTA -->
<style>
.instructor-request-link {
    display: inline-block;
    background-color: rgba(255, 255, 255, 0.2);
    padding: 6px 12px;
    border-radius: 6px;
    border: 1px solid rgba(255, 255, 255, 0.4);
    font-weight: 600;
    margin-left: 8px;
    transition: all 0.3s ease;
}
.instructor-request-link:hover {
    background-color: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.6);
    text-decoration: none;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}
</style>
<?php 
	require("footer.php");
?>
