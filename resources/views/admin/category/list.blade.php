@php
$activeMenu = 'category';
@endphp

@section('title', 'Danh sách danh mục')
{{-- Content Header --}}
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
        <a href="{{route('category.create')}}">
          <button class="form-control btn btn-outline-primary">
            Tạo mới
          </button>
        </a>
      </li>
    </ul>
    <form class="form-inline  mr-sm-2" action="#">
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text"><label for="sort-list">Sắp xếp</label></span>
        </div>
        <select class="form-control" id="sort-list" name="sort">
          @php
          $sort = 'id';
          @endphp
          @isset($_COOKIE['sort'])
          @php
          $sortCookieJson = json_decode($_COOKIE['sort']);
          if (isset($sortCookieJson->category)) {
            $sort = $sortCookieJson->category;
          }          
          @endphp
          @endisset
          <option value="id">Gần đây</option>
          <option value="describes" @if ($sort=='describes' ) selected @endif>Tên</option>
          <option value="name" @if ($sort=='name' ) selected @endif>Link</option>
        </select>
      </div>
    </form>
    <form class="form-inline mr-sm-2" id="order-form" action="#">
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text"><label for="order-list">Thứ tự</label></span>
        </div>
        <select class="form-control" id="order-list" name="order">
          @php
          $order = null;
          @endphp
          @isset($_COOKIE['order'])
          @php
          $orderCookieJson = json_decode($_COOKIE['order']);
          if (isset($orderCookieJson->category)) {
            $order = $orderCookieJson->category;
          }          
          @endphp
          @endisset
          <option value="asc" @if ($order=='asc' ) selected @endif>Tăng dần</option>
          <option value="desc" @if ($order=='desc' ) selected @endif>Giảm dần</option>
        </select>
      </div>
    </form>
    <form action="#" class="form-inline my-2 my-lg-0">
      <input id="search-text" class="form-control mr-sm-2" type="text" placeholder="Tên cần tìm" value="{{$search}}">
      <button id="search-button" type="button" class="btn btn-success my-2 my-sm-0" type="button">Tìm kiếm</button>
    </form>
  </div>
</nav>
@endsection
{{-- End content header --}}

{{-- Main content --}}
@section('content')
<!-- Script -->
<script src="{{asset('public/admin/js/category-list.js')}}"></script>
<!-- End script -->

@isset($_COOKIE['search'])
  @php
  $search = null;
  $searchCookieJson = json_decode($_COOKIE['search']);
  @endphp
  @isset ($searchCookieJson->category) 
    @php
    $search = $searchCookieJson->category;
    @endphp
    @if ($search != null && $search != '')
    <p> Kết quả tìm kiếm từ khóa "{{$search}}" <a class="text-danger" id="delete-search">Xóa tìm kiếm</a></p>
    @endif
  @endisset
@endisset
<div class="table-responsive" style="min-height: 600px">
  <table class="table table-striped table-bordered table-hover ">
    <thead>
      <tr>
        <th>STT</th>
        <th>Tên danh mục</th>
        <th>Liên kết</th>
        <th>Ưu tiên</th>
        <th>Thuộc danh mục</th>
        <th>Hiển thị</th>
        <th></th>
      </tr>
    </thead>
    <tbody id="category-table-tbody">
      @php
      $index = 0;
      /**
       * @var \App\Http\Controllers\Admin\Modules\Pagination\Pagination $pagination;
       */
      if (isset($pagination)) {
        $index = $pagination->getStartRecordNumber();
      }
      //dd($categories);
      @endphp
      @foreach ($categories as $category)
      @php
      $category = (array)$category;
      $id = $category['id'];
      @endphp
      <tr>
        <td>{{++$index}}</td>
        <td>{{$category['describes']}}</td>
        <td>{{$category['name']}}</td>
        <td>{{$priorities[$category['priority_id']]['describes']}}</td>
        <td>{{$category['parent_describes']}}</td>
        <td>@if($category['visible'] == true) Hiện @else Ẩn @endif</td>
        <td>
          <div class="dropdown">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
              Thay đổi
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="{{route('category.edit', ['category' => $category['id']])}}">
                <i class="far fa-edit" aria-hidden="true"></i> Sửa
              </a>
              <form id="delete-id-{{$category['id']}}"
                action="{{route('category.destroy',['category' => $category['id']])}}" method="POST">
                @method('DELETE')
                @csrf
                <a class="dropdown-item" onclick="document.getElementById('delete-id-{{$category['id']}}').submit();"><i
                    class="fa fa-times" aria-hidden="true"></i> Xóa</a>
              </form>
            </div>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection

@section('pagination')
@include('admin.templates.pagination')
@endsection
{{-- End main content --}}

@extends('admin.master')