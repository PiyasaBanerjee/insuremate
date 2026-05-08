@extends('layouts.app')

@push('styles')
    <style>
        .faq-page-wrapper {
            position: relative;
            padding-top: 100px;
            padding-bottom: 60px;
            background-color: #fcfcfd;
            overflow: hidden;
        }

        /* Soft Radial Background Glow */
        .faq-page-wrapper::before {
            content: '';
            position: absolute;
            top: -20%;
            left: 50%;
            transform: translateX(-50%);
            width: 800px;
            height: 600px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.08) 0%, rgba(99, 102, 241, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        .faq-content-z {
            position: relative;
            z-index: 2;
        }

        /* Header Styling */
        .help-center-badge {
            display: inline-block;
            background: rgba(99, 102, 241, 0.1);
            color: #4f46e5;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            margin-bottom: 1.25rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .faq-title {
            font-weight: 800;
            font-size: 2.75rem;
            letter-spacing: -1px;
            color: #0f172a;
            margin-bottom: 1rem;
        }

        .faq-title span {
            background: linear-gradient(135deg, #4f46e5, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .faq-subtitle {
            color: #64748b;
            font-size: 1.15rem;
            max-width: 600px;
            margin: 0 auto 2.5rem;
            line-height: 1.6;
        }

        .faq-divider {
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #6366f1, #a5b4fc);
            border-radius: 4px;
            margin: 0 auto 4rem;
        }

        /* Main Container */
        .faq-container {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Accordion Overrides & Custom Styles */
        .saas-accordion {
            background: #ffffff;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 40px -10px rgba(15, 23, 42, 0.08), 0 1px 3px rgba(15, 23, 42, 0.04);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .saas-accordion .accordion-item {
            border: none;
            background: transparent;
            margin-bottom: 1rem;
            border-radius: 12px !important;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .saas-accordion .accordion-item:last-child {
            margin-bottom: 0;
        }

        .saas-accordion .accordion-button {
            background: transparent;
            color: #334155;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 1.25rem 1.5rem;
            box-shadow: none !important;
            border: none;
            border-radius: 12px !important;
            transition: all 0.3s ease;
        }

        /* Override Default Bootstrap Arrow */
        .saas-accordion .accordion-button::after {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2364748b' class='bi bi-chevron-down' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .saas-accordion .accordion-button:not(.collapsed)::after {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%234f46e5' class='bi bi-chevron-down' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
            transform: rotate(-180deg);
        }

        .saas-accordion .accordion-button:hover {
            background: rgba(248, 250, 252, 0.8);
            color: #0f172a;
        }

        .saas-accordion .accordion-button:not(.collapsed) {
            background: rgba(99, 102, 241, 0.04);
            color: #4f46e5;
        }

        /* Active Item Left Accent */
        .saas-accordion .accordion-item:has(.accordion-button:not(.collapsed)) {
            box-shadow: inset 3px 0 0 0 #4f46e5;
            background: rgba(99, 102, 241, 0.02);
        }

        .saas-accordion .accordion-body {
            padding: 0 1.5rem 1.5rem 1.5rem;
            color: #475569;
            font-size: 1.05rem;
            line-height: 1.7;
        }

        /* CTA Section Upgrade */
        .faq-cta-box {
            margin-top: 4rem;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 16px;
            padding: 2.5rem;
            text-align: center;
            box-shadow: 0 4px 15px -5px rgba(15, 23, 42, 0.05);
            transition: transform 0.3s ease;
        }

        .faq-cta-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08);
        }

        .faq-cta-title {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
            font-size: 1.25rem;
        }

        .faq-cta-text {
            color: #64748b;
            margin-bottom: 1.5rem;
        }

        .btn-premium-cta {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border: none;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-premium-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -5px rgba(79, 70, 229, 0.4);
            color: white;
        }

        /* Trust Section Overhaul */
        .faq-trust-section {
            padding-top: 60px;
            padding-bottom: 80px;
            text-align: center;
            background: linear-gradient(180deg, #fcfcfd 0%, #f1f5f9 100%);
            border-top: 1px solid rgba(226, 232, 240, 0.8);
        }

        .faq-trust-heading {
            font-size: 1.1rem;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 1rem;
            letter-spacing: 0.5px;
        }

        .faq-trust-divider {
            width: 40px;
            height: 3px;
            background: rgba(99, 102, 241, 0.2);
            border-radius: 3px;
            margin: 0 auto 2.5rem;
        }

        .faq-trust-badges {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
            max-width: 800px;
            margin: 0 auto;
        }

        .faq-trust-badge {
            flex: 1;
            min-width: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            background: #ffffff;
            padding: 1.25rem 1.5rem;
            border-radius: 16px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 10px -5px rgba(15, 23, 42, 0.05);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .faq-trust-badge:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.15);
            border-color: rgba(99, 102, 241, 0.3);
        }

        .faq-trust-badge i {
            color: #6366f1;
            font-size: 1.35rem;
            background: rgba(99, 102, 241, 0.1);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }

        .faq-trust-badge span {
            font-size: 0.95rem;
            font-weight: 600;
            color: #334155;
            letter-spacing: 0.2px;
        }
    </style>
@endpush

@section('content')
    <div class="faq-page-wrapper">
        <div class="container faq-content-z">

            <!-- Header Section -->
            <div class="text-center">
                <span class="help-center-badge">Help Center</span>
                <h1 class="faq-title">Frequently Asked <span>Questions</span></h1>
                <p class="faq-subtitle">Find answers to common questions about our insurance plans, claim processes, and
                    billing structure.</p>
                <div class="faq-divider" style="margin-bottom: 0;"></div>
            </div>

            <!-- Main FAQ Container -->
            <div class="faq-container">
                <div class="accordion saas-accordion" id="faqAccordion">

                    <!-- FAQ Item 1 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                How do I purchase a policy?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can purchase a policy by browsing our <strong>Insurance Categories</strong>, selecting a
                                plan that suits your needs, and clicking "Apply Now" or "Buy Policy". Follow the simple
                                onboarding steps to complete your profile, and your policy will be instantly generated.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                How can I file a claim?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                To file a claim, log in to your dashboard and navigate to <strong>My Policies</strong>.
                                Click "View" on the relevant
                                policy, and then select the <strong>File a Claim</strong> button in the right sidebar. Our
                                system will guide you through uploading any necessary supporting documentation.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                What payment methods do you accept?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We currently accept all major credit and debit cards, secure online banking transfers, and
                                select mobile wallets. Our entire payment
                                gateway is 256-bit encrypted giving you enterprise-grade security.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Can I cancel my policy?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, you can cancel your policy within the <strong>15-day free-look period</strong>
                                for a full refund. After that benchmark, cancellation terms will reflect the specific plan's
                                policy document. Please
                                contact our support team for immediate assistance.
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Enhanced CTA Box -->
                <div class="faq-cta-box">
                    <h3 class="faq-cta-title">Still have questions?</h3>
                    <p class="faq-cta-text">Our dedicated support team is ready to help you navigate your options.</p>
                    <a href="{{ route('contact') }}" class="btn btn-premium-cta">
                        <i class="bi bi-chat-square-text"></i> Contact Support
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Trust Section (Moved Above Footer) -->
    <div class="faq-trust-section">
        <div class="container">
            <div class="faq-trust-badges">
                <div class="faq-trust-badge">
                    <i class="bi bi-shield-lock"></i>
                    <span>256-Bit Encrypted</span>
                </div>
                <div class="faq-trust-badge">
                    <i class="bi bi-check-circle"></i>
                    <span>IRDAI Approved</span>
                </div>
                <div class="faq-trust-badge">
                    <i class="bi bi-lightning-charge"></i>
                    <span>Instant Policy Issuance</span>
                </div>
            </div>
        </div>
    </div>
@endsection