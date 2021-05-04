@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê Slider
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
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <!-- <input type="checkbox"><i></i> -->
              </label>
            </th>
            <th>Tên slide</th>
            <th>Hình ảnh</th>
            <th>Mô tả</th>
            <th>Tình trạng</th>
           
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_slide as $key=>$slide)
          <tr>
            <td><i></i></label></td>
            <td>{{($slide-> slider_name)}}</td>
            <td><img src="uploads/slider/{{($slide -> slider_image)}}" height="30" width="30"></td>
            <td><span class="text-ellipsis">
              <?php
            if($slide ->slider_status==0){
              ?>
              <a href="{{URL::to('/unactive-slide/'.$slide->slider_id)}}"><span style="color:mediumseagreen; font-size:28px;" class="fa fa-thumbs-up"></span></a>
              <?php
            }
            else{
              ?>
               <a href="{{URL::to('/active-slide/'.$slide->slider_id)}}"><span style="color:red; font-size:28px;" class="fa fa-thumbs-down"></span></a>
               <?php
            }

              ?>
            </span></td>
           
            <td>
              <a onclick="return confirm('Bạn có chắc muốn xóa slide này không?')" href="{{URL::to('/delete-slide/'.$slide->slider_id)}}" class="active"
              style= "font-size:20px; ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
          </tr>
         @endforeach
        </tbody>
      </table>
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