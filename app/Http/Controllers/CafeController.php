<?php

namespace App\Http\Controllers;
use App\Models\cafe;
use App\Models\Review;
use App\Models\User;

use Illuminate\Http\Request;

class CafeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index','show');
        $this->middleware('isAdmin')->only('create', 'edit'); // Apply 'isAdmin' middleware only to the create and edit methods
    }
    public function index()
    {
    // Retrieve all cafes with their associated reviews
    $cafes = Cafe::with('reviews')->get();

    // Calculate the average rating for each cafe
    $cafes->each(function ($cafe) {
        $cafe->averageRating =  $cafe->reviews->avg('rating');
    });

    // Sort cafes by average rating in descending order
    $sortedCafes = $cafes->sortByDesc('averageRating');

    return view('cafe.index', ['cafes' => $sortedCafes]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cafe.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'gambar' => 'required|mimes:jpg,jpeg,png',
            'content' => 'required'
        ]);
    
        $filename = time() . '.' . $request->gambar->extension();
        $request->gambar->move(public_path('image'), $filename);
    
        // Assuming there's a relationship between 'cafe' and 'User'
        $user_id = auth()->user()->id;
        
    
        $cafe = new Cafe;
        $cafe->nama = $request->nama;
        $cafe->alamat = $request->alamat;
        $cafe->gambar = $filename;
        $cafe->content = $request->content;
        $cafe->user_id = $user_id; // Set the user_id
    
        $cafe->save();
    
        return redirect('/cafe');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    // Retrieve all reviews for the specific cafe
    $reviews = Review::where('cafe_id', $id)->with('user')->orderBy('rating', 'desc')->get();

    // Retrieve the cafe details
    $cafe = Cafe::find($id);

    // Pass the cafe details and reviews to the view
    return view('cafe.detail', compact('cafe', 'reviews'));
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
        //
    }
}
