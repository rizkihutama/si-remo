<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class CarBrandController extends Controller
{
    protected $htmlbuilder;

    public function __construct(Builder $htmlbuilder)
    {
        $this->htmlbuilder = $htmlbuilder;
    }

    private function validateClass(Request $request)
    {
        return $request->validate([
            'brand_name' => 'required',
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
            $data = CarBrand::all();
            $datatables = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editRoute = route('admin.car-brands.edit', ['car_brand' => $row]);
                    $showRoute = route('admin.car-brands.show', ['car_brand' => $row]);
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
            ->addColumn(['data' => 'brand_name', 'name' => 'brand_name', 'title' => 'Brand'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Aksi', 'orderable' => false, 'searchable' => false, 'width' => 100, 'exportable' => false]);

        return view('admin.car-brand.index', compact('dataTable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.car-brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validateClass($request);

        DB::beginTransaction();
        try {
            $carBrand = new CarBrand;
            $carBrand->fill($request->all());
            $carBrand->save();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            return Redirect::back()->with('error', $e->getMessage() . ' : ' . $e->getLine());
        }

        return redirect()->route('admin.car-brands.index')->with('success', 'Brand added success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarBrand  $carBrand
     * @return \Illuminate\Http\Response
     */
    public function show(CarBrand $carBrand)
    {
        return view('admin.car-brand.show', compact('carBrand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CarBrand  $carBrand
     * @return \Illuminate\Http\Response
     */
    public function edit(CarBrand $carBrand)
    {
        return view('admin.car-brand.edit', compact('carBrand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarBrand  $carBrand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarBrand $carBrand)
    {
        $validated = $this->validateClass($request);

        DB::beginTransaction();
        try {
            $carBrand->fill($request->all());
            $carBrand->save();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            return Redirect::back()->with('error', $e->getMessage() . ' : ' . $e->getLine());
        }

        return redirect()->route('admin.car-brands.index')->with('success', 'Brand updated success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarBrand  $carBrand
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarBrand $carBrand)
    {
        //
    }
}
