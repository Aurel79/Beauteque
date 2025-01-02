<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('reviews.user')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->get();
        return view('products.index', compact('products'));
    }

    public function admin_index()
    {
        $pageTitle = 'Products';
        confirmDelete();
        return view('admin.products.index', ['pageTitle' => $pageTitle]);
    }

    public function getProducts(Request $request)
    {
        $products = Product::with('reviews.user')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->get();
        if ($request->ajax()) {
            return datatables()->of($products)
                ->addIndexColumn()
                ->addColumn('actions', function ($product) {
                    return view('admin.products.actions', compact('product'));
                })
                ->toJson();
        }
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'numeric' => 'Isi :attribute dengan angka'
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'brand' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get File
        $file = $request->file('image');

        if ($file != null) {
            $encryptedFilename = $file->hashName();
            $file->store('public/products');
        }

        // ELOQUENT
        $product = new Product;
        $product->name = $request->name;
        $product->brand = $request->brand;
        $product->description = $request->description;
        $product->price = $request->price;

        if ($file != null) {
            $product->image = $encryptedFilename;
        }

        $product->save();

        Alert::success('Added Successfully', 'Product Added Successfully.');

        return redirect()->route('admin.products.index');
    }

    public function show(string $id)
    {
        $pageTitle = 'Product Detail';

        $product = Product::with('reviews.user')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->find($id);
        $reviews = Review::where('product_id', $id)->get();
        return view('products.show', compact('pageTitle', 'product', 'reviews'));
    }

    public function edit(string $id)
    {
        $pageTitle = 'Edit Product';
        $product = Product::find($id);
        return view('admin.products.edit', compact('pageTitle', 'product'));
    }

    public function update(Request $request, string $id)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'numeric' => 'Isi :attribute dengan angka'
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'brand' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('image');

        if ($file != null) {
            $encryptedFilename = $file->hashName();
            $file->store('public/products');
        }

        $product = Product::find($id);
        $product->name = $request->name;
        $product->brand = $request->brand;
        $product->description = $request->description;
        $product->price = $request->price;

        if ($file) {
            if ($product->image) {
                $oldFile = 'public/products/' . $product->image;
                if (Storage::exists($oldFile)) {
                    Storage::delete($oldFile);
                }
            }
            $encryptedFilename = $file->hashName();

            $file->store('public/products');
            $product->image = $encryptedFilename;
        }

        $product->save();
        Alert::success('Changed Successfully', 'Product Data Changed Successfully.');
        return redirect()->route('admin.products.index');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            $filePath = 'public/products/' . $product->image;
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
        }
        $product->delete();
        Alert::success('Deleted Successfully', 'Product Data Deleted  Successfully.');

        return redirect()->route('admin.products.index');
    }
}
