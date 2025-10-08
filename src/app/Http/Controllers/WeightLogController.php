<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\WeightRequest;
use App\Http\Requests\TargetWeightRequest;

class WeightLogController extends Controller
{
    public function admin()
    {
        $userId = Auth::id();

        $latestRecord = WeightLog::where('user_id', $userId)
        ->orderBy('date', 'desc')
        ->first();
        $latestTargetRecord = WeightTarget::where('user_id', $userId)
        ->latest()
        ->first();

        $latestWeight = $latestRecord->weight;
        $latestTargetWeight = $latestTargetRecord->target_weight;
        $downWeight = $latestWeight-$latestTargetWeight;

        $weight_logs = WeightLog::where('user_id', $userId)->orderBy('date','asc')->get();
        $perPage = 8;
        $page = Paginator::resolveCurrentPage('page');
        $pageData = $weight_logs->slice(($page - 1) * $perPage, $perPage);
        $options = [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page'
        ];

        $weight_logs = new LengthAwarePaginator($pageData, $weight_logs->count(), $perPage, $page, $options);

        return view('weight_logs', compact('latestWeight', 'latestTargetWeight', 'downWeight', 'weight_logs'));
    }

    public function getGoal()
    {
        return view('goal');
    }

    public function postGoal(TargetWeightRequest $request)
    {
        WeightTarget::create([
            'user_id' => Auth::id(),
            'target_weight' => $request->target_weight,
        ]);

        return redirect('/weight_logs');
    }

    public function store(WeightRequest $request)
    {
        WeightLog::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'weight' => $request->weight,
            'calories' => $request->calories,
            'exercise_time' => $request->exercise_time,
            'exercise_content' => $request->exercise_content,
        ]);

        return redirect('/weight_logs');
    }


    public function postSearch(Request $request)
    {
        if ($request->has('reset')) {
            return redirect('/weight_logs');
        }

        $userId = Auth::id();

        $latestRecord = WeightLog::where('user_id', $userId)
        ->orderBy('date', 'desc')
        ->first();
        $latestTargetRecord = WeightTarget::where('user_id', $userId)
        ->latest()
        ->first();

        $latestWeight = $latestRecord->weight;
        $latestTargetWeight = $latestTargetRecord->target_weight;
        $downWeight = $latestWeight-$latestTargetWeight;

        $from = $request->input('from');
        $until = $request->input('until');

        $query = WeightLog::where('user_id', $userId);

        if (!empty($from) && !empty($until)) {
            $query->whereBetween('date', [$from, $until]);
        } elseif (!empty($from)) {
            $query->where('date', '>=', $from);
        } elseif (!empty($until)) {
            $query->where('date', '<=', $until);
        }

        $weight_logs = $query->orderBy('date', 'asc')->paginate(8);
        $count = $weight_logs->total();
        $isSearching = !empty($from) || !empty($until);

        return view('/weight_logs', compact('weight_logs', 'from', 'until', 'count', 'isSearching', 'latestWeight', 'latestTargetWeight', 'downWeight'));
    }

    public function getDetail($weight_log_id)
    {
        $weight_log = WeightLog::where('user_id', Auth::id())->findOrFail($weight_log_id);
        return view('detail', compact('weight_log'));
    }

    public function postUpdate(WeightRequest $request)
    {
        $weight_log = WeightLog::where('user_id', Auth::id())->findOrFail($request->input('weight_log_id'));

        $weight_log->update([
            'date' => $request->input('date'),
            'weight' => $request->input('weight'),
            'calories' => $request->input('calories'),
            'exercise_time' => $request->input('exercise_time'),
            'exercise_content' => $request->input('exercise_content'),
        ]);

        return redirect('/weight_logs');
    }

    public function postDelete($weight_log_id)
    {
        $weight_log = WeightLog::where('user_id', Auth::id())->findOrFail($weight_log_id);
        $weight_log->delete();

        return redirect('/weight_logs');
    }
}
