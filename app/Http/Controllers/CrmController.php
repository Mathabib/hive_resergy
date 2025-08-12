<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crm;

class CrmController extends Controller
{

    public function index() {
        $clients = Crm::paginate(10); 

        return view('crm.index', compact('clients'));
    }


        public function create()
    {
        return view('crm.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'name'     => 'required|string|max:255',
            'company'  => 'required|string|max:255',
            'email'    => 'required|email|unique:crm,email',
            'address'  => 'nullable|string|max:255',
            'notes'    => 'nullable|string',
            'phone'    => 'nullable|string|max:20',
            'website'  => 'nullable|url|max:255',
        ]);

        Crm::create($request->all());

        return redirect()->route('crm.index')->with('success', 'CRM data saved successfully!');
    }

    public function edit($id)
{
    $client = Crm::findOrFail($id);
    return view('crm.edit', compact('client'));
}

public function update(Request $request, $id)
{
    $client = Crm::findOrFail($id);

    $request->validate([
        'category' => 'required|string|max:255',
        'name'     => 'required|string|max:255',
        'company'  => 'required|string|max:255',
        'email'    => 'required|email|unique:crm,email,' . $client->id,
        'address'  => 'nullable|string|max:255',
        'notes'    => 'nullable|string',
        'phone'    => 'nullable|string|max:20',
        'website'  => 'nullable|url|max:255',
    ]);

    $client->update($request->all());

    return redirect()->route('crm.index')->with('success', 'CRM data updated successfully!');
}

public function destroy($id)
{
    $client = Crm::findOrFail($id);
    $client->delete();

    return redirect()->route('crm.index')->with('success', 'CRM data deleted successfully!');
}

public function formCrm()
{
    return view('crm.form');
}

public function sumbitForm(Request $request)
{
    $request->validate([
            'category' => 'required|string|max:255',
            'name'     => 'required|string|max:255',
            'company'  => 'required|string|max:255',
            'email'    => 'required|email|unique:crm,email',
            'address'  => 'nullable|string|max:255',
            'notes'    => 'nullable|string',
            'phone'    => 'nullable|string|max:20',
            'website'  => 'nullable|url|max:255',
        ]);

        Crm::create($request->all());

        return response()->json([
        'status' => 'success',
        'message' => 'Data has been successfully added!'
    ]);


}

}
