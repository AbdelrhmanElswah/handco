@extends('layouts.website', [
    'title' => 'Contact Us',
    'headerType' => '_header_pages',
    'bg' => 'bg-light'
])

@section('content')
    <!--============== Page title Start ==============-->
    <div class="full-row py-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3 class="text-secondary">Contact</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Contact</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!--============== Page title End ==============-->

    <!--============== Contact form Start ==============-->
    <div class="full-row pt-0">
        <div class="container">
            <div class="row">
                <div class="col-md-5 order-md-2">
                    <h4 class="down-line mb-4">Get In Touch</h4>
                    <p>Get your free consultation now!</p>
                    <div class="mb-3">
                        <ul>
                            @if(isset($contactInfoSection) && $contactInfoSection)
                                @if($contactInfoSection->contact_addresses)
                                    @foreach($contactInfoSection->contact_addresses as $addr)
                                    <li class="mb-3">
                                        <h6 class="mb-0">{{ $addr['title'] ?? 'Address' }} :</h6> {{ $addr['content'] ?? '' }}
                                    </li>
                                    @endforeach
                                @endif
                                @if($contactInfoSection->contact_phones)
                                    @foreach($contactInfoSection->contact_phones as $ph)
                                    <li class="mb-3">
                                        <h6>{{ $ph['title'] ?? 'Phone' }} :</h6>
                                        <a class="text-black" href="tel:{{ $ph['number'] ?? '' }}">{{ $ph['number'] ?? '' }}</a>
                                    </li>
                                    @endforeach
                                @endif
                                @if($contactInfoSection->contact_emails)
                                    @foreach($contactInfoSection->contact_emails as $em)
                                    <li class="mb-3">
                                        <h6>Email Address :</h6>
                                        <a class="text-black" href="mailto:{{ $em }}">{{ $em }}</a>
                                    </li>
                                    @endforeach
                                @endif
                            @endif
                        </ul>
                    </div>
                    <h5 class="mb-2">Career Info</h5>
                    <p>If you’re interested in employment opportunities at H&Co Properties, please email us:<br>
                        <a href="mailto:info@handcoproperties.com">info@handcoproperties.com</a>
                    </p>
                </div>

                <div class="col-md-7 order-md-1">
                    <h4 class="down-line mb-4">Send Message</h4>

                    <!-- Display Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Contact Form -->
                    <div class="form-simple">
                        <form id="contact-form" action="{{ route('contacts.store') }}" method="POST" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-20">
                                    <label class="mb-2">Full Name:</label>
                                    <input type="text" class="form-control bg-white" name="name" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-6 mb-20">
                                    <label class="mb-2">Your Email:</label>
                                    <input type="email" class="form-control bg-white" name="email" value="{{ old('email') }}" required>
                                </div>
                                <div class="col-md-12 mb-20">
                                    <label class="mb-2">Subject:</label>
                                    <input type="text" class="form-control bg-white" name="subject" value="{{ old('subject') }}" required>
                                </div>
                                <div class="col-md-12 mb-20">
                                    <label class="mb-2">Message:</label>
                                    <textarea class="form-control bg-white" name="message" rows="8" required>{{ old('message') }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-primary" name="submit" type="submit">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--============== Contact form End ==============-->
@endsection
