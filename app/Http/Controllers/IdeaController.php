<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Tournament;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('idea');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'idea' => 'required|string',
        ]);

        $idea          =    new Idea();
        $idea->name    =    $validate['name'];
        $idea->email   =    $validate['email'];
        $idea->idea    =    $validate['idea'];

        $idea->save();
        //check IdeaObserver for further logics
        session()->flash('success', 'Idea submitted successfully');

        return redirect()->route('idea.index');
    }

    public function currentTournaments(){
        $tournaments = Tournament::query()
           ->where('end_time', '>=', Carbon::now())
           ->get()
           ->map(function ($collection){
               return [
                   'id'          => $collection->tournament_id,
                   'phase'       => $collection->tournament_step,
                   'start_time'  => Carbon::createFromFormat('Y-m-d H:i:s', $collection->start_time)->toIso8601String(),
                   'end_time'    => Carbon::createFromFormat('Y-m-d H:i:s', $collection->end_time)->toIso8601String(),
               ];
           });
       return response()->json(['tournaments' => $tournaments]);
    }

}
