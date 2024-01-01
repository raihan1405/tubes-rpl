<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Cafe;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = Menu::with('cafe_id')->get();
        
        return view('menu.index', compact('menu'));
    }
    public function indexByCafe($cafe_id)
    {
        // $menu = Menu::whereHas('cafe', function ($query) use ($cafe_id) {
        //     $query->where('id', $cafe_id);
        // })->get();

        // return view('menu.index', ['menu' => $menu]);
    }
    public function indexAdmin()
    {
        $user = auth()->user();

        // Check if the user has cafes associated with them
        $cafes = $user->cafes ?? collect();

        $menu = Menu::whereIn('cafe_id', $cafes->pluck('id'))->get();

        $title = 'Delete Menu';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('admin.menuIndex', compact('menu','title','text'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userId = Auth::id();
        $cafes = Cafe::where('user_id', $userId)->get();
        return view('menu.create', ['cafes' => $cafes]);
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
            'harga' => 'required',
            'gambar' => 'required|mimes:jpg,jpeg,png',
            'cafe_id' => 'required', // Validate that the cafe_id exists in the cafes table
        ]);
    
        $filename = time() . '.' . $request->gambar->extension();
        $request->gambar->move(public_path('image'), $filename);
    
        $user = Auth::user();
    
        $menu = new Menu;
        $menu->nama = $request->nama;
        $menu->harga = $request->harga;
        $menu->gambar = $filename;
        $menu->user_id = $user->id;
        $menu->cafe_id = $request->cafe_id; // Set the cafe_id
        
        $menu->save();

        return redirect('/table-menu')->with('success','Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $menu = Menu::where('cafe_id', $id)->get();
        $cafe = $id;
        return view('menu.index', ['menu' => $menu, 'cafe' => $cafe]);
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
        $user = auth()->user();
        $cafes = $user->cafes ?? collect();

        $menu = Menu::find($id);
       return view('admin.menuEdit', compact('cafes','menu')); 

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
            'harga' => 'required',
            'gambar' => 'required|mimes:jpg,jpeg,png',
            'cafe_id' => 'required', // Validate that the cafe_id exists in the cafes table
        ]);
    
        $filename = time() . '.' . $request->gambar->extension();
        $request->gambar->move(public_path('image'), $filename);
    
        $user = Auth::user();
        $menu = Menu::find($id);
    
        $menu->nama = $request->nama;
        $menu->harga = $request->harga;
        $menu->gambar = $filename;
        $menu->user_id = $user->id;
        $menu->cafe_id = $request->cafe_id; // Set the cafe_id
        
        $menu->save();

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
        $menu = Menu::find($id);
        $menu->delete();
    
        
        return redirect()->back()->with('success', 'Data Berhasil Dihapus');
    }

    public function search(Request $request,$id)
    {
        $menu = Menu::where('cafe_id', $id)->get();
        $cafe = $id;

        // Check if there is a search query
        $query = $request->input('query');
    
     
            // Perform the search logic using the $query
            $keywords = explode(' ', $query);
            $menu = Menu::where('cafe_id', $id)->where(function ($queryBuilder) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $queryBuilder->where('nama', 'like', "%$keyword%");
                }
            })->get();

        return view('menu.index', compact('menu','cafe'));
    
    }
    public function addToCart($id)
    {
        $menu = Menu::findOrFail($id);
  
        $cart = session()->get('cart', []);
  
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        }  else {
            $cart[$id] = [
                "menu_name" => $menu->nama,
                "photo" => $menu->gambar,
                "price" => $menu->harga,
                "quantity" => 1
            ];
        }
  
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu add to cart successfully!');
    }

    public function clearCart()
    {
    // Mengosongkan array cart tanpa menghapus kunci 'cart' dari session
    session(['cart' => []]);

    return redirect()->back()->with('success', 'Cart cleared successfully!');
    }
    public function cart()
    {
        $title = 'Delete Menu';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('cart',compact('title','text'));
    }
    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart successfully updated!');
        }
    }
  
    public function remove($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Data Berhasil Dihapus');
        }
    }


}
