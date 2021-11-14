<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class CarModelController extends Controller
{
    protected $htmlbuilder;

    public function __construct(Builder $htmlbuilder)
    {
        $this->htmlbuilder = $htmlbuilder;
    }

    private function validateClass(Request $request)
    {
        return $request->validate([
            'brand_id' => 'required',
            'model_name' => 'required'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CarModel::all();
            $datatables = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editRoute = route('admin.car-models.edit', ['car_model' => $row]);
                    $showRoute = route('admin.car-models.show', ['car_model' => $row]);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');
                    $btn = "<div class='d-flex'>
                                <a href='{$showRoute}' class='btn btn-icon btn-info btn-sm mr-2' title='Detail'>
                                    <i class='far fa-eye icon-nm'></i>
                                </a>
                                <a href='{$editRoute}' class='btn btn-icon btn-primary btn-sm mr-2' title='Edit'>
                                    <i class='far fa-edit icon-nm'></i>
                                </a>
                            </div>";

                    return $btn;
                })
                ->editColumn('brand_id', function ($row) {
                    return $row->carBrand->brand_name;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }

        $dataTable = $this->htmlbuilder
            ->parameters([
                'paging' => true,
                'searching' => true,
                'info' => true,
                'searchDelay' => 350,
                // 'dom' => 'lBfrtip',
                'buttons' => [
                    'excelHtml5',
                    'pdfHtml5',
                    'print',
                ],
                'language' => [
                    'emptyTable' => 'Tidak Ada Data',
                    'zeroRecords' => 'Hasil Pencarian Tidak Ditemukan',
                ],
                'order' => [2, 'asc'],
                'responsive' => true,
            ])
            ->addColumn(['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '#', 'orderable' => false, 'searchable' => false, 'width' => 30])
            ->addColumn(['data' => 'model_name', 'name' => 'model_name', 'title' => 'Model'])
            ->addColumn(['data' => 'brand_id', 'name' => 'brand_id', 'title' => 'Brand'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Aksi', 'orderable' => false, 'searchable' => false, 'width' => 100, 'exportable' => false]);

        return view('admin.car-model.index', compact('dataTable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.car-model.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateClass($request);

        DB::beginTransaction();
        try {
            $carModel = new CarModel;
            $carModel->fill($request->all());
            $carModel->save();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            return Redirect::back()->with('error', $e->getMessage() . ' : ' . $e->getLine());
        }

        return redirect()->route('admin.car-models.index')->with('success', 'Model added success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarModel  $carModel
     * @return \Illuminate\Http\Response
     */
    public function show(CarModel $carModel)
    {
        return view('admin.car-model.show', compact('carModel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CarModel  $carModel
     * @return \Illuminate\Http\Response
     */
    public function edit(CarModel $carModel)
    {
        return view('admin.car-model.edit', compact('carModel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarModel  $carModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarModel $carModel)
    {
        $this->validateClass($request);

        DB::beginTransaction();
        try {
            $carModel->fill($request->all());
            $carModel->save();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            return Redirect::back()->with('error', $e->getMessage() . ' : ' . $e->getLine());
        }

        return redirect()->route('admin.car-models.index')->with('success', 'Model updated success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarModel  $carModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarModel $carModel)
    {
        //
    }

    public function dropdown(Request $request)
    {
        $model = CarModel::findByBrandId($request->get('brand_id', null));

        return response($model)->header('Content-Type', 'application/json');
    }
}
