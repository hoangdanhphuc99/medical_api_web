<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser
{

	protected function successResponse($data = [], $message = "Thành công", $code = 200)
	{
		return response()->json([
			'msg_code' => 'SUCCESS',
			'msg' => $message == null ? "Thành công" : $message,
			'data' => $data,
			"success" => true,
			"code" => $code

		], $code);
	}

	protected function errorResponse($message = null, $code = 401)
	{
		return response()->json([
			'msg_code' => 'ERROR',
			'msg' => $message,
			'data' => [],
			"success" => false,
			"code" => $code
		], $code);
	}
}
