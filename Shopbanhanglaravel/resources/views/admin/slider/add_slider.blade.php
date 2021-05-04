@extends('admin_layout')
@section('admin_content')
       <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Thêm Slider
                        </header>
                        <div class="panel-body">
                        @if(Session::has('alert-success'))
                         <div class='alert alert-success' role='alert'>
                        {{Session::get('alert-success')}}
                         </div>
                         @endif
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/insert-slider')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên slide</label>
                                    <input type="text" name="slider_name" class="form-control" id="" placeholder="Tên slide">
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh</label>
                                    <input type="file" name="slider_image" class="form-control" id="" placeholder="Hình ảnh">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả slide</label>
                                    <textarea style="resize: none;" rows="5" class="form-control" name="slider_desc" id="ckeditor" placeholder="Mô tả slide">
                                        
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Hiển thị</label>
                                    <select name="slider_status" class="form-control input-sm m-bot15">
                                        <option value="1">Ẩn slider</option>
                                        <option value="0">Hiển thị slider</option>                      
                                    </select>
                                </div>
                               
                                <button type="submit" name="add_slider" class="btn btn-info">Thêm Slider</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection