<?php

namespace App\Http\Controllers;

use App\Models\CarInAndOut;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class CarInAndOutController extends Controller
{
    protected $htmlbuilder;

    public function __construct(Builder $htmlbuilder)
    {
        $this->htmlbuilder = $htmlbuilder;
    }

    public function validateRequest(Request $request)
    {
        return $request->validate([
            'rent_status' => 'required|numeric',
            'car_out' => 'required|date_format:d/m/Y',
            'car_in' => 'nullable',
            'days_rent' => 'nullable',
            'fine' => 'numeric',
            'fine_status' => 'numeric|required',
        ]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CarInAndOut::all();
            $datatables = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $showRoute = route('admin.car-in-and-out.show', ['car_in_and_out' => $row]);
                    $editRoute = route('admin.car-in-and-out.edit', ['car_in_and_out' => $row]);
                    $btn = "<div class='d-flex'>
                                <a href='{$showRoute}' class='btn btn-icon btn-info btn-sm mr-2' title='Detail'>
                                    <i class='far fa-eye icon-nm'></i>
                                </a>
                                <a href='{$editRoute}' class='btn btn-icon btn-warning btn-sm mr-2' title='Edit'>
                                    <i class='fas fa-edit icon-nm'></i>
                                </a>
                            </div>";

                    return $btn;
                })
                ->editColumn('rent_status', function ($row) {
                    return $row->getRentStatusBadgeLabelAttribute();
                })
                ->editColumn('fine', function ($row) {
                    return $row->getFine();
                })
                ->editColumn('fine_status', function ($row) {
                    return $row->getFineStatusBadgeLabelAttribute();
                })
                ->rawColumns(['rent_status', 'fine_status', 'action']);
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
            ->addColumn(['data' => 'code', 'name' => 'code', 'title' => 'Kode Booking'])
            ->addColumn(['data' => 'rent_status', 'name' => 'rent_status', 'title' => 'Status Sewa'])
            ->addColumn(['data' => 'fine', 'name' => 'fine', 'title' => 'Denda'])
            ->addColumn(['data' => 'fine_status', 'name' => 'fine_status', 'title' => 'Status Denda'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Aksi', 'orderable' => false, 'searchable' => false, 'width' => 100, 'exportable' => false]);

        return view('admin.car-in-and-out.index', compact('dataTable'));
    }

    // public function create()
    // {
    //     //
    // }

    // public function store(Request $request)
    // {
    //     //
    // }

    public function show(CarInAndOut $carInAndOut)
    {
        return view('admin.car-in-and-out.show', compact('carInAndOut'));
    }

    public function edit(CarInAndOut $carInAndOut)
    {
        $rent_status = CarInAndOut::rentStatusLabels();
        $start_date = CarInAndOut::formatDateForm($carInAndOut->bookings->start_date);
        $end_date = CarInAndOut::formatDateForm($carInAndOut->bookings->end_date);
        $days = $carInAndOut->bookings->days;
        $car_out = CarInAndOut::formatDateForm($carInAndOut->car_out);
        $car_in = CarInAndOut::formatDateForm($carInAndOut->car_in);
        $days_rent = $carInAndOut->days_rent;
        $fine = CarInAndOut::rupiah($carInAndOut->fine);
        $fine_status = CarInAndOut::fineStatusLabels();
        $sub_total = $carInAndOut->checkouts->sub_total;
        return view(
            'admin.car-in-and-out.edit',
            compact(
                'start_date',
                'end_date',
                'days',
                'car_out',
                'car_in',
                'fine',
                'fine_status',
                'days_rent',
                'carInAndOut',
                'rent_status',
                'sub_total'
            )
        );
    }

    public function update(Request $request, CarInAndOut $carInAndOut)
    {
        $this->validateRequest($request);
        $car_out = CarInAndOut::formatDate($request->car_out);
        $car_in = CarInAndOut::setCarInDate($request->car_in);
        $getRentDays = CarInAndOut::getRentDays($car_out, $car_in);
        $fine = $carInAndOut->countFine($getRentDays);

        DB::beginTransaction();
        try {

            $carInAndOut->update([
                'rent_status' => $request->rent_status,
                'car_out' => $car_out,
                'car_in' => $car_in,
                'days_rent' => $getRentDays,
                'fine' => $fine,
                'fine_status' => $request->fine_status,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.car-in-and-out.index')->with('success', 'Data berhasil diubah');
    }

    // public function destroy($id)
    // {
    //     //
    // }
}
