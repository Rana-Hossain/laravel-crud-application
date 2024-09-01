<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class ProductController extends Controller
{

    public function export()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    public function index(Request $request)
    {
        // Get all categories for the filter dropdown
        $categories = Category::pluck('name');

        // Build the query
        $query = Product::query();

        // Apply search filter
        if ($search = $request->input('search')) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
        }

        // Apply category filter
        if ($category = $request->input('category')) {
            if ($category != '') {
                $query->where('category', $category);
            }
        }

        // Apply price range filter
        $priceMin = $request->input('price_min');
        $priceMax = $request->input('price_max');
        if ($priceMin || $priceMax) {
            if ($priceMin) {
                $query->where('price', '>=', $priceMin);
            }
            if ($priceMax) {
                $query->where('price', '<=', $priceMax);
            }
        }

        // Apply quantity range filter
        $qtyMin = $request->input('qty_min');
        $qtyMax = $request->input('qty_max');
        if ($qtyMin || $qtyMax) {
            if ($qtyMin) {
                $query->where('qty', '>=', $qtyMin);
            }
            if ($qtyMax) {
                $query->where('qty', '<=', $qtyMax);
            }
        }
        if ($sort = $request->input('sort')) {
            $query->orderBy('name', $sort);
        } else {
            // Default sorting by ascending order
            $query->orderBy('name', 'asc');
        }

        // Get filtered products
        $products = $query->get();

        if ($request->ajax()) {
            return view('products.partials.product-list', compact('products'))->render();
        }

        return view('products.index', compact('products', 'categories'));
    }
    public function create()
    {
        $categories = DB::table('products_catagory')->pluck('name');
        return view('products.create', ['categories' => $categories]);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=> 'required',
            'qty'=> 'required|numeric',
            'price'=> 'required|decimal:0,2',
            'description'=> 'nullable',
            'category'=>'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }
        Product::create($data);
        return redirect(route('product.index'));
    }

    public function edit(Product $product)
    {
        $categories = DB::table('products_catagory')->pluck('name');
        return view('products.update', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    public function update(Product $product, Request $request)
    {
        $data = $request->validate([
            'name'=> 'required',
            'qty'=> 'required|numeric',
            'price'=> 'required|decimal:0,2',
            'description'=> 'nullable',
            'category'=>'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }
        $product->update($data);
        return redirect(route('product.index'))->with('success','Product Updated Successfully');
    }

    public function delete(Product $product)
    {
        $product->delete();
        return redirect(route('product.index'))->with('success','Product Deleted Successfully');
    }

}
