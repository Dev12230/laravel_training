<?php

namespace App\Traits;

use App\News;
use App\Event;
use App\Staff;
use App\Visitor;

trait ModelInstance
{
    private $classes;

    public function __construct()
    {
        $this->classes =[
            News::class =>'news',
            Event::class =>'event',
            Staff::class => 'staff',
            Visitor::class =>'visitors',
        ];
    }

    /**
     * Get model class from model name
     * @param $request
     * @return class
    */
    public function getClass($request)
    {
        $class=array_search($this->getModelName($request), $this->classes);
        return $class;
    }

    /**
     * Get model name from request path
     * @param $request
     * @return name of model
    */
    public function getModelName($request)
    {
        $url=$request->getPathInfo();
        $model_name = explode('/', $url)[1];
        return $model_name;
    }
}
