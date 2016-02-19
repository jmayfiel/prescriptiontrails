<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 0);
error_reporting(E_ERROR | E_PARSE);
require("db.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<pre>
<?php 
$testTrail = new trail;
$testTrail->setID(1);
print_r($testTrail->getInfo("Array")); 
?>
</pre>
</body>
</html>
