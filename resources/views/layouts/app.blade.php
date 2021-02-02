<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('include.html')

    <!-- Preloader -->
    {{-- <div class="preloader"></div> --}}

    @include('include.top')

        @yield('content')

    @include('include.message')
    @include('include.bottom')
    @include('include.user_modal')
    @include('include.footer')
