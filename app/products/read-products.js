$(document).ready(function () {

    showProducts();

});

function showProducts() {

    $.getJSON("http://localhost/woocommerce-api-mirror/product/read.php", function (data) {
        var read_products_html = "";
        read_products_html += "<div id='create-product' class='btn btn-primary pull-right m-b-15px create-product-button'>";
        read_products_html += "<span class='glyphicon glyphicon-plus'></span> Create Product";
        read_products_html += "</div>";


        read_products_html += "<table class='table table-bordered table-hover'>";


        read_products_html += "<tr>";
        read_products_html += "<th class='w-25-pct'>Name</th>";
        read_products_html += "<th class='w-10-pct'>Price</th>";
        read_products_html += "<th class='w-15-pct'>Category</th>";
        read_products_html += "<th class='w-25-pct text-align-center'>Action</th>";
        read_products_html += "</tr>";

        $.each(data.records, function (key, val) {
            read_products_html += "<tr>";
            read_products_html += "<td>" + val.name + "</td>";
            read_products_html += "<td>$" + val.price + "</td>";
            read_products_html += "<td>" + val.category_name + "</td>";


            read_products_html += "<td>";
          
            read_products_html += "<button class='btn btn-info m-r-10px update-product-button' data-id='" + val.id + "'>";
            read_products_html += "<span class='glyphicon glyphicon-edit'></span> Edit";
            read_products_html += "</button>";


            read_products_html += "<button class='btn btn-danger delete-product-button' data-id='" + val.id + "'>";
            read_products_html += "<span class='glyphicon glyphicon-remove'></span> Delete";
            read_products_html += "</button>";
            read_products_html += "</td>";
            read_products_html += "</tr>";
                
        });
        read_products_html += "</table>";
        $("#page-content").html(read_products_html);
       
    });

  
}


$(document).on('click', '.read-products-button', function () {
    showProducts();
});