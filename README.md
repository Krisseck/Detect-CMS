Detect-CMS
==========

PHP Library for detecting CMS

Install
-------

Add to your composer.json

```json
{
    "repositories":[
        {
            "type": "vcs",
            "url": "git@github.com:Krisseck/Detect-CMS.git"
        }
    ],
    "require":{
        "Detect-CMS":"1.0.*"
    }
}
```

How to use:
-----------

    include(__DIR__ . "/vendor/autoload.php");
    $domain = "http://google.com";
    $cms = new \DetectCMS\DetectCMS($domain);
    if($cms->getResult()) {
        echo "Detected CMS: ".$cms->getResult();
    } else {
        echo "CMS couldn't be detected";
    } 
