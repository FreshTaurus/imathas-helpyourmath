<?php
    include_once("config.php");
?>


<div id="login-header">
    <div class="header-content">
        <div id="logo">
            <img src="<?php echo $imasroot; ?>img/HelpYourMath_Logo.png" alt="HelpYourMath Logo" class="logo-image" />
            <div class="logo-text">
                <span id="header-title"><?php echo $installname; ?></span>
                <span class="header-subtitle">Welcome to our Free Virtual Classroom</span>
            </div>
        </div>
        <nav id="header-navi-link">
            <a href="<?php echo $imasroot; ?>/index.php">Home</a>
            <a href="<?php echo $imasroot; ?>/diag/index.php">Diagnostics</a>
            <a href="<?php echo $imasroot; ?>/nys_math_test.php">Grade 7 Math Test</a>
        </nav>
    </div>
</div>
<div class="ad-wrapper">
    <div class="ad-container">
        <span class="ad-placeholder">Advertisement</span>
    </div>
</div>


<!--<div id="header">-->
<!--<img class="floatright" src="--><?php //echo $imasroot; ?><!--/img/graph.gif" alt="graph image" />-->
<!--<div class="vcenter">--><?php //echo $pagetitle;?><!--</div>-->
<!--</div>-->
