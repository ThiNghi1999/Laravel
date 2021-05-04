@extends('admin_layout')
@section('admin_content')
       <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Thêm thương hiệu sản phẩm
                        </header>
                        <div class="panel-body">
                        @if(Session::has('alert-success'))
                         <div class='alert alert-success' role='alert'>
                        {{Session::get('alert-success')}}
                         </div>
                         @endif
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/save-brand-product')}}" method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên thương hiệu</label>
                                    <input type="text" name="brand_product_name" class="form-control" id="" placeholder="Tên danh mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả thương hiệu</label>
                                    <textarea style="resize: none;" rows="5" class="form-control" name="brand_product_desc" id="ckeditor" placeholder="Mô tả danh mục">
                                        
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Hiển thị</label>
                                    <select name="brand_product_status" class="form-control input-sm m-bot15">
                                        <option value="1">Ẩn</option>
                                        <option value="0">Hiển thị</option>                      
                                    </select>
                                </div>
                               
                                <button type="submit" name="add_brand_product" class="btn btn-info">Thêm thương hiệu</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection