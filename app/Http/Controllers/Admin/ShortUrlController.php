<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\ShortUrl;
use Illuminate\Support\Str;



class ShortUrlController extends BaseController
{


      public function index(Request $request) 
      {
       
        if ($request->ajax()) {

            $user = $request->user();
            $filter = $request->get('filter');
            $query = ShortUrl::visibleTo($user)->with('creator','company');

            if ($filter === 'week') {
                $query->where('created_at', '>=', now()->subWeek());
            } elseif ($filter === 'month') {
                $query->where('created_at', '>=', now()->subMonth());
            }
            $items = $query->get()->map(function ($s) {
                return [
                    'id' => $s->id,
                    'short_code' => $s->short_code,
                    'original_url' => $s->original_url,
                    'resolve_url' => url('/r/'.$s->short_code),
                    'created_by' => $s->creator?->name,
                    'company' => $s->company?->name,
                    'hits' => $s->hits,
                ];
            });
            return response()->json(['data' => $items]);
        }
         return view('admin.short_urls.index');
    }

    public function create(){
        return view('admin.short_urls.create');
    }

    public function store(Request $request){
        $user = $request->user();

        // Option B: Admin & Member can create, SuperAdmin cannot
        if ($user->isRole('SuperAdmin')) {
            return redirect()->route('admin.short_urls.index')->with('error', 'SuperAdmin cannot create short urls.');
        }

        $request->validate(['original_url'=>'required|url']);

        $shortCode = Str::lower(Str::random(6));
        while (ShortUrl::where('short_code', $shortCode)->exists()) {
            $shortCode = Str::lower(Str::random(6));
        }
        $accessToken = Str::random(40);

        $short = ShortUrl::create([
            'short_code'=>$shortCode,
            'original_url'=>$request->original_url,
            'created_by'=>$user->id,
            'company_id'=>$user->company_id,
        ]);

        return redirect()->route('admin.short_urls.index')->with('success','Short URL created: '.url('/r/'.$shortCode));
    }
}
