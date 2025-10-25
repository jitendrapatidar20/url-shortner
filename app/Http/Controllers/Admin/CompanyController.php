<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends BaseController
{
   
    public function index()
    {
        return view('admin.companies.index');
    }

    public function list(Request $request)
    {
        if (!$request->ajax()) {
            return abort(403);
        }

        $filter = $request->get('filter');
        $dateFilter = null;


        if ($filter === 'week') {
            $dateFilter = now()->subWeek();
        } elseif ($filter === 'month') {
            $dateFilter = now()->subMonth();
        }

        // fix N+1 issue
        $companies = Company::withCount([
                'users',
                'shortUrls as total_urls' => function ($query) use ($dateFilter) {
                    if ($dateFilter) {
                        $query->where('created_at', '>=', $dateFilter);
                    }
                },
            ])
            ->withSum([
                'shortUrls as total_hits' => function ($query) use ($dateFilter) {
                    if ($dateFilter) {
                        $query->where('created_at', '>=', $dateFilter);
                    }
                }
            ], 'hits')
            ->get(['id', 'name']);

        $data = $companies->map(function ($company) {
            return [
                'id' => $company->id,
                'name' => $company->name,
                'total_users' => $company->users_count,
                'total_urls' => $company->total_urls ?? 0,
                'total_hits' => $company->total_hits ?? 0,
            ];
        });

        return response()->json(['data' => $data]);
    }


    public function create()
    {
        return view('admin.companies.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255|unique:companies,name',
        ], [
            'client_name.unique' => 'A company with this name already exists.',
        ]);

        Company::create([
            'name' => $request->client_name,
        ]);

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'Client created successfully.');
    }


    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('admin.companies.edit', compact('company'));
    }

   
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:companies,name,' . $id,
        ]);

        $company->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'Client detail updated successfully.');
    }


    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json(['success' => true]);
    }
}
