<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Отображает форму создания отзыва.
     */
    public function create(Request $request): View
    {
        $type = $request->input('type');
        $id = $request->input('id');
        
        if ($type === 'product') {
            $item = Product::findOrFail($id);
        } elseif ($type === 'service') {
            $item = Service::findOrFail($id);
        } else {
            abort(404);
        }
        
        return view('reviews.create', [
            'item' => $item,
            'type' => $type,
        ]);
    }
    
    /**
     * Сохраняет новый отзыв.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'reviewable_type' => 'required|in:product,service',
            'reviewable_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
        ]);
        
        $type = $request->input('reviewable_type');
        $id = $request->input('reviewable_id');
        
        // Определяем модель на основе типа
        $reviewableType = $type === 'product' ? Product::class : Service::class;
        
        // Проверяем, существует ли товар/услуга
        $reviewable = $reviewableType::findOrFail($id);
        
        // Проверяем, не оставлял ли пользователь уже отзыв
        $existingReview = Review::where('user_id', Auth::id())
            ->where('reviewable_id', $id)
            ->where('reviewable_type', $reviewableType)
            ->first();
            
        if ($existingReview) {
            return back()->with('error', 'Вы уже оставили отзыв для этого товара/услуги.');
        }
        
        // Создаем отзыв
        Review::create([
            'user_id' => Auth::id(),
            'reviewable_id' => $id,
            'reviewable_type' => $reviewableType,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'is_approved' => false, // По умолчанию отзыв нуждается в модерации
        ]);
        
        // Редирект на страницу товара/услуги
        if ($type === 'product') {
            return redirect()->route('catalog.products.show', $id)->with('success', 'Ваш отзыв успешно отправлен и будет опубликован после проверки модератором.');
        } else {
            return redirect()->route('catalog.services.show', $id)->with('success', 'Ваш отзыв успешно отправлен и будет опубликован после проверки модератором.');
        }
    }
    
    /**
     * Отображает список отзывов в админке для модерации.
     */
    public function index(): View
    {
        $this->authorize('viewAny', Review::class);
        
        $reviews = Review::with('user', 'reviewable')
            ->latest()
            ->paginate(20);
            
        return view('admin.reviews.index', [
            'reviews' => $reviews,
        ]);
    }
    
    /**
     * Одобряет отзыв.
     */
    public function approve(Review $review): RedirectResponse
    {
        $this->authorize('update', $review);
        
        $review->update([
            'is_approved' => true,
        ]);
        
        return back()->with('success', 'Отзыв успешно одобрен.');
    }
    
    /**
     * Отклоняет отзыв.
     */
    public function reject(Review $review): RedirectResponse
    {
        $this->authorize('update', $review);
        
        $review->delete();
        
        return back()->with('success', 'Отзыв успешно удален.');
    }
}
