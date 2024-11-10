<div class="property-overview border rounded bg-white p-30 mb-30">
    <div class="row row-cols-1">
        <div class="col">
            <h5 class="mb-3">More Information</h5>
            <ul style="list-style: none; padding: 0;">
                @foreach($project->more_information as $info)
                    <li style="display: flex; align-items: center; margin-bottom: 10px;">
                        <!-- Icon based on label type -->
                        @php
                            $icon = '';
                            switch(strtolower($info['label'])) {
                                case 'size':
                                    $icon = 'fas fa-ruler-combined'; // Size icon
                                    break;
                                case 'location':
                                    $icon = 'fas fa-map-marker-alt'; // Location icon
                                    break;
                                case 'rooms':
                                    $icon = 'fas fa-door-open'; // Rooms icon
                                    break;
                                case 'price':
                                    $icon = 'fas fa-dollar-sign'; // Price icon
                                    break;
                                case 'features':
                                    $icon = 'fas fa-star'; // Features icon
                                    break;
                                default:
                                    $icon = 'fas fa-info-circle'; // Default icon
                                    break;
                            }
                        @endphp

                            <!-- Display the icon and information -->
                        <i class="{{ $icon }}" style="margin-right: 8px; color: #b89d68;"></i>
                        <span style="font-weight: 500; color: #333; margin-right: 5px;">{{ $info['label'] }}:</span>
                        <span>{{ $info['value'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
