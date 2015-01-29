<?php
class streamsend extends CActiveRecordBehavior {
	function SendRequest($SRrequest, $SRcustreq, $SRurl) { 
		$user_agent = "Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.1)";
		$url = ("https://app.streamsend.com/" . $SRurl);
	
		$headers = array(
		'Accept: application/xml',
		'Content-Type: application/xml');
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		# AUTHENTICATION
		curl_setopt($ch, CURLOPT_USERPWD, "fpIQpW3ib8BV:jIa8EHPorhNHA3vb");
		# PASSING DATA
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $SRcustreq); 
		if ($SRrequest != ""){ curl_setopt($ch, CURLOPT_POSTFIELDS, $SRrequest); } # the result of curl_exec is the actual data instead of a boolean
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		
		//RESPONSE PARSING
		# get the HTTP status code for our session
		$http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		# return all options into an associative array
		$info = curl_getinfo($ch);
		
		# get the HTTP status code for our session $info['http_code'];
		
		// Send Request
		$response = curl_exec($ch);
		
		if (curl_errno($ch)) {
		print "<br />curl_error($ch)";
		} else
		{
		#returns <xml>...</xml>
		print "<br />$response";
		}
		
		// Close Connection Handle
		curl_close ($ch);
	}
}
?>