<?php

namespace App\Http\Controllers;

use App\Poll;
use Illuminate\Http\Request;
use App\Http\Resources\Poll as PollResource;
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
        //$polls = Poll::get()->all();
        return  response()->json(Poll::paginate(1), 200);
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
        //side loading
        $poll->with ('questions')->findOrFail($poll);  // return nested data(relationship)
        $response['poll']  =  $poll;
        $response['questions']  = $poll->questions;
        return  response()->json($response, 200);

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
     * Remove the specified resource from stor
     *
     * age.
     *
     * @param  \App\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poll $poll)
    {
        return response()->json($poll->delete(), null,200);
    }

    public  function  errors()
    {
        return response()->json(['message' => "Payment is required"],501);
    }

    public  function  questions(Request $request , Poll $poll)
    {
        $questions = $poll->questions;
        return response()->json($questions,200);
    }
}



//if (is_null($poll)){
//    return response()->json(null,400);
//}
//// Transformer
//$poll = Poll::with('questions')->findOrFail($poll);  // return nested data(relationship)
//return  response()->json($poll, 200);
//
////$response = new PollResource (Poll::findOrFail($poll),  200);
////        return  response()->json($response, 200);
