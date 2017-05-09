<?php
/**
 * Created by PhpStorm.
 * User: bri
 * Date: 27-Dec-16
 * Time: 20:04
 */

namespace App\Models\Fatcha\Helpers;


class DifficultyLevel {

    const weightingArray = [
         [
            'name' => 'hard',
            'level' =>  3,
            'less_than' => 0.3
        ],
         [
            'name' => 'medium',
            'level' =>  2,
            'less_than' => 0.8
        ],
         [
            'name' => 'easy',
            'level' =>  1,
            'less_than' => 1
        ]
    ];

    public static function getLevel($rate){
        $weightingArray = self::weightingArray;
        for($i = 0; $i< count($weightingArray); $i++ ){
            if($rate <= $weightingArray[$i]['less_than']){
                return $weightingArray[$i]['level'];
            }
        }
        return $weightingArray[count($weightingArray)-1]['level'];

    }

}