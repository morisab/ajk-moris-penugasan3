<?php

namespace App\Http\Controllers;

use Throwable;
use Inertia\Inertia;
use Xendit\Configuration;
use Illuminate\Http\Request;
use Xendit\Invoice\InvoiceApi;
use Illuminate\Support\Facades\DB;
use App\Infrastructure\Repository\SqlPeminjamanRepository;
use App\Core\Application\Service\WebhookXendit\WebhookXenditService;
use App\Core\Application\Service\GetMyPeminjaman\GetMyPeminjamanService;
use App\Core\Application\Service\CreatePeminjaman\CreatePeminjamanService;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function __construct()
    {
        Configuration::setXenditKey(env('XENDIT_API_KEY', ""));
    }

    public function create(Request $request, CreatePeminjamanService $service)
    {
        $request->validate([
            'amount' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $response = $service->execute($request->input('amount'), Auth::user()->id);
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e->getMessage());
            return Inertia::render('auth/register', $this->errorProps(1022, 'Email sudah terdaftar'));
        }
        DB::commit();

        return Inertia::location($response['invoice_url']);
    }

    public function webhook(Request $request, WebhookXenditService $service)
    {
        $request->validate([
            'external_id' => 'required',
        ]);
        $service->execute($request->input('external_id'));
    }

    public function getMyPeminjamanList(GetMyPeminjamanService $service)
    {
        try {
            $response = $service->execute(Auth::user()->id);
        } catch (Throwable $e) {
            dd($e->getMessage());
            return Inertia::render('auth/register', $this->errorProps(1022, 'Email sudah terdaftar'));
        }
        return Inertia::render('peminjaman/index', $this->successWithDataProps($response, 'Berhasil mendapatkan list peminjaman'));
    }
}
