<?php

namespace App\Http\Controllers\Web\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    protected $service_type;

    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function redirectPath()
    {
        return session()->previousUrl() ?? route('home');
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            $this->service_type => $data['service'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function validator(array $data)
    {
        if ($this->service_type = service_type($data['service'])) {
            $config = config('auth.via.'.$this->service_type);
            if ($config['enabled']) {
                return Validator::make($data, [
                    'service'   =>  $config['validation'],
                    'name'      =>  'required',
                    'password'  =>  'required|string|min:6|confirmed',
                ]);
            }
        }

        return service_disabled();
    }
}
