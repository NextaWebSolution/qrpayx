<?php
error_reporting(0);
require_once('lib/QrPayX_Config.php');
require_once('lib/QrPayXCheckSum.php');

$checkSum = "";
$paramList = array();

$gateway_type = "Robotics";
$cust_Mobile = $_POST['cust_Mobile'];
$cust_Email = $_POST['cust_Email'];
$orderId = "TEST".time();
$txnAmount = $_POST['txnAmount'];
$txnNote = $_POST['txnNote'];

if($gateway_type=="Advanced"){
    
$QrPayX_TXN_URL='https://qrpayx.com/order/payment';


}else if($gateway_type=="Robotics"){

$QrPayX_TXN_URL='https://qrpayx.com/order/paytm';


}else if($gateway_type=="Normal"){
    
$QrPayX_TXN_URL='https://qrpayx.com/order/process'; 
}

// Create an array having all required parameters for creating checksum.
$paramList["upiuid"] = $upiuid;
$paramList["token"] = $token;
$paramList["orderId"] = $orderId ;
$paramList["txnAmount"] = $txnAmount;
$paramList["txnNote"] = $txnNote;
$paramList["callback_url"] = $callback_url;
$paramList["cust_Mobile"] = $cust_Mobile;
$paramList["cust_Email"] = $cust_Email;
$checkSum = QrPayXCheckSum::generateSignature($paramList,$secret);
?>
<html>
<head>
<title>Gateway Check Out Page</title>
</head>
<body>
	<center><h1>Please do not refresh this page...</h1></center>
		<form method="post" action="<?php echo $QrPayX_TXN_URL ?>" name="f1">
		<table border="1">
			<tbody>
			<?php
			foreach($paramList as $name => $value) {
				echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
			}
			?>
			<input type="hidden" name="checksum" value="<?php echo $checkSum ?>">
			</tbody>
		</table>
		<script type="text/javascript">
			document.f1.submit();
		</script>
	</form>
</body>
</html>
