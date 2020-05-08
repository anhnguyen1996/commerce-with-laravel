<!-- Pagination -->
@isset($pagination)
@php
/**
* @var \App\Http\Controller\Admin\Pagination\Pagination $pagination
*/
$currentPage = $pagination->getCurrentPage();
$totalPages = $pagination->getTotalPages();
$url = '/' . $pagination->getUrl() . '/page/';
$beforePage1Level = $currentPage - 1;
$beforePage2Level = $beforePage1Level - 1;
$afterPage1Level = $currentPage + 1;
$afterPage2Level = $afterPage1Level + 1;
@endphp
<ul class="pagination d-flex justify-content-center">
  @if ($currentPage - 1 > 0)
  <li class="page-item"><a class="page-link" href="{{url($url . $beforePage1Level)}}">Quay lại</a></li>
  @endif
  @if ($beforePage2Level > 0)
  <li class="page-item"><a class="page-link" href="{{url($url . $beforePage2Level)}}">{{$beforePage2Level}}</a></li>
  @endif
  @if ($beforePage1Level > 0)
  <li class="page-item"><a class="page-link" href="{{url($url . $beforePage1Level)}}">{{$beforePage1Level}}</a></li>
  @endif
  <li class="page-item active"><a class="page-link" href="{{url($url . $currentPage)}}">{{$currentPage}}</a></li>
  @if ($afterPage1Level <= $totalPages) <li class="page-item"><a class="page-link"
      href="{{url($url . $afterPage1Level)}}">{{$afterPage1Level}}</a></li>
    @endif
    @if ($afterPage2Level <= $totalPages) <li class="page-item"><a class="page-link"
        href="{{url($url . $afterPage2Level)}}">{{$afterPage2Level}}</a></li>
      @endif
      @if ($currentPage + 1 <= $totalPages) <li class="page-item"><a class="page-link"
          href="{{url($url . $afterPage1Level)}}">Tiếp tục</a></li>
        @endif
</ul>
@endisset
<!-- End pagination -->