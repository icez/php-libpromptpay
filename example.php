<?php
require 'libpromptpay.php';
require 'phpqrcode/qrlib.php';

$pp = new LibPromptpay();
$pp->setPaymentID(LibPromptpay::PROMPTPAY_ACCTYPE_EWALLET, '004999000281286');
$pp->setQRType(LibPromptpay::EMVCO_QRTYPE_DYNAMIC);
$pp->setAmount(1);

header('Content-Type: image/png');
QRcode::png($pp->generateString());
