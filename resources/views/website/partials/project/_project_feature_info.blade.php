<div class="property-overview border rounded bg-white p-30 mb-30">
    <div class="row row-cols-1">
        <div class="col">
            <h5 class="mb-3">Property Features</h5>
            <ul class="list-three-fold-width list-style-tick">
                @if($project->utility)
                    @if($project->utility->fitness_lab) <li>Fitness Lab and Room</li> @endif
                    @if($project->utility->swimming_pool) <li>Swimming Pool</li> @endif
                    @if($project->utility->parking) <li>Parking Facility</li> @endif
                    @if($project->utility->green_park_view) <li>Green Park View</li> @endif
                    @if($project->utility->playground) <li>Playground Included</li> @endif
                    @if($project->utility->garden) <li>Garden</li> @endif
                    @if($project->utility->fire_security) <li>Fire Security</li> @endif
                    @if($project->utility->high_class_door) <li>High-Class Door</li> @endif
                    @if($project->utility->store_room) <li>Store Room</li> @endif
                    @if($project->utility->furnished) <li>Furnished</li> @endif
                    @if($project->utility->air_conditioning) <li>Air Conditioning</li> @endif
                    @if($project->utility->gym) <li>Gym</li> @endif
                    @if($project->utility->garage_facility) <li>Garage Facility</li> @endif
                    @if($project->utility->fire_place_facility) <li>Fire Place Facility</li> @endif
                    @if($project->utility->marble_floor) <li>Marble Floor</li> @endif
                    @if($project->utility->floor_heating_system) <li>Floor Heating System</li> @endif
                @else
                    <li>No utilities information available.</li>
                @endif
            </ul>
        </div>
    </div>
</div>
