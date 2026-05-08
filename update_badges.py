import sys

def update_file(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    replacements = [
        ("'life-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3382/3382103.png', 'color' => 'primary', 'badge' => 'Upto 15% Discount']",
         "'life-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3382/3382103.png', 'badge' => 'Save up to 15%', 'badge_bg' => '#d1fae5', 'badge_color' => '#065f46']"),
        ("'health-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/2966/2966327.png', 'color' => 'danger', 'badge' => 'Upto 25% Discount']",
         "'health-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/2966/2966327.png', 'badge' => 'Save up to 25%', 'badge_bg' => '#d1fae5', 'badge_color' => '#065f46']"),
        ("'car-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3202/3202926.png', 'color' => 'info', 'badge' => 'Lowest Price Guarantee']",
         "'car-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3202/3202926.png', 'badge' => 'Best Price Guaranteed', 'badge_bg' => '#d1fae5', 'badge_color' => '#065f46']"),
        ("'travel-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/2060/2060284.png', 'color' => 'warning', 'badge' => 'Instant Policy']",
         "'travel-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/2060/2060284.png', 'badge' => 'Instant Policy Issuance']"),
        ("'investment-plans' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/2933/2933116.png', 'color' => 'success', 'badge' => 'In-Built Life Cover']",
         "'investment-plans' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/2933/2933116.png', 'badge' => 'Life Cover Included']"),
        ("'family-health-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3135/3135810.png', 'color' => 'danger', 'badge' => 'Upto 25% Discount']",
         "'family-health-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3135/3135810.png', 'badge' => 'Family Saver Plan']"),
        ("'term-life-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/1055/1055100.png', 'color' => 'primary', 'badge' => 'Upto 20% Cheaper']",
         "'term-life-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/1055/1055100.png', 'badge' => 'Low Premium Plans']"),
        ("'employee-group-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3135/3135694.png', 'color' => 'primary', 'badge' => 'Corporate Discount']",
         "'employee-group-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3135/3135694.png', 'badge' => 'Exclusive Corporate Rates']"),
        ("'home-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/619/619153.png', 'color' => 'warning', 'badge' => 'Secure Home']",
         "'home-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/619/619153.png', 'badge' => 'Comprehensive Coverage']"),
        ("'retirement-plans' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3050/3050474.png', 'color' => 'success', 'badge' => 'Golden Years']",
         "'retirement-plans' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3050/3050474.png', 'badge' => 'Guaranteed Pension', 'badge_bg' => '#d1fae5', 'badge_color' => '#065f46']"),
        ("'guaranteed-return-plans' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/2933/2933100.png', 'color' => 'info', 'badge' => '100% Guaranteed']",
         "'guaranteed-return-plans' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/2933/2933100.png', 'badge' => 'Assured Returns', 'badge_bg' => '#d1fae5', 'badge_color' => '#065f46']"),
        ("'color' => 'success', 'badge' => 'Upto 85% Discount']",
         "'badge' => 'Save up to 85%', 'badge_bg' => '#d1fae5', 'badge_color' => '#065f46']"),
        ('<span class="badge rounded-pill shadow-sm"\\n                                style="background-color: #acf3b7; color: #155724; font-weight: 600; font-size: 0.75rem; padding: 5px 12px;">{{ $catSettings[\'badge\'] }}</span>'.replace('\\n', '\n'),
         '<span class="badge rounded-pill shadow-sm"\\n                                style="background-color: {{ $catSettings[\'badge_bg\'] ?? \'#e0f2fe\' }}; color: {{ $catSettings[\'badge_color\'] ?? \'#0369a1\' }}; font-weight: 600; font-size: 0.70rem; padding: 4px 10px;">{{ $catSettings[\'badge\'] }}</span>'.replace('\\n', '\n')),
        ('<span class="badge rounded-pill shadow-sm"\\n                                            style="background-color: #acf3b7; color: #155724; font-weight: 600; font-size: 0.75rem; padding: 5px 12px;">{{ $catSettings[\'badge\'] }}</span>'.replace('\\n', '\n'),
         '<span class="badge rounded-pill shadow-sm"\\n                                            style="background-color: {{ $catSettings[\'badge_bg\'] ?? \'#e0f2fe\' }}; color: {{ $catSettings[\'badge_color\'] ?? \'#0369a1\' }}; font-weight: 600; font-size: 0.70rem; padding: 4px 10px;">{{ $catSettings[\'badge\'] }}</span>'.replace('\\n', '\n'))
    ]

    for old, new in replacements:
        if old in content:
            content = content.replace(old, new)
        else:
            if 'background-color' not in old:
                print(f"Warning: Could not find {old[:50]}... in {filepath}")

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)

update_file(r'c:\xampp\htdocs\laravel_10\Insurance Management\resources\views\frontend\home.blade.php')
update_file(r'c:\xampp\htdocs\laravel_10\Insurance Management\resources\views\welcome.blade.php')
print("Done")
