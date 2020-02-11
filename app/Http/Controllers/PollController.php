<?php

namespace App\Http\Controllers;

use App\Poll;
use Illuminate\Http\Request;
use Validator;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $polls = Poll::get()->all();
        return  response()->json($polls, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        $validatedData = $request->validate([
//            'title' => 'required|unique:polls|max:255',
//        ]);
       // $poll = Poll::create($validatedData);

        $rules =[
            'title' => 'required|unique:polls|max:30',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return  response()->json( $validator->errors(),400);
        }
        $poll = Poll::create($request->all());
        return  response()->json($poll,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function show(Poll $poll)
    {
        $poll = Poll::findOrFail($poll);
        if (is_null($poll)){
            return response()->json(null,400);
        }
        return response()->json($poll,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function edit(Poll $poll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Poll $poll)
    {
        $poll ->update($request->all());
        return response()->json($poll,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poll $poll)
    {
        $poll->delete();
        return response()->json(null,200);
    }
}
