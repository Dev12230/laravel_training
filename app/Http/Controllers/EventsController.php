<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EventsRequest;
use App\Event;
use App\Visitor;
use App\Traits\ManageFiles;
use App\Events\EventInvitation;
use DataTables;

class EventsController extends Controller
{
    use ManageFiles;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $events=Event::query();
            return Datatables::of($events)
              ->addColumn('action', function ($row) {
                return  view('events.actions', compact('row'));
              })
              ->rawColumns(['action'])->make(true);
        }
        return view('events.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventsRequest $request)
    {
        $event=Event::create($request->all());

        if ($request->input('image')) {
            $event->image()->saveMany($this->getStoredFiles($request));
        }
        if ($visitors = $request['visitor_id']) {
            $event->visitors()->sync($visitors);
            event(new EventInvitation($event));
        }

        return redirect()->route('events.index')->with('success', 'event Added');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $visitors =$event->visitors()->get();
        $visitors =$visitors ->pluck('user.first_name', 'id')->toArray();

        return view('events.edit', compact('event', 'visitors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $event->update($request->all());

        if ($request->input('image')) {
            $event->image()->saveMany($this->getStoredFiles($request));
        }
        if ($visitors = $request['visitor_id']) {
            $event->visitors()->sync($visitors);
        }
        return redirect()->route('events.index')->with('success', 'events has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'events deleted');
    }

    public function getVisitors(Request $request)
    {
        $query = $request['search'];
        $visitors = Visitor::whereHas('user', function ($q) use ($query) {
            $q->where('first_name', 'like', "%$query%");
        })->get();
        
        return response()->json($visitors);
    }
}
