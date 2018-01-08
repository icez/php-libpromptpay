# php-libpromptpay
PHP library for generating a PromptPay string to generate QR code.

# Quick Usage Example

    <?php
    require 'libpromptpay.php';
    $pp = new LibPromptpay();
    $pp->setPaymentID(LibPromptpay::PROMPTPAY_ACCTYPE_EWALLET, '004999000281286');
    $pp->setAmount(0.49);
    $pp->setQRType(LibPromptpay::EMVCO_QRTYPE_DYNAMIC);
    echo $pp->generateString();

# Methods
### setQRType($qrtype)
Set the QR Code Type
- setQRType(LibPromptpay::EMVCO_QRTYPE_STATIC) ** default
- setQRType(LibPromptpay::EMVCO_QRTYPE_DYNAMIC)

### setPaymentID($acctype, $accid)
Set the Merchant Account Type & Number
- setPaymentID(LibPromptpay::PROMPTPAY_ACCTYPE_MOBILE, '0066XXXXXXXXX');
- setPaymentID(LibPromptpay::PROMPTPAY_ACCTYPE_IDCARD, 'XXXXXXXXXXXXX');
- setPaymentID(LibPromptpay::PROMPTPAY_ACCTYPE_EWALLET, 'XXXXXXXXXXXXXXX');

### setAmount($amount)
Set the preferred amount for receiving the payment ** WARNING ** K Plus Application does not support amount in QR code
- setAmount(2999.31)

# Thai QR Payment Limitation

### K Plus Application
- [2018-01-08] Does not recognize 'Amount' field

### SCBEasy Applcation
- [2018-01-08] Does not allow amount less than 1 THB

# Credit
- CRC16 CCITT from [jkobus/crc16-ccit](https://github.com/jkobus/crc16-ccit)
- Original work from [ifew/PromptpayQR](https://github.com/ifew/PromptpayQR)
- [EMVCo QR Code Specification](https://www.emvco.com/emv-technologies/qrcodes/)
