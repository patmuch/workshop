<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Build;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Requests\Builds\BuildRequest;


class BuildController extends BaseController
{
    protected $build = '';


    public function __construct(Build $build)
    {
        $this->middleware('auth:api');
        $this->build = $build;
    }

  
    public function index()
    {
        $builds =  $this->build->latest()->with('user','productionStage')->paginate(10);
        return $this->sendResponse($builds, 'Productions queue');
    }


      
    public function getBuilds()
    {

        $builds =  $this->build->all();               //pluck('buildable_id','id');
        return $this->sendResponse($builds, 'Builds');
  
    }

   
    public function store(BuildRequest $request)
    {
     
        
        $builds = $this->build->create([

        'buildable_id'        => $request->get('buildable_id'),
        'buildable_type'      => $request->get('buildable_type'),
        'user_id'             => $request->get('user_id'),
        'notes'               => $request->get('notes'),
        'production_stage_id' => $request->get('production_stage_id'),      
        
        ]);

        return $this->sendResponse($builds, 'New Production Queue Created Successfully');

        
    }



    public function update(BuildRequest $request, $build)
    {
        

        $builds = $this->build->findOrFail($build);

        $builds->update( ['production_stage_id' =>$request->get('production_stage_id'),]);
                
        return $this->sendResponse($builds, 'Production Stage has been updated');

        
    }

  
    public function destroy($build)
    {
        $this->authorize('isAdmin');

        $builds = $this->build->findOrFail($build);

        $builds->delete();

        return $this->sendResponse($builds, 'Production build has been Deleted');
    }


    public function wipMaterial($id)
    {

        $order = $this->build->findOrFail($id);

        $wipMat = $order->materials()->withPivot('quantity')->get();

        return $this->sendResponse($wipMat, 'Build materials');
    }



    public function storeRecipe(Request $request)
    {
       
       
        $buildItems = $request->buildItems;

        $build = $this->build->findOrFail($request->get('selectedOrder'));
         
             foreach ($buildItems as $buildItem)
               {

                  // update pivot table
     
                    
                   $build->materials()->attach( ['material_id' => $buildItem['material_id']], ['quantity'=> $buildItem['quantity'] ] );

                   Material::where('id', $buildItem['material_id'] )->increment('committed', $buildItem['quantity'] );

                   Material::where('id', $buildItem['material_id'] )->decrement('quantity', $buildItem['quantity'] );
 
                } 

           return $this->sendResponse($build, 'Material allocation Successfully');

    }

}
