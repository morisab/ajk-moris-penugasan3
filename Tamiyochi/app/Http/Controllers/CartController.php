<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Core\Application\Service\CreateCart\CreateCartRequest;
use App\Core\Application\Service\CreateCart\CreateCartService;
use App\Core\Application\Service\DeleteCart\DeleteCartService;
use App\Core\Application\Service\GetCartUser\GetCartUserService;
use App\Core\Application\Service\DeleteCart\DeleteCartByVolumeIdService;
use Inertia\Inertia;

class CartController extends Controller
{
    public function getCartUser(GetCartUserService $service)
    {
        $response = $service->execute(Auth::user()->id);

        return Inertia::render('cart/index', $this->successWithDataProps($response, 'Berhasil mendapatkan list cart'));
    }

    public function createCart(Request $request, CreateCartService $service)
    {
        $request->validate([
            'volume_id' => 'required',
            'jumlah' => 'required'
        ]);

        $input = new CreateCartRequest(
            $request->input('volume_id'),
            $request->input('jumlah'),
        );

        DB::beginTransaction();
        try {
            $service->execute($input, Auth::user()->id);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return redirect()->back();
    }

    public function deleteCart(Request $request, DeleteCartService $service)
    {
        DB::beginTransaction();
        try {
            $service->execute($request->route('id'), Auth::user()->id);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return redirect()->back();
    }

    public function deleteCartByVolumeId(Request $request, DeleteCartByVolumeIdService $service)
    {
        DB::beginTransaction();
        try {
            $service->execute($request->route('id'), Auth::user()->id);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return redirect()->back();
    }
}
