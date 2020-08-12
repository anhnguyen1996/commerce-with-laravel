@php
$activeMenu = 'product';
@endphp

@section('title', 'Tạo mới sản phẩm')

{{-- Content header --}}
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="/admin">Bảng điều khiển</a></li>
  <li class="breadcrumb-item"><a href="/admin/product">Sản phẩm</a></li>
  <li class="breadcrumb-item active">Tạo mới sản phẩm</li>
</ol>
@endsection

@section('back-link')
<a href="{{url('/admin/product')}}" class="btn btn-primary btn-sm">
  <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
  Trở về
</a>
@endsection

{{-- Main content --}}
@section('content')
<section class="content">
  <!-- Script -->
  <script src="{{asset('public/admin/js/form-setting/validation-rule.js')}}"></script>
  <script src="{{asset('public/admin/js/form-setting/form.js')}}"></script>
  <script src="{{asset('public/admin/js/product-form.js')}}"></script>
  <!-- End script -->
  <form action="{{route('product.store')}}" id="product-form" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group col-md-9">
      <label for="product-name">Tên sản phẩm:</label>
      <input type="text" class="form-control" id="product-name" name="product_name" placeholder="Tên danh mục"
        value="{{old('product_name')}}" required />
      @if (!empty($errors->first('product_name')))
      <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Lỗi!</strong> {{$errors->first('product_name')}}
      </div>
      @endif
    </div><br />
    <div class="form-group col-md-9">
      <label for="product-alias">Đường dẫn sản phẩm:</label>
      <input type="text" class="form-control" id="product-alias" name="product_alias" placeholder="Đường dẫn sản phẩm"
        value="{{old('product_alias')}}" readonly required />
      @if (!empty($errors->first('product_alias')))
      <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Lỗi!</strong> {{$errors->first('product_alias')}}
      </div>
      @endif
    </div><br />
    <div class="form-group col-md-2">
      <label for="product-price">Giá sản phẩm:</label>
      <input type="number" class="form-control" id="product-price" name="product_price" placeholder="Giá sản phẩm"
        value="{{old('product_price')}}" required />
      @if (!empty($errors->first('product_price')))
      <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Lỗi!</strong> {{$errors->first('product_price')}}
      </div>
      @endif
    </div><br />
    <div class="form-group col-md-2">
      <label for="product-sale-price">Giá khuyến mãi: (*)nhỏ hơn giá sản phẩm:</label>
      <input type="number" class="form-control" id="product-sale-price" name="product_sale_price"
        placeholder="Giá khuyến mãi" value="{{old('product_sale_price')}}" required />
      @if (!empty($errors->first('product_sale_price')))
      <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Lỗi!</strong> {{$errors->first('product_sale_price')}}
      </div>
      @endif
    </div><br />
    <div class="form-group col-md-2">
      <label for="inventory-quantity">Số lượng tồn kho:</label>
      <input type="number" class="form-control" id="inventory-quantity" name="inventory_quantity"
        placeholder="Số lượng tồn kho" value="{{old('inventory_quantity')}}" required />
      @if (!empty($errors->first('inventory_quantity')))
      <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Lỗi!</strong> {{$errors->first('inventory_quantity')}}
      </div>
      @endif
    </div><br />
    <div class="form-group col-md-2">
      <label for="product-category">Danh mục sản phẩm:</label>
      <select class="form-control" id="product-category" name="product_category">
        @foreach($categories as $category)
        <option value="{{$category['id']}}">{{$category['describes']}}</option>
        @endforeach
      </select>
    </div><br />
    <div class="form-group col-md-3">
      <label>Ảnh chính:</label><br />
      <input type="file" name="product_image" />
      @if (!empty($errors->first('product_image')))
      <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Lỗi!</strong> {{$errors->first('product_image')}}
      </div>
      @endif
    </div><br />
    <div class="sub-image">
      <label>Ảnh phụ:</label>
      <div id="sub-image-pattern">
        <div class="sub-image-insert">
          <div class="row">
            <div class="form-group col-md-3">
              <input type="file" name="sub_product_image[]" />
              @if (!empty($errors->first('sub_product_image')))
              <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Lỗi!</strong> {{$errors->first('sub_product_image')}}
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="sub-image-insert">
        <div class="row">
          <div class="form-group col-md-3">
            <input type="file" name="sub_product_image[]" />
            @if (!empty($errors->first('sub_product_image')))
            <div class="alert alert-danger alert-dismissible fade show">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Lỗi!</strong> {{$errors->first('sub_product_image')}}
            </div>
            @endif
          </div>
        </div>
      </div>
      <button type="button" class="btn btn-outline-primary" id="button-add-sub-image">Thêm ảnh phụ</button>
    </div><br />
    <div class="form-group col-md-9">
      <label for="description">Mô tả:</label>
      <textarea class="ckeditor" id="description" name="product_description">
        {{old('product_description')}}
      </textarea>
    </div><br />
    <div class="form-group col-md-9">
      <label for="content">Nội dung:</label>
      <textarea class="ckeditor" id="content" name="product_content">
        {{old('product_content')}}
      </textarea>
    </div><br />
    <div class="form-group col-md-2">
      <label for="product-status">Trạng thái sản phẩm:</label>
      <select class="form-control" id="product-status" name="product_status">
        @foreach ($productStatuses as $productStatus)
        <option value="{{$productStatus['id']}}">
          {{$productStatus['describes']}}
        </option>
        @endforeach
      </select>
    </div><br />
    <div class="form-group col-md-2">
      <label for="product-priority">Độ ưu tiên sản phẩm:</label>
      <select class="form-control" id="product-priority" name="product_priority">
        @foreach ($priorities as $priority)
        <option value="{{$priority['id']}}">{{$priority['describes']}}</option>
        @endforeach
      </select>
    </div><br />
    <div class="form-group col-md-3">
      <button type="submit" class="btn btn-primary">Gửi</button>
    </div><br />
  </form>
</section>
@endsection
{{-- End main content --}}

@extends('admin.master')