<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\WeightRequest;
use App\Http\Requests\Step2Request;

class WeightLogController extends Controller
{
    public function getStep2()
    {
        return view('auth.register.step2');
    }

    public function postStep2(Step2Request $request)
    {
        WeightLog::create(
            $request->only(['now_weight'])
        );
        WeightTarget::create(
            $request->only(['target_weight'])
        );

        return view('weight_logs');
    }

    public function admin()
    {
        $latestRecord = WeightLog::latest()->first();
        $latestWeight = $latestRecord->weight;
        $latestTargetRecord = WeightTarget::latest()->first();
        $latestTargetWeight = $latestTargetRecord->target_weight;
        $downWeight = $latestWeight-$latestTargetWeight;

        $weight_logs = WeightLog::all();
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

    public function postGoal(WeightRequest $request)
    {
        WeightTarget::create(
            $request->only(['target_weight'])
        );

        return redirect('/weight_logs');
    }

    public function store(WeightRequest $request)
    {
        $weight_log = $request->all();
        WeightLog::create($weight_log);

        return redirect('/weight_logs');
    }


    public function postSearch(Request $request)
    {
        if ($request->has('reset')) {
            return redirect('/weight_logs')->withInput();
        }

        $from = $request->input('from');
        $until = $request->input('until');
        $q = WeightLog::query();

        // 日付検索
        if (isset($from) && isset($until)) {
            $query = $q->whereBetween("tr_date", [$from, $until])->get();
        }

        $weight_logs = $query->paginate(8);
        $count = $weight_logs->count();

        return redirect('/weight_logs', compact('weight_logs', 'from', 'until', 'count'));
    }

    public function getDetail($weight_log_id)
    {
        $weight_log = WeightLog::find($weight_log_id);

        return view('detail', compact('weight_log'));
    }

    public function postUpdate(WeightRequest $request)
    {
        $weight_log_data = WeightLog::find( $_POST["weight_log_id"]);
        $weight_log_data->user_id= $_POST[$_POST["weight_log_user_id"]];
        $weight_log_data->date= $_POST["weight_log_date"];
        $weight_log_data->weight= $_POST["weight_log_weight"];
        $weight_log_data->calories= $_POST["weight_log_calories"];
        $weight_log_data->exercise_time= $_POST["weight_log_exercise_time"];
        $weight_log_data->exercise_content= $_POST["weight_log_exercise_content"];
        $weight_log_data->save();

        $weight_logs = WeightLog::all();
        $perPage = 8;
        $page = Paginator::resolveCurrentPage('page');
        $pageData = $weight_logs->slice(($page - 1) * $perPage, $perPage);
        $options = [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page'
        ];

        $weight_logs = new LengthAwarePaginator($pageData, $weight_logs->count(), $perPage, $page, $options);

        return redirect('/weight_logs');
    }

    public function postDelete($weight_log_id)
    {
        $weight_log = WeightLog::find($weight_log_id);
        $weight_log->delete();

        return redirect('/weight_logs');
    }

}
