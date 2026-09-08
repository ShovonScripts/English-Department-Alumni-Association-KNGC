import re

with open('resources/views/pages/home.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Update Hero section background
hero_pattern = r'<section class="relative overflow-hidden bg-navy-950 text-white">(.*?)</section>'
def replace_hero(match):
    inner = match.group(1)
    # Replace the pointer-events-none div with the animated mesh
    new_bg = """
        <div class="pointer-events-none absolute inset-0 hero-gradient-mesh" aria-hidden="true">
            <div class="absolute -right-32 -top-32 h-[28rem] w-[28rem] rounded-full bg-gold-400 bg-ambient-orb"></div>
            <div class="absolute -left-24 bottom-0 h-80 w-80 rounded-full bg-maroon-500 bg-ambient-orb" style="animation-delay: -5s;"></div>
            <div class="absolute bottom-24 left-1/3 h-40 w-40 rounded-full bg-navy-400 bg-ambient-orb" style="animation-delay: -10s;"></div>
        </div>
"""
    # Use regex to replace the first div
    inner_replaced = re.sub(r'<div class="pointer-events-none absolute inset-0 opacity-\[0\.07\]".*?</div>\s*</div>', new_bg.strip(), inner, flags=re.DOTALL)
    
    # Add AOS to the h1 and p
    inner_replaced = inner_replaced.replace(
        '<h1 class="font-serif text-4xl font-semibold',
        '<h1 x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? \'aos-animate\' : \'\'" class="aos-init aos-fade-up font-serif text-4xl font-semibold'
    )
    inner_replaced = inner_replaced.replace(
        '<p class="mt-7 max-w-2xl text-base leading-relaxed',
        '<p x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? \'aos-animate\' : \'\'" class="aos-init aos-fade-up aos-delay-200 mt-7 max-w-2xl text-base leading-relaxed'
    )
    inner_replaced = inner_replaced.replace(
        '<div class="mt-9 flex flex-col gap-3',
        '<div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? \'aos-animate\' : \'\'" class="aos-init aos-fade-up aos-delay-400 mt-9 flex flex-col gap-3'
    )
    inner_replaced = inner_replaced.replace(
        '<div class="hidden lg:col-span-4 lg:block">',
        '<div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? \'aos-animate\' : \'\'" class="aos-init aos-fade-right aos-delay-500 hidden lg:col-span-4 lg:block">'
    )
    return '<section class="relative overflow-hidden bg-navy-950 text-white">' + inner_replaced + '</section>'

content = re.sub(hero_pattern, replace_hero, content, count=1, flags=re.DOTALL)

# 2. Add AOS to Section Headings
content = content.replace(
    '<x-section-heading',
    '<div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? \'aos-animate\' : \'\'" class="aos-init aos-fade-up"><x-section-heading'
)
# Close the div after the x-section-heading component
content = re.sub(r'(<x-section-heading[^>]*/>)', r'\1</div>', content)

# 3. Add AOS to grid containers to fade up the cards
content = content.replace(
    '<div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">',
    '<div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? \'aos-animate\' : \'\'" class="aos-init aos-fade-up aos-delay-200 mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">'
)
content = content.replace(
    '<div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">',
    '<div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? \'aos-animate\' : \'\'" class="aos-init aos-fade-up aos-delay-200 mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">'
)
content = content.replace(
    '<div class="mt-12 grid gap-6 lg:grid-cols-3">',
    '<div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? \'aos-animate\' : \'\'" class="aos-init aos-fade-up aos-delay-200 mt-12 grid gap-6 lg:grid-cols-3">'
)

with open('resources/views/pages/home.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

print("home.blade.php updated with AOS.")
