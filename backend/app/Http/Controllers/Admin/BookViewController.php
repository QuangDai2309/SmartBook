<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookView;
use Illuminate\Http\Request;

class BookViewController extends Controller
{
    public function index(Request $request)
    {
        $views = BookView::with(['book', 'user'])
            ->orderByDesc('last_viewed_at')
            ->paginate(10);

        return view('admin.book_views.index', compact('views'));
    }
}
