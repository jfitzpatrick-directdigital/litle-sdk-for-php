<?php

// =begin
// Copyright (c) 2011 Litle & Co.

// Permission is hereby granted, free of charge, to any person
// obtaining a copy of this software and associated documentation
// files (the "Software"), to deal in the Software without
// restriction, including without limitation the rights to use,
// copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the
// Software is furnished to do so, subject to the following
// conditions:

// The above copyright notice and this permission notice shall be
// included in all copies or substantial portions of the Software.

// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
// EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
// OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
// NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
// HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
// WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
// FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
// OTHER DEALINGS IN THE SOFTWARE.
// =end

class Obj2xml {

	public static function toXml($data, $type, $rootNodeName = 'litleOnlineRequest', $xml=null)
	{
		$config = array('user'=>'PHXMLTEST',
								'password' => 'certpass', 
								'merchantId' => '101',
								'version' => '8.10', 
								'reportGroup' => 'planets',
								'id' => '10');
		$xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
		$xml-> addAttribute('version',$config["version"]);
		$xml-> addAttribute('merchantId',$config["merchantId"]);
		$xml-> addAttribute('xmlns:xmlns','http://www.litle.com/schema');// does not show up on browser docs
		$authentication = $xml->addChild('authentication');
		$authentication->addChild('user',$config["user"]);
		$authentication->addChild('password',$config["password"]);
		$transacType = $xml->addChild($type);
		$transacType-> addAttribute('reportGroup',$config["reportGroup"]);
		$transacType-> addAttribute('id',$config["id"]);
		Obj2xml::iterateChildren($data,$transacType);
		return $xml->asXML();
	}
	// loop through the data passed in.
	private function iterateChildren($data,$transacType){
		foreach($data as $key => $value)
		{
			if ($value == "REQUIRED"){
				throw new Exception("Missing Required Field: /$key/");
			}
			elseif ((is_string($value)) || is_numeric($value)) {
				$transacType->addChild($key,$value);
			}
			elseif(is_array($value))
			{
				$node = $transacType->addChild($key);
				Obj2xml::iterateChildren($value,$node);

			}
		}
	}
}

?>
