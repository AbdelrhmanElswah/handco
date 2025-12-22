@if($faqSection && $faqSection->is_active && $faqSection->accordion_items && count($faqSection->accordion_items) > 0)
@php
    // Group FAQs by category
    $faqsByCategory = [];
    $allFaqs = [];
    
    foreach($faqSection->accordion_items as $index => $faq) {
        $category = $faq['category'] ?? 'General';
        if (!isset($faqsByCategory[$category])) {
            $faqsByCategory[$category] = [];
        }
        $faqsByCategory[$category][] = [
            'index' => $index,
            'title' => $faq['title'] ?? '',
            'content' => $faq['content'] ?? '',
        ];
        $allFaqs[] = [
            'index' => $index,
            'title' => $faq['title'] ?? '',
            'content' => $faq['content'] ?? '',
            'category' => $category,
        ];
    }
    
    // Default categories if none specified
    $categories = array_keys($faqsByCategory);
    if (empty($categories)) {
        $categories = ['General'];
        $faqsByCategory['General'] = $allFaqs;
    }
@endphp
<div class="full-row" style="padding: 70px 0; background-color: #f8f5f0;">
    <div class="container-fluid px-0">
        <div class="row">
            <div class="col-12 mb-5">
                @if($faqSection->title)
                <div class="container">
                    <h1 class="text-center fw-bold mb-4" style="font-size: 2.5rem; font-family: 'Calibri', sans-serif; color: #001f3f; border-bottom: 1px solid #d0d0d0; padding-bottom: 20px;">{{ $faqSection->title }}</h1>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Category Buttons -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="container">
                    <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">
                        <button class="faq-category-btn active" data-category="all" style="padding: 12px 24px; border: 2px solid #001f3f; background-color: #001f3f; color: white; border-radius: 5px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                            View All
                        </button>
                        @foreach($categories as $category)
                        <button class="faq-category-btn" data-category="{{ strtolower(str_replace(' ', '-', $category)) }}" style="padding: 12px 24px; border: 2px solid #001f3f; background-color: transparent; color: #001f3f; border-radius: 5px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                            {{ $category }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="faq-container">
                    <!-- All FAQs (View All) -->
                    <div class="faq-category-content" data-category-content="all">
                        @foreach($allFaqs as $faq)
                        <div class="faq-item" data-faq-category="{{ strtolower(str_replace(' ', '-', $faq['category'] ?? 'general')) }}">
                            <div class="faq-question d-flex justify-content-between align-items-center p-4 cursor-pointer" 
                                 data-faq-index="{{ $faq['index'] }}"
                                 style="cursor: pointer; background-color: #ffffff; border-bottom: 1px solid #d0d0d0; transition: background-color 0.3s;">
                                <span class="faq-question-text fw-normal" style="font-size: 16px; flex: 1; text-align: left; color: #001f3f; font-family: 'Calibri', sans-serif;">
                                    {{ $faq['title'] }}
                                </span>
                                <span class="faq-toggle-icon ms-3" style="font-size: 1.5rem; font-weight: bold; flex-shrink: 0; color: #001f3f;">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </div>
                            <div class="faq-answer p-4" 
                                 data-faq-answer="{{ $faq['index'] }}"
                                 style="display: none; border-bottom: 1px solid #d0d0d0; background-color: #ffffff;">
                                <p class="mb-0" style="line-height: 1.8; color: #808080; font-family: 'Calibri', sans-serif; font-size: 11.5px;">
                                    {!! nl2br(e($faq['content'])) !!}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Category-specific FAQs -->
                    @foreach($categories as $category)
                    <div class="faq-category-content" data-category-content="{{ strtolower(str_replace(' ', '-', $category)) }}" style="display: none;">
                        @foreach($faqsByCategory[$category] as $faq)
                        <div class="faq-item">
                            <div class="faq-question d-flex justify-content-between align-items-center p-4 cursor-pointer" 
                                 data-faq-index="{{ $faq['index'] }}"
                                 style="cursor: pointer; background-color: #ffffff; border-bottom: 1px solid #d0d0d0; transition: background-color 0.3s;">
                                <span class="faq-question-text fw-normal" style="font-size: 16px; flex: 1; text-align: left; color: #001f3f; font-family: 'Calibri', sans-serif;">
                                    {{ $faq['title'] }}
                                </span>
                                <span class="faq-toggle-icon ms-3" style="font-size: 1.5rem; font-weight: bold; flex-shrink: 0; color: #001f3f;">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </div>
                            <div class="faq-answer p-4" 
                                 data-faq-answer="{{ $faq['index'] }}"
                                 style="display: none; border-bottom: 1px solid #d0d0d0; background-color: #ffffff;">
                                <p class="mb-0" style="line-height: 1.8; color: #808080; font-family: 'Calibri', sans-serif; font-size: 11.5px;">
                                    {!! nl2br(e($faq['content'])) !!}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .faq-item {
        border: none;
        margin-bottom: 0;
    }
    
    .faq-item:first-child .faq-question {
        border-top: 1px solid #d0d0d0;
    }
    
    .faq-question:hover {
        background-color: #f8f5f0 !important;
    }
    
    .faq-item.active .faq-question {
        background-color: #f8f5f0 !important;
    }
    
    .faq-item.active .faq-toggle-icon i {
        transform: rotate(45deg);
        transition: transform 0.3s;
    }
    
    .faq-answer {
        animation: slideDown 0.3s ease-out;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            max-height: 0;
        }
        to {
            opacity: 1;
            max-height: 500px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle category button clicks
        const categoryButtons = document.querySelectorAll('.faq-category-btn');
        const categoryContents = document.querySelectorAll('.faq-category-content');
        
        categoryButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const selectedCategory = this.getAttribute('data-category');
                
                // Update button styles
                categoryButtons.forEach(function(btn) {
                    btn.classList.remove('active');
                    btn.style.backgroundColor = 'transparent';
                    btn.style.color = '#001f3f';
                });
                this.classList.add('active');
                this.style.backgroundColor = '#001f3f';
                this.style.color = 'white';
                
                // Show/hide category contents
                categoryContents.forEach(function(content) {
                    const contentCategory = content.getAttribute('data-category-content');
                    if (selectedCategory === 'all' || contentCategory === selectedCategory) {
                        content.style.display = 'block';
                    } else {
                        content.style.display = 'none';
                    }
                });
            });
        });
        
        // Handle FAQ question clicks
        const faqQuestions = document.querySelectorAll('.faq-question');
        
        faqQuestions.forEach(function(question) {
            question.addEventListener('click', function() {
                const faqItem = this.closest('.faq-item');
                const answer = faqItem.querySelector('.faq-answer');
                const icon = this.querySelector('.faq-toggle-icon i');
                
                // Toggle active class
                faqItem.classList.toggle('active');
                
                // Toggle answer visibility
                if (faqItem.classList.contains('active')) {
                    answer.style.display = 'block';
                    icon.classList.remove('fa-plus');
                    icon.classList.add('fa-times');
                } else {
                    answer.style.display = 'none';
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-plus');
                }
            });
        });
    });
</script>
@endif

