<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Build;
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
        $builds =  $this->build->latest()->with('product','user','productionStage','customer')->paginate(10);
        return $this->sendResponse($builds, 'Productions list');
    }

   
    public function store(BuildRequest $request)
    {
     
        
        $builds = $this->build->create([

        'product_id' => $request->get('product_id'),
        'user_id' => $request->get('user_id'),
        'customer_id' => $request->get('customer_id'),
        'production_time' => $request->get('production_time'),
        'notes' => $request->get('notes'),
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

}
