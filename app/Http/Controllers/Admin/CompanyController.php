<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
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
        if ($request->ajax()) {

            $filter = $request->get('filter'); 
            $companies = Company::with(['users', 'shortUrls'])->get()->map(function ($company) use ($filter) {
                $urlsQuery = $company->shortUrls();
                if ($filter === 'week') {
                    $urlsQuery->where('created_at', '>=', now()->subWeek());
                } elseif ($filter === 'month') {
                    $urlsQuery->where('created_at', '>=', now()->subMonth());
                }
                $urls = $urlsQuery->get();

                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'total_users' => $company->users()->count(),
                    'total_urls' => $urls->count(),
                    'total_hits' => $urls->sum('hits'),
                ];
            });
            return response()->json(['data' => $companies]);
        }
        return abort(403);
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

        $company = Company::create([
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
        $company->update($request->all());
        return redirect()->route('admin.companies.index')->with('success', 'Client detail is updated successfully.');
    }

    public function destroy($id)
    {
        Company::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}

