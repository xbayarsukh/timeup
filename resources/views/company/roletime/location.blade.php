@foreach($locations as $location)
    <div class="card align-middle text-center" onclick="thisclick({{$location->id}})"
        style="width:90px; height:90px; background-color:white;display:inline-flex;margin:5px;font-size:14px;white-space:normal">
        <div style="margin:auto">
            {{$location->name}}
        </div>
    </div>
@endforeach