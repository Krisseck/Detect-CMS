Detect-CMS
==========

PHP Library for detecting CMS

How to use:
-----------

    include("Detect-CMS/Detect-CMS.php");
    $domain = "http://google.com";
    $cms = new DetectCMS($domain);
    if($cms->getResult()) {
        echo "Detected CMS: ".$cms->getResult();
    } else {
        echo "CMS couldn't be detected";
    } 
