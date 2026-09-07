@props([
    'question',
    'answer',
])

<details class="group border-b border-line py-5">
    <summary class="flex cursor-pointer list-none items-start justify-between gap-4 text-left text-base font-medium marker:content-none">
        <span>{{ $question }}</span>
        <span class="mt-1 text-ink-soft transition duration-200 group-open:rotate-45" aria-hidden="true">+</span>
    </summary>
    <p class="mt-3 max-w-3xl text-sm leading-relaxed text-ink-soft">{{ $answer }}</p>
</details>
