<?php

namespace App\Services;
use App\Post;
 
class FormCheckService {
 
    public function currentForm($id)
    {
        $post = Post::find($id);
        $delivery_charge_name = ($post->delivery_charge === 1) ? "着払い（購入者負担）" : "送料込み（出品者負担）";
        $method_of_shipment_name = ($post->method_of_shipment === 1) ? "宅配便" : "メール便" ;
        $days_to_derivery_name = ($post->days_to_derivery === 1) ? "4~7日で発送" : "1~3日で発送";
        
        return [$delivery_charge_name, $method_of_shipment_name, $days_to_derivery_name];
    }
    
    public function profileCheck($request)
    {
        $profile = ($request->profile !== null) ? $request->profile : '';
        $first_name = ($request->first_name !== null) ? $request->first_name : '';
        $last_name = ($request->last_name !== null) ? $request->last_name : '';
        $phone = ($request->phone !== null) ? $request->phone : '';
        $postal_code = ($request->postal_code !== null) ? $request->postal_code : '';
        $address = ($request->address !== null) ? $request->address : '';
        
        return [$profile, $first_name, $last_name, $phone, $postal_code, $address];
    }
    
    public function fillingProfile()
    {
        if( \Auth::user()->first_name === '' ||
            \Auth::user()->last_name === '' ||
            \Auth::user()->phone === '' ||
            \Auth::user()->postal_code === '' ||
            \Auth::user()->address=== '' ){
                $not_entered = true;
                
            }else{
                $not_entered = false;
            }  
            
        return $not_entered;
        
    }
    
}
