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
        // $this->middleware('auth')->except('index','show');
        // $this->middleware('isAdmin')->only('create', 'edit'); // Apply 'isAdmin' middleware only to the create and edit methods
    }
    public function index()
    {
    // Retrieve all cafes with their associated reviews
    $cafes = Cafe::with('reviews')->get();

    // Calculate the average rating for each cafe
    $cafes->each(function ($cafe) {
        $cafe->averageRating = $cafe->reviews->avg('rating');
    });

    // Sort cafes by average rating in descending order
    $sortedCafes = $cafes->sortByDesc('averageRating');

    return view('cafe.index', ['cafes' => $sortedCafes]);
    }

    public function indexAdmin()
    {
        $user = auth()->user();

        // Check if the user has cafes associated with them
        $cafe = $user->cafes ?? collect();

        $title = 'Delete Cafe';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        
        return view('admin.cafeIndex', compact('cafe', 'title', 'text'));
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
    
        return redirect('/table-cafe')->with('success','Data berhasil disimpan');


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

    public function showAdmin($id)
    {
        $reviews = Review::where('cafe_id', $id)->with('user')->orderBy('rating', 'desc')->get();
        $cafe = Cafe::find($id);
        return view('admin.cafeDetail', ['cafe' => $cafe, 'reviews' => $reviews]);
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
    public function editAdmin($id)
    {
        $cafe = Cafe::find($id);

        return view('admin.cafeEdit', ['cafe' => $cafe]);
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
    public function updateAdmin(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'gambar' => 'required|mimes:jpg,jpeg,png',
            'content' => 'required'
        ]);
        $cafe = Cafe::find($id);

        $filename = time() . '.' . $request->gambar->extension();
        $request->gambar->move(public_path('image'), $filename);
        $cafe->gambar = $filename;
        
    
        // Update other fields
        $cafe->nama = $request->nama;
        $cafe->alamat = $request->alamat;
        $cafe->content = $request->content;
    
        // Save the changes
        $cafe->save();
    
        return redirect('/table-menu')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        

        $cafe = Cafe::find($id);

         $cafe->menus()->delete();
    
         $cafe->reviews()->delete();
      
         $cafe->delete();
    
        return redirect('/table-cafe')->with('success','Data berhasil dihapus');
    }
    // CafeController.php

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Perform the search logic using the $query
        $keywords = explode(' ', $query);
        $cafes = Cafe::where(function ($queryBuilder) use ($keywords) {
            foreach ($keywords as $keyword) {
                $queryBuilder->where('nama', 'like', "%$keyword%");
            }
        })->get();

        return view('cafe.index', compact('cafes'));
    }

}
