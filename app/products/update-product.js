$(document).ready(function () {

    $(document).on('click', '.update-product-button', function () {

        var id = $(this).attr('data-id');

        $.getJSON("http://localhost/woocommerce-api-mirror/product/read_one.php?id=" + id, function (data) {


            // values will be used to fill out our form
            var name = data.name;
            var price = data.price;
            var description = data.description;
            var update_product_html = "";

            // build 'update product' html form
            // we used the 'required' html5 property to prevent empty fields
            update_product_html += "<div id='read-products' class='btn btn-primary pull-right m-b-15px read-products-button'>";
            update_product_html += "<span class='glyphicon glyphicon-list'></span> Read Products";
            update_product_html += "</div>";
            update_product_html += "<form id='update-product-form' action='#' method='post' border='0'>";
            update_product_html += "<table class='table table-hover table-responsive table-bordered'>";

            // name field
            update_product_html += "<tr>";
            update_product_html += "<td>Name</td>";
            update_product_html += "<td><input value=\"" + name + "\" type='text' name='name' class='form-control' required /></td>";
            update_product_html += "</tr>";

            // price field
            update_product_html += "<tr>";
            update_product_html += "<td>Price</td>";
            update_product_html += "<td><input value=\"" + price + "\" type='number' min='1' name='price' class='form-control' required /></td>";
            update_product_html += "</tr>";

            // description field
            update_product_html += "<tr>";
            update_product_html += "<td>Description</td>";
            update_product_html += "<td><textarea name='description' class='form-control' required>" + description + "</textarea></td>";
            update_product_html += "</tr>";

            // hidden 'product id' to identify which record to delete
            update_product_html += "<td><input value=\"" + id + "\" name='id' type='hidden' /></td>";


            update_product_html += "<td>";
            update_product_html += "<button type='submit' class='btn btn-info'>";
            update_product_html += "<span class='glyphicon glyphicon-edit'></span> Update Product";
            update_product_html += "</button>";
            update_product_html += "</td>";

            update_product_html += "</tr>";

            update_product_html += "</table>";
            update_product_html += "</form>";
            $("#page-content").html(update_product_html);
        });

        $(document).on('submit', '#update-product-form', function () {

            var form_data = JSON.stringify($(this).serializeObject());
            $.ajax({
                url: "http://localhost/woocommerce-api-mirror/product/update.php",
                method: "POST",
                data: form_data,
                success: function (result) {
                    console.log("success ::" + form_data);
                    showProducts();
                },
                error: function (xhr, resp, text) {
                    console.log("error ::" + form_data);
                    console.log(xhr, resp, text);
                }
            });

            return false;
        });

    });




});