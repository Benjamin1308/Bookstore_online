<?php
session_start();

$data = json_decode(file_get_contents("php://input"));
$product_id = $data->product_id;

if(@$_SESSION['nguoi_dung']!=''){
    $max=count($_SESSION['cart']);
    for($i=0;$i<$max;$i++){
        if($product_id==$_SESSION['cart'][$i]['product_id']){
            unset($_SESSION['cart'][$i]);
            break;
        }
    }
    $_SESSION['cart']=array_values($_SESSION['cart']);
    // $gio_hang = $_SESSION['cart'];

    // for($i = 0; $i < count($gio_hang); $i++)
    // {
    //     if($gio_hang[$i]->id == $id)
    //     {
    //         unset($gio_hang[$i]);
    //     }
    // }

    // $_SESSION['gio_hang'] = $gio_hang;
    echo json_encode($_SESSION['cart']);
}
else
{
    echo 0;
}
?>