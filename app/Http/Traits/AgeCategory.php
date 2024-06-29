<?php

namespace App\Http\Traits;

trait AgeCategory
{
    public function age_limit_and_category(
        $Infant,
        $Toddler,
        $Preschooler,
        $Child,
        $Teenager_or_Adolescent,
        $Young_adult,
        $Middle_aged_adult,
        $Senior_citizen_Elderly,
        $age
    ) {
        $categories = [
            ["Infant", $Infant],
            ["Toddler", $Toddler],
            ["Preschooler", $Preschooler],
            ["Child", $Child],
            ["Teenager or Adolescent", $Teenager_or_Adolescent],
            ["Young adult", $Young_adult],
            ["Middle aged adult", $Middle_aged_adult],
            ["Senior citizen Elderly", $Senior_citizen_Elderly],
        ];
        foreach ($categories as $category) {
            if ($age <= $category[1]) {
                return $category[0];
            }
        }
        return "Category not found";
    }
}
