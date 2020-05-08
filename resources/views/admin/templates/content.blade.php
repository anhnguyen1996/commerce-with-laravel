<div class="content-wrapper" style="min-height: 1200.88px;">
  @isset($content)
  @include('admin.' . $content)
  @endisset
  @section('pagination')
  @show
</div>