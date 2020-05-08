<!-- Script -->
<script src="{{asset('public/admin/js/category-list.js')}}"></script>
<!-- End script -->

@section('title', 'Danh sách danh mục')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="/admin">Bảng điều khiển</a></li>
  <li class="breadcrumb-item active">Danh mục</li>
</ol>
@endsection
@section('back-link')
<a href="{{url('/admin')}}" class="btn btn-primary btn-sm">
  <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
  Trở về
</a>
@endsection
@section('feature')

<nav class="navbar navbar-expand-sm bg-light navbar-dark">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">      
      <li class="nav-item">                     
      </li>    
    </ul>
    <form class="form-inline  mr-sm-2" action="#">
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text"><label for="sort-list">Sắp xếp</label></span>
        </div>
        <select class="form-control" id="sort-list" name="sort">
          @php
          $sort = null;
          @endphp
          @isset($_COOKIE['sort'])
          @php
          $sort = $_COOKIE['sort'];
          @endphp
          @endisset
          <option value="id">Gần đây</option>
          <option value="name" @if ($sort=='name' ) selected @endif>Tên</option>
          <option value="link" @if ($sort=='link' ) selected @endif>Link</option>
        </select>
      </div>
    </form>
    <form class="form-inline mr-sm-2" action="#">
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text"><label for="order-list">Thứ tự</label></span>
        </div>
        <select class="form-control" id="order-list" name="order">
          <option value="asc">Tăng dần</option>
          <option value="desc">Giảm dần</option>
        </select>
      </div>
    </form>
    <form class="form-inline my-2 my-lg-0">      
      <input class="form-control mr-sm-2" type="text" placeholder="Tên">
      <button class="btn btn-success my-2 my-sm-0" type="button">Tìm kiếm</button>
    </form>    
  </div>
  
</nav>
@endsection
@include('admin.templates.content_header')

<!-- Main content -->
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover ">
    <thead>
      <tr>
        <th>STT</th>
        <th>Tên</th>
        <th>Liên kết</th>
        <th>Ưu tiên</th>
        <th></th>
      </tr>
    </thead>
    <tbody id="category-table-tbody">
      @php
      $count = 0;
      @endphp
      @foreach ($categories as $category)
      <tr>
        <td>{{++$count}}</td>
        <td>{{$category['describes']}}</td>
        <td>{{$category['name']}}</td>
        <td>{{$priorities[$category['priority_id']]['describes']}}</td>
        <td>
          <div class="dropdown">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
              Thay đổi
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="{{route('category.edit', ['category' => $category['id']])}}">
                <i class="far fa-edit" aria-hidden="true"></i> Sửa
              </a>
              <form id="delete-category-form" action="{{route('category.destroy',['category' => $category['id']])}}"
                method="POST">
                @method('DELETE')
                @csrf
                <a class="dropdown-item" href="#" onclick="document.getElementById('delete-category-form').submit()"><i
                    class="fa fa-times" aria-hidden="true"></i> Xóa</a>
              </form>
            </div>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  @section('pagination')
  @include('admin.templates.pagination')
  @endsection
</div>