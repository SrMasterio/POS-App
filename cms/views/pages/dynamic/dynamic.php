<?php 

/*=============================================
Variable para actualizar el stock
=============================================*/

$updateStock = false;

/*=============================================
Abrir la página correspondiente del Dashboard
=============================================*/

if (!empty($routesArray[0])){

    $url = "relations?rel=modules,pages&type=module,page&linkTo=url_page&equalTo=".$routesArray[0];

    if($routesArray[0] == "pos" || $routesArray[0] == "productos"){

        $updateStock = true;

    }

}else{

    $url = "relations?rel=modules,pages&type=module,page&linkTo=order_page&equalTo=1";

    $updateStock = true;
}

$method = "GET";
$fields = array();

$modules = CurlController::request($url,$method,$fields);

if($modules->status == 200){

    $modules = $modules->results;
   

}else{

    $modules = array();

}

/*=============================================
Actualizar el stock
=============================================*/

if($updateStock){

    /*=============================================
    Traer los productos
    =============================================*/
    $url = "products?select=id_product";
    $method = "GET";
    $fields = array();

    $productsStock = CurlController::request($url,$method,$fields);
    
    if($productsStock->status == 200){

        $countStockProducts = 0;

        foreach ($productsStock->results as $key => $value) {

            /*=============================================
            Traer total de compras
            =============================================*/

            $url = "purchases?linkTo=id_product_purchase&equalTo=".$value->id_product."&select=qty_purchase";
            $purchases = CurlController::request($url,$method,$fields);
            
            $totalPurchaseProduct = 0;
         
            if($purchases->status == 200){

                foreach ($purchases->results as $index => $item) {

                    $totalPurchaseProduct += $item->qty_purchase;
                }
            }

            /*=============================================
            Traer total de ventas
            =============================================*/

            $url = "sales?linkTo=id_product_sale&equalTo=".$value->id_product."&select=qty_sale";
            $sales = CurlController::request($url,$method,$fields);

             $totalSaleProduct = 0;

            if($sales->status == 200){

              foreach ($sales->results as $index => $item) {

                $totalSaleProduct += $item->qty_sale;

              } 

            }

            /*=============================================
            Calcular compras menos ventas
            =============================================*/

            $arrayStock[$value->id_product] = ($totalPurchaseProduct - $totalSaleProduct);

            $countStockProducts++;

            if($countStockProducts == count($productsStock->results)){

                /*=============================================
                Actualizar stock en base de datos
                =============================================*/

                foreach ($arrayStock as $key => $value) {

                    $url = "products?id=".$key."&nameId=id_product&token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
                    $method = "PUT";
                    $fields = array(
                        "stock_product" => $value
                    );

                    $fields = http_build_query($fields);
                    $updateStock = CurlController::request($url,$method,$fields);

                }
             
            }
           
        }

    }
   
}

?>
    
<div class="container-fluid py-3 p-lg-4">
          
    <div class="row">

        <?php if (!empty($modules)): ?>

            <?php foreach ($modules as $key => $value): $module = $value ?>

                <!--=========================================
                Cuando el módulo es un breadcrumb
                ===========================================-->

                <?php if ($module->type_module == "breadcrumbs"): ?>

                    <?php include "breadcrumbs/breadcrumbs.php" ?>
                    
                <?php endif ?>

                <!--=========================================
                Cuando el módulo es una métrica
                ===========================================-->

                <?php if ($module->type_module == "metrics"): ?>

                    <?php include "metrics/metrics.php" ?>
                    
                <?php endif ?>

                <!--=========================================
                Cuando el módulo es un gráfico
                ===========================================-->

                <?php if ($module->type_module == "graphics"): ?>

                    <?php include "graphics/graphics.php" ?>
                    
                <?php endif ?>

                <!--=========================================
                Cuando el módulo es una tabla
                ===========================================-->

                <?php if ($module->type_module == "tables"): ?>

                    <?php include "tables/tables.php" ?>
                    
                <?php endif ?>

                <!--=========================================
                Cuando el módulo es personalizado
                ===========================================-->

                <?php if ($module->type_module == "custom"): ?>

                    <?php include "custom/".str_replace(" ","_",$module->title_module)."/".str_replace(" ","_",$module->title_module).".php" ?>
                    
                <?php endif ?>
   
            <?php endforeach ?>
            
        <?php endif ?>
    </div>

</div>

<script src="/views/assets/js/pos/pos.js"></script>