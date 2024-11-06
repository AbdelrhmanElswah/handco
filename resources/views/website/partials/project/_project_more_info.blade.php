<div class="property-overview border rounded bg-white p-30 mb-30">
    <div class="row row-cols-1">
        <div class="col">
            <h5 class="mb-3">More Information</h5>
            <ul class="list-three-fold-width">
                @foreach($project->more_information as $info)
                    <li><span class="font-500">{{ $info['label'] }} :</span> {{ $info['value'] }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
