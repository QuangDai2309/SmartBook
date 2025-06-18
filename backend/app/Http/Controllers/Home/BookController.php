<?php

namespace App\Http\Controllers\Home;

use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Banner;

class BookController extends Controller
{
    public function index()
    {
        // 5 sách giấy được thích nhiều nhất
        $topLikedBooks = Book::with(['author', 'category', 'publisher'])
            ->where('is_physical', 0)
            ->orderByDesc('likes')
            ->take(5)
            ->get();

        // 5 sách giấy được xem nhiều nhất
        $topViewedBooks = Book::with(['author', 'category', 'publisher'])
            ->where('is_physical', 0)
            ->orderByDesc('views')
            ->take(5)
            ->get();

        // 10 sách giấy mới nhất
        $latestPaperBooks = Book::with(['author', 'category', 'publisher'])
            ->where('is_physical', 0)
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        // 10 sách ebook mới nhất
        $latestEbooks = Book::with(['author', 'category', 'publisher'])
            ->where('is_physical', 1)
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        return response()->json([
            'status' => 'success',
            'top_liked_books' => $topLikedBooks,         // 5 sách giấy yêu thích nhất
            'top_viewed_books' => $topViewedBooks,       // 5 sách giấy xem nhiều nhất
            'latest_paper_books' => $latestPaperBooks,   // 10 sách giấy mới
            'latest_ebooks' => $latestEbooks             // 10 sách điện tử mới
        ]);
    }

    public function search(Request $request)
{
    $query = Book::with(['author', 'category', 'publisher']);
    
    // Search theo tên sách
    if ($request->has('name') && !empty($request->name)) {
        $query->where('title', 'LIKE', '%' . $request->name . '%');
    }
    
    // Filter theo category (có thể truyền ID hoặc tên)
    if ($request->has('category') && !empty($request->category)) {
        $category = $request->category;
        // Nếu là số thì search theo ID, không thì search theo tên
        if (is_numeric($category)) {
            $query->where('category_id', $category);
        } else {
            $query->whereHas('category', function($q) use ($category) {
                $q->where('name', 'LIKE', '%' . $category . '%');
            });
        }
    }
    
    // Filter theo author (có thể truyền ID hoặc tên)
    if ($request->has('author') && !empty($request->author)) {
        $author = $request->author;
        // Nếu là số thì search theo ID, không thì search theo tên
        if (is_numeric($author)) {
            $query->where('author_id', $author);
        } else {
            $query->whereHas('author', function($q) use ($author) {
                $q->where('name', 'LIKE', '%' . $author . '%');
            });
        }
    }
    
    // Filter theo publisher (có thể truyền ID hoặc tên)
    if ($request->has('publisher') && !empty($request->publisher)) {
        $publisher = $request->publisher;
        if (is_numeric($publisher)) {
            $query->where('publisher_id', $publisher);
        } else {
            $query->whereHas('publisher', function($q) use ($publisher) {
                $q->where('name', 'LIKE', '%' . $publisher . '%');
            });
        }
    }
    
    // Filter theo giá cụ thể
    if ($request->has('price') && !empty($request->price)) {
        $query->where('price', $request->price);
    }
    
    // Filter theo khoảng giá
    if ($request->has('price_min') && !empty($request->price_min)) {
        $query->where('price', '>=', $request->price_min);
    }
    
    if ($request->has('price_max') && !empty($request->price_max)) {
        $query->where('price', '<=', $request->price_max);
    }
    
    // Filter theo khoảng giá định sẵn
    if ($request->has('price_range') && !empty($request->price_range)) {
        switch ($request->price_range) {
            case 'free':
                $query->where('price', 0);
                break;
            case 'cheap':      // Dưới 50k
                $query->where('price', '>', 0)->where('price', '<', 50000);
                break;
            case 'medium':     // 50k - 150k
                $query->whereBetween('price', [50000, 150000]);
                break;
            case 'expensive':  // 150k - 300k
                $query->whereBetween('price', [150000, 300000]);
                break;
            case 'premium':    // Trên 300k
                $query->where('price', '>', 300000);
                break;
        }
    }
    
    // Filter theo loại sách
    if ($request->has('type') && $request->type !== '') {
        // type=paper (sách giấy) hoặc type=ebook
        if ($request->type === 'paper') {
            $query->where('is_physical', 0);
        } elseif ($request->type === 'ebook') {
            $query->where('is_physical', 1);
        }
    }
    
    // Filter theo stock
    if ($request->has('available') && $request->available !== '') {
        if ($request->available == 1 || $request->available === 'true') {
            $query->where('stock', '>', 0);
        } else {
            $query->where('stock', 0);
        }
    }
    
    // Sắp xếp
    $sort = $request->get('sort', 'newest'); // mặc định sắp xếp mới nhất
    
    switch ($sort) {
        case 'newest':
            $query->orderBy('created_at', 'desc');
            break;
        case 'oldest':
            $query->orderBy('created_at', 'asc');
            break;
        case 'price_low':
            $query->orderBy('price', 'asc');
            break;
        case 'price_high':
            $query->orderBy('price', 'desc');
            break;
        case 'popular':
            $query->orderBy('views', 'desc');
            break;
        case 'liked':
            $query->orderBy('likes', 'desc');
            break;
        case 'name_az':
            $query->orderBy('title', 'asc');
            break;
        case 'name_za':
            $query->orderBy('title', 'desc');
            break;
        default:
            $query->orderBy('created_at', 'desc');
    }
    
    // Phân trang
    $limit = $request->get('limit', 12); // mặc định 10 items
    $limit = min($limit, 50); // tối đa 50 items
    
    // Lấy kết quả
    if ($request->has('all') && $request->all == 1) {
        // Lấy tất cả không phân trang
        $books = $query->get();
        $result = [
            'status' => 'success',
            'data' => $books,
            'total' => $books->count()
        ];
    } else {
        // Có phân trang
        $books = $query->paginate($limit);
        $result = [
            'status' => 'success',
            'data' => $books->items(),
            'pagination' => [
                'current_page' => $books->currentPage(),
                'last_page' => $books->lastPage(),
                'per_page' => $books->perPage(),
                'total' => $books->total(),
                'from' => $books->firstItem(),
                'to' => $books->lastItem(),
                'has_more' => $books->hasMorePages()
            ]
        ];
    }
    
    return response()->json($result);
}
// Helper function để hiển thị các filter đã áp dụng
private function getAppliedFilters(Request $request)
{
    $filters = [];
    
    if ($request->has('search') && !empty($request->search)) {
        $filters['search'] = $request->search;
    }
    
    if ($request->has('author_id') && !empty($request->author_id)) {
        $filters['author_id'] = $request->author_id;
    }
    
    if ($request->has('author_name') && !empty($request->author_name)) {
        $filters['author_name'] = $request->author_name;
    }
    
    if ($request->has('category_id') && !empty($request->category_id)) {
        $filters['category_id'] = $request->category_id;
    }
    
    if ($request->has('category_name') && !empty($request->category_name)) {
        $filters['category_name'] = $request->category_name;
    }
    
    if ($request->has('publisher_id') && !empty($request->publisher_id)) {
        $filters['publisher_id'] = $request->publisher_id;
    }
    
    if ($request->has('is_physical') && $request->is_physical !== '') {
        $filters['is_physical'] = $request->is_physical;
    }
    
    if ($request->has('price_min') && !empty($request->price_min)) {
        $filters['price_min'] = $request->price_min;
    }
    
    if ($request->has('price_max') && !empty($request->price_max)) {
        $filters['price_max'] = $request->price_max;
    }
    
    if ($request->has('price_range') && !empty($request->price_range)) {
        $filters['price_range'] = $request->price_range;
    }
    
    if ($request->has('in_stock') && $request->in_stock !== '') {
        $filters['in_stock'] = $request->in_stock;
    }
    
    if ($request->has('sort_by') && !empty($request->sort_by)) {
        $filters['sort_by'] = $request->sort_by;
    }
    
    if ($request->has('sort_order') && !empty($request->sort_order)) {
        $filters['sort_order'] = $request->sort_order;
    }
    
    return $filters;
}


    // Chi tiết sách
    public function show($id)
    {
        $book = Book::with(['author', 'publisher', 'category'])->find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found1'], 404);
        }

        if ($book->is_physical == 1) {
            // Sách giấy
            return response()->json([
                'id' => $book->id,
                'title' => $book->title,
                'description' => $book->description,
                'cover_image' => $book->cover_image,
                'author' => $book->author ? [
                    'id' => $book->author->id,
                    'name' => $book->author->name,
                ] : null,
                'publisher' => $book->publisher ? [
                    'id' => $book->publisher->id,
                    'name' => $book->publisher->name,
                ] : null,
                'category' => $book->category ? [
                    'id' => $book->category->id,
                    'name' => $book->category->name,
                ] : null,
                'price' => $book->price,
                'stock' => $book->stock,
                'views' => $book->views,
                'likes' => $book->likes,
                'format' => 'paper',
            ]);
        } elseif ($book->is_physical == 0) {
            // Sách điện tử
            return response()->json([
                'id' => $book->id,
                'title' => $book->title,
                'description' => $book->description,
                'cover_image' => $book->cover_image,
                'author' => $book->author ? [
                    'id' => $book->author->id,
                    'name' => $book->author->name,
                ] : null,
                'publisher' => $book->publisher ? [
                    'id' => $book->publisher->id,
                    'name' => $book->publisher->name,
                ] : null,
                'category' => $book->category ? [
                    'id' => $book->category->id,
                    'name' => $book->category->name,
                ] : null,
                'views' => $book->views,
                'likes' => $book->likes,
                'format' => 'ebook',
            ]);
        } else {
            return response()->json(['message' => 'Unknown book type'], 400);
        }
    }
}
    