@extends('layout_details')
@section('content')

                 <div class="features_items"><!--features_items-->

                <div class="fb-like" data-href="http://127.0.0.1:8000/" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="true">
                	
                </div>
                 	@foreach($category_name as $key=>$name )
                 	
						<h2 class="title text-center">{{$name->category_name}}</h2>

					@endforeach
						@foreach($category_by_id as $key=>$product)
						<div class="col-sm-4">
							<div class="product-image-wrapper">
					<a href="{{URL::to('/Chi-tiet-san-pham/'.$product->product_id)}}">
								<div class="single-products">
										<div class="productinfo text-center">
											<img src="{{URL::to('/uploads/product/'.$product->product_image)}}" alt="" />
											<h2>{{number_format($product->product_price).' '.'vnd'}}</h2>
											<p>{{$product->product_name}}</p>
											<!-- <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a> -->
										</div>
										
								</div>
								<div class="choose">
									<ul class="nav nav-pills nav-justified">
										<li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
										<li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
									</ul>
								</div>
							</div>
						</div>
					</a>
						@endforeach

						<!-- thêm sp -->
					<div class="fb-comments" data-href="http://127.0.0.1:8000/Danh-muc-san-pham/5" data-width="" data-numposts="20">
							
										</div>
						
					</div><!--features_items-->


@endsection