@include('include.newpage.top')
@include('include.newpage.header')

@yield('content')

@include('include.newpage.footer')
@include('include.modal')
{{--  This Tawk plugin is meant for Africa  --}}

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
    @endif
@endisset

{{--  End Tawk Plugin for Africa  --}}

@include('include.newpage.footerjs')
