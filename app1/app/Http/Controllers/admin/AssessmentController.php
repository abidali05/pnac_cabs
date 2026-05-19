<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AssessmentPlan;
use App\Models\AssesssorUser;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function assessmentIndex()
    {
        // $assessmentPlans = AssessmentPlan::with('assessmentType', 'cabCycle', 'general')
        // ->where('status', 1)->get();
        // i coeded
        $user = auth()->user();
        //dd($user);
        $assessmentPlans = AssessmentPlan::with(['assessmentType', 'cabCycle', 'general'])
            ->where('status', 1)
            ->whereHas('general', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->get();
        // i coeded
        $assessorUser = AssesssorUser::with('assessmentPlan')->get();
        return view('admin.assessment.index', compact('assessmentPlans', 'assessorUser'));
    }
}
