<?php

namespace App\Http\Controllers;

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
            'start_date' => 'required|date_format:d/m/Y',
            'end_date' => 'required|date_format:d/m/Y',
            'fine' => 'numeric|nullable',
        ]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Checkout::where('status', Checkout::STATUS_PAID)->get();
            $datatables = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $showRoute = route('admin.car-in-and-out.show', ['checkout' => $row]);
                    $editRoute = route('admin.car-in-and-out.edit', ['checkout' => $row]);
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
                ->editColumn('booking_code', function ($row) {
                    return $row->bookings->code;
                })
                ->editColumn('rent_status', function ($row) {
                    return $row->getRentStatusBadgeLabelAttribute();
                })
                ->editColumn('payment_proof', function ($row) {
                    return $row->getPaymentProof();
                })
                ->editColumn('status', function ($row) {
                    return $row->getPaymentStatusBadgeLabelAttribute();
                })
                ->rawColumns(['rent_status', 'payment_proof', 'status', 'action']);
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
            ->addColumn(['data' => 'booking_code', 'name' => 'booking_code', 'title' => 'Kode Booking'])
            ->addColumn(['data' => 'rent_status', 'name' => 'rent_status', 'title' => 'Status Sewa'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => 'Status Pembayaran'])
            ->addColumn(['data' => 'payment_proof', 'name' => 'payment_proof', 'title' => 'Bukti Pembayaran'])
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

    public function show(Checkout $checkout)
    {
        return view('admin.car-in-and-out.show', compact('checkout'));
    }

    public function edit(Checkout $checkout)
    {
        $rent_status = Checkout::rentStatusLabels();
        $start_date = Checkout::formatDateForm($checkout->bookings->start_date);
        $end_date = Checkout::formatDateForm($checkout->bookings->end_date);
        return view('admin.car-in-and-out.edit', compact('start_date', 'end_date', 'checkout', 'rent_status'));
    }

    public function update(Request $request, Checkout $checkout)
    {
        $this->validateRequest($request);

        DB::beginTransaction();
        try {
            $checkout->update([
                'rent_status' => $request->rent_status,
                'fine' => $request->fine ?? null,
            ]);

            $checkout->bookings->update([
                'start_date' => Checkout::formatDate($request->start_date),
                'end_date' => Checkout::formatDate($request->end_date),
                // 'start_date' => $request->start_date,
                // 'end_date' => $request->end_date,
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
