<?php
if (!function_exists('api_response')) {
	function api_response($code, $message = '', $data = null, $success = null) {
		if($success == null) $success = $code < 300;
		$response = [
			'success' => $success,
			'message' => $message,
			'code' => $code,
		];
		if(is_array($data)) $response['data'] = $data;
		
		return response()->json($response, $code);
	}
}