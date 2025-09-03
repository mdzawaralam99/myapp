<?php
namespace App\Helpers;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
class ApiResponseHelper
{
    /**
     * Success JSON
     */
    public static function success($data=[], $message='Success', $statusCode=200, $meta=[]){
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
            'meta' => !empty($meta) ? $meta : null,
            'timestamp' => Carbon::now()->toIsoString(),  
        ], $statusCode);
    }

    /**
     *  Error JSON response
     */

public static function error($message='Error', $statusCode=400, $data=[], $meta=[]){
        return response()->json([
            'success' =>false,
            'data' => $data,
            'message' => $message,
            'meta' => !empty($meta) ? $meta : null,
            'timestamp'=> Carbon::now()->toIsoString()
        ], $statusCode);
}

/**
     * Paginated JSON response
     */
    public static function paginated(LengthAwarePaginator $paginator, $message = 'Success', $statusCode = 200, $extraMeta = [])
    {
        return response()->json([
            'success' => true,
            'data' => $paginator->items(),
            'message' => $message,
            'meta' => array_merge([
                'currentPage' => $paginator->currentPage(),
                'perPage' => $paginator->perPage(),
                'total' => $paginator->total(),
                'lastPage' => $paginator->lastPage(),
                'hasMorePages' => $paginator->hasMorePages()
            ], $extraMeta),
            'timestamp' => Carbon::now()->toISOString()
        ], $statusCode);
    }

}