<?php
/*
* Copyright (c) 2011 Litle & Co.
*
* Permission is hereby granted, free of charge, to any person
* obtaining a copy of this software and associated documentation
* files (the "Software"), to deal in the Software without
* restriction, including without limitation the rights to use,
* copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the
* Software is furnished to do so, subject to the following
* conditions:
*
* The above copyright notice and this permission notice shall be
* included in all copies or substantial portions of the Software.
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND
* EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
* OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
* NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
* HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
* WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
* FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
* OTHER DEALINGS IN THE SOFTWARE.
*/

require_once("../../simpletest/autorun.php");
require_once('../../simpletest/unit_tester.php');
require_once realpath(dirname(__FILE__)) . '/../../lib/LitleOnline.php';

class forceCapture_FunctionalTest extends UnitTestCase
{
	function test_simple_forceCapture_with_card()
	{
		$hash_in = array(
		  'merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'litleTxnId'=>'123456',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'orderSource'=>'ecommerce',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210'
		));

		$initilaize = &new LitleOnlineRequest();
		$forceCaptureResponse = $initilaize->forceCaptureRequest($hash_in);
		$response = XMLParser::get_attribute($forceCaptureResponse,'litleOnlineResponse','response');
		$this->assertEqual('000',$response);
	}
	
	function test_simple_forceCapture_with_token()
	{
		$hash_in = array(
		'merchantId' => '101',
      'version'=>'8.8',
      'reportGroup'=>'Planets',
      'litleTxnId'=>'123456',
      'orderId'=>'12344',
      'amount'=>'106',
      'orderSource'=>'ecommerce',
      'token'=> array(
      'litleToken'=>'123456789101112',
      'expDate'=>'1210',
      'cardValidationNum'=>'555',
      'type'=>'VI'
		));
	
		$initilaize = &new LitleOnlineRequest();
		$forceCaptureResponse = $initilaize->forceCaptureRequest($hash_in);
		$message = XMLParser::get_attribute($forceCaptureResponse,'litleOnlineResponse','message');
		$this->assertEqual('Valid Format',$message);
	}
	
	

}
