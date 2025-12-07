<div class="full-row bg-light">
    <style>
        /* Reduce overlay-secondary opacity for better image visibility in blog cards */
        .thumb-blog-overlay .overlay-secondary::before {
            background-color: rgba(28, 46, 74, 0.3) !important; /* Reduced from 0.8 to 0.3 */
        }
        
        /* Fixed card height - ensures all cards have the same size */
        .thumb-blog-overlay {
            height: 500px; /* Fixed height for all cards */
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        /* Fixed image section height */
        .thumb-blog-overlay .post-image {
            height: 250px; /* Fixed height for image section */
            overflow: hidden;
            flex-shrink: 0;
        }
        
        /* Image styling - ensures images fill the space properly */
        .thumb-blog-overlay .post-image img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures image covers the entire area while maintaining aspect ratio */
            object-position: center;
        }
        
        /* Content section - takes remaining space */
        .thumb-blog-overlay .post-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        /* Title styling */
        .thumb-blog-overlay .post-content h5 {
            flex-shrink: 0;
            min-height: 60px; /* Minimum height for title area */
        }
        
        /* Paragraph styling - allows text overflow */
        .thumb-blog-overlay .post-content p {
            flex: 1;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3; /* Limit to 3 lines */
            -webkit-box-orient: vertical;
            text-overflow: ellipsis;
            word-break: break-word;
            padding-bottom: 10px;
            margin-bottom: 0;
            line-height: 1.6;
        }
        
        /* Meta section - fixed at bottom */
        .thumb-blog-overlay .post-meta {
            flex-shrink: 0;
            margin-top: auto;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="down-line w-50 w-sm-100 mx-auto text-center mb-5 fw-bold" style="font-size: 2.5rem;">Latest News & Insights</h1>
            </div>
        </div>
        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1">
            @if($latestBlogs->isNotEmpty())
                @foreach($latestBlogs as $blog)
                    <div class="col">
                        <div class="thumb-blog-overlay bg-white hover-text-PushUpBottom mb-4">
                            <div class="post-image position-relative overlay-secondary">
                              <a href="{{ route('blogs.show', $blog->id) }}">
                                <img src="{{ $blog->mainImage->media_link ?? asset('assets/images/default.png') }}" alt="Image not found!">
                              </a>
                            </div>
                            <div class="post-content p-35">
                                <h5 class="d-block font-400 mb-3">
                                    <a href="{{ route('blogs.show', $blog->id) }}" class="transation text-dark hover-text-primary">{{ $blog->title }}</a>
                                </h5>
                                <p>{{ Str::limit(html_entity_decode(strip_tags($blog->content)), 100, '...') }}</p>
                                <div class="post-meta text-uppercase">
                                    <a href="#"><span>{{ $blog->created_at->format('M d, Y') }}</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Default Static Content -->
                <div class="col">
                    <div class="thumb-blog-overlay bg-white hover-text-PushUpBottom mb-4">
                        <div class="post-image position-relative overlay-secondary">
                            <img src="{{ asset('assets/images/blog/1.png') }}" alt="Image not found!">
                        </div>
                        <div class="post-content p-35">
                            <h5 class="d-block font-400 mb-3"><a href="#" class="transation text-dark hover-text-primary">Our latest development projects by more efficie.</a></h5>
                            <p>Nostra maecenas malesuada vel lobortis sociis mus aliquam tempor etiam ipsum pretium cursus.</p>
                            <div class="post-meta text-uppercase">
                                <a href="#"><span>By Robert Haven</span></a>
                                <a href="#"><span>Dec 25, 2019</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="thumb-blog-overlay bg-white hover-text-PushUpBottom mb-4">
                        <div class="post-image position-relative overlay-secondary">
                            <img src="{{ asset('assets/images/blog/2.png') }}" alt="Image not found!">
                        </div>
                        <div class="post-content p-35">
                            <h5 class="d-block font-400 mb-3"><a href="#" class="transation text-dark hover-text-primary">Cultivating market leadership from the inside.</a></h5>
                            <p>Nostra maecenas malesuada vel lobortis sociis mus aliquam tempor etiam ipsum pretium cursus.</p>
                            <div class="post-meta text-uppercase">
                                <a href="#"><span>By Robert Haven</span></a>
                                <a href="#"><span>Dec 25, 2019</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="thumb-blog-overlay bg-white hover-text-PushUpBottom mb-4">
                        <div class="post-image position-relative overlay-secondary">
                            <img src="{{ asset('assets/images/blog/3.png') }}" alt="Image not found!">
                        </div>
                        <div class="post-content p-35">
                            <h5 class="d-block font-400 mb-3"><a href="#" class="transation text-dark hover-text-primary">We are the next generation of the advertising.</a></h5>
                            <p>Nostra maecenas malesuada vel lobortis sociis mus aliquam tempor etiam ipsum pretium cursus.</p>
                            <div class="post-meta text-uppercase">
                                <a href="#"><span>By Robert Haven</span></a>
                                <a href="#"><span>Dec 25, 2019</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
