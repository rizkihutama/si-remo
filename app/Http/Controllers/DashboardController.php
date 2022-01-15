<?php

namespace App\Http\Controllers;

use App\Exports\CheckoutsExport;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class DashboardController extends Controller
{
    protected $htmlbuilder;

    public function __construct(Builder $htmlbuilder)
    {
        $this->htmlbuilder = $htmlbuilder;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Checkout::all();
            $datatables = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $showRoute = route('admin.dashboard.show', ['checkout' => $row]);
                    $editRoute = route('admin.dashboard.edit', ['checkout' => $row]);
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
                ->editColumn('payment_proof', function ($row) {
                    return $row->getPaymentProof();
                })
                ->editColumn('status', function ($row) {
                    return $row->getPaymentStatusBadgeLabelAttribute();
                })
                ->rawColumns(['payment_proof', 'status', 'action']);
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
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => 'Status Pembayaran'])
            ->addColumn(['data' => 'payment_proof', 'name' => 'payment_proof', 'title' => 'Bukti Pembayaran'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Aksi', 'orderable' => false, 'searchable' => false, 'width' => 100, 'exportable' => false]);

        return view('admin.dashboard.index', compact('dataTable'));
    }

    public function show(Checkout $checkout)
    {
        return view('admin.dashboard.show', compact('checkout'));
    }

    public function edit(Checkout $checkout)
    {
        $status = Checkout::paymentStatusLabels();
        return view('admin.dashboard.edit', compact('checkout', 'status'));
    }

    public function update(Request $request, Checkout $checkout)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $checkout->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.dasboard.index')->with('success', 'Status Pembayaran Berhasil Diubah');
    }

    public function export()
    {
        // return Excel::download(new CheckoutsExport, 'checkouts.xlsx');
        return (new CheckoutsExport)->download('checkouts.xlsx');
    }
}
