<?php 

/*=============================================
Traer categorías desde la BD
=============================================*/

$url = "categories?linkTo=status_category&equalTo=1";
$method = "GET";
$fields = array();

$categories = CurlController::request($url,$method,$fields);

if($categories->status == 200){

	$categories = $categories->results;

}else{

	$categories = array();
}

?>

<!--===================================
JD SLIDER	
=====================================-->

<div class="jd-slider mb-0 pb-0">
	
	<div class="slide-inner">
		
		<ul class="slide-area">

			<?php if (!empty($categories)): ?>

				<li>

					<div class="border-0 rounded text-center bg-white mx-1 p-3 pb-0 loadCategory" idCategory="all">
							
						<img src="http://cms.pos.com/views/assets/files/67e1b44dd86f045.png" class="img-fluid mx-auto" style="width:50px; cursor:pointer">
						<p class="pt-2 mb-0 lead" style="cursor:move"><strong>Todo</strong></p>

						<p class="small pb-3" style="cursor:move">0 items</p>

					</div>
					
				</li>

				<?php foreach ($categories as $key => $value): ?>

					<li>
						
						<div class="border-0 rounded text-center bg-white mx-1 p-3 pb-0 loadCategory" idCategory="<?php echo $value->id_category ?>">
							
							<img src="<?php echo urldecode($value->img_category) ?>" class="img-fluid mx-auto" style="width:50px; cursor:pointer">
							<p class="pt-2 mb-0 lead" style="cursor:move"><strong><?php echo urldecode($value->title_category) ?></strong></p>

							<p class="small pb-3" style="cursor:move">0 items</p>

						</div>
					</li>
					
				<?php endforeach ?>
				
			<?php endif ?>
			

		</ul>

		<a href="#" class="prev ps-1">	
			<i class="bi bi-chevron-left"></i>
		</a>

		<a href="#" class="next ps-1">	
			<i class="bi bi-chevron-right"></i>
		</a>

	</div>

	<div class="controller d-none">
		<div class="indicate-area"></div>	
	</div>

</div>
