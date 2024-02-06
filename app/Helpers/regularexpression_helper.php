<?php

if (!function_exists('removeSpecialCharinString')) {
	function removeSpecialCharinString(string $chaine)
	{
		$pattern = '/(\W+)/i';
		$replacement = time();
		return preg_replace($pattern, $replacement, $chaine);
	}
}


if (!function_exists('base64decodeImage')) {
	function base64decodeImage($codeImageParam)
	{
		$codeimageBase64 =  $codeImageParam;
		//test if is endode 64
		if ($codeImageParam != '' && substr($codeImageParam, 0, (strlen('data:image'))) == 'data:image') {
			//get mime type
			$pos  = strpos($codeImageParam, ';');
			$mimetype = explode(':', substr($codeImageParam, 0, $pos))[1];
			//get extension image
			$extension = explode('/', $mimetype)[1];
			//get code image
			$posimg  = strpos($codeImageParam, ',');
			$codeimageBase64 = substr($codeImageParam, ($posimg + 1));
			$imageDecode = base64_decode($codeimageBase64);
		}
		return $codeimageBase64;
		//save image
		//Path where to save image
		//$path = "images/";
		//$file = $path . time() . '.' . $extension;
		//file_put_contents($file, $imageDecode);
	}
}

if (!function_exists('convertToFrenchFormatDate')) {
	function convertToFrenchFormatDate($paramValue, $formatdate = 'fr', $separatordate = '/')
	{
		$result = false;
		$array_times = array();
		$hour_minute_second = '';
		if (!empty($paramValue)) {

			$array_dateandtime = explode(' ', $paramValue);
			if (count($array_dateandtime) == 2) {
				$paramValue = $array_dateandtime[0];
				$array_time = explode(':', $array_dateandtime[1]);
				if (count($array_time) > 1) {
					$hour_minute_second = $array_time[0] . ':' . $array_time[1];
				}
			}

			$array_timeslash = explode('/', $paramValue);
			$array_timedash = explode('-', $paramValue);
			if (count($array_timeslash) == 3) {
				$array_times = $array_timeslash;
			} elseif (count($array_timedash) == 3) {
				$array_times = $array_timedash;
			}

			if (!empty($array_times) && count($array_times) == 3) {
				//test case jj/mm/aaaa
				$format1_size_jj = strlen($array_times[0]);
				$format1_size_mm = strlen($array_times[1]);
				$format1_size_aaaa = strlen($array_times[2]);
				$format1_value_jj = $array_times[0];
				$format1_value_mm = $array_times[1];
				$format1_value_aaaa = $array_times[2];
				//test case aaaa/mm/jj
				$format2_size_jj = strlen($array_times[2]);
				$format2_size_mm = strlen($array_times[1]);
				$format2_size_aaaa = strlen($array_times[0]);
				$format2_value_jj = $array_times[2];
				$format2_value_mm = $array_times[1];
				$format2_value_aaaa = $array_times[0];
				if (($format1_size_jj == 1 || $format1_size_jj == 2) && ($format1_size_mm == 1 || $format1_size_mm == 2) && $format1_size_aaaa > 3 && test_is_integer($format1_value_jj) && test_is_integer($format1_value_mm) && test_is_integer($format1_value_aaaa)) {
					$result =  $format1_value_aaaa . '-' . substr('0' . $format1_value_mm, -2) . '-' . substr('0' . $format1_value_jj, -2); //1999-01-08	ISO-8601 ; 8 janvier, quel que soit le mode (format recommandé dans postgresql)
				} elseif (($format2_size_jj == 1 || $format2_size_jj == 2) && ($format2_size_mm == 1 || $format2_size_mm == 2) && $format2_size_aaaa > 3 && test_is_integer($format2_value_jj) && test_is_integer($format2_value_mm) && test_is_integer($format2_value_aaaa)) {
					$result =  $format2_value_aaaa . '-' . substr('0' . $format2_value_mm, -2) . '-' . substr('0' . $format2_value_jj, -2); //1999-01-08	ISO-8601 ; 8 janvier, quel que soit le mode (format recommandé dans postgresql)
				}

				if (strtolower($formatdate) == strtolower('fr')) {
					$tb_result = explode('-', $result);
					$tmp_year = $tb_result[0];
					$tb_result[0] = $tb_result[2];
					$tb_result[2] = $tmp_year;
					$result = implode($separatordate, $tb_result);
				} else {
					$tb_result = explode('-', $result);
					$result = $tb_result[0] . $separatordate . $tb_result[1] . $separatordate . $tb_result[2];
				}
			}
		}
		return (empty($hour_minute_second)) ? $result : $result . ' ' . $hour_minute_second;
	}

	function test_is_integer($chaine)
	{
		$result = true;
		if (!is_null($chaine) && !is_array($chaine)) {
			if (!is_int($chaine)) {
				for ($i = 0; $i < strlen($chaine); $i++) {
					$result = (is_numeric($chaine[$i])) ? $result : false;
				}
			}
		} else {
			$result = false;
		}
		return $result;
	}
}

if (!function_exists('makeNewDate')) {
	function  makeNewDate($action, $date, $number_days)
	{
		$date1 = convertToFrenchFormatDate($date, 'fr', '-');
		$tb_date1 = explode('-', $date1);
		$hour = 0;
		$minute = 0;
		$second = 0;
		$month = $tb_date1[1];
		$day = $tb_date1[0];
		$year = $tb_date1[2];
		$timestamp1 = mktime($hour, $minute, $second, $month, $day, $year);
		if ($action == 'add' || $action == '+') {
			$timestamp1 = $timestamp1 + getTimeStampNumberOfDays($number_days);
		} elseif ('remove' || $action == '-') {
			$timestamp1 = $timestamp1 - getTimeStampNumberOfDays($number_days);
		}
		return date('d/m/Y', $timestamp1);
	}
}

if (!function_exists('getTimeStampDate')) {
	function  getTimeStampDate($date)
	{
		$result = 0;
		if (!empty($date)) {
			$date1 = convertToFrenchFormatDate($date, 'en', '-');
			$result = strtotime($date1);
		}
		return $result;
	}
}

if (!function_exists('getTimeStampNumberOfDays')) {
	function  getTimeStampNumberOfDays($number_days)
	{
		$result = 0;
		if (!empty($number_days)) {
			$result = intval($number_days) * 60 * 60 * 24;
		}
		return $result;
	}
}

if (!function_exists('getNumberOfDays')) {
	function  getNumberOfDays($timeStampDate)
	{
		$result = 0;
		if (!empty($timeStampDate)) {
			$result = intval($timeStampDate) / (60 * 60 * 24);
		}
		return $result;
	}
}
