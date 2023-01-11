<?php

namespace App\Http\Controllers\v1\API\User\Activity;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityResource;
use App\Oluwablin\OluwablinApp;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    use OluwablinApp;

    /**
     * Get an activity to interact with
     *
     * @param int $id
     *
     * @return mixed
     */
    private function getUserActivity($id)
    {
        return Activity::find($id) ?? abort(404, 'Activity not found.');
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allActivities(Request $request)
    {
        $activities = Activity::where('user_id', Auth::id())
        ->orWhereNull('user_id')
        ->latest()->paginate(intVal($request->query('paginate')) ?? 10);

        return ActivityResource::collection($activities)->additional(['status' => 'OK', 'message' => 'Activities fetched successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $id
     * @return \Illuminate\Http\Response
     */
    public function getActivity($id)
    {
        return $this->AppResponse('OK', 'Activity details fetched successfully', 200, new ActivityResource($this->getUserActivity($id)));
    }

}
