<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Validation\Rule;

class CarController extends Controller
{
    protected $htmlbuilder;

    public function __construct(Builder $htmlbuilder)
    {
        $this->htmlbuilder = $htmlbuilder;
    }

    private function validateClass(Request $request, $car = null)
    {
        return $request->validate([
            'brand_id' => 'required|numeric',
            'model_id' => 'required|numeric',
            'year' => 'required|numeric|digits:4',
            // 'image' => 'required|file|size:2048|mimes:jpg,jpeg,bmp,png,gif,svg,webp,doc,docx,xls,pdf,xlsx',
            'status' => 'required|numeric',
            'image' => [
                'image',
                'max:2048',
                Rule::requiredIf(!$car || $car->car_id == null),
            ],
            'seats' => 'required|numeric',
            'luggage' => 'required|numeric',
            'cc' => 'required|numeric',
            'number_plates' => [
                'required',
                'string',
                Rule::unique('cars')->ignore($car, 'car_id'),
            ],
            'price' => 'required|numeric',
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
            $data = Car::all();
            $datatables = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $showRoute = route('admin.cars.show', ['car' => $row]);
                    $editRoute = route('admin.cars.edit', ['car' => $row]);
                    $deleteRoute = route('admin.cars.destroy', ['car' => $row]);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');
                    $btn = "<div class='d-flex'>
                                <a href='{$showRoute}' class='btn btn-icon btn-info btn-sm mr-2' title='Detail'>
                                    <i class='far fa-eye icon-nm'></i>
                                </a>
                                <a href='{$editRoute}' class='btn btn-icon btn-primary btn-sm mr-2' title='Edit'>
                                    <i class='far fa-edit icon-nm'></i>
                                </a>
                                <form method='POST' action='{$deleteRoute}' class='delete-form'>{$csrf}{$method}
                                    <button class='btn btn-icon btn-danger btn-sm' title='Delete' onclick=\"return deleteAlert(event)\">
                                        <i class='far fa-trash-alt icon-nm'></i>
                                    </button>
                                </form>
                            </div>";

                    return $btn;
                })
                ->editColumn('status', function ($row) {
                    return $row->getStatusBadgeLabelAttribute();
                })
                ->editColumn('number_plates', function ($row) {
                    return Car::getNumberPlates($row->number_plates);
                })
                ->editColumn('price', function ($row) {
                    return Car::rupiah($row->price);
                })
                ->rawColumns(['status', 'action']);
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
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => 'Car Name'])
            ->addColumn(['data' => 'seats', 'name' => 'seats', 'title' => 'Seats'])
            ->addColumn(['data' => 'luggage', 'name' => 'luggage', 'title' => 'Luggage'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => 'Status'])
            ->addColumn(['data' => 'number_plates', 'name' => 'number_plates', 'title' => 'Number Plates'])
            ->addColumn(['data' => 'price', 'name' => 'price', 'title' => 'Price'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Aksi', 'orderable' => false, 'searchable' => false, 'width' => 100, 'exportable' => false]);

        return view('admin.car.index', compact('dataTable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = CarBrand::pluck('brand_name', 'brand_id');
        $models = CarModel::pluck('model_name', 'model_id');
        $status = Car::statusLabels();

        return view('admin.car.create', compact('brands', 'models', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $this->validateClass($request);

        DB::beginTransaction();
        try {
            $car = new Car;
            $car->fill($request->all());

            $brandName = CarBrand::findOrFail($request->brand_id)->brand_name;
            $modelName = CarModel::findOrFail($request->model_id)->model_name;
            $carName = $brandName . ' ' . $modelName . ' ' . $request->year;

            $car->name = $carName;
            $imageName = FileHelper::upload($request->file('image'), Car::getImgPath());
            $car->image = $imageName;
            $car->save();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            return Redirect::back()->with('error', $e->getMessage() . ' : ' . $e->getLine());
        }

        return redirect()->route('admin.cars.index')->with('success', 'Car Added Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        $brands = CarBrand::pluck('brand_name', 'brand_id');
        $models = CarModel::pluck('model_name', 'model_id');
        $status = Car::statusLabels();
        $path = Car::getImgUrl($car->image);
        $price = Car::rupiah($car->price);

        return view(
            'admin.car.show',
            compact(
                'car',
                'brands',
                'models',
                'status',
                'path',
                'price',
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        $brands = CarBrand::pluck('brand_name', 'brand_id');
        $models = CarModel::pluck('model_name', 'model_id');
        $status = Car::statusLabels();
        $path = Car::getImgUrl($car->image);

        return view(
            'admin.car.edit',
            compact(
                'car',
                'brands',
                'models',
                'status',
                'path'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
        $validate = $this->validateClass($request, $car);

        DB::beginTransaction();
        try {
            $oldFile = $car->image;

            if (!empty($request->file('image'))) {
                //* hapus old file
                FileHelper::delete(Car::getImgPath() . $oldFile);
                //* Get New File Name
                $newFile = FileHelper::upload($request->file('image'), Car::getImgPath());
            }

            $car->fill($request->all());
            $brandName = CarBrand::findOrFail($request->brand_id)->brand_name;
            $modelName = CarModel::findOrFail($request->model_id)->model_name;
            $carName = $brandName . ' ' . $modelName . ' ' . $request->year;

            $car->name = $carName;
            $car->image = $newFile ?? $oldFile;
            $car->save();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            return Redirect::back()->with('error', $e->getMessage() . ' : ' . $e->getLine());
        }

        return redirect()->route('admin.cars.index')->with('success', 'Car Updated Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        DB::beginTransaction();
        try {
            $car->delete();
            FileHelper::delete($car->image);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            return Redirect::back()->with('error', $e->getMessage() . ' : ' . $e->getLine());
        }

        return redirect()->route('admin.cars.index')->with('success', 'Car Deleted Success');
    }
}
