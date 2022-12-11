
## About Laravel

<p>
  php artisan make:model Biodata --all
</p>

<p>pagination generate</p>

```

php artisan vendor:publish --tag=laravel-pagination

```


<hr>

<p> store method validation file (authorize function change to true)</p>


```php

  <?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBiodataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /*need change true*/
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'=>'required',
            'last_name'=>'required',
            'image'=>'required|image|max:2048'
        ];
    }
}

```

<p>update method validation file</p>

```php

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBiodataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if ($this->attributes->get('image')) {
            return [
                'first_name' => 'required',
                'last_name' => 'required',
                'image' => 'required|image|max:2048'
            ];
        } else {
            return [
                'first_name' => 'required',
                'last_name' => 'required',
            ];
        }


    }
}



```

<p>BiodataController.php file</p>

```php

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBiodataRequest;
use App\Http\Requests\UpdateBiodataRequest;
use App\Models\Biodata;
use App\Services\BiodataService;
use Illuminate\Http\Request;

class BiodataController extends Controller
{

    public function index(BiodataService $data)
    {
        return view('biodata.index',['biodatas'=>$data->show_all_biodata()]);
    }


    public function create()
    {
       return view('biodata.create');
    }


    public function store(StoreBiodataRequest $request, BiodataService $data)
    {

        $request->validated();

        $data->save_data_for_database(
             $request->first_name,
             $request->last_name,
             $request->image,
        );

        return redirect()->route('biodata.index')
            ->with('success','New Biodata created success full');

    }

    public function show(Biodata $biodata)
    {
        //
    }


    public function edit($id)
    {
        return view('biodata.edit',['biodata'=>Biodata::find($id)]);
    }


    public function update(UpdateBiodataRequest $request,BiodataService $data,$id)
    {
    
        $request->validated();


        $data->edit_biodata(
            $request->hidden_image,
            $request->file('image'),
            $request->validated(),
            $request->first_name,
            $request->last_name,
            $id,
        );

        return redirect()->route('biodata.index')
            ->with('success', 'success fully update data');

    }


    public function destroy(BiodataService $data,$id)
    {

        $data->biodata_destroy($id);

        return redirect()->route('biodata.index')
            ->with('success','Bio data deleted');
    }
}



```

```php

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


```


