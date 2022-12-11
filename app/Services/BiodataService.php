<?php

namespace App\Services;

use App\Models\Biodata;

class BiodataService
{
      public function show_all_biodata()
      {
          $biodatas = Biodata::latest()->paginate(5);
          return $biodatas;
      }

      public function save_data_for_database(
          $first_name,
          $last_name,$image
      )
      {

          $image_name=rand().'.'.$image->getClientOriginalExtension();

          $image->move(public_path('images'),$image_name);


          $form_data = $this->form_array($first_name,$last_name,$image_name);

          Biodata::create($form_data);

      }

      public function edit_biodata(
          $hiddenimage,
          $image_file,
          $validation,
          $first_name,
          $last_name,
          $id)
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

          $form_data = $this->form_array($first_name,$last_name,$image_name);

          Biodata::whereId($id)->update($form_data);


      }

     public function biodata_destroy($id)
     {
         $biodata=Biodata::find($id);
         $biodata->delete();
     }

    private function form_array(
        $first_name,
        $last_name,
        $image_name
    )
    {
        $form_data = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'image' => $image_name
        );

        return $form_data;
    }


}
