<div class="timeline">
    <div class="time-label">
        <span class="bg-green">最新记录</span>
    </div>
    @foreach(array_reverse($remarks) as $item)
        <div>
            @if($val->valid==1)
                <?php   $a=explode('@',$item); ?>
                <i class="fa fa-plus" style="background: rgba(98,168,234,1);color: white"></i>
                <div class="timeline-item">
                    <span class="time"><i class="feather icon-clock"></i>{{$a[0]}}</span>
                    <div class="timeline-header">
                        <p></p>
                   </div>
                    <div class="timeline-body">
                        {{$a[1]}}
                    </div>
                </div>
            @else
                <?php
                $a=explode('@',$item);
                ?>
                <i class="fa fa-minus" style="background: rgba(234,84,85,1);color: white"></i>
                <div class="timeline-item">
                    <span class="time"><i class="feather icon-clock"></i> {{$a[0]}}</span>
                    <div class="timeline-header">
                        <p></p>
                    </div>
                    <div class="timeline-body">
                        {{$a[1]}}
                    </div>
                </div>
            @endif
        </div>
    @endforeach
    <div>
        <i class="fas fa-clock bg-gray"></i>
    </div>
</div>
<style>
    .timeline-item, .timeline-header {
        font-size: 10;
        padding-top: 20px;
        background: none !important;
        color: #a8a9bb !important;
    }
    .ft{width: 300px;}
</style>
