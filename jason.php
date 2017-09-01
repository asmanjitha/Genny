<?php
	$content = "gedi Asm";
	list($key, $second) = explode(" ",$content);
	echo $second;
?>
<html>
<body>

<h2>Convert a JavaScript object into a JSON string, and send it to the server.</h2>

<script>

var myObj = {
"message":"gedi app1",
"sourceAddress":"tel:94777323654",
"requestId":"APP_000001",
"encoding":"0",
"version":"1.0"
};
var myJSON = JSON.stringify(myObj);
window.location = "sms.php?x=" + myJSON;

</script>

</body>
</html>