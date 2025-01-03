<div class="d-flex">
  <a href="{{ route('products.show', $product->id) }}" target="_blank" class="btn btn-outline-dark btn-sm me-2"><i
          class="bi-list"></i></a>
  <a href="{{ route('admin.products.edit', ['product' => $product->id]) }}" class="btn btn-outline-dark btn-sm me-2"><i
          class="bi-pencil-square"></i></a>

  <div>
      <form action="{{ route('admin.products.destroy', ['product' => $product->id]) }}" method="POST">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-outline-dark btn-sm me-2 btn-delete"
              data-name="{{ $product->name }}">
              <i class="bi-trash"></i>
          </button>
      </form>
  </div>
</div>