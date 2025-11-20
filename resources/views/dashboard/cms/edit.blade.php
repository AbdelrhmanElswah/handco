@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Edit CMS Section: {{ $cms->section_name }}</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('cms.index') }}">CMS Sections</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">{{ $cms->section_name }} ({{ $cms->section_key }})</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('cms.update', $cms->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            @php
                                $sectionKey = $cms->section_key;
                            @endphp

                            {{-- Show Title and Subtitle for common sections including footer_register_cta --}}
                            @if(in_array($sectionKey, ['main_services', 'testimonials_section', 'about_page_banner', 'about_hero_banner', 'about_partners', 'mission_vision_section', 'footer_register_cta']))
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="title" style="font-size: 21px">Title</label>
                                    <input type="text" placeholder="Section Title" name="title" class="form-control"
                                           value="{{ old('title', $cms->title) }}">
                                    <small class="form-text text-muted">Main heading/title for this section</small>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="subtitle" style="font-size: 21px">Subtitle</label>
                                    <input type="text" placeholder="Subtitle (optional)" name="subtitle" class="form-control"
                                           value="{{ old('subtitle', $cms->subtitle) }}">
                                </div>
                            </div>
                            @endif

                            {{-- Social Links Section --}}
                            @if($sectionKey === 'social_links_section')
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label style="font-size: 21px">Social Links</label>
                                    <div id="social-links-container">
                                        @php $socials = $cms->social_links ?? []; @endphp
                                        @if(count($socials) > 0)
                                            @foreach($socials as $index => $s)
                                            <div class="card mb-2 social-link-card" data-social-index="{{ $index }}">
                                                <div class="card-body">
                                                    <div class="row g-2">
                                                        <div class="col-md-3">
                                                            <input type="text" name="social_links[{{ $index }}][platform]" class="form-control" value="{{ $s['platform'] ?? '' }}" placeholder="Platform (e.g., Facebook)">
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input type="text" name="social_links[{{ $index }}][url]" class="form-control" value="{{ $s['url'] ?? '' }}" placeholder="https://...">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <input type="text" name="social_links[{{ $index }}][icon_class]" class="form-control" value="{{ $s['icon_class'] ?? 'fab fa-facebook-f' }}" placeholder="Icon class">
                                                        </div>
                                                        <div class="col-md-1 d-flex align-items-end">
                                                            <button type="button" class="btn btn-outline-danger remove-social-link-btn"><i class="far fa-trash-alt"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <div class="card mb-2 social-link-card" data-social-index="0">
                                                <div class="card-body">
                                                    <div class="row g-2">
                                                        <div class="col-md-3">
                                                            <input type="text" name="social_links[0][platform]" class="form-control" placeholder="Platform (e.g., Facebook)">
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input type="text" name="social_links[0][url]" class="form-control" placeholder="https://...">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <input type="text" name="social_links[0][icon_class]" class="form-control" value="fab fa-facebook-f" placeholder="Icon class">
                                                        </div>
                                                        <div class="col-md-1 d-flex align-items-end">
                                                            <button type="button" class="btn btn-outline-danger remove-social-link-btn"><i class="far fa-trash-alt"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-social-link-btn"><i class="far fa-plus"></i> Add Social Link</button>
                                </div>
                            </div>
                            @endif

                            {{-- Contact Info Section (phones, addresses, emails) --}}
                            @if($sectionKey === 'contact_info_section')
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label style="font-size: 21px">Phone Numbers</label>
                                    <div id="contact-phones-container">
                                        @php $phones = $cms->contact_phones ?? []; @endphp
                                        @if(count($phones) > 0)
                                            @foreach($phones as $index => $phone)
                                            <div class="card mb-2 contact-phone-card" data-phone-index="{{ $index }}">
                                                <div class="card-body">
                                                    <div class="row g-2">
                                                        <div class="col-md-5">
                                                            <input type="text" name="contact_phones[{{ $index }}][title]" class="form-control" value="{{ $phone['title'] ?? '' }}" placeholder="Title (e.g., Sales)">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" name="contact_phones[{{ $index }}][number]" class="form-control" value="{{ $phone['number'] ?? '' }}" placeholder="Number (e.g., +971 52 778 5359)">
                                                        </div>
                                                        <div class="col-md-1 d-flex align-items-end">
                                                            <button type="button" class="btn btn-outline-danger remove-contact-phone-btn"><i class="far fa-trash-alt"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <div class="card mb-2 contact-phone-card" data-phone-index="0">
                                                <div class="card-body">
                                                    <div class="row g-2">
                                                        <div class="col-md-5">
                                                            <input type="text" name="contact_phones[0][title]" class="form-control" placeholder="Title (e.g., Sales)">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" name="contact_phones[0][number]" class="form-control" placeholder="Number (e.g., +971 52 778 5359)">
                                                        </div>
                                                        <div class="col-md-1 d-flex align-items-end">
                                                            <button type="button" class="btn btn-outline-danger remove-contact-phone-btn"><i class="far fa-trash-alt"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-contact-phone-btn"><i class="far fa-plus"></i> Add Phone</button>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label style="font-size: 21px">Addresses</label>
                                    <div id="contact-addresses-container">
                                        @php $addresses = $cms->contact_addresses ?? []; @endphp
                                        @if(count($addresses) > 0)
                                            @foreach($addresses as $index => $addr)
                                            <div class="card mb-2 contact-address-card" data-address-index="{{ $index }}">
                                                <div class="card-body">
                                                    <div class="row g-2">
                                                        <div class="col-md-5">
                                                            <input type="text" name="contact_addresses[{{ $index }}][title]" class="form-control" value="{{ $addr['title'] ?? '' }}" placeholder="Title (e.g., Office Address)">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" name="contact_addresses[{{ $index }}][content]" class="form-control" value="{{ $addr['content'] ?? '' }}" placeholder="Address content">
                                                        </div>
                                                        <div class="col-md-1 d-flex align-items-end">
                                                            <button type="button" class="btn btn-outline-danger remove-contact-address-btn"><i class="far fa-trash-alt"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <div class="card mb-2 contact-address-card" data-address-index="0">
                                                <div class="card-body">
                                                    <div class="row g-2">
                                                        <div class="col-md-5">
                                                            <input type="text" name="contact_addresses[0][title]" class="form-control" placeholder="Title (e.g., Office Address)">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" name="contact_addresses[0][content]" class="form-control" placeholder="Address content">
                                                        </div>
                                                        <div class="col-md-1 d-flex align-items-end">
                                                            <button type="button" class="btn btn-outline-danger remove-contact-address-btn"><i class="far fa-trash-alt"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-contact-address-btn"><i class="far fa-plus"></i> Add Address</button>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label style="font-size: 21px">Emails</label>
                                    <div id="contact-emails-container">
                                        @php $emails = $cms->contact_emails ?? []; @endphp
                                        @if(count($emails) > 0)
                                            @foreach($emails as $index => $email)
                                            <div class="input-group mb-2 contact-email-item" data-email-index="{{ $index }}">
                                                <input type="email" name="contact_emails[]" class="form-control" value="{{ $email }}" placeholder="email@example.com">
                                                <button type="button" class="btn btn-outline-danger remove-contact-email-btn"><i class="far fa-trash-alt"></i></button>
                                            </div>
                                            @endforeach
                                        @else
                                            <div class="input-group mb-2 contact-email-item" data-email-index="0">
                                                <input type="email" name="contact_emails[]" class="form-control" placeholder="email@example.com">
                                                <button type="button" class="btn btn-outline-danger remove-contact-email-btn"><i class="far fa-trash-alt"></i></button>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-contact-email-btn"><i class="far fa-plus"></i> Add Email</button>
                                </div>
                            </div>
                            @endif

                            {{-- Show Content for main_services and about_hero_banner --}}
                            @if(in_array($sectionKey, ['main_services', 'about_hero_banner']))
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="content" style="font-size: 21px">Content/Description</label>
                                    <textarea name="content" class="form-control" rows="5"
                                              placeholder="Main content or description">{{ old('content', $cms->content) }}</textarea>
                                </div>
                            </div>
                            @endif

                            {{-- Background Image Upload for about_hero_banner --}}
                            @if($sectionKey === 'about_hero_banner')
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label style="font-size: 21px">Background Image</label>
                                    @if($cms->backgroundImage)
                                    <div class="mb-3">
                                        <label class="form-label">Current Image:</label>
                                        <div class="mb-2">
                                            <img src="{{ $cms->backgroundImage->media_link }}" alt="Background Image" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; border-radius: 4px;">
                                        </div>
                                        <small class="text-muted d-block">Upload a new image to replace the current one</small>
                                    </div>
                                    @endif
                                    <input type="file" name="background_image" class="form-control" accept="image/*">
                                    <small class="form-text text-muted d-block">Upload a background image for the About Us hero banner section</small>
                                </div>
                            </div>
                            @endif

                            {{-- Footer CTA fields (button text/link) --}}
                            @if($sectionKey === 'footer_register_cta')
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label style="font-size: 21px">Button Text</label>
                                    <input type="text" name="button_text" class="form-control" value="{{ data_get($cms->list_items, 'button_text') }}" placeholder="Contact Us">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label style="font-size: 21px">Button Link</label>
                                    <input type="text" name="button_link" class="form-control" value="{{ data_get($cms->list_items, 'button_link') }}" placeholder="{{ route('contact') }}">
                                </div>
                            </div>
                            @endif

                            {{-- Show List Items for main_services --}}
                            @if($sectionKey === 'main_services')
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label style="font-size: 21px">List Items</label>
                                    <div id="list-items-container">
                                        @if($cms->list_items && count($cms->list_items) > 0)
                                            @foreach($cms->list_items as $index => $item)
                                                <div class="input-group mb-2" data-item-index="{{ $index }}">
                                                    <input type="text" name="list_items[]" class="form-control"
                                                           value="{{ $item }}" placeholder="List item">
                                                    <button type="button" class="btn btn-outline-danger remove-list-item-btn">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="input-group mb-2" data-item-index="0">
                                                <input type="text" name="list_items[]" class="form-control"
                                                       placeholder="List item">
                                                <button type="button" class="btn btn-outline-danger remove-list-item-btn">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-list-item-btn">
                                        <i class="far fa-plus"></i> Add List Item
                                    </button>
                                    <small class="form-text text-muted d-block">Add multiple list items (e.g., services, features)</small>
                                </div>
                            </div>
                            @endif

                            {{-- Show Partner Logos Upload for about_partners --}}
                            @if($sectionKey === 'about_partners')
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label style="font-size: 21px">Partner Logos</label>

                                    {{-- Display existing logos --}}
                                    @if($cms->list_items && count($cms->list_items) > 0)
                                    <div class="mb-3">
                                        <label class="form-label">Existing Logos:</label>
                                        <div class="row g-3" id="existing-logos-container">
                                            @foreach($cms->list_items as $index => $logoUrl)
                                            <div class="col-md-3 existing-logo-item" data-logo-index="{{ $index }}">
                                                <div class="card">
                                                    <div class="card-body text-center p-2">
                                                        <img src="{{ $logoUrl }}" alt="Partner Logo" class="img-fluid mb-2" style="max-height: 80px; object-fit: contain;">
                                                        <input type="hidden" name="existing_logos[]" value="{{ $logoUrl }}">
                                                        <button type="button" class="btn btn-outline-danger btn-sm remove-existing-logo-btn">
                                                            <i class="far fa-trash-alt"></i> Remove
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    {{-- File upload for new logos --}}
                                    <div class="mb-3">
                                        <label class="form-label">Upload New Logos:</label>
                                        <input type="file" name="partner_logos[]" class="form-control" multiple accept="image/*">
                                        <small class="form-text text-muted d-block">You can select multiple logo images at once</small>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Show Statistics Items only for counting_section --}}
                            @if($sectionKey === 'counting_section')
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label style="font-size: 21px">Statistics Items</label>
                                    <div id="stats-items-container">
                                        @if($cms->stats_items && count($cms->stats_items) > 0)
                                            @foreach($cms->stats_items as $index => $stat)
                                                <div class="card mb-2 stats-item-card" data-stat-index="{{ $index }}">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <label class="form-label">Value (e.g., $15.4M, 25K+)</label>
                                                                <input type="text" name="stats_items[{{ $index }}][value]"
                                                                       class="form-control" value="{{ $stat['value'] ?? '' }}"
                                                                       placeholder="Statistic value">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Description</label>
                                                                <input type="text" name="stats_items[{{ $index }}][description]"
                                                                       class="form-control" value="{{ $stat['description'] ?? '' }}"
                                                                       placeholder="Statistic description">
                                                            </div>
                                                            <div class="col-md-1 d-flex align-items-end">
                                                                <button type="button" class="btn btn-outline-danger remove-stats-item-btn">
                                                                    <i class="far fa-trash-alt"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="card mb-2 stats-item-card" data-stat-index="0">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <label class="form-label">Value (e.g., $15.4M, 25K+)</label>
                                                            <input type="text" name="stats_items[0][value]"
                                                                   class="form-control" placeholder="Statistic value">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Description</label>
                                                            <input type="text" name="stats_items[0][description]"
                                                                   class="form-control" placeholder="Statistic description">
                                                        </div>
                                                        <div class="col-md-1 d-flex align-items-end">
                                                            <button type="button" class="btn btn-outline-danger remove-stats-item-btn">
                                                                <i class="far fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-stats-item-btn">
                                        <i class="far fa-plus"></i> Add Statistic Item
                                    </button>
                                    <small class="form-text text-muted d-block">Add statistics with values and descriptions (e.g., "$15.4M" and "Owned from Properties Transactions")</small>
                                </div>
                            </div>
                            @endif

                            {{-- Show Testimonials only for testimonials_section --}}
                            @if($sectionKey === 'testimonials_section')
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label style="font-size: 21px">Testimonials</label>
                                    <div id="testimonials-container">
                                        @if($cms->testimonials && count($cms->testimonials) > 0)
                                            @foreach($cms->testimonials as $index => $testimonial)
                                                <div class="card mb-2 testimonial-card" data-testimonial-index="{{ $index }}">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Quote</label>
                                                                <textarea name="testimonials[{{ $index }}][quote]"
                                                                          class="form-control" rows="3"
                                                                          placeholder="Testimonial quote">{{ $testimonial['quote'] ?? '' }}</textarea>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Author Name</label>
                                                                <input type="text" name="testimonials[{{ $index }}][author]"
                                                                       class="form-control" value="{{ $testimonial['author'] ?? '' }}"
                                                                       placeholder="Author name">
                                                            </div>
                                                            <div class="col-md-5">
                                                                <label class="form-label">Position/Title</label>
                                                                <input type="text" name="testimonials[{{ $index }}][position]"
                                                                       class="form-control" value="{{ $testimonial['position'] ?? '' }}"
                                                                       placeholder="Position or title (e.g., CEO, Grodins Group)">
                                                            </div>
                                                            <div class="col-md-1 d-flex align-items-end">
                                                                <button type="button" class="btn btn-outline-danger remove-testimonial-btn">
                                                                    <i class="far fa-trash-alt"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="card mb-2 testimonial-card" data-testimonial-index="0">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">Quote</label>
                                                            <textarea name="testimonials[0][quote]"
                                                                      class="form-control" rows="3"
                                                                      placeholder="Testimonial quote"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Author Name</label>
                                                            <input type="text" name="testimonials[0][author]"
                                                                   class="form-control" placeholder="Author name">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="form-label">Position/Title</label>
                                                            <input type="text" name="testimonials[0][position]"
                                                                   class="form-control" placeholder="Position or title (e.g., CEO, Grodins Group)">
                                                        </div>
                                                        <div class="col-md-1 d-flex align-items-end">
                                                            <button type="button" class="btn btn-outline-danger remove-testimonial-btn">
                                                                <i class="far fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-testimonial-btn">
                                        <i class="far fa-plus"></i> Add Testimonial
                                    </button>
                                    <small class="form-text text-muted d-block">Add client testimonials with quotes, author names, and positions</small>
                                </div>
                            </div>
                            @endif

                            {{-- Background Image Upload for mission_vision_section --}}
                            @if($sectionKey === 'mission_vision_section')
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label style="font-size: 21px">Section Image</label>
                                    @if($cms->backgroundImage)
                                    <div class="mb-3">
                                        <label class="form-label">Current Image:</label>
                                        <div class="mb-2">
                                            <img src="{{ $cms->backgroundImage->media_link }}" alt="Section Image" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; border-radius: 4px;">
                                        </div>
                                        <small class="text-muted d-block">Upload a new image to replace the current one</small>
                                    </div>
                                    @endif
                                    <input type="file" name="background_image" class="form-control" accept="image/*">
                                    <small class="form-text text-muted d-block">Upload an image for the Mission & Vision section</small>
                                </div>
                            </div>
                            @endif

                            {{-- Show Accordion Items for mission_vision_section --}}
                            @if($sectionKey === 'mission_vision_section')
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label style="font-size: 21px">Accordion Items (Mission & Vision)</label>
                                    <div id="accordion-items-container">
                                        @if($cms->accordion_items && count($cms->accordion_items) > 0)
                                            @foreach($cms->accordion_items as $index => $item)
                                                <div class="card mb-2 accordion-item-card" data-accordion-index="{{ $index }}">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Title</label>
                                                                <input type="text" name="accordion_items[{{ $index }}][title]"
                                                                       class="form-control" value="{{ $item['title'] ?? '' }}"
                                                                       placeholder="Accordion item title (e.g., Our Mission)">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Content</label>
                                                                <textarea name="accordion_items[{{ $index }}][content]"
                                                                          class="form-control" rows="4"
                                                                          placeholder="Accordion item content">{{ $item['content'] ?? '' }}</textarea>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           name="accordion_items[{{ $index }}][is_active]"
                                                                           value="1"
                                                                           {{ ($item['is_active'] ?? true) ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Show as active (expanded by default)</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <button type="button" class="btn btn-outline-danger remove-accordion-item-btn">
                                                                    <i class="far fa-trash-alt"></i> Remove
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="card mb-2 accordion-item-card" data-accordion-index="0">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">Title</label>
                                                            <input type="text" name="accordion_items[0][title]"
                                                                   class="form-control" placeholder="Accordion item title (e.g., Our Mission)">
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">Content</label>
                                                            <textarea name="accordion_items[0][content]"
                                                                      class="form-control" rows="4"
                                                                      placeholder="Accordion item content"></textarea>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                       name="accordion_items[0][is_active]"
                                                                       value="1" checked>
                                                                <label class="form-check-label">Show as active (expanded by default)</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-2">
                                                            <button type="button" class="btn btn-outline-danger remove-accordion-item-btn">
                                                                <i class="far fa-trash-alt"></i> Remove
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-accordion-item-btn">
                                        <i class="far fa-plus"></i> Add Accordion Item
                                    </button>
                                    <small class="form-text text-muted d-block">Add accordion items for Mission & Vision section</small>
                                </div>
                            </div>
                            @endif

                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                           value="1" {{ old('is_active', $cms->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active" style="font-size: 21px">
                                        Active (Section will be displayed on website)
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Update Section</button>
                                <a href="{{ route('cms.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add new list item (only for main_services)
            const addListBtn = document.getElementById('add-list-item-btn');
            if (addListBtn) {
                addListBtn.addEventListener('click', function() {
                    const container = document.getElementById('list-items-container');
                    const index = container.children.length;
                    const newItem = document.createElement('div');
                    newItem.className = 'input-group mb-2';
                    newItem.setAttribute('data-item-index', index);
                    newItem.innerHTML = `
                        <input type="text" name="list_items[]" class="form-control" placeholder="List item">
                        <button type="button" class="btn btn-outline-danger remove-list-item-btn">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    `;
                    container.appendChild(newItem);
                });
            }

            // Remove list item
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-list-item-btn')) {
                    const item = e.target.closest('.input-group');
                    item.remove();
                }
                // Remove existing logo
                if (e.target.closest('.remove-existing-logo-btn')) {
                    const item = e.target.closest('.existing-logo-item');
                    item.remove();
                }
            });

            // Contact Phones add/remove
            const addPhoneBtn = document.getElementById('add-contact-phone-btn');
            if (addPhoneBtn) {
                addPhoneBtn.addEventListener('click', function() {
                    const container = document.getElementById('contact-phones-container');
                    const index = container.querySelectorAll('.contact-phone-card').length;
                    const div = document.createElement('div');
                    div.className = 'card mb-2 contact-phone-card';
                    div.setAttribute('data-phone-index', index);
                    div.innerHTML = `
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-5">
                                    <input type="text" name="contact_phones[${index}][title]" class="form-control" placeholder="Title (e.g., Sales)">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="contact_phones[${index}][number]" class="form-control" placeholder="Number (e.g., +971 52 778 5359)">
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-outline-danger remove-contact-phone-btn"><i class="far fa-trash-alt"></i></button>
                                </div>
                            </div>
                        </div>`;
                    container.appendChild(div);
                });
            }

            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-contact-phone-btn')) {
                    const card = e.target.closest('.contact-phone-card');
                    card.remove();
                }
            });

            // Contact Addresses add/remove
            const addAddressBtn = document.getElementById('add-contact-address-btn');
            if (addAddressBtn) {
                addAddressBtn.addEventListener('click', function() {
                    const container = document.getElementById('contact-addresses-container');
                    const index = container.querySelectorAll('.contact-address-card').length;
                    const div = document.createElement('div');
                    div.className = 'card mb-2 contact-address-card';
                    div.setAttribute('data-address-index', index);
                    div.innerHTML = `
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-5">
                                    <input type="text" name="contact_addresses[${index}][title]" class="form-control" placeholder="Title (e.g., Office Address)">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="contact_addresses[${index}][content]" class="form-control" placeholder="Address content">
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-outline-danger remove-contact-address-btn"><i class="far fa-trash-alt"></i></button>
                                </div>
                            </div>
                        </div>`;
                    container.appendChild(div);
                });
            }

            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-contact-address-btn')) {
                    const card = e.target.closest('.contact-address-card');
                    card.remove();
                }
            });

            // Contact Emails add/remove
            const addEmailBtn = document.getElementById('add-contact-email-btn');
            if (addEmailBtn) {
                addEmailBtn.addEventListener('click', function() {
                    const container = document.getElementById('contact-emails-container');
                    const index = container.querySelectorAll('.contact-email-item').length;
                    const div = document.createElement('div');
                    div.className = 'input-group mb-2 contact-email-item';
                    div.setAttribute('data-email-index', index);
                    div.innerHTML = `
                        <input type="email" name="contact_emails[]" class="form-control" placeholder="email@example.com">
                        <button type="button" class="btn btn-outline-danger remove-contact-email-btn"><i class="far fa-trash-alt"></i></button>`;
                    container.appendChild(div);
                });
            }

            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-contact-email-btn')) {
                    const item = e.target.closest('.contact-email-item');
                    item.remove();
                }
            });
            // Add new stats item (only for counting_section)
            const addStatsBtn = document.getElementById('add-stats-item-btn');
            if (addStatsBtn) {
                addStatsBtn.addEventListener('click', function() {
                    const container = document.getElementById('stats-items-container');
                    const index = container.children.length;
                    const newItem = document.createElement('div');
                    newItem.className = 'card mb-2 stats-item-card';
                    newItem.setAttribute('data-stat-index', index);
                    newItem.innerHTML = `
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label">Value (e.g., $15.4M, 25K+)</label>
                                    <input type="text" name="stats_items[${index}][value]"
                                           class="form-control" placeholder="Statistic value">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Description</label>
                                    <input type="text" name="stats_items[${index}][description]"
                                           class="form-control" placeholder="Statistic description">
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-outline-danger remove-stats-item-btn">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    container.appendChild(newItem);
                });
            }

            // Remove stats item
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-stats-item-btn')) {
                    const item = e.target.closest('.stats-item-card');
                    item.remove();
                }
            });

            // Add new testimonial (only for testimonials_section)
            const addTestimonialBtn = document.getElementById('add-testimonial-btn');
            if (addTestimonialBtn) {
                addTestimonialBtn.addEventListener('click', function() {
                    const container = document.getElementById('testimonials-container');
                    const index = container.children.length;
                    const newItem = document.createElement('div');
                    newItem.className = 'card mb-2 testimonial-card';
                    newItem.setAttribute('data-testimonial-index', index);
                    newItem.innerHTML = `
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Quote</label>
                                    <textarea name="testimonials[${index}][quote]"
                                              class="form-control" rows="3"
                                              placeholder="Testimonial quote"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Author Name</label>
                                    <input type="text" name="testimonials[${index}][author]"
                                           class="form-control" placeholder="Author name">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Position/Title</label>
                                    <input type="text" name="testimonials[${index}][position]"
                                           class="form-control" placeholder="Position or title (e.g., CEO, Grodins Group)">
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-outline-danger remove-testimonial-btn">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    container.appendChild(newItem);
                });
            }

            // Remove testimonial
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-testimonial-btn')) {
                    const item = e.target.closest('.testimonial-card');
                    item.remove();
                }
            });

            // Add new accordion item (only for mission_vision_section)
            const addAccordionBtn = document.getElementById('add-accordion-item-btn');
            if (addAccordionBtn) {
                addAccordionBtn.addEventListener('click', function() {
                    const container = document.getElementById('accordion-items-container');
                    const index = container.children.length;
                    const newItem = document.createElement('div');
                    newItem.className = 'card mb-2 accordion-item-card';
                    newItem.setAttribute('data-accordion-index', index);
                    newItem.innerHTML = `
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="accordion_items[${index}][title]"
                                           class="form-control" placeholder="Accordion item title (e.g., Our Mission)">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Content</label>
                                    <textarea name="accordion_items[${index}][content]"
                                              class="form-control" rows="4"
                                              placeholder="Accordion item content"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                               name="accordion_items[${index}][is_active]"
                                               value="1" checked>
                                        <label class="form-check-label">Show as active (expanded by default)</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <button type="button" class="btn btn-outline-danger remove-accordion-item-btn">
                                        <i class="far fa-trash-alt"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    container.appendChild(newItem);
                });
            }

            // Remove accordion item
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-accordion-item-btn')) {
                    const item = e.target.closest('.accordion-item-card');
                    item.remove();
                }
            });

            // Social links add/remove
            const addSocialBtn = document.getElementById('add-social-link-btn');
            if (addSocialBtn) {
                addSocialBtn.addEventListener('click', function() {
                    const container = document.getElementById('social-links-container');
                    const index = container.querySelectorAll('.social-link-card').length;
                    const div = document.createElement('div');
                    div.className = 'card mb-2 social-link-card';
                    div.setAttribute('data-social-index', index);
                    div.innerHTML = `
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <input type="text" name="social_links[${index}][platform]" class="form-control" placeholder="Platform (e.g., Facebook)">
                                </div>
                                <div class="col-md-7">
                                    <input type="text" name="social_links[${index}][url]" class="form-control" placeholder="https://...">
                                </div>
                                <div class="col-md-1">
                                    <input type="text" name="social_links[${index}][icon_class]" class="form-control" value="fab fa-facebook-f" placeholder="Icon class">
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-outline-danger remove-social-link-btn"><i class="far fa-trash-alt"></i></button>
                                </div>
                            </div>
                        </div>`;
                    container.appendChild(div);
                });
            }

            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-social-link-btn')) {
                    const card = e.target.closest('.social-link-card');
                    card.remove();
                }
            });
        });
    </script>

@endsection

