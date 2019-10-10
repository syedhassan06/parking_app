<?php

function getTaggingValues($tagging=[]){
    if(is_array($tagging) && count($tagging)>0){
        return implode(', ',$tagging);
    }
    else{
        return null;
    }
}

function setActiveMenu(string $routeNamed, string $class_name = "active"){
    //Route::currentRouteNamed( 'user_manage' )
    return request()->routeIs($routeNamed)?'active':'';
}

function haveCustomerLoggedIn(){
    $user = session()->get(config('app.user_sess'));
    if($user['role']=='customer'){
        return true;
    }else{
        return false;
    }
}

function getOrderStatus($status){
    switch($status){
        case "in-progress" :
            return ucwords(str_replace('-', ' ', $status));
        case "payment-confirmed" :
            return ucwords(str_replace('-', ' ', $status));
        case "order-placed" :
            return ucwords(str_replace('-', ' ', $status));
        case "dispatched" :
            return ucwords(str_replace('-', ' ', $status));
        case "completed" :
            return ucwords(str_replace('-', ' ', $status));
        default :
            return "";
    }
}

function snakeToTileCase($str){
    return title_case(str_replace('_', ' ', $str));
}

function dashToTitleCase($str){
    return title_case(str_replace('-', ' ', $str));
}

function shipperDeliveryText($number){
    return "( Transit time  $number  working day". ($number>1?'s':''). " )";
}

function cleanNumber($price){
    $price = preg_replace('/[\$,]/', '', $price);
    return (float)$price;
}

function formatCurrency($value,$currency='$',$space=1){
    if($space==1)
        return $currency." ".number_format($value, 3);
    else
        return $currency.number_format($value, 3);
}

function rowStatus($status){
    if(!$status) {
        return '';
    } else if(in_array($status,['pending','in-progress'])) {
        return '<div class="text-center"><span class="badge  badge-warning">'.dashToTitleCase($status).'</span></div>';
    }else if(in_array($status,['designing','payment-confirmed'])) {
        return '<div class="text-center"><span class="badge bg-purple bg-lighten-1 white">'.dashToTitleCase($status).'</span></div>';
    }else if( in_array($status,['completed', 'paid', 'sent' ,'received', 'stock-in', 'delivered'])  ){
        return '<div class="text-center"><span class="badge badge-success">'.dashToTitleCase($status).'</span></div>';
    }else if( in_array($status,['ready','order-placed']) ){
        return '<div class="text-center"><span class="badge bg-teal bg-lighten-3 white">'.dashToTitleCase($status).'</span></div>';
    }else if( in_array($status,['partial', 'transferring', 'ordered' ,'dispatched']) ) {
        return '<div class="text-center"><span class="badge badge-info">'.dashToTitleCase($status).'</span></div>';
    }else if( in_array($status,['due', 'returned', 'stock-out']) ) {
        return '<div class="text-center"><span class="badge badge-danger">'.dashToTitleCase($status).'</span></div>';
    } else {
        return '<div class="text-center"><span class="badge badge-secondary">'.dashToTitleCase($status).'</span></div>';
    }
}

function twoDigitFormat($num,$decimal=0) {
    return str_pad(number_format($num,$decimal),2,'0',STR_PAD_LEFT);
}

function rowStatusV2($status){
    if(!$status) {
        return '';
    } else if(in_array($status,['pending','in-progress'])) {
        return '<button type="button" class="btn  btn-outline-warning btn-sm round">'.dashToTitleCase($status).'</button>';
    }else if(in_array($status,['designing','payment-confirmed'])) {
        return '<button type="button" class="btn btn-outline-purple btn-lighten-1 btn-sm round">'.dashToTitleCase($status).'</button>';
    }else if( in_array($status,['completed', 'paid', 'sent' ,'received', 'stock-in', 'delivered'])  ){
        return '<button type="button" class="btn btn-outline-success btn-sm round">'.dashToTitleCase($status).'</button>';
    }else if( in_array($status,['ready','order-placed']) ){
        return '<button type="button" class="btn btn-outline-teal btn-lighten-3 btn-sm round">'.dashToTitleCase($status).'</button>';
    }else if( in_array($status,['partial', 'transferring', 'ordered' ,'dispatched']) ) {
        return '<button type="button" class="btn  btn-outline-info round btn-sm">'.dashToTitleCase($status).'</button>';
    }else if( in_array($status,['due', 'returned', 'stock-out']) ) {
        return '<button type="button" class="btn btn-outline-danger btn-sm round">'.dashToTitleCase($status).'</button>';
    } else {
        return '<button type="button" class="btn btn-outline-secondary btn-sm round">'.dashToTitleCase($status).'</button>';
    }
}

function ordinalDate($date,$html=false){
    if($html){
        return date('j', strtotime($date)).
            "<sup>".date('S', strtotime($date))."</sup>".' '.
            date('F, Y', strtotime($date));

    }else{
        return date('jS F, Y', strtotime($date));
    }
}

?>