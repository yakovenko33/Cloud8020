<?php


namespace CarPark\CommonModule\UI\Response;


use CarPark\CommonModule\Bus\Handler\ResultHandlerInterface;
use \Illuminate\Http\JsonResponse;

trait Response
{
    /**
     * @param ResultHandlerInterface $resultHandler
     * @return JsonResponse
     */
    protected function getResponse(ResultHandlerInterface $resultHandler): JsonResponse
    {
        $hasErrors = $resultHandler->hasErrors();

        return response()->json([
            "data" => $hasErrors ? [] : $resultHandler->getResult(),
            "errors" => $hasErrors ? $resultHandler->getErrors() : [],
            'status' => $hasErrors ? 'errors' : 'success'
        ], $resultHandler->getStatusCode());
    }
}
