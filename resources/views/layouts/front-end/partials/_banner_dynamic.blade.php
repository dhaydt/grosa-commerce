<style>
    .banner_dynamic{
        height: 72px;
        width: 100%;
        position: relative;
    }
    .banner_dynamic img{
        height: 100%;
        width: 100%;
        background-color: #fff;
    }
    .downloadApp {
        background-color: {{$web_config['secondary_color']}};
        border: 1px solid {{$web_config['secondary_color']}};
        position: absolute;
        right: 15px;
        top: 15px;
        border-radius: 8px;
        font-weight: 700;
        letter-spacing: 1px;
    }
    .closeBan {
        position: absolute;
        left: 0;
        color: #6c727c;
        font-size: 32px;
        font-weight: 600;
        margin-top: 0;
    }


</style>

@php($main_banner=\App\Model\Banner::where('banner_type','Header Banner')->where('published',1)->orderBy('id','desc')->first())
@if (isset($main_banner))
<div class="banner_dynamic" id="bannerDynamic">
    <img src="{{asset('storage/app/public/banner/'.$main_banner['photo'])}}" alt="">
    <button type="button" class="closeBan btn" aria-label="Close" onclick="closeBanner()">
        <span aria-hidden="true">&times;</span>
    </button>
    <a class="downloadApp btn btn-sm btn-success" target="_blank"  href="{{ $main_banner['url'] }}">
        Download
    </a>
</div>
@endif

@push('script')
    <script>
        function closeBanner(){
            $('#bannerDynamic').attr('class', 'd-none')
        }
    </script>
@endpush
