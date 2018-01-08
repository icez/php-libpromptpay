<?php
require __DIR__.'/CRC16CCIT.php';
use Crc16CCIT\Crc16CCIT;

class LibPromptpay
{
	const EMVCO_FORMAT = '00';
	const EMVCO_QRTYPE = '01';
	const EMVCO_QRTYPE_STATIC = '11';
	const EMVCO_QRTYPE_DYNAMIC = '12';
	const EMVCO_CRC = '63';
	const EMVCO_CUSTOMMERCHANT = '29';
	const EMVCO_COUNTRY = '58';
	const EMVCO_CURRENCY = '53';
	const EMVCO_CURRENCY_THB = '764';
	const EMVCO_AMOUNT = '54';
	const EMVCO_TIPAMOUNT = '55';
	const EMVCO_FEEAMOUNT_FIXED = '56';
	const EMVCO_FEEAMOUNT_PCNT = '57';

	const PROMPTPAY_APPID = 'A000000677010111';
	const PROMPTPAY_ACCTYPE_PHONE = '01';
	const PROMPTPAY_ACCTYPE_IDCARD = '02';
	const PROMPTPAY_ACCTYPE_EWALLET = '03';

	protected $_setting = [];
	function __construct() {
		$this->_setting = [
			LibPromptpay::EMVCO_FORMAT => '01',
			LibPromptpay::EMVCO_QRTYPE => LibPromptpay::EMVCO_QRTYPE_STATIC,
			LibPromptpay::EMVCO_COUNTRY => 'TH',
			LibPromptpay::EMVCO_CURRENCY => LibPromptpay::EMVCO_CURRENCY_THB
		];
	}
	function setQRType($qrtype) {
		if (!in_array($qrtype, ['11', '12'])) {
			throw new Exception("Invalid QR Type");
		}
		$this->_setting[LibPromptpay::EMVCO_QRTYPE ] = $qrtype;
	}
	function setPaymentID($acctype, $accid) {
		$this->_setting[LibPromptpay::EMVCO_CUSTOMMERCHANT] = [
				'00' => LibPromptpay::PROMPTPAY_APPID,
				$acctype => $accid
			];
	}
	function setAmount($amount) {
		$this->_setting[LibPromptpay::EMVCO_AMOUNT] = number_format($amount, 2, '.', '');
	}
	function generateKeyString($key, $value) {
		if (!is_array($value)) {
			return $key.sprintf('%02d', strlen($value)).$value;
		} else {
			$_val = $value;
			ksort($_val);
			$str = '';
			foreach ($_val as $_key => $_value) {
				$str .= $this->generateKeyString($_key, $_value);
			}
			return $key.sprintf('%02d', strlen($str)).$str;
		}
	}
	function generateString() {
		if (!isset($this->_setting[LibPromptpay::EMVCO_CUSTOMMERCHANT])) {
			throw new Exception("MERCHANT ID is not set");
		}
		ksort($this->_setting);
		$str = '';
		foreach($this->_setting as $key => $val) {
			$str .= $this->generateKeyString($key, $val);
		}
		$str .= LibPromptpay::EMVCO_CRC.'04';
		$str .= strtoupper(sprintf('%04s', Crc16CCIT::calculate($str)));
		return $str;
	}
}
