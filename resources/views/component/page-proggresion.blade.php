
@php
    $steps = [
        ['title' => 'Create Order', 'icon' => 'clipboard-list'],
        ['title' => 'Choose Payment Method', 'icon' => 'wallet-cards'],
        ['title' => 'Make Payment', 'icon' => 'qr-code'],
    ];

    $currentStep = max(1, min(3, (int) ($step ?? 1)));
    $progress = ($currentStep / 3) * 100;
@endphp

<section class="mx-4 my-6 sm:mx-8 xl:mx-32">

    {{-- DESKTOP MODE --}}
    <div class="hidden md:block mx-auto w-2/3 px-2 py-4">
        <div class="relative ">

            {{-- PROGRESS LINE --}}
            <div class="absolute left-5 right-5 top-5 z-0 flex gap-2">
                @foreach ([2, 3] as $target)
                    <div @class([
                        'h-0.75 flex-1 rounded-full',
                        'bg-linear-to-r from-sky-400 to-sky-500' => $currentStep >= $target,
                        'bg-slate-400' => $currentStep < $target,
                    ])></div>
                @endforeach
            </div>

            {{-- STEPS --}}
            <div class="relative z-10 grid grid-cols-3">
                @foreach ($steps as $index => $item)
                    @php
                        $number = $index + 1;
                        $completed = $number < $currentStep;
                        $current = $number === $currentStep;
                    @endphp

                    <div @class([
                        'flex flex-col gap-2',
                        'items-start' => $index === 0,
                        'items-center text-center' => $index === 1,
                        'items-end text-right' => $index === 2,
                    ])>

                        {{-- CIRCLE --}}
                        <div @class([
                            'flex size-10 items-center justify-center rounded-full',
                            'bg-sky-600 text-white shadow-md shadow-sky-600/20' => $completed,
                            'border-4 border-sky-100 bg-sky-600 text-white shadow-lg shadow-sky-500/25' => $current,
                            'border-2 border-slate-200 bg-white text-slate-400' => !$completed && !$current,
                        ])>
                            @if ($completed)
                                <i data-lucide="check" class="size-5"></i>
                            @else
                                <span class="text-sm font-bold">
                                    {{ sprintf('%02d', $number) }}
                                </span>
                            @endif
                        </div>

                        {{-- LABEL --}}
                        <div>
                            <p @class([
                                'text-xs font-medium',
                                'text-sky-600' => $completed || $current,
                                'text-slate-400' => !$completed && !$current,
                            ])>
                                STEP {{ sprintf('%02d', $number) }}

                                @if ($current)
                                    · CURRENT
                                @elseif ($completed)
                                    · COMPLETED
                                @endif
                            </p>

                            <p @class([
                                'font-semibold',
                                'text-slate-900 font-bold' => $current,
                                'text-slate-800' => $completed,
                                'text-slate-400' => !$completed && !$current,
                            ])>
                                {{ $item['title'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    {{-- MOBILE MODE --}}
    <div class="md:hidden px-1 py-3">

        <div class="mb-4 flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-wider text-sky-600">
                    Checkout Progress
                </p>

                <h3 class="mt-1 text-xl font-bold text-slate-900">
                    Step {{ sprintf('%02d', $currentStep) }}
                    <span class="text-sm font-medium text-slate-400">/ 03</span>
                </h3>
            </div>

            <div class="flex size-11 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                <i data-lucide="{{ $steps[$currentStep - 1]['icon'] }}" class="size-5"></i>
            </div>
        </div>

        {{-- PROGRESS BAR --}}
        <div class="mb-4 flex gap-2">
            @foreach ([1, 2, 3] as $item)
                <div @class([
                    'h-1.5 flex-1 rounded-full transition-all duration-300',
                    'bg-linear-to-r from-sky-500 to-blue-600' => $item <= $currentStep,
                    'bg-slate-100' => $item > $currentStep,
                ])></div>
            @endforeach
        </div>

        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold text-slate-900">
                {{ $steps[$currentStep - 1]['title'] }}
            </span>

            <span class="rounded-full bg-sky-50 px-2 py-1 text-[10px] font-semibold text-sky-600">
                Current Step
            </span>
        </div>


    </div>
</section>
