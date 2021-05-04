@extends('layout')
@section('content')
                 <div class="features_items"><!--features_items-->
						<h2 class="title text-center">Sản phẩm</h2>
						@foreach($product as $key=>$pr)
						<div class="col-md-4">
							<div class="row">
							<div class="product-image-wrapper">
							<a href="{{URL::to('/Chi-tiet-san-pham/'.$pr->product_id)}}">
								<div class="single-products">
										<div class="productinfo text-center">
										<form>
											<input type="hidden" value="{{$pr->product_id}}" class="cart_product_id_{{$pr->product_id}}">
											<input type="hidden" value="{{$pr->product_name}}" class="cart_product_name_{{$pr->product_id}}">
											<input type="hidden" value="{{$pr->product_image}}" class="cart_product_image_{{$pr->product_id}}">
											<input type="hidden" value="{{$pr->product_price}}" class="cart_product_price_{{$pr->product_id}}">
										
											<input type="hidden" value="1" class="cart_product_qty_{{$pr->product_id}}">
											<img width="70px" height="170px" src="{{URL::to('/uploads/product/'.$pr->product_image)}}" alt="" />
											<h2>{{number_format($pr->product_price).' '.'vnđ'}}</h2>
											<p>{{$pr->product_name}}</p>
											</a>
											<button type="button" class="btn btn-default add-to-cart" name="add-to-cart" data-id_product="{{$pr->product_id}}"><b>Thêm giỏ hàng</b></button>
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
						</div>

						@endforeach

						<!-- thêm sp -->
						
					</div>


@endsection