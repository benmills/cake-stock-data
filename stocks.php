<?php
class StockComponent extends Object {
  function get($symbols = array()) {
		$request ='http://download.finance.yahoo.com/d/quotes.csv?s=';
		foreach ($symbols as $s) $request .= $s.'+';
		$request = substr($request, 0, strlen($request)-1);
		$request .= '&f=sc6b2';
		
	  $ch = curl_init(); 
	  curl_setopt($ch, CURLOPT_URL, $request); 
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	  $output = curl_exec($ch); 
	  curl_close($ch);
	
		$splits = explode("\n", $output);
		$stocks = array();
		foreach($splits as $s) {
			$s_data = explode(',', $s);
			if (strlen($s)>0) {
				$stocks[] = array(
					'symbol' => $s_data[0],
					'change' => $s_data[1],
					'current' => $s_data[2]
				);
			}
		}
		
		return $stocks;
	}
}
?>