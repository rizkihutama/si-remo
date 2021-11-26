<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class DriverController extends Controller
{
    protected $htmlbuilder;

    public function __construct(Builder $htmlbuilder)
    {
        $this->htmlbuilder = $htmlbuilder;
    }

    private function validateClass(Request $request, $driver = null)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('drivers', 'email')->ignore($driver, 'driver_id'),
            ],
            'phone' => 'required|numeric|digits_between:10,13',
            'nik' => 'required|numeric|digits:16',
            'license' => 'required|numeric|digits_between:12,15',
            'status' => 'required',
            'address' => 'required',
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
            $data = Driver::all();
            $datatables = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $showRoute = route('admin.drivers.show', ['driver' => $row]);
                    $editRoute = route('admin.drivers.edit', ['driver' => $row]);
                    $deleteRoute = route('admin.drivers.destroy', ['driver' => $row]);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');
                    $btn = "<div class='d-flex'>
                                <a href='{$showRoute}' class='btn btn-icon btn-info btn-sm mr-2' title='Detail'>
                                    <i class='far fa-eye icon-nm'></i>
                                </a>
                                <a href='{$editRoute}' class='btn btn-icon btn-primary btn-sm mr-2' title='Edit'>
                                    <i class='far fa-edit icon-nm'></i>
                                </a>
                                <form action='{$deleteRoute}' method='POST' class='delete-form'>{$csrf}{$method}
                                    <button class='btn btn-icon btn-danger btn-sm' title='Delete' onclick=\"return deleteAlert(event) \">
                                        <i class='far fa-trash-alt icon-nm'></i>
                                    </button>
                            </div>";

                    return $btn;
                })
                ->editColumn('status', function ($row) {
                    return $row->getStatusBadgeLabelAttribute();
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
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => 'Driver Name'])
            ->addColumn(['data' => 'phone', 'name' => 'phone', 'title' => 'Driver Phone'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => 'Driver Status'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Aksi', 'orderable' => false, 'searchable' => false, 'width' => 100, 'exportable' => false]);

        return view('admin.driver.index', compact('dataTable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusLabels = Driver::statusLabels();
        return view('admin.driver.create', compact('statusLabels'));
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
            $driver = new Driver;
            $driver->fill($validate);
            $driver->save();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage() . ' at line ' . $e->getLine() . ' in ' . $e->getFile());
        }

        return redirect()->route('admin.drivers.index')->with('success', 'Driver Success Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Driver $driver)
    {
        return view('admin.driver.show', compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit(Driver $driver)
    {
        $statusLabels = Driver::statusLabels();
        return view('admin.driver.edit', compact('driver', 'statusLabels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Driver $driver)
    {
        $validate = $this->validateClass($request, $driver);

        DB::beginTransaction();
        try {
            $driver->fill($validate);
            $driver->save();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage() . ' at line ' . $e->getLine() . ' in ' . $e->getFile());
        }

        return redirect()->route('admin.drivers.index')->with('success', 'Driver Success Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Driver $driver)
    {
        try {
            $driver->delete();
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage() . ' at line ' . $e->getLine() . ' in ' . $e->getFile());
        }
        return redirect()->route('admin.drivers.index')->with('success', 'Driver Success Deleted');
    }
}
