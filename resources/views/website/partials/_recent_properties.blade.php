@if($popularProjects->count() > 0)
<div class="full-row bg-light">
    <div class="container">
        <div class="row">
            <div class="col mb-4">
                <div class="position-relative">
                    <div class="text-center">
                        <h1 class="down-line w-50 mx-auto mb-4 text-center fw-bold" style="font-size: 2.5rem;">Off Plan Projects</h1>
                    </div>
                    <div class="position-absolute" style="bottom: 0; right: 0;">
                        <a href="{{ route('featured_projects') }}" class="btn-link">View All</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach($popularProjects as $project)
                        <div class="col">
                            <div class="bg-white property-block border transition hover-shadow" style="border-radius: 8px; overflow: hidden;">
                                <!-- Property Image -->
                                <div class="overflow-hidden position-relative" style="height: 300px;">
                                    <a href="{{ route('off-plan-project.show', $project->id) }}">
                                        <img src="{{ $project->mainImage->media_link ?? asset('images/default.jpg') }}" alt="{{ $project->project_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </a>
                                </div>
                                
                                <!-- Property Details -->
                                <div class="p-4">
                                    <!-- Title -->
                                    <h4 class="mb-3" style="font-size: 1.5rem; font-weight: 600; color: #333;">
                                        <a href="{{ route('off-plan-project.show', $project->id) }}" style="color: #333; text-decoration: none;">{{ $project->project_name }}</a>
                                    </h4>
                                    
                                    <!-- Price -->
                                    @if($project->starting_price)
                                    <p class="mb-3" style="font-size: 1.2rem; font-weight: 600; color: #001f3f;">
                                        Prices from: AED {{ number_format($project->starting_price) }}
                                    </p>
                                    @endif
                                    
                                    <!-- Location -->
                                    @if($project->location)
                                    <p class="mb-2" style="color: #666; font-size: 0.95rem;">
                                        <strong>Location:</strong> {{ $project->location }}
                                    </p>
                                    @endif
                                    
                                    <!-- Developer -->
                                    @if($project->developer)
                                    <p class="mb-2" style="color: #666; font-size: 0.95rem;">
                                        <strong>Developer:</strong> {{ $project->developer }}
                                    </p>
                                    @endif
                                    
                                    <!-- Development Type -->
                                    @if($project->development_type)
                                    <p class="mb-3" style="color: #666; font-size: 0.95rem;">
                                        <strong>Development Type:</strong> {{ $project->development_type }}
                                    </p>
                                    @endif
                                    
                                    <!-- Description -->
                                    @if($project->description || $project->overview)
                                    <p class="mb-0" style="color: #666; font-size: 0.9rem; line-height: 1.6;">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($project->description ?? $project->overview ?? ''), 120) }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif
