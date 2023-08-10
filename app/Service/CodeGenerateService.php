<?php

namespace App\Service;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Interface\CodeGenerateInterface;

class CodeGenerateService implements CodeGenerateInterface
{
    public function productCategoryCode($tableName)
    {
        $nameArr = explode("_",$tableName);

        $prefix = '';

        foreach($nameArr as $key=> $name)
        {
            $prefix = $prefix . strtoupper(substr($name,0,3));

            if($key < count($nameArr) - 1){
                $prefix = $prefix . '_';
            }
        }

        $lastRecord = DB::table($tableName)->orderBy('id', 'DESC')->first();

        $last_id = '';

        if (isset($lastRecord)){
            $last_id = $lastRecord->id;
        }else{
            $last_id = 1;
        }

        $code = $prefix . '-' . $last_id + 1;

        return $code;
    }
}
