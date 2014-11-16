Detect-CMS
==========

PHP Library for detecting CMS

How to use:
-----------

    include("Detect-CMS/Detect-CMS.php");
    $domain = "http://google.com";
    $detect = new DetectCMS();
    if($cms = $detect->check($domain)) {
        echo "Detected CMS: ".$cms;
    } else {
        echo "CMS couldn't be detected";
    }
    
