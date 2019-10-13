<?php

namespace App\Traits;
 
trait toggle
{
    public function publish($model)
    {
        $model->is_publish = !$model->is_publish;
        $model->save();
    }

    public function active($model)
    {
        $model->active = !$model->active;
        $model->save();
    }

 

}