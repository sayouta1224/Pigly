<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Step2Request;
use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Support\Facades\Auth;

class RegisterStepController extends Controller
{
    public function create()
    {
        return view('auth.register.step1');
    }

    public function store(Request $request, CreateNewUser $creator)
    {
        $user = $creator->create($request->all());

        session(['pending_user_id' => $user->id]);

        return redirect('register/step2');
    }

    public function createStep2()
    {
        if (!session()->has('pending_user_id')) {
            return redirect('auth/register/step1');
        }

        return view('auth.register.step2');
    }

    public function storeStep2(Step2Request $request)
    {
        $user = User::findOrFail(session('pending_user_id'));

        WeightLog::create([
            'user_id' => $user->id,
            'weight' => $request->now_weight,
            'date' => now(),
            'calories' => 0,
            'exercise_time' => 0000,
            'exercise_content' => '',
        ]);

        WeightTarget::create([
            'user_id' => $user->id,
            'target_weight' => $request->target_weight,
        ]);

        Auth::login($user);
        

        return redirect('/weight_logs');
    }
}
