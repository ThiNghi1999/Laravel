<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feeship;
use App\Shipping;
use App\Order;
use App\OrderDetails;
use App\customer;
use App\Coupon;
use App\Product;
use PDF;

class OrderController extends Controller
{

	public function update_qty(Request $request){
		$data=$request->all();
		$or_details=OrderDetails::where('product_id',$data['order_product_id'])->where('order_code',$data['order_code'])->first();
		$or_details->product_sales_quantity=$data['order_qty'];
		$or_details->save();

	}

	public function update_order_quantity(Request $request){
		$data=$request->all();
		$order=Order::find($data['order_id']);
		$order->order_status=$data['order_status'];
		$order->save();
		if($order->order_status==2){
			foreach($data['order_product_id'] as $key=>$product_id){
				$product=Product::find($product_id);
				$product_quantity=$product->product_quantity;
				$product_sold=$product->product_sold;
				foreach ($data['quantity'] as $key2 => $qty) {
					if($key==$key2){
						$pro_remain=$product_quantity-$qty;
						$product->product_quantity=$pro_remain;
						$product->product_sold=$product_sold+$qty;
						$product->save();					
					}
				}
			}

		}
		elseif($order->order_status!=2 && $order->order_status!=3){
			foreach($data['order_product_id'] as $key => $product_id){
				
				$product = Product::find($product_id);
				$product_quantity = $product->product_quantity;
				$product_sold = $product->product_sold;
				foreach($data['quantity'] as $key2 => $qty){
						if($key==$key2){
								$pro_remain = $product_quantity + $qty;
								$product->product_quantity = $pro_remain;
								$product->product_sold = $product_sold - $qty;
								$product->save();
							}
						}
				}
			}
	}
	public function print_order($checkout_code){
		$pdf=\App::make('dompdf.wrapper');
		$pdf->loadHTML($this->print_order_convert($checkout_code));
		return $pdf->stream();
	}
	public function print_order_convert($checkout_code){
		$order_details=OrderDetails::where('order_code',$checkout_code)->get();
    	$order=Order::where('order_code',$checkout_code)->get();
    	foreach ($order as $key => $ord) {
    		$customer_id=$ord->customer_id;
    		$shipping_id=$ord->shipping_id;


    	}
    	$customer=Customer::where('customer_id',$customer_id)->first();
		$shipping=Shipping::where('shipping_id',$shipping_id)->first();
		$order_details_product=OrderDetails::with('product')->where('order_code',$checkout_code)->get();

		foreach ($order_details_product as $key => $order_d) {
    		$product_coupon=$order_d->product_coupon;

    	}
    	
    	if($product_coupon!='no'){
		$coupon=Coupon::where('coupon_code',$product_coupon)->first();
		//Hai trường hợp phần trăm và tiền mặt
		$coupon_condition=$coupon->coupon_condition;
    	$coupon_number=$coupon->coupon_number;
    		if($coupon_condition==1){
    			$coupon_echo=$coupon_number.'%';
    		}else{
    			$coupon_echo=number_format( $coupon_number,0,',','.').'đ';
    		}
    	}else{
    	$coupon_condition=2;
    	$coupon_number=0;
    	$coupon_echo=0;
    	}





		$output='';
		$output.='<style>body{
			font-family: DejaVu Sans;
		}
		.table-styling{
			border: 1px solid #000;
		}
		.table-styling tr td{
			border: 1px solid #000;
		}

		</style>
		<h1><center>Cửa hàng mỹ phẩm ABC</center></h1>
		<h4><center>Độc lập - Tự do - Hạnh phúc</center></h4>	
		<p><b>Người đặt </b></p>
		<table class="table-styling">
					<thead>
					<tr>
					<th>Tên khách đặt hàng</th>
					<th>Số điện thoại</th>
					<th>Email</th>
					</tr>
					</thead>
					<tbody>';
				$output.='
					<tr>
						<td>'.$customer->customer_name.'</td>
						<td>'.$customer->customer_phone.'</td>
						<td>'.$customer->customer_email.'</td>
					</tr>';
				$output.='
					</tbody>

		</table>


		<p><b>Ship hàng tới</b></p>
		<table class="table-styling">
					<thead>
					<tr>
					<th>Tên người nhận</th>
					<th>Địa chỉ</th>
					<th>Số điện thoại</th>
					<th>Ghi chú</th>
					</tr>
					</thead>
					<tbody>';
				$output.='
					<tr>
						<td>'.$shipping->shipping_name.'</td>
						<td>'.$shipping->shipping_address.'</td>
						<td>'.$shipping->shipping_phone.'</td>
						<td>'.$shipping->shipping_notes.'</td>
					</tr>';
				$output.='
					</tbody>

		</table>

		<p><b>Đơn hàng đặt</b></p>
		<table class="table-styling">
					<thead>
					<tr>
					<th>Tên sản phẩm</th>
					<th>Mã giảm giá</th>
					<th>phí ship</th>
					<th>Số lượng</th>
					<th>Gía sản phẩm</th>
					<th>Thành tiền</th>
					</tr>
					</thead>
					<tbody>';
					$total=0;
					
					
					foreach ($order_details_product as $key => $product) {
						$subtotal=$product->product_price*$product->product_sales_quantity;
						$total+=$subtotal;
						if($product->product_coupon!='no'){
							$product_coupon=$product->product_coupon;
						}else{
							$product_coupon='không mã';
						}
				$output.='
					<tr>
						<td>'.$product->product_name.'</td>
						<td>'.$product_coupon.'</td>
						<td>'.number_format( $product->product_feeship,0,',','.').'đ'.'</td>
						<td>'.$product->product_sales_quantity.'</td>
						<td>'.number_format( $product->product_price,0,',','.').'đ'.'</td>
						<td>'.number_format( $subtotal,0,',','.').'đ'.'</td>
					</tr>';
				}
				if($coupon_condition==1){
						$total_after_coupon=($total*$coupon_number)/100;       				
         				$total_coupon=$total_after_coupon;
					}else{
					
                        $total_coupon=$coupon_number;
					}
				$output.='<tr>
					<td colspan="2">
					<p>Tổng giảm:'.$coupon_echo.'</p>
					<p>Phí ship:'.number_format( $product->product_feeship,0,',','.').'đ'.'</p>
					<p>Thanh toán:'.number_format($total-$total_coupon-$product->product_feeship,0,',','.').'đ'.'</p>
					</td>
				</tr>';
				$output.='
					</tbody>

		</table>


	<p><b>Ký tên</b></p>
		<table>
					<thead>
					<tr>
					<th width="200px">Người lập phiếu</th>
					<th width="800px">Người nhận</th>
					</tr>
					</thead>
					<tbody>';
				
				$output.='
					</tbody>

		</table>







		';
		return $output;
		// return $checkout_code;
	}
	public function view_order($order_code){
    	$order_details=OrderDetails::where('order_code',$order_code)->get();
    	$order=Order::where('order_code',$order_code)->get();
    	foreach ($order as $key => $ord) {
    		$customer_id=$ord->customer_id;
    		$shipping_id=$ord->shipping_id;
    		$order_status=$ord->order_status;


    	}
    	$customer=Customer::where('customer_id',$customer_id)->first();
    	$shipping=Shipping::where('shipping_id',$shipping_id)->first();
    	$orderdetail=OrderDetails::with('product')->where('order_code',$order_code)->get();
    	foreach ($orderdetail as $key => $order_d) {
    		$product_coupon=$order_d->product_coupon;

    	}
    	
    	if($product_coupon!='no'){
		$coupon=Coupon::where('coupon_code',$product_coupon)->first();
		//Hai trường hợp phần trăm và tiền mặt
		$coupon_condition=$coupon->coupon_condition;
    	$coupon_number=$coupon->coupon_number;
    	}else{
    	$coupon_condition=2;
    	$coupon_number=0;
    	}
    	return view('admin.view_order')->with(compact('order_details','customer','shipping','orderdetail','coupon_condition','coupon_number','order','order_status'));
    	//Dùng get thì phải dùng foreach 
    	//Dùng first thì không cần dùng foreach
    	//Hầu hết model có where nên sử dụng foreach
    }
    public function manage_order(){
    	$order=Order::orderby('created_at','DESC')->get();
    	return view('admin.manage_order')->with(compact('order'));
    }
    
}
