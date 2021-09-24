    @include('include.newpage.merchant.top')
    @include('include.newpage.header')

    @yield('content')

    @include('include.newpage.footer')

    {{--  This Tawk plugin is meant for Africa  --}}
@if ($pages != "Supporting HAITI")
@isset($data['continent'])
    @if ($data['continent'] == "Africa")
        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/60e6c49e649e0a0a5ccb2529/1fa2n03hq';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
        </script>
        <!--End of Tawk.to Script-->

        @else

            <!--Start of Tawk.to Script-->
            <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/60e32cb8649e0a0a5ccaa278/1f9rmdccf';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
            })();
            </script>
            <!--End of Tawk.to Script-->

    @endif
@endisset
@endif

{{--  End Tawk Plugin for Africa  --}}



    @include('include.newpage.merchant.footerjs')

    