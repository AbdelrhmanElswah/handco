@extends('layouts.website', [
    'title' => 'Sell Your Property',
    'headerType' => '_header_pages',
    'bg' => 'bg-light'
])

@section('content')
    {{-- Page Banner (breadcrumb style) --}}
    @if($sellPageBanner && $sellPageBanner->is_active)
        <div class="page-banner-simple bg-light py-40">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        @if($sellPageBanner->title)
                            <h3 class="banner-title">{{ $sellPageBanner->title }}</h3>
                        @endif
                        @if($sellPageBanner->subtitle)
                            <span class="banner-tagline font-medium">
                                {{ $sellPageBanner->subtitle }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Hero Section --}}
    @if($sellHeroBanner && $sellHeroBanner->is_active)
        <div class="full-row paraxify position-relative"
             style="background-image: url('https://ggfx-dachare.s3.eu-west-2.amazonaws.com/x.prod/1800x640/sell_your_property_with_us_min_cd59dc314a.webp'); background-repeat: no-repeat; background-position: center center; background-size: cover;">
            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to right, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.3)); z-index: 1;"></div>
            <div class="container position-relative" style="z-index: 2;">
                <div class="row align-items-center" style="min-height: 380px;">
                    <div class="col-xl-7 col-lg-8">
                        <div class="text-white">
                            @if($sellHeroBanner->subtitle)
                                <span class="tagline text-primary" style="text-shadow: 0 0 10px rgba(0,0,0,0.7); font-weight: 600;">
                                    {{ $sellHeroBanner->subtitle }}
                                </span>
                            @endif
                            @if($sellHeroBanner->title)
                                <h1 class="mb-4 text-white" style="font-size: 2.8rem; font-weight: 700; text-shadow: 0 0 15px rgba(0,0,0,0.9);">
                                    {{ $sellHeroBanner->title }}
                                </h1>
                            @endif
                            @if($sellHeroBanner->content)
                                <div class="mb-4" style="max-width: 650px; text-shadow: 0 0 8px rgba(0,0,0,0.8);">
                                    {!! $sellHeroBanner->content !!}
                                </div>
                            @endif
                            <div class="d-flex flex-wrap gap-3">
                                <button type="button"
                                        class="btn px-4 py-2 open-valuation-modal"
                                        style="background-color:#ff941a; color:#fff; border:none; min-width:230px; font-weight:600; font-size:1rem; box-shadow:0 4px 10px rgba(0,0,0,.25); border-radius:8px;"
                                        data-bs-toggle="modal" data-bs-target="#valuationModal"
                                        data-subject="Property Valuation Request"
                                        data-title="Property Valuation">
                                    Request Valuation
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Step by Step Section --}}
    @if($sellStepsSection && $sellStepsSection->is_active)
        <div class="full-row py-5" style="background-color:#ffffff;">
            <div class="container">
                {{-- Section heading --}}
                <div class="row mb-5">
                    <div class="col-lg-8 text-start">
                        @if($sellStepsSection->subtitle)
                            <span class="d-block mb-2" style="color:#c79a5b; letter-spacing:0.08em; text-transform:uppercase; font-size:0.9rem; font-weight:600;">
                                {{ $sellStepsSection->subtitle }}
                            </span>
                        @endif
                        @if($sellStepsSection->title)
                            <h2 class="fw-bold" style="font-size: 2.5rem; color:#0b2948;">
                                {{ $sellStepsSection->title }}
                            </h2>
                        @endif
                    </div>
                </div>

                @php
                    $steps = $sellStepsSection->accordion_items ?? [];
                @endphp

                @if(!empty($steps))
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                        @foreach($steps as $index => $step)
                            <div class="col">
                                <div class="h-100 shadow-sm" style="background-color:#ffffff; border-radius:16px; border:1px solid rgba(15,46,83,0.06);">
                                    <div class="p-4 p-lg-4 h-100 d-flex flex-column">                                        {{-- Optional icon slot in case we add icons later --}}
                                        @if(!empty($step['icon']))
                                            <div class="mb-3">
                                                <img src="{{ $step['icon'] }}" alt="" style="height:44px;">
                                            </div>
                                        @endif

                                        <h5 class="fw-bold mb-3" style="color:#0b2948; font-size:1.25rem;">
                                            {{ $step['title'] ?? 'Step '.($index + 1) }}
                                        </h5>
                                        <p class="mb-0" style="color:#718096; font-size:0.98rem; line-height:1.7;">
                                            {!! $step['content'] ?? '' !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Call To Action Section --}}
    <div class="full-row py-0" style="background-color: #001f3f;">
        <div class="container-fluid p-0">
            <div class="row g-0 align-items-stretch">
                {{-- Left: text + buttons with patterned background --}}
                <div class="col-lg-7 d-flex align-items-center" style="background-color: #001f3f; position: relative; padding: 70px 80px 80px 80px;">
                    <div style="position:absolute; inset:0; opacity:0.12; background-image:repeating-linear-gradient(45deg, transparent, transparent 30px, rgba(255,255,255,.08) 30px, rgba(255,255,255,.08) 60px);"></div>
                    <div class="position-relative text-white" style="z-index:1;">
                        <h2 class="fw-bold mb-4" style="font-size: 2.5rem; line-height: 1.2; color: #ffffff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ optional($sellCtaSection)->title ?? 'Ready to sell your property with H&Co Properties?' }}
                        </h2>
                        @if(optional($sellCtaSection)->content)
                            <div class="mb-4" style="max-width: 640px; font-size: 1rem; line-height: 1.7; color: rgba(255,255,255,0.85);">
                                {!! optional($sellCtaSection)->content !!}
                            </div>
                        @endif
                        <div class="d-flex flex-wrap gap-3">
                                <button type="button"
                                        class="btn px-4 py-2 open-valuation-modal"
                                        style="background-color:#ff941a; color:#fff; border:none; min-width:190px; font-weight:600; font-size:0.95rem; box-shadow:0 4px 10px rgba(0,0,0,.25); border-radius:8px;"
                                    data-bs-toggle="modal" data-bs-target="#valuationModal"
                                    data-subject="Property Valuation Request"
                                    data-title="Property Valuation">
                                Request Valuation
                            </button>
                            <button type="button"
                                    class="btn px-4 py-2 open-valuation-modal"
                                    style="background-color:#4ab1ff; color:#fff; border:none; min-width:190px; font-weight:600; font-size:0.95rem; box-shadow:0 4px 10px rgba(0,0,0,.2); border-radius:8px;"
                                    data-bs-toggle="modal" data-bs-target="#valuationModal"
                                    data-subject="Callback Request from Sell Page"
                                    data-title="Request a Call Back">
                                Request a Call Back
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Right: fixed image --}}
                <div class="col-lg-5" style="min-height: 220px;">
                    <img src="https://mybayutcdn.bayut.com/mybayut/wp-content/uploads/Property-Ownership-in-Dubai-_-Body1-ar16012025.jpg"
                         alt="Sell with H&Co"
                         class="img-fluid w-100 h-100"
                         style="object-fit: cover; min-height: 220px; max-height: 320px;">
                </div>
            </div>
        </div>
    </div>

    {{-- Valuation / Callback Modal --}}
    <div class="modal fade" id="valuationModal" tabindex="-1" aria-labelledby="valuationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="valuationModalLabel">Property Valuation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="valuation-form" action="{{ route('contacts.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="subject" id="valuation-subject" value="Property Valuation Request">
                        <textarea name="message" id="valuation-message" class="d-none"></textarea>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Name<span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" id="valuation-phone" class="form-control" placeholder="+971">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Property Address</label>
                                <input type="text" id="valuation-address" class="form-control" placeholder="Your property address">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Bedrooms</label>
                                <input type="text" id="valuation-bedrooms" class="form-control" placeholder="e.g. 3">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Size (sqft)</label>
                                <input type="text" id="valuation-size" class="form-control" placeholder="e.g. 1500">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message</label>
                                <textarea id="valuation-notes" class="form-control" rows="4" placeholder="Leave your message"></textarea>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Intl-Tel-Input CSS/JS for phone field --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize intl-tel-input for phone field
            let phoneInput = document.getElementById('valuation-phone');
            let phoneIti = null;
            if (phoneInput && window.intlTelInput) {
                phoneIti = window.intlTelInput(phoneInput, {
                    initialCountry: 'ae',
                    // Show full international number (with country code) inside the box
                    nationalMode: false,
                    separateDialCode: false,
                    autoPlaceholder: 'off',
                    preferredCountries: ['ae', 'sa', 'kw', 'qa', 'om', 'bh'],
                    utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js',
                });

                // Pre-fill the input with the UAE country code so it is always visible
                phoneIti.setNumber('+971');
            }
            // Handle opening modal from different buttons
            document.querySelectorAll('.open-valuation-modal').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const subject = this.getAttribute('data-subject') || 'Property Valuation Request';
                    const title = this.getAttribute('data-title') || 'Property Valuation';

                    document.getElementById('valuation-subject').value = subject;
                    document.getElementById('valuationModalLabel').innerText = title;
                });
            });

            // On submit, build a single message body from the extra fields
            const form = document.getElementById('valuation-form');
            if (form) {
                form.addEventListener('submit', function () {
                    const rawPhoneInput = document.getElementById('valuation-phone');
                    let phone = rawPhoneInput ? rawPhoneInput.value.trim() : '';
                    if (typeof phoneIti !== 'undefined' && phoneIti) {
                        const itiNumber = phoneIti.getNumber();
                        if (itiNumber) {
                            phone = itiNumber;
                        }
                    }
                    const address = document.getElementById('valuation-address').value.trim();
                    const bedrooms = document.getElementById('valuation-bedrooms').value.trim();
                    const size = document.getElementById('valuation-size').value.trim();
                    const notes = document.getElementById('valuation-notes').value.trim();

                    let messageParts = [];
                    if (phone) messageParts.push('Phone: ' + phone);
                    if (address) messageParts.push('Property address: ' + address);
                    if (bedrooms) messageParts.push('Bedrooms: ' + bedrooms);
                    if (size) messageParts.push('Size: ' + size + ' sqft');
                    if (notes) messageParts.push('\nAdditional message:\n' + notes);

                    document.getElementById('valuation-message').value = messageParts.join('\n');
                });
            }
        });
    </script>

    <style>
        /* Sell page - valuation modal styling to match boxed fields */
        /* Position modal content a bit lower so navbar doesn't cover it */
        #valuationModal .modal-dialog {
            margin-top: 80px;
        }

        #valuationModal .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 18px 45px rgba(15, 46, 83, 0.25);
        }

        #valuationModal .modal-header {
            border-bottom: none;
            padding: 1.5rem 1.5rem 0.5rem;
        }

        #valuationModal .modal-body {
            padding: 0 1.5rem 1.5rem;
            overflow: visible !important; /* إلغاء أي سكروول داخلي بالكامل */
        }

        #valuationModal .form-label {
            font-weight: 600;
            font-size: 0.95rem;
            color: #4a4f59;
        }

        #valuationModal .form-control {
            border-radius: 8px;
            border: 1px solid #d7dde5;
            padding: 0.65rem 0.9rem;
            font-size: 0.95rem;
            box-shadow: none;
        }

        /* Extra space for phone input so الكود يبقى واضح جنب العلم */
        #valuationModal .iti--allow-dropdown input[type=tel],
        #valuationModal .iti--allow-dropdown input[type=text] {
            padding-left: 3.2rem; /* يزيد المسافة بين العلم والكود */
        }
        #valuationModal .iti__flag-container {
            padding-left: 0.5rem;
        }

        #valuationModal .form-control:focus {
            border-color: #ff941a;
            box-shadow: 0 0 0 0.15rem rgba(255, 148, 26, 0.18);
        }

        #valuationModal textarea.form-control {
            min-height: 130px;
        }

        #valuationModal .form-check-label {
            font-size: 0.9rem;
            color: #4a4f59;
        }

        #valuationModal .btn-primary {
            background-color: #ff941a;
            border-color: #ff941a;
            border-radius: 999px;
            padding: 0.6rem 1.8rem;
            font-weight: 600;
            font-size: 0.95rem;
        }

        #valuationModal .btn-primary:hover {
            background-color: #f58305;
            border-color: #f58305;
        }

        /* Allow page (body) scroll while modal is open so full form can be seen */
        body.modal-open {
            overflow-y: auto !important;
            padding-right: 0 !important;
        }
    </style>
@endsection
