<?php
namespace App\Http\Controllers;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class RedirectController extends BaseController {
    public function resolve(Request $request, $code) {
       $short = ShortUrl::where('short_code', $code)->firstOrFail();
       $short->increment('hits');
       return redirect()->away($short->original_url);
    }
}
