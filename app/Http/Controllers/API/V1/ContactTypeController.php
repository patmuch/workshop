<?php

namespace App\Http\Controllers\API\V1;

use App\Models\ContactType;
use Illuminate\Http\Request;

class ContactTypeController extends BaseController
{
    protected $contactType = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ContactType $contactType)
    {
        $this->middleware('auth:api');
        $this->contactType = $contactType;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactTypes = $this->contactType->latest()->paginate(10);

        return $this->sendResponse($contactTypes, 'ContactType list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $contactTypes = $this->contactType->pluck('name', 'id');

        return $this->sendResponse($contactTypes, 'ContactType list');
    }


   

}
