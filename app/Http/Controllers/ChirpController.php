<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Chirp;


class ChirpController extends Controller
{
    public function index(){
        $chirp = new Chirp;
        return view('chirps.index',['chirps' => $chirp::with('user')->latest()->get()]);
    }

    public function store(Request $request){

        $validacion = $request->validate([
            'message' => 'required|min:3'
        ]);

        auth()->user()->chirps()->create($validacion);

        return to_route('chirps.index')->with('status',__('Chirp created succesfully!'));
    }

    public function edit (Chirp $chirp){

        $this->authorize('update',$chirp);
    
        return view ('chirps.edit',['chirp' => $chirp]);
    }

    public function update(Request $request, Chirp $chirp){
        $validacion = $request->validate([
            'message' => 'required|min:3'
        ]);
        $this->authorize('update',$chirp);
        $chirp->update($validacion);
        return to_route('chirps.index')->with('status',__('Chirp updated succesfully!'));
    }

    public function destroy(Chirp $chirp){
        $this->authorize('delete',$chirp);

        $chirp->delete();
        return to_route('chirps.index')->with('status',__('Chirp deleted succesfully!'));
    }

}
