<?php

$limit = 6;
$url = "relations?rel=products,categories&type=product,category&linkTo=status_product&equalTo=1&orderBy=id_product&orderMode=DESC&startAt=0&endAt=".$limit;
$method = "GET";
$fields = array();

$products = CurlController::request($url,$method,$fields);

if($products->status == 200){

	$products = $products->results; 

	/*=============================================
	Traer Total de productos
	=============================================*/

	$url = "relations?rel=products,categories&type=product,category&linkTo=status_product&equalTo=1";

	$totalPageProducts = ceil(CurlController::request($url,$method,$fields)->total/$limit);

}else{

	$products = array();
}

?>

<?php if (!empty($products)): ?>

	<div class="row p-2 viewProducts">
		
		<?php foreach ($products as $key => $value): ?>

			<div class="col-12 col-lg-6 col-xl-4 p-2 btn addProductPos" idProduct="<?php echo $value->id_product ?>">
				
				<div class="card rounded border-0 position-relative">

					<?php if ($value->discount_product > 0): ?>

						<div class="position-absolute small bg-red p-1 shadow-sm rounded" style="top:4px; left:4px; font-size:10px"><?php echo $value->discount_product ?>% OFF</div>
						
					<?php endif ?>
					
					<div class="position-absolute small bg-white p-1 shadow-sm rounded" style="top:4px; right:4px; font-size:10px"><?php echo $value->sku_product ?></div>

					<img src="<?php echo urldecode($value->img_product) ?>" class="card-img-top px-5 py-3 mx-auto" style="width:200px !important">

					<div class="card-body">
						
						<h6 class="font-weight-bold text-gray samll"><?php echo urldecode($value->title_category) ?></h6>
						<h6 class="card-title pb-2 font-weight-bold"><?php echo urldecode($value->title_product) ?></h6>

						<div class="d-flex justify-content-between">

							<?php 

							if($value->stock_product < 50){

								$colorStock = "bg-maroon";
							}

							if($value->stock_product >= 50 && $value->stock_product < 100){

								$colorStock = "bg-indigo";
							}

							if($value->stock_product >= 100){

								$colorStock = "bg-teal";
							}

							?>

							<div class="card-text small h6 badge badge-default pb-0 <?php echo $colorStock  ?>" style="font-size:10px; padding-top:6px">
								
								<?php echo $value->stock_product ?>

							</div>

							<?php 

							$url = "purchases?linkTo=id_product_purchase&equalTo=".$value->id_product."&select=price_purchase";

							$price = CurlController::request($url,$method,$fields);

							if($price->status == 200){

								$price = $price->results[0]->price_purchase;

								if($value->discount_product > 0){

									$discount = $price-($price*($value->discount_product/100));
								}

							}else{

								$price = 0;
							}

							?>

<?php
if ($value->discount_product > 0) {
    $discount = $price - ($price * ($value->discount_product / 100));
} else {
    $discount = $price; // Evita el error en caso de que no haya descuento
}
?>

<?php if ($value->discount_product > 0): ?>
    <span class="small ms-auto pe-1 h6 mt-1 text-red font-weight-bold" style="font-size:12px">
        <s>$ <?php echo number_format($price,2) ?></s>
    </span>

    <div class="small h6 mt-1 textColor font-weight-bold">
        <strong>$ <?php echo number_format($discount,2) ?></strong>
    </div>
<?php else: ?>
    <div class="small h6 mt-1 textColor font-weight-bold">
        <strong>$ <?php echo number_format($price,2) ?></strong>
    </div>
<?php endif; ?>


						</div>

					</div>

				</div>
			</div>
			
		<?php endforeach ?>

	</div>

<?php else: ?>

	<div class="row p-2 my-5 text-center">

		<p>No hay productos agregados.</p>

	</div>
	
<?php endif ?>