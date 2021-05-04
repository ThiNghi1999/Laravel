@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê đơn hàng
    </div>
    <div class="row w3-res-tb">
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
            <th>Mã đơn hàng</th>
            <th>Ngày tháng đặt hàng</th>
            <th>Tình trạng đơn hàng</th>
          </tr>
        </thead>
        <tbody>
          @php
          $i = 0;
          @endphp
          @foreach($order as $key=>$ord)
          @php
          $i++;
          @endphp
          <tr>
            <td><i>{{$i}}</i></td>
            <td>{{$ord -> order_code}}</td>
            <td>{{$ord -> created_at}}</td>
            <td>@if($ord -> order_status==1)
              Đơn hàng mới
              @else
              Đã xử lý
              @endif
            </td>

            <td>
              <a href="{{URL::to('/view-order/'.$ord->order_code)}}" class="active" 
                style= "font-size:20px; ui-toggle-class="">
                <i class="fa fa-eye text-success text-active"></i>
              </a>
              <a onclick="return confirm('Bạn có chắc muốn xóa đơn hàng này không?')" href="{{URL::to('/delete-order/'.$ord->order_code)}}" class="active"
              style= "font-size:20px; ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
          </tr>
         @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection