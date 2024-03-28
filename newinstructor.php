<?php

	require("init_without_validate.php");
	require_once(__DIR__.'/includes/newusercommon.php');
	$pagetitle = "New instructor account request";
	$placeinhead = "<link rel=\"stylesheet\" href=\"$imasroot/infopages.css\" type=\"text/css\">\n";
	$placeinhead .= '<script type="text/javascript" src="'.$imasroot.'/javascript/jquery.validate.min.js"></script>';
	if (isset($CFG['locale'])) {
	  $placeinhead .= '<script type="text/javascript" src="'.$imasroot.'/javascript/jqvalidatei18n/messages_'.substr($CFG['locale'],0,2).'.min.js"></script>';
	}
	$nologo = true;
	require("header.php");
	$pagetitle = "Instructor Account Request";
	require("infoheader.php");
	$required = array('SID','firstname','lastname','email','pw1','pw2','school','phone','agree');

	if (isset($_POST['firstname'])) {
		$error = '';
		if (!isset($_POST['agree'])) {
			$error .= "<p>You must agree to the Terms and Conditions to set up an account</p>";
		}

		$error .= checkNewUserValidation($required);

		if ($error != '') {
			echo $error;
		} else {
			if (isset($CFG['GEN']['homelayout'])) {
				$homelayout = $CFG['GEN']['homelayout'];
			} else {
				$homelayout = '|0,1,2||0,1';
			}

			if (isset($CFG['GEN']['newpasswords'])) {
				require_once("./includes/password.php");
				$md5pw = password_hash($_POST['pw1'], PASSWORD_DEFAULT);
			} else {
				$md5pw = md5($_POST['pw1']);
			}
			//DB $query = "INSERT INTO imas_users (SID, password, rights, FirstName, LastName, email, homelayout) ";
			//DB $query .= "VALUES ('{$_POST['username']}','$md5pw',0,'{$_POST['firstname']}','{$_POST['lastname']}','{$_POST['email']}','$homelayout');";
			//DB mysql_query($query) or die("Query failed : " . mysql_error());
			//DB $newuserid = mysql_insert_id();
			$query = "INSERT INTO imas_users (SID, password, rights, FirstName, LastName, email, homelayout) ";
			$query .= "VALUES (:SID, :password, :rights, :FirstName, :LastName, :email, :homelayout);";
			$stm = $DBH->prepare($query);
			$stm->execute(array(':SID'=>$_POST['SID'], ':password'=>$md5pw, ':rights'=>12, ':FirstName'=>$_POST['firstname'], ':LastName'=>$_POST['lastname'], ':email'=>$_POST['email'], ':homelayout'=>$homelayout));
			$newuserid = $DBH->lastInsertId();
			if (isset($CFG['GEN']['enrollonnewinstructor'])) {
				$valbits = array();
				foreach ($CFG['GEN']['enrollonnewinstructor'] as $ncid) {
				  $ncid = intval($ncid);
					$valbits[] = "($newuserid,$ncid)";
				}
				//DB $query = "INSERT INTO imas_students (userid,courseid) VALUES ".implode(',',$valbits);
				//DB mysql_query($query) or die("Query failed : " . mysql_error());

				$stm = $DBH->query("INSERT INTO imas_students (userid,courseid) VALUES ".implode(',',$valbits)); //known INTs - safe
			}
			$subject = "New Instructor Account Request";
			$message = "Name: {$_POST['firstname']} {$_POST['lastname']} <br/>\n";
			$message .= "Email: {$_POST['email']} <br/>\n";
			$message .= "School: {$_POST['school']} <br/>\n";
			$message .= "Phone: {$_POST['phone']} <br/>\n";
			$message .= "Username: {$_POST['SID']} <br/>\n";


			require_once("./includes/email.php");
			
			send_email($sendfrom, $sendfrom, $subject, $message, array(), array(), 10); 

			$now = time();
			//DB $query = "INSERT INTO imas_log (time, log) VALUES ($now, 'New Instructor Request: $newuserid:: School: {$_POST['school']} <br/> Phone: {$_POST['phone']} <br/>')";
			//DB mysql_query($query) or die("Query failed : " . mysql_error());
			$stm = $DBH->prepare("INSERT INTO imas_log (time, log) VALUES (:now, :log)");
			$stm->execute(array(':now'=>$now, ':log'=>"New Instructor Request: $newuserid:: School: {$_POST['school']} <br/> Phone: {$_POST['phone']} <br/>"));

			$reqdata = array('reqmade'=>$now, 'school'=>$_POST['school'], 'phone'=>$_POST['phone']);
			$stm = $DBH->prepare("INSERT INTO imas_instr_acct_reqs (userid,status,reqdate,reqdata) VALUES (?,0,?,?)");
			$stm->execute(array($newuserid, $now, json_encode($reqdata)));

			$message = "<p>Your new account request has been sent.</p>  ";
			$message .= "<p>This request is processed by hand, so please be patient.</p>";
			
			send_email($_POST['email'], $sendfrom, $subject, $message, array(), array(), 10); 

			echo $message;
			require("footer.php");
			exit;

		}
	}
	if (isset($_POST['firstname'])) {$firstname=Sanitize::encodeStringForDisplay($_POST['firstname']);} else {$firstname='';}
	if (isset($_POST['lastname'])) {$lastname=Sanitize::encodeStringForDisplay($_POST['lastname']);} else {$lastname='';}
	if (isset($_POST['email'])) {$email=Sanitize::encodeStringForDisplay($_POST['email']);} else {$email='';}
	if (isset($_POST['phone'])) {$phone=Sanitize::encodeStringForDisplay($_POST['phone']);} else {$phone='';}
	if (isset($_POST['school'])) {$school=Sanitize::encodeStringForDisplay($_POST['school']);} else {$school='';}
	if (isset($_POST['SID'])) {$username=Sanitize::encodeStringForDisplay($_POST['SID']);} else {$username='';}

	echo "<div class='centered-container' style='display: flex; flex-direction: column; align-items: center; justify-content: center;text-align: center;'>";
	echo "<h3 style='font-size: 37px; color: #00cc00;'>New Instructor Account Request</h3>\n";
	echo "<form method=post id=newinstrform class=limitaftervalidate action=\"newinstructor.php\">\n";

	echo "<input class='instructor-signup-input' type=text id=firstname name=firstname placeholder='First Name' value=\"$firstname\" size=40><br/>\n";
	echo "<input class='instructor-signup-input' type=text id=lastname name=lastname placeholder='Last Name' value=\"$lastname\" size=40><br/>\n";
	echo "<input class='instructor-signup-input' type=text id=email name=email placeholder='Email Address' value=\"$email\" size=40><br/>\n";
	echo "<input class='instructor-signup-input' type=text id=phone name=phone placeholder='Phone Number' value=\"$phone\" size=40><br/>\n";
	echo "<input class='instructor-signup-input' type=text id=school name=school placeholder='School/College' value=\"$school\" size=40><br/>\n";
	echo "<input class='instructor-signup-input' type=text id=SID name=SID placeholder='Requested Username' value=\"$username\" size=40><br/>\n";
	echo "<input class='instructor-signup-input' type=password id=pw1 name=pw1 placeholder='Requested Password' size=40><br/>\n";
	echo "<input class='instructor-signup-input' type=password id=pw2 name=pw2 placeholder='Retype Password' size=40><br />\n";
	echo "<input type=checkbox id=agree name=agree><label for='agree'>I have read and agree to the <a href='#' onclick='openTermsPopup(); return false;'>Terms of Use</a>.</label><br/>\n";
	echo "<div id='termsPopup' class='popup-container' style='display:none;'>
			<div class='popup-content'>
				<h4>Terms of Use</h4>
				<div class='popup-text'>
					<p><em>This software is made available with <strong>no warranty</strong> and <strong>no guarantees</strong>. 
					The server or software might crash or mysteriously lose all your data.  Your account or this service may be 
					terminated without warning.  No official support is provided. </em></p>
					<p><em>Copyrighted materials should not be posted or used in questions without the permission of the copyright owner.  
					You shall be solely responsible for your own user created content and the consequences of posting or publishing them.  
					This site expressly disclaims any and all liability in connection with user created content.</em></p>
				</div>
				<button onclick='closeTermsPopup();'>Close</button>
			</div>
		  </div>";

	echo "<div class=submit><input type=submit value=\"Request Account\"></div>\n";
	echo "</form>\n";

	echo "</div>";

	showNewUserValidation('newinstrform',$required);
	echo "<script>
		function openTermsPopup() {
			document.getElementById('termsPopup').style.display = 'flex';
		}
		function closeTermsPopup() {
			document.getElementById('termsPopup').style.display = 'none';
		}
	</script>";
	require("footer.php");
?>
