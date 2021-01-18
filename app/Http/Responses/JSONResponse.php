<?php
namespace App\Http\Responses;

use Illuminate\Http\Response;

/**
 * Custom response class
 * 
 */
class JSONResponse {

    /**
     * Send response to the client
     *
     * @param [array] $data
     * @param [int] $code
     * @return Response
     */
    static public function send(array $data, int $code = 200): Response {
        $instance = new self();
        return Response($instance->transform($data, $code), $code);
    }

    /**
     * Transform response
     *
     * @return Array
     */
    public function transform(array $data, int $code): Array {
        $response = [
            'status' => $code,
            'data' => $data
        ];

        return $response;
    }

}