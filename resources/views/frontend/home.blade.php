@extends('layouts.app')

@section('content')
    <style>
        .hero-animated-bg {
            background: linear-gradient(-45deg, #667eea, #764ba2, #5a67d8, #4c51bf);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            position: relative;
            overflow: hidden;
            color: white;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .hero-blob {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            top: -200px;
            left: -100px;
            animation: floatBlob 20s infinite alternate cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
        }

        .hero-blob-2 {
            top: auto;
            bottom: -200px;
            left: auto;
            right: -100px;
            width: 500px;
            height: 500px;
            animation-delay: -10s;
            animation-duration: 25s;
        }

        @keyframes floatBlob {
            0% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(50px, 30px) scale(1.1);
            }

            100% {
                transform: translate(-30px, 50px) scale(0.9);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .delay-1 {
            animation-delay: 0.2s;
        }

        .delay-2 {
            animation-delay: 0.4s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="py-5 mb-5 hero-animated-bg">
        <div class="hero-blob"></div>
        <div class="hero-blob hero-blob-2"></div>
        <div class="container py-5 text-center position-relative z-1">
            <div class="row justify-content-center">
                <div class="col-lg-8 py-4">
                    <h1 class="display-3 fw-bold mb-4 fade-in-up" style="letter-spacing: -1px;">Secure Your Future with
                        Confidence</h1>
                    <p class="lead mb-5 fade-in-up delay-1" style="font-size: 1.25rem; font-weight: 300;">
                        Compare and buy the best insurance plans tailored for you and your family. Experience absolute peace
                        of mind with our premium coverage.
                    </p>
                    <div class="d-flex gap-3 justify-content-center fade-in-up delay-2">
                        <a href="#categories"
                            class="btn btn-light text-primary btn-lg px-5 py-3 fw-bold shadow-sm rounded-pill"
                            style="font-size: 1.1rem; color: #6366f1 !important; transition: all 0.3s ease;">Explore
                            Plans</a>
                        @if(Auth::guard('admin')->check())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill shadow-sm d-flex align-items-center gap-2"
                                style="font-size: 1rem; font-weight: 600; transition: all 0.3s ease; border: 2px solid rgba(255,255,255,0.7);">
                                <i class="bi bi-speedometer2"></i> Go to Admin Panel
                            </a>
                        @else
                            <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill shadow-sm"
                                style="font-size: 1.1rem; transition: all 0.3s ease;">Talk to Expert</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .categories-premium-section {
            background-color: #f8fafc;
            position: relative;
            overflow: hidden;
            padding-top: 5rem;
            padding-bottom: 5rem;
        }

        .categories-glow-bg {
            position: absolute;
            width: 80vw;
            height: 80vh;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.05) 0%, rgba(139, 92, 246, 0.03) 30%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            pointer-events: none;
            animation: slowPulse 15s ease-in-out infinite alternate;
        }

        @keyframes slowPulse {
            0% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 0.8;
            }

            100% {
                transform: translate(-45%, -55%) scale(1.1);
                opacity: 1;
            }
        }

        .premium-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.02);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            z-index: 2;
        }

        .premium-card::before {
            display: none;
        }

        .premium-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
            border-color: #cbd5e1;
        }

        .premium-icon-container {
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .premium-card:hover .premium-icon-container {
            transform: scale(1.08) translateY(-2px);
        }

        .premium-badge {
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 5px 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .premium-badge.glowing {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important;
            color: #065f46 !important;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .premium-badge.standard {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important;
            color: #475569 !important;
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .section-title-premium {
            font-size: 2.25rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }

        .section-subtitle-premium {
            font-size: 1.1rem;
            color: #64748b;
        }
    </style>

    <div class="categories-premium-section" id="categories">
        <div class="categories-glow-bg"></div>
        <div class="container position-relative z-1">
            <div class="text-center mb-5 pb-2">
                <h2 class="section-title-premium">Insurance Products</h2>
                <p class="section-subtitle-premium">Choose from a wide range of intuitive insurance categories.</p>
            </div>


            <div class="row pt-4">
                @php
                    $categoryData = [
                        'life-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3382/3382103.png', 'badge' => 'Save up to 15%', 'badge_bg' => '#d1fae5', 'badge_color' => '#065f46'],
                        'health-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/2966/2966327.png', 'badge' => 'Save up to 25%', 'badge_bg' => '#d1fae5', 'badge_color' => '#065f46'],
                        'car-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3202/3202926.png', 'badge' => 'Best Price Guaranteed', 'badge_bg' => '#d1fae5', 'badge_color' => '#065f46'],
                        'two-wheeler-insurance' => ['icon' => 'data:image/png;base64,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', 'badge' => 'Save up to 85%', 'badge_bg' => '#d1fae5', 'badge_color' => '#065f46'],
                        'travel-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/2060/2060284.png', 'badge' => 'Instant Policy Issuance'],
                        'investment-plans' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/2933/2933116.png', 'badge' => 'Life Cover Included'],
                        'family-health-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3135/3135810.png', 'badge' => 'Family Saver Plan'],
                        'term-life-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/1055/1055100.png', 'badge' => 'Low Premium Plans'],
                        'employee-group-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3135/3135694.png', 'badge' => 'Exclusive Corporate Rates'],
                        'home-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/619/619153.png', 'badge' => 'Comprehensive Coverage'],
                        'retirement-plans' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3050/3050474.png', 'badge' => 'Guaranteed Pension', 'badge_bg' => '#d1fae5', 'badge_color' => '#065f46'],
                        'guaranteed-return-plans' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/2933/2933100.png', 'badge' => 'Assured Returns', 'badge_bg' => '#d1fae5', 'badge_color' => '#065f46']
                    ];
                @endphp
                
                @php
                    $policyLibrary = [

    'life-insurance' => [
        ['name'=>'Smart Secure Life Plan','desc'=>'Long-term financial protection with bonus benefits.','benefit'=>'High sum assured with loyalty bonus','audience'=>'Working professionals aged 25-45','premium'=>'₹899/month'],
        ['name'=>'Wealth Plus Endowment','desc'=>'Combines savings and life cover for future milestones.','benefit'=>'Guaranteed maturity benefits','audience'=>'Families planning for children\'s education','premium'=>'₹1,200/month'],
        ['name'=>'Micro Bachat Protection','desc'=>'Affordable life cover designed for low-income brackets.','benefit'=>'Low premium with basic life cover','audience'=>'Rural or low-income populations','premium'=>'₹350/month'],
        ['name'=>'Golden Years Assure','desc'=>'Whole life policy offering coverage up to 99 years.','benefit'=>'Lifelong coverage with premium waiver','audience'=>'Middle-aged individuals planning a legacy','premium'=>'₹1,500/month'],
        ['name'=>'Flexi Protect Life Plan','desc'=>'Customizable payout options with increasing life cover.','benefit'=>'Step-up sums assured to combat inflation','audience'=>'Young earners expecting salary growth','premium'=>'₹950/month']
    ],
    'health-insurance' => [
        ['name'=>'Arogya Sanjeevani Standard','desc'=>'Standardized health coverage for basic medical needs.','benefit'=>'Covers room rent, ICU, and day care','audience'=>'General individuals & small families','premium'=>'₹450/month'],
        ['name'=>'Optima Secure Health','desc'=>'Comprehensive coverage with automatic restore benefits.','benefit'=>'2X coverage from day one','audience'=>'Professionals seeking high sum insured','premium'=>'₹850/month'],
        ['name'=>'Active Fit Health Plan','desc'=>'Rewards healthy lifestyle with premium discounts.','benefit'=>'Up to 30% discount for hitting fitness goals','audience'=>'Young fitness enthusiasts aged 20-35','premium'=>'₹600/month'],
        ['name'=>'Senior Citizen Red Carpet','desc'=>'Dedicated health plan for parents without pre-medical checks.','benefit'=>'Covers pre-existing diseases from year 1','audience'=>'Senior citizens above 60 years','premium'=>'₹1,800/month'],
        ['name'=>'Maternity Plus Shield','desc'=>'Health plan with robust maternity and newborn coverage.','benefit'=>'Covers delivery and vaccination expenses','audience'=>'Newlywed couples','premium'=>'₹1,100/month']
    ],
    'car-insurance' => [
        ['name'=>'Bumper-to-Bumper Care','desc'=>'Zero depreciation cover for maximum claim settlement.','benefit'=>'Covers plastic, glass, and fiber parts 100%','audience'=>'New car owners','premium'=>'₹1,200/month'],
        ['name'=>'Smart Drive Pay-As-You-Go','desc'=>'Usage-based premium for low-mileage drivers.','benefit'=>'Premium calculated based on km driven','audience'=>'Work-from-home professionals','premium'=>'₹500/month'],
        ['name'=>'Essential Third-Party Plus','desc'=>'Mandatory third-party cover with personal accident benefit.','benefit'=>'Meets legal requirements with owner protection','audience'=>'Budget-conscious drivers','premium'=>'₹300/month'],
        ['name'=>'Engine Protect Shield','desc'=>'Standalone add-on for engine and gearbox damage.','benefit'=>'Covers water ingression and oil leakage','audience'=>'Cars in flood-prone areas','premium'=>'₹800/month'],
        ['name'=>'Comprehensive Assure','desc'=>'Standard own-damage plus third-party with 24x7 roadside assist.','benefit'=>'Free towing and jump-start services','audience'=>'Everyday city commuters','premium'=>'₹950/month']
    ],
    'term-life-insurance' => [
        ['name'=>'Click-to-Protect Elite','desc'=>'Pure term plan with high sum assured for minimal premium.','benefit'=>'₹1 Crore cover at low rates','audience'=>'Primary family breadwinners','premium'=>'₹650/month'],
        ['name'=>'Income Return Term Plan','desc'=>'Term cover providing monthly income payouts to dependents.','benefit'=>'Replaces monthly salary upon demise','audience'=>'Families with single earners','premium'=>'₹800/month'],
        ['name'=>'Premium Return Shield','desc'=>'Term plan with return of premium upon maturity.','benefit'=>'Get 100% premiums back if you survive the term','audience'=>'Risk-averse individuals','premium'=>'₹1,050/month'],
        ['name'=>'Insta-Cover Term','desc'=>'Instant term policy with no medical tests for moderate covers.','benefit'=>'Quick 5-minute issuance','audience'=>'Busy working professionals','premium'=>'₹550/month'],
        ['name'=>'Joint Life Term Shield','desc'=>'Single term policy covering both husband and wife.','benefit'=>'20% discount on joint premium','audience'=>'Married couples','premium'=>'₹1,100/month']
    ],
    'investment-plans' => [
        ['name'=>'Wealth Builder ULIP','desc'=>'Market-linked plan for aggressive wealth creation.','benefit'=>'Choice of equity and debt funds','audience'=>'Risk-tolerant investors','premium'=>'₹2,000/month'],
        ['name'=>'Guaranteed Savings Plan','desc'=>'Safe investment with assured returns and life cover.','benefit'=>'Guaranteed maturity payouts','audience'=>'Conservative investors','premium'=>'₹1,500/month'],
        ['name'=>'Child Future Assure','desc'=>'Investment plan dedicated to funding higher education.','benefit'=>'Premium waiver upon parent\'s demise','audience'=>'Parents with young children','premium'=>'₹1,800/month'],
        ['name'=>'Tax Saver Plus','desc'=>'ELSS alternative offering section 80C tax benefits.','benefit'=>'Dual benefit of saving tax and growing wealth','audience'=>'Salaried taxpayers','premium'=>'₹1,250/month'],
        ['name'=>'Capital Guarantee Shield','desc'=>'Invest in markets safely with capital protection.','benefit'=>'Zero downside risk on principal','audience'=>'First-time market investors','premium'=>'₹2,500/month']
    ],
    'two-wheeler-insurance' => [
        ['name'=>'Rider Protect Comp','desc'=>'Comprehensive policy covering own damage and third-party.','benefit'=>'Includes helmet and accessory cover','audience'=>'Daily scooter/bike commuters','premium'=>'₹150/month'],
        ['name'=>'Third-Party Basic','desc'=>'Legally compliant cover for third-party liabilities only.','benefit'=>'Cheapest mandatory policy','audience'=>'Old two-wheeler owners','premium'=>'₹60/month'],
        ['name'=>'Zero-Dep Bike Shield','desc'=>'Complete bumper-to-bumper protection for bikes.','benefit'=>'Full reimbursement without depreciation','audience'=>'New bike owners','premium'=>'₹250/month'],
        ['name'=>'Long-Term Multi-Year','desc'=>'Renew once every 3 or 5 years to lock in premiums.','benefit'=>'Protection from yearly tariff hikes','audience'=>'Hassle-free vehicle owners','premium'=>'₹120/month'],
        ['name'=>'EV Shield Scooter','desc'=>'Tailored insurance covering battery packs and chargers for EVs.','benefit'=>'Specialized EV breakdown assistance','audience'=>'Electric scooter buyers','premium'=>'₹180/month']
    ],
    'family-health-insurance' => [
        ['name'=>'Family Floater Supreme','desc'=>'Single policy covering up to 6 family members.','benefit'=>'Shared sum insured with no individual limits','audience'=>'Nuclear families','premium'=>'₹1,100/month'],
        ['name'=>'Global Family Care','desc'=>'Health cover valid both in India and abroad.','benefit'=>'Cashless treatment at international hospitals','audience'=>'Families traveling frequently','premium'=>'₹2,200/month'],
        ['name'=>'Health Plus Super Top-up','desc'=>'Affordable top-up to upgrade existing family cover.','benefit'=>'Extends coverage after deductible is exhausted','audience'=>'Families with corporate covers','premium'=>'₹450/month'],
        ['name'=>'OPD Care Family','desc'=>'Covers doctor consultations, pharmacy, and diagnostics.','benefit'=>'Eliminates out-of-pocket minor medical expenses','audience'=>'Families with toddlers or elderly','premium'=>'₹950/month'],
        ['name'=>'Critical Illness Family Guard','desc'=>'Lump-sum payout upon diagnosis of 36 critical illnesses.','benefit'=>'Immediate cash flow for major treatments','audience'=>'Families with medical history','premium'=>'₹700/month']
    ],
    'travel-insurance' => [
        ['name'=>'Global Explorer Plan','desc'=>'Complete international travel protection for medical and delays.','benefit'=>'Covers flight cancellations and lost baggage','audience'=>'International tourists','premium'=>'₹500/trip'],
        ['name'=>'Domestic Travel Shield','desc'=>'Affordable cover for domestic flights and train journeys.','benefit'=>'Covers medical emergencies within India','audience'=>'Domestic vacationers','premium'=>'₹100/trip'],
        ['name'=>'Student Secure Travel','desc'=>'Tailored for students studying abroad.','benefit'=>'Covers tuition fees interruption and sponsor protection','audience'=>'International students','premium'=>'₹800/month'],
        ['name'=>'Multi-Trip Annual Pass','desc'=>'One policy for unlimited trips throughout the year.','benefit'=>'Avoid buying separate policies per trip','audience'=>'Frequent business travelers','premium'=>'₹1,200/year'],
        ['name'=>'Schengen Visa Approved','desc'=>'Meets standard requirements for Schengen visa applications.','benefit'=>'Minimum €30,000 medical coverage','audience'=>'Europe travelers','premium'=>'₹650/trip']
    ],
    'employee-group-insurance' => [
        ['name'=>'CorpHealth Standard','desc'=>'Group medical cover for MSME employees.','benefit'=>'Cashless hospitalization in network hospitals','audience'=>'Startups and MSMEs','premium'=>'₹300/employee'],
        ['name'=>'Group Term Life Protect','desc'=>'Flat term life cover provided to all employees.','benefit'=>'Financial security for employee families','audience'=>'IT and Corporate firms','premium'=>'₹150/employee'],
        ['name'=>'Group Accident Shield','desc'=>'Coverage against workplace and off-duty accidents.','benefit'=>'Compensation for disability or death','audience'=>'Manufacturing & construction workers','premium'=>'₹100/employee'],
        ['name'=>'Premium Flexi-Benefit Plan','desc'=>'Allows employees to customize their group health benefits.','benefit'=>'Top-up options for parents and maternity','audience'=>'Large modern enterprises','premium'=>'₹500/employee'],
        ['name'=>'Gratuity Funding Plan','desc'=>'Helps employers meet their statutory gratuity obligations.','benefit'=>'Seamless fund management and tax benefits','audience'=>'Established companies','premium'=>'₹1000/employee']
    ],
    'home-insurance' => [
        ['name'=>'Bharat Griha Raksha','desc'=>'Standardized home structure and contents cover.','benefit'=>'Protection against fire, theft, and natural disasters','audience'=>'Homeowners and tenants','premium'=>'₹250/month'],
        ['name'=>'Tenant Protection Shield','desc'=>'Covers only household belongings and electronics.','benefit'=>'Protection from burglary and accidental damage','audience'=>'People living in rented apartments','premium'=>'₹150/month'],
        ['name'=>'Premium Villa Protect','desc'=>'High-value coverage for luxury properties and jewelry.','benefit'=>'Covers precious items and alternate accommodation','audience'=>'Owners of luxury homes/villas','premium'=>'₹850/month'],
        ['name'=>'Home Appliance Care','desc'=>'Specific coverage for breakdown of costly electronics.','benefit'=>'Replaces ACs, TVs, and fridges in case of voltage spikes','audience'=>'Tech-heavy households','premium'=>'₹200/month'],
        ['name'=>'Rent Loss Cover','desc'=>'Compensates landlords if the property becomes uninhabitable.','benefit'=>'Covers lost rental income up to 6 months','audience'=>'Property investors / Landlords','premium'=>'₹300/month']
    ],
    'retirement-plans' => [
        ['name'=>'Jeevan Shanti Pension','desc'=>'Immediate annuity plan for instant retirement income.','benefit'=>'Start receiving pension from next month','audience'=>'Individuals retiring right now','premium'=>'₹5,000/month'],
        ['name'=>'Deferred Wealth Builder','desc'=>'Accumulate a corpus now, receive pension later.','benefit'=>'Tax-free maturity and market-linked growth','audience'=>'Professionals in their 30s','premium'=>'₹2,000/month'],
        ['name'=>'Golden Age Assure','desc'=>'Traditional retirement plan with guaranteed additions.','benefit'=>'Capital protection with steady bonuses','audience'=>'Risk-averse pre-retirees','premium'=>'₹3,000/month'],
        ['name'=>'Joint Pension Plus','desc'=>'Annuity covering both spouses with return of purchase price.','benefit'=>'Pension continues for the surviving spouse','audience'=>'Married couples nearing retirement','premium'=>'₹4,000/month'],
        ['name'=>'NPS Tier-I Advantage','desc'=>'Market-linked government scheme for retirement.','benefit'=>'Exclusive ₹50,000 extra tax benefit under 80CCD','audience'=>'Salaried employees','premium'=>'₹1,000/month']
    ],
    'guaranteed-return-plans' => [
        ['name'=>'Assured Income Plan','desc'=>'Provides fixed monthly income for 10 years post-maturity.','benefit'=>'Tax-free predictable cash flows','audience'=>'Sole breadwinners planning for future','premium'=>'₹1,500/month'],
        ['name'=>'Wealth Guarantee 10x','desc'=>'Pay for 5 years, get 10 times the premium guaranteed.','benefit'=>'100% principal protection with high returns','audience'=>'Medium-term investors','premium'=>'₹2,500/month'],
        ['name'=>'Milestone Magic Plan','desc'=>'Pumps out lump-sum amounts at critical life stages.','benefit'=>'Guaranteed payouts at years 5, 10, and 15','audience'=>'Parents planning for education/marriage','premium'=>'₹2,000/month'],
        ['name'=>'FD Beater Plus','desc'=>'Offers guaranteed returns higher than bank FDs.','benefit'=>'Assured interest rate locked for 20 years','audience'=>'Conservative savers','premium'=>'₹1,000/month'],
        ['name'=>'Secure Future Plus','desc'=>'Combines life insurance with a guaranteed lump sum payout.','benefit'=>'Get maturity amount even if premiums stop due to death','audience'=>'Safety-focused individuals','premium'=>'₹1,200/month']
    ]

                    ];
                @endphp

                @foreach($categories as $category)
                    @php
                        $catSettings = $categoryData[$category->slug] ?? [
                            'icon' => 'https://cdn-icons-png.flaticon.com/512/3373/3373151.png',
                            'color' => 'primary',
                            'badge' => 'Best Seller'
                        ];
                    @endphp
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4 mt-2">
                        <div class="card h-100 premium-card text-center text-decoration-none">

                            <!-- Premium Glass Badge -->
                            <div class="position-absolute w-100 text-center" style="top: -12px; z-index: 10;">
                                @php
                                    $isDiscount = str_contains(strtolower($catSettings['badge']), 'save') || str_contains(strtolower($catSettings['badge']), 'guarantee') || str_contains(strtolower($catSettings['badge']), 'return');
                                    $badgeClass = $isDiscount ? 'premium-badge glowing rounded-pill' : 'premium-badge standard rounded-pill';
                                @endphp
                                <span class="{{ $badgeClass }}">{{ $catSettings['badge'] }}</span>
                            </div>

                            <div class="card-body p-4 pt-4 d-flex flex-column align-items-center justify-content-center">
                                <div class="mb-4 mt-2 premium-icon-container">
                                    <img src="{{ $catSettings['icon'] }}" alt="{{ $category->name }}"
                                        style="height: 60px; object-fit: contain; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.05));">
                                </div>
                                <h6 class="card-title fw-bold mb-1"
                                    style="color: #1e293b; font-size: 1.05rem; letter-spacing: -0.2px;">{{ $category->name }}
                                </h6>
                                
                                <a href="{{ route('frontend.category', $category->slug) }}" class="btn btn-sm btn-saas-outline mt-3 rounded-pill fw-bold px-4 stretched-link" style="position:relative; z-index:2; border: 1.5px solid #6366f1;">
                                    View 5 Plans
                                </a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <style>
            .trust-premium-section {
                background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
                position: relative;
                overflow: hidden;
                padding-top: 6rem;
                padding-bottom: 6rem;
            }

            .trust-glow-bg {
                position: absolute;
                width: 100vw;
                height: 100%;
                background: radial-gradient(ellipse at center, rgba(139, 92, 246, 0.08) 0%, transparent 70%);
                top: 0;
                left: 0;
                pointer-events: none;
                animation: trustPulse 10s ease-in-out infinite alternate;
            }

            @keyframes trustPulse {
                0% {
                    opacity: 0.6;
                    transform: scale(0.95);
                }

                100% {
                    opacity: 1;
                    transform: scale(1.05);
                }
            }

            .trust-card {
                background: #ffffff;
                border: 1px solid rgba(226, 232, 240, 0.8);
                border-radius: 16px;
                padding: 2.5rem 1.5rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
                position: relative;
                z-index: 2;
                height: 100%;
            }

            .trust-card::before {
                display: none;
            }

            .trust-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
                border-color: #cbd5e1;
            }

            .trust-card:hover::before {
                display: none;
            }

            .trust-icon {
                font-size: 2.5rem;
                background: linear-gradient(135deg, #667eea, #764ba2);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                margin-bottom: 1rem;
                display: inline-block;
                transition: transform 0.4s ease;
            }

            .trust-card:hover .trust-icon {
                transform: scale(1.1);
            }

            .trust-number {
                font-size: 3.5rem;
                font-weight: 800;
                letter-spacing: -1px;
                color: #0f172a;
                line-height: 1.1;
                margin-bottom: 0.5rem;
            }

            .trust-label {
                font-size: 1.05rem;
                font-weight: 500;
                color: #64748b;
            }

            .trust-micro-label {
                display: inline-block;
                padding: 6px 16px;
                background: rgba(99, 102, 241, 0.08);
                color: #4f46e5;
                border-radius: 100px;
                font-size: 0.85rem;
                font-weight: 700;
                letter-spacing: 1px;
                text-transform: uppercase;
                margin-bottom: 1.5rem;
            }

            .section-divider-glow {
                width: 100%;
                height: 1px;
                background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.3), transparent);
                box-shadow: 0 0 20px rgba(99, 102, 241, 0.2);
                margin-bottom: 0;
            }

            .fade-in-up-trust {
                opacity: 0;
                transform: translateY(20px);
                transition: opacity 0.8s ease-out, transform 0.8s ease-out;
            }

            .fade-in-up-trust.visible {
                opacity: 1;
                transform: translateY(0);
            }
        </style>

        
    
        <style>
            .hover-elevate { border-color: rgba(226,232,240,0.8); background: #ffffff; }
            .hover-elevate:hover { 
                transform: translateY(-4px); 
                box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05), 0 8px 10px -6px rgba(0,0,0,0.01); 
                border-color: #cbd5e1; 
                background: linear-gradient(to bottom right, #ffffff, #f8fafc);
            }
            .text-indigo { color: #4f46e5; }
            .border-end-md { border-right: 1px solid rgba(226,232,240,0.8); }
            @media (max-width: 767.98px) {
                .border-end-md { border-right: none; border-bottom: 1px solid rgba(226,232,240,0.8); padding-bottom: 1rem; }
            }
        </style>

    <!-- Premium Modals for Category Policies -->
    @foreach($categories as $category)
    @php 
        $catSettings = $categoryData[$category->slug] ?? ['icon' => 'https://cdn-icons-png.flaticon.com/512/3373/3373151.png']; 
        $policies = $policyLibrary[$category->slug] ?? [];
    @endphp
    <div class="modal fade" id="modal-{{ $category->slug }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
                <div class="modal-header border-0 px-4 py-3" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
                    <div class="d-flex align-items-center">
                        <div class="p-2 bg-white rounded-circle shadow-sm me-3">
                            <img src="{{ $catSettings['icon'] }}" height="32" alt="">
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-dark mb-0">{{ $category->name }} Plans</h5>
                            <small class="text-muted">Top 5 hand-picked, market-ready policies</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white" style="max-height: 65vh; overflow-y: auto;">
                    <div class="d-flex flex-column gap-3">
                        @foreach($policies as $policy)
                            <div class="policy-modal-card p-3 border rounded-4 hover-elevate transition-all" style="transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
                                <div class="row align-items-center">
                                    <div class="col-md-7 border-end-md pe-md-4">
                                        <div class="d-flex justify-content-between align-items-middle mb-1">
                                            <h5 class="fw-bold mb-1" style="color: #4f46e5;">{{ $policy['name'] }}</h5>
                                            <span class="badge d-md-none bg-light text-dark border">{{ $policy['premium'] }}</span>
                                        </div>
                                        <p class="text-secondary small mb-3">{{ $policy['desc'] }}</p>
                                        <div class="d-flex flex-wrap align-items-center gap-2">
                                            <span class="badge bg-light text-secondary border px-2 py-1 fw-medium"><i class="bi bi-person me-1"></i>{{ $policy['audience'] }}</span>
                                            <span class="text-success small fw-bold"><i class="bi bi-shield-check me-1"></i>{{ $policy['benefit'] }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-5 mt-3 mt-md-0 ps-md-4 d-flex flex-column justify-content-center">
                                        <div class="mb-3 d-none d-md-block">
                                            <span class="text-muted small d-block mb-1">Starting Premium</span>
                                            <span class="fs-4 fw-black text-dark" style="letter-spacing: -0.5px; font-weight: 800;">{{ $policy['premium'] }}</span>
                                        </div>
                                        <div class="d-flex gap-2 w-100">
                                            <button class="btn btn-outline-primary fw-medium rounded-pill flex-fill" data-bs-dismiss="modal" onclick="window.location='{{ route('frontend.category', $category->slug) }}'">Details</button>
                                            <button class="btn btn-saas-primary fw-medium rounded-pill flex-fill" data-bs-dismiss="modal" onclick="window.location='{{ route('frontend.category', $category->slug) }}'">Buy Now</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 justify-content-between px-4 py-3">
                    <span class="text-muted small"><i class="bi bi-info-circle me-1"></i>Prices are indicative for demo purposes</span>
                    <a href="{{ route('frontend.category', $category->slug) }}" class="btn btn-link text-decoration-none fw-bold text-indigo">Explore All {{ $category->name }} <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    @endforeach

        <div class="section-divider-glow"></div>
        <div class="trust-premium-section" id="trust-metrics">
            <div class="trust-glow-bg"></div>
            <div class="container position-relative z-1">
                <div class="text-center mb-5 pb-3">
                    <span class="trust-micro-label">Trusted by Millions Across India</span>
                </div>

                <div class="row text-center g-4">
                    <div class="col-md-4">
                        <div class="trust-card fade-in-up-trust">
                            <i class="bi bi-people trust-icon"></i>
                            <h3 class="trust-number"><span class="counter" data-target="10">0</span>M+</h3>
                            <p class="trust-label">Happy Customers</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="trust-card fade-in-up-trust" style="transition-delay: 0.2s;">
                            <i class="bi bi-building trust-icon"></i>
                            <h3 class="trust-number"><span class="counter" data-target="50">0</span>+</h3>
                            <p class="trust-label">Top Insurers</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="trust-card fade-in-up-trust" style="transition-delay: 0.4s;">
                            <i class="bi bi-headset trust-icon"></i>
                            <h3 class="trust-number"><span class="counter" data-target="24">0</span>/7</h3>
                            <p class="trust-label">Expert Support</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const counters = document.querySelectorAll('.counter');
                const speed = 200; // The lower the slower

                const animateCounters = () => {
                    counters.forEach(counter => {
                        const updateCount = () => {
                            const target = +counter.getAttribute('data-target');
                            const count = +counter.innerText;
                            const inc = target / speed;

                            if (count < target) {
                                counter.innerText = Math.ceil(count + inc);
                                setTimeout(updateCount, 15);
                            } else {
                                counter.innerText = target;
                            }
                        };
                        updateCount();
                    });
                };

                // Intersection Observer for triggering animation
                const observerOptions = {
                    root: null,
                    rootMargin: '0px',
                    threshold: 0.3
                };

                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            animateCounters();
                            // Trigger fade in
                            document.querySelectorAll('.fade-in-up-trust').forEach(el => el.classList.add('visible'));
                            observer.unobserve(entry.target);
                        }
                    });
                }, observerOptions);

                const trustSection = document.getElementById('trust-metrics');
                if (trustSection) observer.observe(trustSection);
            });
        </script>
@endsection

    @push('styles')
        <style>
            .hover-shadow:hover {
                transform: translateY(-5px);
                box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
                transition: all 0.3s ease;
            }
        </style>
    @endpush