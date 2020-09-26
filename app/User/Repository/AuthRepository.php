<?php

namespace App\User\Repository;
use App\User\Repository\AuthRepositoryInterface;
use DB;

class AuthRepository implements AuthRepositoryInterface
{


    public function store($model)
    {
        
        try {
            $result = DB::transaction(function () use ($model) {
                $model->save();
                return [
                    'message' => "SUCCESS",
                    'data' => $model
                ];
            });

            return $result;
        } catch (\Exception $e) {
          
            return [
                'message' => "FAILED",
                'data' => $e
            ];
        }
    }
}
