<?php

            namespace App\Http\Controllers;
            
            use App\Models\Listing;
            use Illuminate\Http\Request;
            use Illuminate\Validation\Rule;
            class nahuekController extends Controller

                public function create(Request $request) {
                    
                    $formFields = $request->validate([
                        'id' => 'required',
                       'nombre' => 'required'
                ]);
                Listing::create($formFields);
                return redirect('/')};
                
                public function show( nahuek $nahuek){
                        return view('nahuek.show', ['nahuek' =>$nahuek]); 
                        
                public function update(Request $request, nahuek $nahuek) {
                            $formFields = $request->validate([
                                'id' => 'required',
                           'nombre' => 'required'
                ]);
                $nahuekListing->update($formFields);
                return redirect('/')};
                