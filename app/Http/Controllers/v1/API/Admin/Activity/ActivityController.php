<?php

namespace App\Http\Controllers\v1\API\Admin\Activity;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityFormRequest;
use App\Http\Resources\ActivityResource;
use App\Oluwablin\OluwablinApp;

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
        $start_date = $request->filled('start_date') ?  date('Y-m-d 00:00:00', strtotime($request->input('start_date'))) : date('1970-01-01 00:00:00');
        $end_date = $request->filled('end_date') ?  date('Y-m-d', strtotime($request->input('end_date'))) . " 23:59:59" : date('Y-m-d 23:59:59');

        $activities = Activity::when($request->query('keywords'), function ($query) use ($request, $start_date, $end_date) {
            $query->where('title', 'like', '%' . $request->keywords . '%')->orderBy('title')
            ->whereBetween('created_at', [$start_date, $end_date]);
        })->latest()->paginate(intVal($request->query('paginate')) ?? 10);

        return ActivityResource::collection($activities)->additional(['status' => 'OK', 'message' => 'Activities fetched successfully.']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  ActivityFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function addActivity(ActivityFormRequest $request)
    {
        if($request->validated()['image']){
            $imageName = time(). '.' .$request->image->getClientOriginalExtension();
            $request->image->move(public_path('upload/images'), $imageName);
        }

        $activity = Activity::create($request->validated());

        return $this->AppResponse('OK', 'Activity created successfully.', 201, new ActivityResource($activity));
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

    /**
     * Update the specified resource in storage.
     *
     * @param  ActivityFormRequest  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityFormRequest $request, $id)
    {
        $activity = $this->getUserActivity($id);

        $activity->update($request->validated());

        return $this->AppResponse('OK', 'Activity updated successfully.', 200, new ActivityResource($activity));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteActivity($id)
    {
        $activity = $this->getUserActivity($id);

        $activity->delete();

        return $this->AppResponse('OK', 'Activity deleted successfully');
    }
}
