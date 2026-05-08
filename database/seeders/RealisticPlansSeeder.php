<?php

namespace Database\Seeders;

use App\Models\InsuranceCategory;
use App\Models\InsurancePlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RealisticPlansSeeder extends Seeder
{
    public function run(): void
    {
        $categoriesData = [
            'life-insurance' => [
                ['name' => 'Smart Secure Life Plan', 'desc' => 'Long-term financial protection with bonus benefits.', 'benefit' => 'High sum assured with loyalty bonus', 'audience' => 'Working professionals aged 25-45', 'premium' => '899'],
                ['name' => 'Wealth Plus Endowment', 'desc' => 'Combines savings and life cover for future milestones.', 'benefit' => 'Guaranteed maturity benefits', 'audience' => 'Families planning for children\'s education', 'premium' => '1200'],
                ['name' => 'Micro Bachat Protection', 'desc' => 'Affordable life cover designed for low-income brackets.', 'benefit' => 'Low premium with basic life cover', 'audience' => 'Rural or low-income populations', 'premium' => '350'],
                ['name' => 'Golden Years Assure', 'desc' => 'Whole life policy offering coverage up to 99 years.', 'benefit' => 'Lifelong coverage with premium waiver', 'audience' => 'Middle-aged individuals planning a legacy', 'premium' => '1500'],
                ['name' => 'Flexi Protect Life Plan', 'desc' => 'Customizable payout options with increasing life cover.', 'benefit' => 'Step-up sums assured to combat inflation', 'audience' => 'Young earners expecting salary growth', 'premium' => '950']
            ],
            'health-insurance' => [
                ['name' => 'Arogya Sanjeevani Standard', 'desc' => 'Standardized health coverage for basic medical needs.', 'benefit' => 'Covers room rent, ICU, and day care', 'audience' => 'General individuals & small families', 'premium' => '450'],
                ['name' => 'Optima Secure Health', 'desc' => 'Comprehensive coverage with automatic restore benefits.', 'benefit' => '2X coverage from day one', 'audience' => 'Professionals seeking high sum insured', 'premium' => '850'],
                ['name' => 'Active Fit Health Plan', 'desc' => 'Rewards healthy lifestyle with premium discounts.', 'benefit' => 'Up to 30% discount for hitting fitness goals', 'audience' => 'Young fitness enthusiasts aged 20-35', 'premium' => '600'],
                ['name' => 'Senior Citizen Red Carpet', 'desc' => 'Dedicated health plan for parents without pre-medical checks.', 'benefit' => 'Covers pre-existing diseases from year 1', 'audience' => 'Senior citizens above 60 years', 'premium' => '1800'],
                ['name' => 'Maternity Plus Shield', 'desc' => 'Health plan with robust maternity and newborn coverage.', 'benefit' => 'Covers delivery and vaccination expenses', 'audience' => 'Newlywed couples', 'premium' => '1100']
            ],
            'car-insurance' => [
                ['name' => 'Bumper-to-Bumper Care', 'desc' => 'Zero depreciation cover for maximum claim settlement.', 'benefit' => 'Covers plastic, glass, and fiber parts 100%', 'audience' => 'New car owners', 'premium' => '1200'],
                ['name' => 'Smart Drive Pay-As-You-Go', 'desc' => 'Usage-based premium for low-mileage drivers.', 'benefit' => 'Premium calculated based on km driven', 'audience' => 'Work-from-home professionals', 'premium' => '500'],
                ['name' => 'Essential Third-Party Plus', 'desc' => 'Mandatory third-party cover with personal accident benefit.', 'benefit' => 'Meets legal requirements with owner protection', 'audience' => 'Budget-conscious drivers', 'premium' => '300'],
                ['name' => 'Engine Protect Shield', 'desc' => 'Standalone add-on for engine and gearbox damage.', 'benefit' => 'Covers water ingression and oil leakage', 'audience' => 'Cars in flood-prone areas', 'premium' => '800'],
                ['name' => 'Comprehensive Assure', 'desc' => 'Standard own-damage plus third-party with 24x7 roadside assist.', 'benefit' => 'Free towing and jump-start services', 'audience' => 'Everyday city commuters', 'premium' => '950']
            ],
            'term-life-insurance' => [
                ['name' => 'Click-to-Protect Elite', 'desc' => 'Pure term plan with high sum assured for minimal premium.', 'benefit' => '₹1 Crore cover at low rates', 'audience' => 'Primary family breadwinners', 'premium' => '650'],
                ['name' => 'Income Return Term Plan', 'desc' => 'Term cover providing monthly income payouts to dependents.', 'benefit' => 'Replaces monthly salary upon demise', 'audience' => 'Families with single earners', 'premium' => '800'],
                ['name' => 'Premium Return Shield', 'desc' => 'Term plan with return of premium upon maturity.', 'benefit' => 'Get 100% premiums back if you survive the term', 'audience' => 'Risk-averse individuals', 'premium' => '1050'],
                ['name' => 'Insta-Cover Term', 'desc' => 'Instant term policy with no medical tests for moderate covers.', 'benefit' => 'Quick 5-minute issuance', 'audience' => 'Busy working professionals', 'premium' => '550'],
                ['name' => 'Joint Life Term Shield', 'desc' => 'Single term policy covering both husband and wife.', 'benefit' => '20% discount on joint premium', 'audience' => 'Married couples', 'premium' => '1100']
            ],
            'investment-plans' => [
                ['name' => 'Wealth Builder ULIP', 'desc' => 'Market-linked plan for aggressive wealth creation.', 'benefit' => 'Choice of equity and debt funds', 'audience' => 'Risk-tolerant investors', 'premium' => '2000'],
                ['name' => 'Guaranteed Savings Plan', 'desc' => 'Safe investment with assured returns and life cover.', 'benefit' => 'Guaranteed maturity payouts', 'audience' => 'Conservative investors', 'premium' => '1500'],
                ['name' => 'Child Future Assure', 'desc' => 'Investment plan dedicated to funding higher education.', 'benefit' => 'Premium waiver upon parent\'s demise', 'audience' => 'Parents with young children', 'premium' => '1800'],
                ['name' => 'Tax Saver Plus', 'desc' => 'ELSS alternative offering section 80C tax benefits.', 'benefit' => 'Dual benefit of saving tax and growing wealth', 'audience' => 'Salaried taxpayers', 'premium' => '1250'],
                ['name' => 'Capital Guarantee Shield', 'desc' => 'Invest in markets safely with capital protection.', 'benefit' => 'Zero downside risk on principal', 'audience' => 'First-time market investors', 'premium' => '2500']
            ],
            'two-wheeler-insurance' => [
                ['name' => 'Rider Protect Comp', 'desc' => 'Comprehensive policy covering own damage and third-party.', 'benefit' => 'Includes helmet and accessory cover', 'audience' => 'Daily scooter/bike commuters', 'premium' => '150'],
                ['name' => 'Third-Party Basic', 'desc' => 'Legally compliant cover for third-party liabilities only.', 'benefit' => 'Cheapest mandatory policy', 'audience' => 'Old two-wheeler owners', 'premium' => '60'],
                ['name' => 'Zero-Dep Bike Shield', 'desc' => 'Complete bumper-to-bumper protection for bikes.', 'benefit' => 'Full reimbursement without depreciation', 'audience' => 'New bike owners', 'premium' => '250'],
                ['name' => 'Long-Term Multi-Year', 'desc' => 'Renew once every 3 or 5 years to lock in premiums.', 'benefit' => 'Protection from yearly tariff hikes', 'audience' => 'Hassle-free vehicle owners', 'premium' => '120'],
                ['name' => 'EV Shield Scooter', 'desc' => 'Tailored insurance covering battery packs and chargers for EVs.', 'benefit' => 'Specialized EV breakdown assistance', 'audience' => 'Electric scooter buyers', 'premium' => '180']
            ],
            'family-health-insurance' => [
                ['name' => 'Family Floater Supreme', 'desc' => 'Single policy covering up to 6 family members.', 'benefit' => 'Shared sum insured with no individual limits', 'audience' => 'Nuclear families', 'premium' => '1100'],
                ['name' => 'Global Family Care', 'desc' => 'Health cover valid both in India and abroad.', 'benefit' => 'Cashless treatment at international hospitals', 'audience' => 'Families traveling frequently', 'premium' => '2200'],
                ['name' => 'Health Plus Super Top-up', 'desc' => 'Affordable top-up to upgrade existing family cover.', 'benefit' => 'Extends coverage after deductible is exhausted', 'audience' => 'Families with corporate covers', 'premium' => '450'],
                ['name' => 'OPD Care Family', 'desc' => 'Covers doctor consultations, pharmacy, and diagnostics.', 'benefit' => 'Eliminates out-of-pocket minor medical expenses', 'audience' => 'Families with toddlers or elderly', 'premium' => '950'],
                ['name' => 'Critical Illness Family Guard', 'desc' => 'Lump-sum payout upon diagnosis of 36 critical illnesses.', 'benefit' => 'Immediate cash flow for major treatments', 'audience' => 'Families with medical history', 'premium' => '700']
            ],
            'travel-insurance' => [
                ['name' => 'Global Explorer Plan', 'desc' => 'Complete international travel protection for medical and delays.', 'benefit' => 'Covers flight cancellations and lost baggage', 'audience' => 'International tourists', 'premium' => '500'],
                ['name' => 'Domestic Travel Shield', 'desc' => 'Affordable cover for domestic flights and train journeys.', 'benefit' => 'Covers medical emergencies within India', 'audience' => 'Domestic vacationers', 'premium' => '100'],
                ['name' => 'Student Secure Travel', 'desc' => 'Tailored for students studying abroad.', 'benefit' => 'Covers tuition fees interruption and sponsor protection', 'audience' => 'International students', 'premium' => '800'],
                ['name' => 'Multi-Trip Annual Pass', 'desc' => 'One policy for unlimited trips throughout the year.', 'benefit' => 'Avoid buying separate policies per trip', 'audience' => 'Frequent business travelers', 'premium' => '1200'],
                ['name' => 'Schengen Visa Approved', 'desc' => 'Meets standard requirements for Schengen visa applications.', 'benefit' => 'Minimum €30,000 medical coverage', 'audience' => 'Europe travelers', 'premium' => '650']
            ],
            'employee-group-insurance' => [
                ['name' => 'CorpHealth Standard', 'desc' => 'Group medical cover for MSME employees.', 'benefit' => 'Cashless hospitalization in network hospitals', 'audience' => 'Startups and MSMEs', 'premium' => '300'],
                ['name' => 'Group Term Life Protect', 'desc' => 'Flat term life cover provided to all employees.', 'benefit' => 'Financial security for employee families', 'audience' => 'IT and Corporate firms', 'premium' => '150'],
                ['name' => 'Group Accident Shield', 'desc' => 'Coverage against workplace and off-duty accidents.', 'benefit' => 'Compensation for disability or death', 'audience' => 'Manufacturing & construction workers', 'premium' => '100'],
                ['name' => 'Premium Flexi-Benefit Plan', 'desc' => 'Allows employees to customize their group health benefits.', 'benefit' => 'Top-up options for parents and maternity', 'audience' => 'Large modern enterprises', 'premium' => '500'],
                ['name' => 'Gratuity Funding Plan', 'desc' => 'Helps employers meet their statutory gratuity obligations.', 'benefit' => 'Seamless fund management and tax benefits', 'audience' => 'Established companies', 'premium' => '1000']
            ],
            'home-insurance' => [
                ['name' => 'Bharat Griha Raksha', 'desc' => 'Standardized home structure and contents cover.', 'benefit' => 'Protection against fire, theft, and natural disasters', 'audience' => 'Homeowners and tenants', 'premium' => '250'],
                ['name' => 'Tenant Protection Shield', 'desc' => 'Covers only household belongings and electronics.', 'benefit' => 'Protection from burglary and accidental damage', 'audience' => 'People living in rented apartments', 'premium' => '150'],
                ['name' => 'Premium Villa Protect', 'desc' => 'High-value coverage for luxury properties and jewelry.', 'benefit' => 'Covers precious items and alternate accommodation', 'audience' => 'Owners of luxury homes/villas', 'premium' => '850'],
                ['name' => 'Home Appliance Care', 'desc' => 'Specific coverage for breakdown of costly electronics.', 'benefit' => 'Replaces ACs, TVs, and fridges in case of voltage spikes', 'audience' => 'Tech-heavy households', 'premium' => '200'],
                ['name' => 'Rent Loss Cover', 'desc' => 'Compensates landlords if the property becomes uninhabitable.', 'benefit' => 'Covers lost rental income up to 6 months', 'audience' => 'Property investors / Landlords', 'premium' => '300']
            ],
            'retirement-plans' => [
                ['name' => 'Jeevan Shanti Pension', 'desc' => 'Immediate annuity plan for instant retirement income.', 'benefit' => 'Start receiving pension from next month', 'audience' => 'Individuals retiring right now', 'premium' => '5000'],
                ['name' => 'Deferred Wealth Builder', 'desc' => 'Accumulate a corpus now, receive pension later.', 'benefit' => 'Tax-free maturity and market-linked growth', 'audience' => 'Professionals in their 30s', 'premium' => '2000'],
                ['name' => 'Golden Age Assure', 'desc' => 'Traditional retirement plan with guaranteed additions.', 'benefit' => 'Capital protection with steady bonuses', 'audience' => 'Risk-averse pre-retirees', 'premium' => '3000'],
                ['name' => 'Joint Pension Plus', 'desc' => 'Annuity covering both spouses with return of purchase price.', 'benefit' => 'Pension continues for the surviving spouse', 'audience' => 'Married couples nearing retirement', 'premium' => '4000'],
                ['name' => 'NPS Tier-I Advantage', 'desc' => 'Market-linked government scheme for retirement.', 'benefit' => 'Exclusive ₹50,000 extra tax benefit under 80CCD', 'audience' => 'Salaried employees', 'premium' => '1000']
            ],
            'guaranteed-return-plans' => [
                ['name' => 'Assured Income Plan', 'desc' => 'Provides fixed monthly income for 10 years post-maturity.', 'benefit' => 'Tax-free predictable cash flows', 'audience' => 'Sole breadwinners planning for future', 'premium' => '1500'],
                ['name' => 'Wealth Guarantee 10x', 'desc' => 'Pay for 5 years, get 10 times the premium guaranteed.', 'benefit' => '100% principal protection with high returns', 'audience' => 'Medium-term investors', 'premium' => '2500'],
                ['name' => 'Milestone Magic Plan', 'desc' => 'Pumps out lump-sum amounts at critical life stages.', 'benefit' => 'Guaranteed payouts at years 5, 10, and 15', 'audience' => 'Parents planning for education/marriage', 'premium' => '2000'],
                ['name' => 'FD Beater Plus', 'desc' => 'Offers guaranteed returns higher than bank FDs.', 'benefit' => 'Assured interest rate locked for 20 years', 'audience' => 'Conservative savers', 'premium' => '1000'],
                ['name' => 'Secure Future Plus', 'desc' => 'Combines life insurance with a guaranteed lump sum payout.', 'benefit' => 'Get maturity amount even if premiums stop due to death', 'audience' => 'Safety-focused individuals', 'premium' => '1200']
            ]
        ];

        // Clear existing plans generated by seeders maybe? 
        InsurancePlan::query()->delete();

        foreach ($categoriesData as $slug => $plans) {
            $category = InsuranceCategory::where('slug', $slug)->first();

            if (!$category) {
                continue;
            }

            foreach ($plans as $plan) {
                InsurancePlan::create([
                    'category_id' => $category->id,
                    'name' => $plan['name'],
                    'slug' => Str::slug($plan['name']),
                    'description' => $plan['desc'],
                    'base_premium' => (float) $plan['premium'],
                    'coverage_amount' => ((float) $plan['premium']) * 500, // Example coverage
                    'duration_years' => 1,
                    'benefits' => [
                        $plan['benefit'],
                        'Suitable for: ' . $plan['audience']
                    ],
                    'features' => [
                        ['title' => 'Key Benefit', 'description' => $plan['benefit']],
                        ['title' => 'Target Audience', 'description' => $plan['audience']]
                    ],
                    'is_active' => true,
                ]);
            }
        }
    }
}
