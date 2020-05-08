@extends('layouts.app')
@section('content')
<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<div class="log-w3">
  <div class="w3layouts-main">
    <h2>Đăng nhập</h2>
    <form action="{{route('login')}}" method="POST">
      @csrf
      <div class="form-group row">
        <input type="email" class="ggg form-control @error('email') is-invalid @enderror" name="email"
          placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        @error('email')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      <div class="form-group row">
        <input type="password" class="ggg form-control @error('password') is-invalid @enderror" name="password"
          placeholder="Mật khẩu" required autocomplete="current-password">
        @error('password')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      <div class="form-group row">
        <span>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember"
              {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
              {{ __('Nhớ tài khoản') }}
            </label>
          </div>
        </span>
      </div>
      <h6><a href="#">Quên mật khẩu?</a></h6>

      <div class="clearfix"></div>
      <div class="form-group row">
        <button type="submit" class="btn btn-primary">
          {{ __('Đăng nhập') }}
        </button>
        @if (Route::has('password.request'))
        <a class="btn btn-link" href="{{ route('password.request') }}">
          {{ __('Quên tài khoản?') }}
        </a>
        @endif
      </div>
    </form>
    <p>Chưa có tài khoản <a href="{{route('register')}}">Tạo tài khoản mới</a></p>
  </div>
</div>
<script src="{{asset('public/admin2/js/bootstrap.js')}}"></script>
<script src="{{asset('public/admin2/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/admin2/js/scripts.js')}}"></script>
<script src="{{asset('public/admin2/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/admin2/js/jquery.nicescroll.js')}}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="{{asset('public/admin2/js/flot-chart/excanvas.min.js')}}"></script><![endif]-->
<script src="{{asset('public/admin2/js/jquery.scrollTo.js')}}"></script>
@endsection