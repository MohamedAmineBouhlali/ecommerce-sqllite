<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CatalogController extends Controller
{
    public function __construct(
        private ProductService $productService,
        private CategoryService $categoryService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['category_id', 'search', 'featured', 'min_price', 'max_price', 'sort_by', 'sort_order']);
        $products = $this->productService->getProducts($filters, 12);
        $categories = $this->categoryService->getAllCategories(true);

        return Inertia::render('Catalog/Index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $filters,
        ]);
    }

    public function show(string $slug)
    {
        $product = $this->productService->getProductBySlug($slug);

        if (!$product) {
            abort(404);
        }

        $this->productService->incrementViews($product);

        $relatedProducts = $this->productService->getProducts([
            'category_id' => $product->category_id,
        ], 4)->items();

        return Inertia::render('Catalog/Show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
