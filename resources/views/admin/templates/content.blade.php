<div class="content-wrapper" style="min-height: 1200.88px;">
  {{-- @isset($content)
  @include('admin.' . $content)
  @endisset
   --}}
  @include('admin.templates.content_header')
  @section('content')
  @show
  @section('pagination') 
  @show
</div>