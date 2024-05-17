<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Core\Application\Service\GetUserList\GetUserListService;
use App\Core\Application\Service\RegisterUser\RegisterUserRequest;
use App\Core\Application\Service\RegisterUser\RegisterUserService;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function test(): JsonResponse
    {
        return response()->json(
            [
                'success' => true,
                'message' => "Test",
            ]
        );
    }

    public function storeUser(Request $request, RegisterUserService $service)
    {
        $request->validate([
            'email' => 'email:rfc',
            'password' => 'min:8|max:64|string',
            'name' => 'min:8|max:128|string',
        ]);

        $input = new RegisterUserRequest(
            $request->input('name'),
            $request->input('email'),
            $request->input('no_telp'),
            $request->input('age'),
            $request->file('image'),
            $request->input('password')
        );

        DB::beginTransaction();
        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            return Inertia::render('auth/register', $this->errorProps($e->getCode(), $e->getMessage()));
        }
        DB::commit();
        return redirect()->route('auth.login.index');
    }

    public function storeLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $userdata = [
            'email'     => $request->email,
            'password'  => $request->password
        ];

        if (Auth::attempt($userdata)) {
            return redirect()->route('seri.index');
        }

        return Inertia::render('auth/login', $this->errorProps(1234, 'Email atau Password Salah'));
    }

    public function destroyLogin(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('auth.login.index');
    }

    public function getUserList(GetUserListService $service)
    {
        $response = $service->execute();
        return view('users', ['users' => $response]);
    }

    public function getUserListApi(GetUserListService $service)
    {
        $response = $service->execute();
        return $this->successWithData($response, "Berhasil mendapatkan data");
    }
}
