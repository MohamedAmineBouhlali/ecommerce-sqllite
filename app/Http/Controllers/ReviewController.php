<?php

namespace App\Http\Controllers;

use App\Services\ReviewService;
use App\Models\Product;
use App\Http\Requests\StoreReviewRequest;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(
        private ReviewService $reviewService
    ) {}

    public function store(StoreReviewRequest $request, Product $product)
    {
        $this->reviewService->createReview($request->user(), $product, $request->validated());

        return back()->with('message', 'Review submitted successfully. It will be published after approval.');
    }
}
