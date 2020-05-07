<!-- Script -->
<script src="{{asset('public/admin/js/form-setting/validation-rule.js')}}"></script>
<script src="{{asset('public/admin/js/form-setting/form.js')}}"></script>
<script src="{{asset('public/admin/js/category-form.js')}}"></script>
<!-- End script -->

@section('title', 'Tạo mới danh mục')
@section('breadcrumb')                         
  <ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="/admin">Bảng điều khiển</a></li>    
    <li class="breadcrumb-item"><a href="/admin/category">Danh mục</a></li>
    <li class="breadcrumb-item active">Tạo mới danh mục</li>    
  </ol>
@endsection
@section('back-link')
  <a href="{{url('/admin/category')}}" class="btn btn-primary btn-sm">
    <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
    Trở về
  </a>
@endsection
@include('admin.templates.content_header')

<!-- Main content -->
<section class="content">  
  <form action="{{route('category.store')}}" id="create-category-form" method="POST">
    @csrf
    <div class="form-group col-md-9">
      <label for="category-describes">Tên danh mục:</label>
      <input type="text" class="form-control" id="category-describes" name="category_describes"
        placeholder="Tên danh mục" value="{{old('category_describes')}}"/>
      @if (!empty($errors->first('category_describes')))
        <div class="alert alert-danger alert-dismissible fade show">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Lỗi!</strong> {{$errors->first('category_describes')}}
        </div>
      @endif
    </div><br />
    <div class="form-group col-md-9">
      <label for="category-name">Đường dẫn danh mục:</label>
      <input type="text" class="form-control" id="category-name" name="category_name"
        placeholder="Đường dẫn danh mục" value="{{old('category_name')}}" readonly/>
      @if (!empty($errors->first('category_name')))
        <div class="alert alert-danger alert-dismissible fade show">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Lỗi!</strong> {{$errors->first('category_name')}}
        </div>
      @endif
    </div><br />  
    <div class="form-group col-md-3">
      <label for="category-priority">Độ ưu tiên(thứ tự):</label>
      <select class="form-control" id="category-priority" name="category_priority">
        @foreach ($priorities as $priority)
          <option value="{{$priority['id']}}"
            @if ($priority['name'] == 'medium') 
              selected
            @endif>
            {{$priority['describes']}}
          </option>
        @endforeach
      </select>
      @if(!empty($errors->first('category_priority')))
        <div class="alert alert-danger alert-dismissible fade show">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Lỗi!</strong> {{$errors->first('category_priority')}}
        </div>
      @endif
    </div><br />
    <br />
    <div class="form-group col-md-3">
      <button type="submit" class="btn btn-primary">Gửi</button>
    </div>
  </form>
</section>
<!-- /.content -->