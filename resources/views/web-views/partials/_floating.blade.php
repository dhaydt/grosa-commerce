<style>
    .floating-btn{
        position: fixed;
        z-index: 21;
        width: auto;
        background-color: transparent;
        cursor: move;
        border-radius: 50%;
        justify-content: center;
        /* padding: 10px */
        align-items: center;
    }
    .chatus {
        z-index: 25;
        position: absolute;
    }
    .float-img {
        width: 150px;
        height: auto;
    }
</style>
@php($floating=\App\Model\Banner::where('banner_type','Floating Banner')->where('published',1)->orderBy('id','desc')->first())
@if (isset($floating))
<div class="floating-btn d-flex d-md-none draggable" style="bottom:65px; right:0px; width:85px; height:85px;">
    <a href="{{ $floating['url'] }}" target="_blank" class="chatus">
    <img class="float-img" src="{{asset('storage/app/public/banner')}}/{{$floating['photo']}}" alt="floating"></a>
</div>
@endif

@push('script')
    <script>
        $(document).ready(function() {
            function openThis() {
                console.log('open')
            }
            $(".draggable").draggableTouch();
                $("#enable").click(function() {
                    $(".draggable").draggableTouch();
                });
                $("#enable-transform").click(function() {
                    $(".draggable").draggableTouch({useTransform:true});
                });
                $("#disable").click(function() {
                    $(".draggable").draggableTouch("disable");
                });

                $(".draggable").bind("dragstart", function(e, pos) {
                    console.log("dragstart:", this, pos.left + "," + pos.top);
                }).bind("dragend", function(e, pos) {
                    console.log("dragend:", this, pos.left + "," + pos.top);
                });
            });

            if ("ontouchstart" in document.documentElement) {
                window.console = {
                    log: function(a, b, c) {
                        if (a && b && c)
                            $("<div>" + a + " " + b + " " + c + "</div>").appendTo($("#console"));
                        else if (a && b)
                            $("<div>" + a + " " + b + "</div>").appendTo($("#console"));
                        else if (a)
                            $("<div>" + a + "</div>").appendTo($("#console"));
                    }
                };
            }
    </script>
@endpush
