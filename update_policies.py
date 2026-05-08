import re
import os

blade_path = r"c:\xampp\htdocs\laravel_10\Insurance Management\resources\views\frontend\home.blade.php"

with open(blade_path, 'r', encoding='utf-8') as f:
    content = f.read()

# Define policies
policies_data = """
    'life-insurance' => [
        ['name'=>'Smart Secure Life Plan','desc'=>'Long-term financial protection with bonus benefits.','benefit'=>'High sum assured with loyalty bonus','audience'=>'Working professionals aged 25-45','premium'=>'₹899/month'],
        ['name'=>'Wealth Plus Endowment','desc'=>'Combines savings and life cover for future milestones.','benefit'=>'Guaranteed maturity benefits','audience'=>'Families planning for children\\'s education','premium'=>'₹1,200/month'],
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
        ['name'=>'Child Future Assure','desc'=>'Investment plan dedicated to funding higher education.','benefit'=>'Premium waiver upon parent\\'s demise','audience'=>'Parents with young children','premium'=>'₹1,800/month'],
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
"""

# We'll inject this string after the first `<?php` or `@php` block that declares `$categoryData`.
# Currently `$categoryData = [ ... ];` is from lines 221 to 234.
# We will just parse the file and inject `$policyLibrary = [ ... ];` and use it inside the loop.

injection_php = f"""
                @php
                    $policyLibrary = [
{policies_data}
                    ];
                @endphp
"""

# Let's replace the foreach loop content directly to add the button.
# Replace `<a href="{{ route('frontend.category', $category->slug) }}" class="stretched-link"></a>`
# with `<a href="#" class="btn btn-sm btn-outline-primary mt-2 stretched-link w-100 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modal-{{ $category->slug }}" style="position:relative; z-index:2;">View 5 Top Plans</a>`

# Wait, `stretched-link` makes the whole card clickable. If we want the modal to open when the card is clicked, we can put data-bs-target on it!
# Wait, currently clicking the card goes to the category page. The user asked "Display these 5 policies inside each insurance card on click or hover".
# Let's change the card link to open the modal instead. 

card_old = """<a href="{{ route('frontend.category', $category->slug) }}" class="stretched-link"></a>"""
card_new = """
                                <a href="javascript:void(0)" 
                                   class="stretched-link" 
                                   data-bs-toggle="modal" 
                                   data-bs-target="#modal-{{ $category->slug }}">
                                </a>
                                <button class="btn btn-sm btn-saas-outline mt-3 rounded-pill fw-bold px-4" style="position:relative; z-index:2; border: 1.5px solid #6366f1;">
                                    View 5 Plans
                                </button>
"""

content = content.replace(card_old, card_new)

# Now, add $policyLibrary right before @foreach($categories as $category)
content = content.replace("@foreach($categories as $category)", injection_php + "\n                @foreach($categories as $category)")

# Now, append the Modal HTML right at the end of the `categories-premium-section` div
modal_html = """
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
"""

# We'll inject Modal HTML before: `<div class="section-divider-glow"></div>`
content = content.replace('<div class="section-divider-glow"></div>', modal_html + '\n        <div class="section-divider-glow"></div>')

# Also inject custom CSS
custom_css = """
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
"""
content = content.replace('<!-- Premium Modals for Category Policies -->', custom_css + '\n    <!-- Premium Modals for Category Policies -->')

with open(blade_path, 'w', encoding='utf-8') as f:
    f.write(content)

print("Blade file updated with Python script!")
