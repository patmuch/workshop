<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Contacts\ContactRequest;

use App\Models\Contact;



class ContactController extends BaseController
{
    protected $contact = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->middleware('auth:api');
        $this->contact = $contact;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts =  $this->contact->latest()->with('contactType')->paginate(10);
        return $this->sendResponse($contacts, 'Contacts list');
    }

    public function supplierList()
    {
        $contacts =  $this->contact->latest()->with('contactType')->where('contact_type_id','2')->paginate(10);
        return $this->sendResponse($contacts, 'Suppliers list');
    }

    public function customerList()
    {
        $contacts =  $this->contact->latest()->with('contactType')->where('contact_type_id','1')->paginate(10);
        return $this->sendResponse($contacts, 'Customers list');
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
    public function store(ContactRequest $request)
    {
     
        
        $contacts = $this->contact->create([

        'fname' => $request->get('fname'),
        'lname' => $request->get('lname'),
        'email' => $request->get('email'),
        'phone' => $request->get('phone'),
        'contact_type_id' => $request->get('contact_type_id'),      
        
        ]);

        return $this->sendResponse($contacts, 'Contact Created Successfully');

        
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\contact  $contact
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(ContactRequest $request, $contact)
    {
        

        $contacts = $this->contact->findOrFail($contact);

        $contacts->update($request->all());
                
        return $this->sendResponse($contacts, 'Contact Information has been updated');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy($contact)
    {
        $this->authorize('isAdmin');

        $contacts = $this->contact->findOrFail($contact);

        $contacts->delete();

        return $this->sendResponse($contacts, 'Contact has been Deleted');
    }
}
