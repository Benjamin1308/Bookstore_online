<?php 
session_start();

    // $connection=new PDO('mysql:host=localhost;dbname=ban_sach_online_db','root','');
    // $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);    
    $data = json_decode(file_get_contents("php://input"));
    date_default_timezone_set("Asia/Vientiane");
    

    

    $product_id = $data->product_id;
    $product_name = $data->product_name;
    $don_gia = $data->don_gia;
    $quantity = $data->quantity;
   
    if(@$_SESSION['nguoi_dung']!=''){
        
        if(is_array(@$_SESSION['cart'])){
            
			// if(product_exists($product_id)) return;
			$product_already_there = false;
            $max=count($_SESSION['cart']);
            
            for($i=0;$i<$max;$i++){
                if($product_id==$_SESSION['cart'][$i]['product_id']){
                    $_SESSION['cart'][$i]['quantity']=$_SESSION['cart'][$i]['quantity']+$quantity;
                    $product_already_there = true;
                    break;
                }
            }       
            
            // else add a new product to the cart
            if($product_already_there === false) {
                $_SESSION['cart'][$max]['product_id']=$product_id;
                $_SESSION['cart'][$max]['product_name']=$product_name;
                $_SESSION['cart'][$max]['don_gia']=$don_gia;
                $_SESSION['cart'][$max]['quantity']=$quantity;
            }
              
        }
			
		else{
			$_SESSION['cart']=array();
			$_SESSION['cart'][0]['product_id']=$product_id;
            $_SESSION['cart'][0]['product_name']=$product_name;
            $_SESSION['cart'][0]['don_gia']=$don_gia;
			$_SESSION['cart'][0]['quantity']=$quantity;
		}
        
        echo json_encode($_SESSION['cart']);
    }else{
        echo 0;
    }
    
    function product_exists($item){
		$item=intval($item);
		$max=count($_SESSION['cart']);
		$flag=0;
		for($i=0;$i<$max;$i++){
			if($item==$_SESSION['cart'][$i]['product_id']){
				$flag=1;
				break;
			}
		}
		return $flag;
	}

?>