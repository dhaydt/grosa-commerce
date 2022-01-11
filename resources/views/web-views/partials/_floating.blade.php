<style>
    .floating-btn{
        position: fixed;
        z-index: 21;
        width: auto;
        background-color: red;
        cursor: move;
        border-radius: 50%;
        justify-content: center;
        align-items: center;
    }
    .chatus {
        z-index: 23;
    }
</style>
{{-- <div class="draggable" style="position:fixed; z-index:21; top:50px; left:10px; width:50px; height:50px; background:#f00;"></div> --}}
<div class="floating-btn d-flex d-md-none draggable" style="bottom:50px; left:10px; width:50px; height:50px;" onclick="openThis()">
    <a href="http://grosa.id" target="_blank" class="chatus">chat</a>
</div>

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
