@if($faqSection && $faqSection->is_active && $faqSection->accordion_items && count($faqSection->accordion_items) > 0)
<div class="full-row" style="padding: 70px 0; background-color: #eef7fe;">
    <div class="container-fluid px-0">
        <div class="row">
            <div class="col-12 mb-5">
                @if($faqSection->title)
                <div class="container">
                    <h1 class="text-center text-secondary fw-bold mb-4" style="font-size: 2.5rem; font-family: serif;">{{ $faqSection->title }}</h1>
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="faq-container">
                    @foreach($faqSection->accordion_items as $index => $faq)
                    <div class="faq-item">
                        <div class="faq-question d-flex justify-content-between align-items-center p-4 cursor-pointer" 
                             data-faq-index="{{ $index }}"
                             style="cursor: pointer; background-color: #eef7fe; border-bottom: 1px solid #d0d0d0; transition: background-color 0.3s;">
                            <span class="faq-question-text text-secondary fw-normal" style="font-size: 1.1rem; flex: 1; text-align: left;">
                                {{ $faq['title'] ?? '' }}
                            </span>
                            <span class="faq-toggle-icon text-secondary ms-3" style="font-size: 1.5rem; font-weight: bold; flex-shrink: 0;">
                                <i class="fa fa-plus"></i>
                            </span>
                        </div>
                        <div class="faq-answer p-4" 
                             data-faq-answer="{{ $index }}"
                             style="display: none; border-bottom: 1px solid #d0d0d0; background-color: #eef7fe;">
                            <p class="text-secondary mb-0" style="line-height: 1.8;">
                                {!! nl2br(e($faq['content'] ?? '')) !!}
                            </p>
                        </div>
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
        background-color: #eef7fe !important;
    }
    
    .faq-item.active .faq-question {
        background-color: #eef7fe !important;
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

