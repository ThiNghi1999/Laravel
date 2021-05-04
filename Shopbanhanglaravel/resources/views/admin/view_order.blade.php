
@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
    Thông tin khách hàng đăng nhập
    </div>
    
    <div class="table-responsive">
                    @if(Session::has('alert-success'))
                     <div class='alert alert-success' role='alert'>
                     {{Session::get('alert-success')}}
                     </div>
                     @endif
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
           
            <th>Tên khách hàng đăng nhập</th>
            <th>Số điện thoại</th>
            <th>Email</th>

            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
       
          <tr>
            <td>{{$customer->customer_name}}</td>
            <td>{{$customer->customer_phone}}</td>
            <td>{{$customer->customer_email}}</td>
          </tr>
       
        </tbody>
      </table>
    </div>
    
  </div>
</div>

<br><br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
    Thông tin người mua hàng
    </div>
    
    <div class="table-responsive">
                    @if(Session::has('alert-success'))
                     <div class='alert alert-success' role='alert'>
                     {{Session::get('alert-success')}}
                     </div>
                     @endif
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
           
            <th>Tên người mua hàng</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Ghi chú</th>
            <th>Hình thức thanh toán</th>

           
          
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
       
          <tr>
            <td>{{$shipping->shipping_name}}</td>
            <td>{{$shipping->shipping_address}}</td>
            <td>{{$shipping->shipping_phone}}</td>
            <td>{{$shipping->shipping_email}}</td>
            <td>{{$shipping->shipping_notes}}</td>
            <td>
              @if($shipping->shipping_method==0)
              Chuyển khoản
              @else
              Tiền mặt
              @endif
            </td>
          </tr>
       
        </tbody>
      </table>
    </div>
    
  </div>
</div>

<br><br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê chi tiết đơn hàng
    </div>
    
    <div class="table-responsive">
                    @if(Session::has('alert-success'))
                     <div class='alert alert-success' role='alert'>
                     {{Session::get('alert-success')}}
                     </div>
                     @endif
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Thứ tự</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng kho </th>
            <th>Mã giảm giá</th>
            <th>Phí ship hàng</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Tổng tiền</th>
          
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
       @php
       $i=0;
       $total=0;
       @endphp
       @foreach($orderdetail as $key => $details)
       @php
       $i++;
       $subtotal=$details->product_price*$details->product_sales_quantity;
       $total+=$subtotal;
       @endphp
          <tr class="color_qty_{{$details->product_id}}">
            <td><i>{{$i}}</i></td>
            <td>{{$details->product_name}}</td>
            <td>{{$details->product->product_quantity}}</td>
            <td>@if($details->product_coupon!='no')
              {{$details->product_coupon}}
              @else
              Không mã giảm giá
              @endif
              
            </td>
            <td>{{number_format($details->product_feeship,0,',','.')}}đ</td>
            <td>
             <!--  Số lượng khách đặt -->
              <input type="number" min="1" {{$order_status==2 ? 'disabled' : ''}} class="order_qty_{{$details->product_id}}" value="{{$details->product_sales_quantity}}" name="product_sales_quantity">
             <!--  Số lượng kho -->
              <input type="hidden" name="order_qty_storage" class="order_qty_storage_{{$details->product_id}}"
               value="{{$details->product->product_quantity}}">
              <input type="hidden" name="order_code" class="order_code" value="{{$details->order_code}}">
              <input type="hidden" name="order_product_id" class="order_product_id" value="{{$details->product_id}}">
                @if($order_status!=2) 
            <button class="btn btn-default update_quantity_order" data-product_id="{{$details->product_id}}" name="update_quantity_order">Cập nhật</button>
            @endif
            </td>
            <td>{{number_format($details->product_price,0,',','.')}}đ</td>
            <td>{{number_format( $subtotal,0,',','.')}}đ</td>
          </tr>
       @endforeach
       <tr>
         <td>
          @php
          $total_coupon=0;
          @endphp
         @if($coupon_condition==1)
         @php
         $total_after_coupon=($total*$coupon_number)/100;
         echo 'Tổng giảm:'.number_format($total_after_coupon,0,',','.').'đ'.'<br>';
         $total_coupon=$total-$total_after_coupon;
         @endphp
         @else
         @php
         echo 'Tổng giảm:'.number_format($coupon_number,0,',','.').'đ'.'<br>';
         $total_coupon=$total-$coupon_number;
         @endphp
         @endif
         Phí ship: {{number_format( $details->product_feeship,0,',','.')}}đ
         <br>
         Thanh Toán: {{number_format( $total_coupon-$details->product_feeship,0,',','.')}}đ
         </td>
         <!-- <td>{{number_format( $total,0,',','.')}}đ</td> -->
       </tr>
       <tr>
         <td colspan="6">
            @foreach($order as $key =>$or)
            @if($or->order_status==1)
          <form>
            @csrf
           <select class="form-control order_details">
            <option value="">---Chọn hình thức đơn hàng---</option>
            <option id="{{$or->order_id}}" selected value="1">Chưa xử lý</option>
             <option id="{{$or->order_id}}" value="2">Đã xử lý - Đã giao hàng</option>
             <option id="{{$or->order_id}}" value="3">Hủy đơn hàng - Tạm giữ</option>
           </select>
           </form>
           @elseif($or->order_status==2)
             <form>
               @csrf
           <select class="form-control order_details">
            <option value="">---Chọn hình thức đơn hàng---</option>
            <option id="{{$or->order_id}}" value="1">Chưa xử lý</option>
             <option id="{{$or->order_id}}" selected value="2">Đã xử lý - Đã giao hàng</option>
             <option id="{{$or->order_id}}" value="3">Hủy đơn hàng - Tạm giữ</option>
           </select>
           </form>
           @else
            <form>
               @csrf
           <select class="form-control order_details">
            <option value="">---Chọn hình thức đơn hàng---</option>
            <option id="{{$or->order_id}}" value="1">Chưa xử lý</option>
             <option id="{{$or->order_id}}" value="2">Đã xử lý - Đã giao hàng</option>
             <option id="{{$or->order_id}}" selected value="3">Hủy đơn hàng - Tạm giữ</option>
           </select>
           </form>
           @endif
           @endforeach
         </td>
       </tr>
        </tbody>
      </table>
     <!--  _blank: cho tab mới -->
      <a target="_blank" href="{{url('print-order/'.$details->order_code)}}">In đơn hàng</a>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
            <li><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection