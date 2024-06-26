<?php

namespace App\Http\Controllers;
use App\Models\Review;


use Illuminate\Http\Request;

class RatingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'rate' => 'required|integer|between:1,5',
            'review' => 'required|string',
            'cafe_id' => 'required',
        ]);

        try {
            // Assuming there's a relationship between 'cafe' and 'User'
            $user_id = auth()->user()->id;

            // Create a new review
            $review = new Review;
            $review->rating = $request->rate;
            $review->komentar = $request->review;
            $review->status = 0;
            $review->user_id = $user_id; // Set the user_id
            $review->cafe_id = $request->cafe_id; // Set the cafe_id

            // Save the review
            $review->save();

            // Redirect with success message
            return redirect()->back()->with('success', 'Review submitted successfully!');
        } catch (\Exception $e) {
            // Redirect with error message
            return redirect()->back()->with('error', 'You need Login for give ratings.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = Review::find($id);
        $review->delete();
        $cafeId = $review->cafe_id;

        return redirect('/table-cafe/' . $cafeId);
    }
}
