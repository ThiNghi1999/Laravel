@extends('admin_layout')
@section('admin_content')
       <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Thêm mã giảm giá
                        </header>
                        <div class="panel-body">
                        @if(Session::has('alert-success'))
                        <div class='alert alert-success' role='alert'>
                        {{Session::get('alert-success')}}
                         </div>
                        @endif
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/insert-coupon-code')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên mã giảm giá</label>
                                    <input type="text" name="coupon_name" class="form-control" id="" placeholder="Tên danh mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mã giảm giá</label>
                                    <input type="text" name="coupon_code" class="form-control" id="" placeholder="Tên danh mục">
                                </div>
                                   <div class="form-group">
                                    <label for="exampleInputPassword1">Số lượng mã</label>
                                    <input type="text" name="coupon_time" class="form-control" id="" placeholder="Tên danh mục">
                                </div>

                                 <div class="form-group">
                                    <label for="exampleInputPassword1">Tính năng mã</label>
                                    <select name="coupon_condition" class="form-control input-sm m-bot15">
                                        <option value="0">------Chọn------</option>
                                        <option value="1">Giam theo phần trăm</option>
                                        <option value="2">Giam theo tiền</option>                      
                                    </select>
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputPassword1">Nhập số % hoặc tiền thưởng giảm</label>
                                     <input type="text" name="coupon_number" class="form-control" placeholder="Tên danh mục">
                                </div>
                                <button type="submit" name="" class="btn btn-info">Thêm mã giảm giá</button>
                            </form>
                            </div>
                        </div>
                    </section>
            </div>
@endsection