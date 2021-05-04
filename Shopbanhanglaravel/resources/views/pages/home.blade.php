@extends('layout')
@section('content')
                 <div class="features_items"><!--features_items-->
						<h2 class="title text-center">Sản phẩm mới nhất</h2>
						@foreach($all_product as $key=>$product)
						<div class="col-sm-4">
							<div class="product-image-wrapper">
							<a href="{{URL::to('/Chi-tiet-san-pham/'.$product->product_id)}}">
								<div class="single-products">
										<div class="productinfo text-center">
										<form>
											<input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
											<input type="hidden" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
											<input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
											<input type="hidden" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
										
											<input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">
											<img width="70px" height="170px" src="{{URL::to('/uploads/product/'.$product->product_image)}}" alt="" />
											<h2>{{number_format($product->product_price).' '.'vnđ'}}</h2>
											<p>{{$product->product_name}}</p>
											</a>
											<button type="button" class="btn btn-default add-to-cart" name="add-to-cart" data-id_product="{{$product->product_id}}"><b>Thêm giỏ hàng</b></button>
										</form>
										</div>
								</div>
								<!-- <div class="choose">
									<ul class="nav nav-pills nav-justified">
										<li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
										<li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
									</ul>
								</div> -->
							</div>
						</div>

						@endforeach

						<!-- thêm sp -->
						
					</div>


@endsection