$(document).ready(function() {
  $("#productTable").DataTable({
      serverSide: true,
      processing: true,
      ajax: {
        url: "/admin/getProducts",
        dataSrc: function (json) {
          return json.data;
        }
      },
      columns: [
        { data: "id", name: "id", visible: false },
        { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false },
        { data: "name", name: "name" },
        { data: "brand", name: "brand" },
        { data: "description", name: "description" },
        { data: "price", name: "price" },
        {
            data: "reviews_avg_rating", 
            name: "reviews_avg_rating",
            render: function(data, type, row) {
              if (data !== null && data !== undefined) {
                const rating = parseFloat(data);
                const avgRating = rating.toFixed(1);
                const count = row.reviews_count;
                var result = `${avgRating} (${count} rating)`;
                return result;
              } else {
                return `No rating yet`;
              }
            }
          },
        { 
          data: "image", 
          name: "image", 
          render: function(data, type, row) {
              return `<img src="/storage/products/${data}" alt="Product Image" class="img-thumbnail" style="width: 80px; height: auto;">`;
          },
          orderable: false,
          searchable: false
        },
        { data: "actions", name: "actions", orderable: false, searchable: false }
      ],
      order: [
          [0, "desc"]
      ],
      lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"],
      ],
  });
  $("#reviewTable").DataTable({
    serverSide: true,
    processing: true,
    ajax: {
      url: "/admin/getReviews",
      dataSrc: function (json) {
        return json.data;
      }
    },
    columns: [
      { data: "id", name: "id", visible: false },
      { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false },
      { data: "user.name", name: "name" },
      { data: "product.name", name: "product.name" },
      { data: "comment", name: "comment" },
      { data: "rating", name: "rating" },
      { 
        data: "image", 
        name: "image", 
        render: function(data, type, row) {
            return `<img src="/storage/reviews/${data}" alt="Product Image" class="img-thumbnail" style="width: 80px; height: auto;">`;
        },
        orderable: false,
        searchable: false
      },
      { data: "status", name: "status" },
      { data: "actions", name: "actions", orderable: false, searchable: false }
    ],
    order: [
        [0, "desc"]
    ],
    lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"],
    ],
  });
  $(".datatable").on("click", ".btn-delete", function(e) {
      e.preventDefault();
      var form = $(this).closest("form");
      var name = $(this).data("name");
      Swal.fire({
          title: "Are you sure want to delete\n" + name + "?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonClass: "bg-primary",
          confirmButtonText: "Yes, delete it!",
      }).then((result) => {
          if (result.isConfirmed) {
              form.submit();
          }
      });
  });
});