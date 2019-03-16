<?php

namespace App\Traits;

use Laravel\Lumen\Http\ResponseFactory;

trait ControllerHelper
{
    /**
     * Return json
     *
     * @param array $data
     * @return ResponseFactory
     */
    private function json(array $data, int $status = 200)
    {
        return (new ResponseFactory)->json($data, $status);
    }
}