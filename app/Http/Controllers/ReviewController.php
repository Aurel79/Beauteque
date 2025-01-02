<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;


class ReviewController extends Controller
{

    public function admin_index()
    {
        $pageTitle = 'Reviews';
        confirmDelete();
        return view('admin.reviews.index', ['pageTitle' => $pageTitle]);
    }

    public function store(Request $request, $productId)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
        ];

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('image');

        if ($file != null) {
            $encryptedFilename = $file->hashName();

            // Store File
            $file->store('public/reviews');
        }

        $review = new Review();
        $review->product_id = $productId;
        $review->user_id = Auth::id();
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        if ($file != null) {
            $review->image = $encryptedFilename;
        }
        $review->save();

        Alert::success('Added Successfully', 'Review Submitted');

        return redirect()->route('products.show', $productId);
    }

    public function getReviews(Request $request)
    {
        $reviews = Review::with(['product', 'user'])
            ->orderBy('status', 'asc')
            ->get();
        if ($request->ajax()) {
            return datatables()->of($reviews)
                ->addIndexColumn()
                ->addColumn('actions', function ($review) {
                    return view('admin.reviews.actions', compact('review'));
                })
                ->toJson();
        }
    }

    public function valid(string $id)
    {
        $review = Review::find($id);
        $review->status = "valid";
        $review->save();
        Alert::success('Changed Successfully', 'Review Has Been Validated Successfully.');
        return redirect()->route('admin.reviews.index');
    }

    public function invalid(string $id)
    {
        $review = Review::find($id);
        $review->status = "invalid";
        $review->save();
        Alert::success('Changed Successfully', 'Review Has Been Validated Successfully.');
        return redirect()->route('admin.reviews.index');
    }

    public function destroy(string $id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        Alert::success('Deleted Successfully', 'Review Deleted  Successfully.');
        return redirect()->route('admin.reviews.index');
    }

}
