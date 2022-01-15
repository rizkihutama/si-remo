<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Models\Bank;
use App\Models\Booking;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class CheckoutController extends Controller
{
    protected $htmlbuilder;

    public function __construct(Builder $htmlbuilder)
    {
        $this->htmlbuilder = $htmlbuilder;
    }

    protected function getBookings($booking_id)
    {
        return Booking::where('booking_id', $booking_id)->first();
    }

    private function validateBankRequest(Request $request)
    {
        return $request->validate([
            'bank_id' => 'required|numeric|exists:banks,bank_id',
        ]);
    }

    private function validateUploadProofRequest(Request $request, $checkout)
    {
        return $request->validate([
            'payment_proof' => [
                'image',
                'max:2048',
                Rule::requiredIf($checkout->payment_proof == null),
            ],
        ]);
    }

    public function checkoutBooking(Checkout $checkout)
    {
        $banks = Bank::pluck('name', 'bank_id');
        $booking_code = $checkout->bookings->code;
        $image = $checkout->cars->getImgUrl($checkout->cars->image);
        $start_date = Checkout::formatDateFE($checkout->bookings->start_date);
        $end_date = Checkout::formatDateFE($checkout->bookings->end_date);
        $days = $checkout->bookings->days;
        $tax = Booking::TAX_RATE;
        $sub_total = Checkout::rupiah($checkout->bookings->sub_total);
        $total = Checkout::rupiah($checkout->bookings->total);
        return view('checkout.choose-bank', compact(
            'checkout',
            'banks',
            'booking_code',
            'image',
            'start_date',
            'end_date',
            'days',
            'tax',
            'sub_total',
            'total'
        ));
    }

    public function checkoutUpdate(Request $request, Checkout $checkout)
    {
        $validatedBank = $this->validateBankRequest($request);
        $checkout->update($validatedBank);
        return redirect()->route('car-checkout.detail', $checkout->checkout_id);
    }

    public function uploadProofIndex(Checkout $checkout)
    {
        $banks = Bank::pluck('name', 'bank_id');
        $booking_code = $checkout->bookings->code;
        $image = $checkout->cars->getImgUrl($checkout->cars->image);
        $start_date = Checkout::formatDateFE($checkout->bookings->start_date);
        $end_date = Checkout::formatDateFE($checkout->bookings->end_date);
        $days = $checkout->bookings->days;
        $tax = Booking::TAX_RATE;
        $sub_total = Checkout::rupiah($checkout->bookings->sub_total);
        $total = Checkout::rupiah($checkout->bookings->total);
        $path = Checkout::getImgProofUrl($checkout->payment_proof);
        return view('checkout.detail-bank', compact(
            'checkout',
            'path',
            'banks',
            'booking_code',
            'image',
            'start_date',
            'end_date',
            'days',
            'tax',
            'sub_total',
            'total'
        ));
    }

    public function myCheckoutIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = Checkout::where('user_id', auth()->id())->get();
            $datatables = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if (empty($row->bank_id)) {
                        $showRoute = route('car-checkout', ['checkout' => $row]);
                    } else {
                        if ($row->status == Checkout::STATUS_PAID) {
                            $invoice = route('invoice', ['checkout' => $row]);
                            $btn = "<div class='d-flex'>
                            <a href='{$invoice}' class='btn btn-icon btn-info btn-sm mr-2' title='Invoice'>
                                <i class='fas fa-file-invoice-dollar'></i>
                            </a>
                            <a href='mailto:siremo@admin.com' class='btn btn-icon btn-primary btn-sm mr-2' title='Email to admin'>
                                <i class='fas fa-envelope'></i>
                            </a>
                        </div>";
                        } else {
                            $showRoute = route('car-checkout.upload-proof', ['checkout' => $row]);
                            $btn = "<div class='d-flex'>
                                <a href='{$showRoute}' class='btn btn-icon btn-info btn-sm mr-2' title='Upload Bukti'>
                                    <i class='fas fa-file-upload'></i>
                                </a>
                                <a href='mailto:siremo@admin.com' class='btn btn-icon btn-primary btn-sm mr-2' title='Email to admin'>
                                    <i class='fas fa-envelope'></i>
                                </a>
                            </div>";
                        }
                    }

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
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => 'Status'])
            ->addColumn(['data' => 'payment_proof', 'name' => 'payment_proof', 'title' => 'Bukti Pembayaran'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Aksi', 'orderable' => false, 'searchable' => false, 'width' => 100, 'exportable' => false]);

        return view('checkout.index', compact('dataTable'));
    }

    public function uploadProof(Request $request, Checkout $checkout)
    {
        $this->validateUploadProofRequest($request, $checkout);
        $bookings = $this->getBookings($checkout->bookings->booking_id);


        DB::beginTransaction();
        try {
            $oldFile = $checkout->payment_proof;

            if (!empty($request->file('payment_proof'))) {
                //* hapus old file
                FileHelper::delete(Checkout::getImgProofPath() . $oldFile);
                //* Get New File Name
                $newFile = FileHelper::upload($request->file('payment_proof'), Checkout::getImgProofPath());
            }

            $bookings->update([
                'status' => Booking::STATUS_WAITING_CONFIRMATION,
            ]);

            $checkout->update([
                'payment_proof' => $newFile ?? $oldFile,
                'status' => Checkout::STATUS_WAITING_CONFIRMATION,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage() . ' : ' . $e->getLine());
        }
        return redirect()->route('my-checkout.index')->with('success', 'Upload Bukti Pembayaran Berhasil, Silahkan Tunggu Konfirmasi Admin');
    }

    public function invoice(Checkout $checkout)
    {
        $booking_code = $checkout->bookings->code;
        $start_date = Checkout::formatDateFE($checkout->bookings->start_date);
        $end_date = Checkout::formatDateFE($checkout->bookings->end_date);
        $days = $checkout->bookings->days;
        $tax = Booking::TAX_RATE;
        $sub_total = Checkout::rupiah($checkout->bookings->sub_total);
        $total = Checkout::rupiah($checkout->bookings->total);
        return view('checkout.invoice', compact(
            'checkout',
            'booking_code',
            'start_date',
            'end_date',
            'days',
            'tax',
            'sub_total',
            'total'
        ));
    }

    public function cancelCheckout(Checkout $checkout)
    {
        $bookings = $this->getBookings($checkout->bookings->booking_id);
        $bookings->update([
            'status' => Booking::STATUS_CANCELED,
        ]);

        $checkout->update([
            'status' => Checkout::STATUS_CANCELED,
        ]);

        return redirect()->route('my-checkout.index')->with('success', 'Pesanan Dibatalkan');
    }
}
