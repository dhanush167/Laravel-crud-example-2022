
##  Laravel crud example

![Project Complete](https://img.shields.io/badge/Status-Project%20Complete-brightgreen)




```
 php artisan make:model Biodata --all
```

<p>pagination generate</p>

```

php artisan vendor:publish --tag=laravel-pagination

```

![img](https://github.com/dhanush167/Laravel-crud-example-2022/assets/37043938/2d4a0474-827e-40a1-b109-e1e3d6a2f7ed)


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
            'first_name' => 'required|max:255|string|min:3',
            'last_name' => 'required|max:255|string|min:3',
            'image' => 'required|mimes:svg,jpeg,png,jpg|image|max:2048',
            'date_of_birth' => 'required|date|after:11/01/1920',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First Name is required !',
            'last_name.required' => 'Last Name is required !',
            'image.required' => 'Image is required !',
            'age.required' => 'Age is required !'
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'first_name' => 'trim|capitalize|escape',
            'last_name' => 'trim|capitalize|escape'
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
                'first_name' => 'required|max:255|string|min:3',
                'last_name' => 'required|max:255|string|min:3',
                'image' => 'required|mimes:svg,jpeg,png,jpg|image|max:2048',
                'date_of_birth'=>'required|date|after:11/01/1925',
            ];
        } else {
            return [
                'first_name' => 'required|max:255|string|min:3',
                'last_name' => 'required|max:255|string|min:3',
                'date_of_birth'=>'required|date|after:11/01/1925',
            ];
        }


    }

    public function messages()
    {
        return [
            'first_name.required' => 'First Name is required !',
            'last_name.required' => 'Last Name is required !',
            'image.required' => 'Image is required !',
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'first_name' => 'trim|capitalize|escape',
            'last_name' => 'trim|capitalize|escape'
        ];
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
        return view('biodata.index', ['biodatas' => $data->show_all_biodata()]);
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
            $request->date_of_birth
        );

        return redirect()->route('biodata.index')
            ->with('success', 'New biodata created successfully');
    }

    public function edit($id)
    {
        return view('biodata.edit', ['biodata' => Biodata::find($id)]);
    }

    public function update(UpdateBiodataRequest $request, BiodataService $data, $id)
    {
        $data->edit_biodata(
            $request->hidden_image,
            $request->file('image'),
            $request->validated(),
            $request->first_name,
            $request->last_name,
            $request->date_of_birth,
            $id
        );

        return redirect()->route('biodata.index')
            ->with('success', 'Successfully update data');
    }

    public function destroy(BiodataService $data, $id)
    {
        $data->biodata_destroy($id);

        return redirect()->route('biodata.index')
            ->with('success', 'Bio data deleted');
    }
}

```

<p>
app/Services/BiodataService.php
</p>

```php

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

```

<p>AppServiceProvider.php</p>

```php

<?php

namespace App\Providers;

use App\Services\BiodataService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(BiodataService::class,function ($app){
            return new BiodataService(
                config('custom.infant'),
                config('custom.toddler'),
                config('custom.preschooler'),
                config('custom.child'),
                config('custom.teenager_or_adolescent'),
                config('custom.young_adult'),
                config('custom.middle_aged_adult'),
                config('custom.senior_citizen_elderly')
            );
        });
    }
}

```
<p> Traits </p>

```php

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


```















