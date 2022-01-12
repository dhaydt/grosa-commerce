<style>
    #floating{
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
    .chat {
        position: fixed;
        bottom: 70px;
        left: 20px;
        font-size: 20px;
        font-weight: 800;
        color: red !important;
        z-index: 30;
        transition: .5s;
    }
    .chat::hover{
        color: blue;
    }
    @media(min-width: 600px){
        #floating {
            display: none;
        }
    }
</style>
@php($floating=\App\Model\Banner::where('banner_type','Floating Banner')->where('published',1)->orderBy('id','desc')->first())
@if (isset($floating))
<div id="floating" style="position: fixed; right: 0px; bottom: 65px; width: 80px;height: 80px;">
    <a href="{{ $floating['url'] }}" class="chatus">
        <img class="float-img" src="{{asset('storage/app/public/banner')}}/{{$floating['photo']}}" alt="floating"></a>
</div>
<a href="https://wa.me/6282382852283?text=Daging%20segarnya%20tersedia?"  class="chat">Chat Me</a>
@endif

@push('script')
    <script>
        $('#floating').draggable({
            scroll: false,
            containment: "#bg-container",

            start: function( event, ui ) {
                console.log("start top is :" + ui.position.top)
                console.log("start left is :" + ui.position.left)
            },
            drag: function(event, ui) {
                console.log('draging.....');
            },
            stop: function( event, ui ) {
                console.log("stop top is :" + ui.position.top)
                console.log("stop left is :" + ui.position.left)

                // alert('left:'+ui.position.left + ' top:'+ui.position.top)
            }
        });
    </script>
@endpush
