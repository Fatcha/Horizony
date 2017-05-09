<?php

/**
 * Created by PhpStorm.
 * User: bri
 * Date: 02-Oct-16
 * Time: 08:21
 */
namespace  App\Models\Fatcha\Helpers;
use Illuminate\Support\Facades\DB;
class DBHelper
{
    public static function getEnumValues($table, $column) {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM $table WHERE Field = '{$column}'"))[0]->Type ;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach( explode(',', $matches[1]) as $value )
        {
            $v = trim( $value, "'" );
            $enum = array_add($enum, $v, $v);
        }
        return $enum;
    }

}