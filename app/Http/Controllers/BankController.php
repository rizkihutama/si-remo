<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class BankController extends Controller
{
    protected $htmlbuilder;

    public function __construct(Builder $htmlbuilder)
    {
        $this->htmlbuilder = $htmlbuilder;
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'name' => 'required|string',
            'account_number' => 'required|numeric|digits_between:10,16',
            'account_name' => 'required|string',
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
            $data = Bank::all();
            $datatables = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $showRoute = route('admin.banks.show', ['bank' => $row]);
                    $editRoute = route('admin.banks.edit', ['bank' => $row]);
                    $deleteRoute = route('admin.banks.destroy', ['bank' => $row]);
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
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => 'Car Name'])
            ->addColumn(['data' => 'account_number', 'name' => 'account_number', 'title' => 'No. Rekening'])
            ->addColumn(['data' => 'account_name', 'name' => 'account_name', 'title' => 'Pemilik Rekening'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Aksi', 'orderable' => false, 'searchable' => false, 'width' => 100, 'exportable' => false]);

        return view('admin.bank.index', compact('dataTable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.bank.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        $bank = Bank::create($validated);

        return redirect()->route('admin.banks.index')->with('success', 'Data Bank Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        return view('admin.bank.show', compact('bank'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        return view('admin.bank.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
        $validated = $this->validateRequest($request);
        $bank->update($validated);
        return redirect()->route('admin.banks.index')->with('success', 'Data Bank Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        $bank->delete();
        return redirect()->route('admin.banks.index')->with('success', 'Data Bank Berhasil Dihapus');
    }
}
