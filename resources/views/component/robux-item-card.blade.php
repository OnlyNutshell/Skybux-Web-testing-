<div data-card data-robux="{{ $item['robux'] }}" data-price="{{ $item['price'] }}" class="bg-white px-2.5 pb-3 pt-4 border-2 border-black shadow-sm hover:bg-sky-600 cursor-pointer hover:shadow-[inset_0_0_8px_rgba(0,0,0,0.45)] rounded-2xl">
        <div class="flex items-center gap-1.5 mb-3">
            <img
                class="w-5 h-5 object-contain"
                src="https://img.icons8.com/ios-filled/50/22C3E6/robux--v1.png"
                alt="Robux"
            />
            <span class="block leading-3.75 align-middle">{{ $item['robux'] }}</span>
        </div>
        <div class="dotted-divider mb-6"></div>
        <span class="font-semibold text-[16px]">{{ number_format($item['price'], 0, ',', '.') }}</span>
    </div>