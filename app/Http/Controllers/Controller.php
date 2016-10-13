<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Response
     *
     * @param Request $request
     * @param $view
     * @param array $params
     * @return Response
     */
    public function response($view, array $params = [])
    {
        return $this->callback(function() use ($view, $params){

            return response()->view($view, $params);

        }, function() use ($view, $params){

            return $params;

        });
    }

    /**
     * Anonymous Function (web and json support)
     * * JSON Callback Function MUST return an array
     *
     * @param $callback
     * @param $json_callback
     * @return mixed
     */
    public function callback($callback, $json_callback, $request = null)
    {
        if(!$request){
            $request = $this->request;
        }

        if ($request->getContentType() == 'json' || ($request->ajax() || $request->wantsJson())) {

            return response(json_encode($json_callback()), 200, [
                'Content-Type' => "application/json"
            ]);

        }

        return $callback();
    }

    /**
     * Return Error Array
     *
     * @param null $message
     * @return array
     */
    public function returnErrorArray($message = null)
    {
        if(is_array($message)){
            return array_merge(['error'=>1], $message);
        }

        return [
            'error' => 1,
            'message' => $message
        ];
    }

    /**
     * Return Success Array
     *
     * @param array $params
     * @return mixed
     */
    public function returnSuccessArray(array $params = []){
        return array_merge(['error'=>0], $params);
    }
}
