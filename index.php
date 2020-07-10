<?php
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});

$productModel = new ProductModel();
$productList = $productModel->getProducts();

$categoryModel = new CategoryModel();
$categoryList = $categoryModel->getCategoryList();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/public/css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <!--Danh muc san pham-->
            <div class="col-md-3">
                <h1>Categories</h1>
                <ul>
                    <?php
                    foreach ($categoryList as $cat) {
                    ?>
                        <li>
                            <input onclick="checkboxChanged(this)" type="checkbox" name="categories" id="cat_<?php echo $cat['category_id'] ?>" value="<?php echo $cat['category_id'] ?>">
                            <label for="cat_<?php echo $cat['category_id'] ?>"><?php echo $cat['category_name'] ?></label>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <!-- Danh sach san pham -->
            <div class="col-md-9" id="list-product">
                <h1>Products</h1>
                <?php
                foreach ($productList as $item) {
                    $pName = strtolower(str_replace(' ', '-', $item['product_name']));
                ?>
                    <div class="row">
                        <div class="col-md-2">
                            <img src="/<?php echo BASE_URL; ?>/public/images/<?php echo $item['product_image'] ?>" alt="" class="img-fluid" onclick="getProduct(<?php echo $item['product_id']; ?>)">
                        </div>
                        <div class="col-md-10">
                            <h4><a href="/<?php echo BASE_URL; ?>/product.php/<?php echo $pName . '-' . $item['product_id']; ?>"><?php echo $item['product_name']; ?></a></h4>
                            <p><?php echo $item['product_price']; ?></p>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

            <script>
                $('input[type=checkbox]').on('change', async function(e, target) {
                    let arr_cat_selected = [];
                    let arr_cat = document.getElementsByName('categories');

                    //Duyet tat ca cac checkbox duoc check
                    arr_cat.forEach(function(e) {
                        if (document.getElementById(e.value).checked) {
                            let id_cat_selected = e.value.split('_')[1];
                            arr_cat_selected.push(id_cat_selected)
                        }
                    })

                    //Tao du lieu de lay du lieu backend
                    const url = 'productByIdCategory.php';
                    const data = {
                        arr_id_cat: arr_cat_selected
                    };
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });

                    const result = await response.json();

                    //Xoa va tao thanh phan va add vao trong list-product
                    var listView = document.getElementById('list-product');
                    listView.innerHTML = '<h1>Products</h1>';

                    result.forEach((item) => {
                        let row_item = document.createElement('div');
                        row_item.className = 'row';
                        row_item.innerHTML = `
                        <div class="col-md-2">
                            <img src="/fe2_ajax_w10/public/images/${item.product_image}" alt="" class="img-fluid" onclick="getProduct(${item.product_id})">
                        </div>
                        <div class="col-md-10">
                            <h4><a href="/<?php echo BASE_URL; ?>/product.php/${item.product_name}-${item.product_id}">${item.product_name}</a></h4>
                            <p>${item.product_price}</p>
                        </div>
                        `;
                        listView.appendChild(row_item)
                    })
                });
            </script>
</body>

</html>