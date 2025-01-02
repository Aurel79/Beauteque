<div class="d-flex">

    @if ($review->status == 'on review')
        <a href="{{ route('admin.reviews.valid', ['review' => $review->id]) }}" class="btn btn-success btn-sm me-2"><i
                class="bi-check-lg"></i>Valid</a>
        <a href="{{ route('admin.reviews.invalid', ['review' => $review->id]) }}" class="btn btn-danger btn-sm me-2"><i
                class="bi-x-lg">Invalid</i></a>
    @endif
    <div>
        <form action="{{ route('admin.reviews.destroy', ['review' => $review->id]) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-outline-dark btn-sm me-2 btn-delete" data-name="{{ $review->name }}">
                <i class="bi-trash"></i>
            </button>
        </form>
    </div>
</div>
