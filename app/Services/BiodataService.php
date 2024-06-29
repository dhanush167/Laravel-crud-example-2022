<?php

namespace App\Services;

use App\Http\Traits\AgeCategory;
use App\Models\Biodata;
use Carbon\Carbon;

class BiodataService
{
    use AgeCategory;

    private $Infant;
    private $Toddler;
    private $Preschooler;
    private $Child;
    private $Teenager_or_Adolescent;
    private $Young_adult;
    private $Middle_aged_adult;
    private $Senior_citizen_Elderly;

    public function __construct(
        int $Infant,
        int $Toddler,
        int $Preschooler,
        int $Child,
        int $Teenager_or_Adolescent,
        int $Young_adult,
        int $Middle_aged_adult,
        int $Senior_citizen_Elderly
    )
    {
        $this->Infant = $Infant;
        $this->Toddler = $Toddler;
        $this->Preschooler = $Preschooler;
        $this->Child = $Child;
        $this->Teenager_or_Adolescent = $Teenager_or_Adolescent;
        $this->Young_adult = $Young_adult;
        $this->Middle_aged_adult = $Middle_aged_adult;
        $this->Senior_citizen_Elderly = $Senior_citizen_Elderly;
    }

    public function show_all_biodata()
    {
        $biodatas = Biodata::latest()->paginate(5);
        return $biodatas;
    }

    public function save_data_for_database(
        $first_name,
        $last_name,
        $image,
        $date_of_birth
    )
    {
        $dateOfBirth = Carbon::parse($date_of_birth);
        $age = $dateOfBirth->age;
        $category = $this->age_limit_and_category(
            $this->Infant,
            $this->Toddler,
            $this->Preschooler,
            $this->Child,
            $this->Teenager_or_Adolescent,
            $this->Young_adult,
            $this->Middle_aged_adult,
            $this->Senior_citizen_Elderly,
            $age
        );

        $image_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $image_name);

        $form_data = $this->form_array($first_name, $last_name, $image_name, $age, $category, $date_of_birth);

        Biodata::create($form_data);
    }

    public function edit_biodata(
        $hiddenimage,
        $image_file,
        $validation,
        $first_name,
        $last_name,
        $date_of_birth,
        $id
    )
    {
        $image_name = $hiddenimage;
        $image = $image_file;

        if ($image != '') {
            $validation;
            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $image_name);
        } else {
            $validation;
        }

        $dateOfBirth = Carbon::parse($date_of_birth);
        $age = $dateOfBirth->age;
        $category = $this->age_limit_and_category(
            $this->Infant,
            $this->Toddler,
            $this->Preschooler,
            $this->Child,
            $this->Teenager_or_Adolescent,
            $this->Young_adult,
            $this->Middle_aged_adult,
            $this->Senior_citizen_Elderly,
            $age
        );

        $form_data = $this->form_array($first_name, $last_name, $image_name, $age, $category, $date_of_birth);

        Biodata::whereId($id)->update($form_data);
    }

    public function biodata_destroy($id)
    {
        $biodata = Biodata::find($id);
        $biodata->delete();
    }

    private function form_array(
        $first_name,
        $last_name,
        $image_name,
        $age,
        $category,
        $date_of_birth
    )
    {
        $form_data = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'image' => $image_name,
            'age' => $age,
            'category' => $category,
            'date_of_birth' => Carbon::parse($date_of_birth)->toDateString(),
        );

        return $form_data;
    }
}
