<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>@yield('title')</h1>
      </div>
      <div class="col-sm-6">
        @section('breadcrumb')
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Bảng điều khiển</a></li>
          <li class="breadcrumb-item "><a href="#">Sản phẩm</a></li>
          <li class="breadcrumb-item active">Thêm sản phẩm</li>
        </ol>
        @show
      </div>
    </div>
    <div class="row mb-2">
      <div class="col-sm-12">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            @section('back-link')
            <a href="{{url('/admin')}}" class="btn btn-primary btn-sm">
              <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
              Trở về
            </a>
            @show
          </li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
  @section('feature')
  @show
</section>