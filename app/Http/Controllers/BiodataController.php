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
