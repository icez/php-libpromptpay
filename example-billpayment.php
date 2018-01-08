<?php
require 'libpromptpay.php';
require 'phpqrcode/qrlib.php';

$pp = new LibPromptpay();
$pp->setBillPayment('010552300935008', '00129', 2.99);
$pp->setBillPaymentRef3('Ref3code');

header('Content-Type: image/png');
QRcode::png($pp->generateString());
