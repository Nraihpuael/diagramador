           <?php

                namespace App\Http\Controllers;
                
                use App\Models\Listing;
                use Illuminate\Http\Request;
                use Illuminate\Validation\Rule;
                class nahuekController extends Controller{

                public function create(Request $request) {
                $formFields = $request->validate([
                    'id' => 'required',
                       'nombre' => 'required'
                    ]);
                Listing::create($formFields);
                return redirect('/')};
                
                public function show( nahuek $nahuek){
                        return view('nahuek.show', ['nahuek' => $nahuek])}; 
                        
                public function update(Request $request, nahuek $nahuek) {
                            $formFields = $request->validate([
                                'id' => 'required',
                           'nombre' => 'required'
                        ]);
                $nahuekListing->update($formFields);
                return redirect('/')
                };
                
                public function destroy( nahuek $nahuek){
                    $nahuekListing->delete();
                    return redirect('/')};
                    
                }
                
               <?php

                namespace App\Http\Controllers;
                
                use App\Models\Listing;
                use Illuminate\Http\Request;
                use Illuminate\Validation\Rule;
                class alisonController extends Controller{

                public function create(Request $request) {
                $formFields = $request->validate([
                       'id' => 'required'
                    ]);
                Listing::create($formFields);
                return redirect('/')};
                
                public function show( alison $alison){
                        return view('alison.show', ['alison' => $alison])}; 
                        
                public function update(Request $request, alison $alison) {
                            $formFields = $request->validate([
                                       'id' => 'required'
                        ]);
                $alisonListing->update($formFields);
                return redirect('/')
                };
                
                public function destroy( alison $alison){
                    $alisonListing->delete();
                    return redirect('/')};
                    
                }
                
               <?php

                namespace App\Http\Controllers;
                
                use App\Models\Listing;
                use Illuminate\Http\Request;
                use Illuminate\Validation\Rule;
                class cristianController extends Controller{

                public function create(Request $request) {
                $formFields = $request->validate([
                    'asda' => 'required',
                       'id_nahuek' => 'required'
                    ]);
                Listing::create($formFields);
                return redirect('/')};
                
                public function show( cristian $cristian){
                        return view('cristian.show', ['cristian' => $cristian])}; 
                        
                public function update(Request $request, cristian $cristian) {
                            $formFields = $request->validate([
                                'asda' => 'required',
                           'id_nahuek' => 'required'
                        ]);
                $cristianListing->update($formFields);
                return redirect('/')
                };
                
                public function destroy( cristian $cristian){
                    $cristianListing->delete();
                    return redirect('/')};
                    
                }
                
    