<add-to-cart :default-qty="{{ $product->min_sale_qty > $product->qty_increments ? $product->min_sale_qty : $product->qty_increments }}">
    <form slot-scope="{ _renderProxy: addToCartSlotProps, options, customOptions, error, add, disabledOptions, simpleProduct, adding, added, price, specialPrice, setCustomOptionFile }" v-on:submit.prevent="add">
        <h1 class="mb-4 text-3xl font-bold" itemprop="name">{{ $product->name }}</h1>
        @if (App::providerIsLoaded('Rapidez\Reviews\ReviewsServiceProvider'))
            @if ($product->reviews_score)
                <div class="my-4">
                    <stars :score="{{ $product->reviews_score }}" :count="{{ $product->reviews_count }}" />
                </div>
            @endif
            <div class="my-4">
                <stars :score="5" :count="82" />
            </div>
        @endif
        @if (!$product->in_stock)
            <p class="text-red-600">@lang('Sorry! This product is currently out of stock.')</p>
        @else
            <div class="grid gap-5 max-w-sm">
                <div v-cloak v-for="(superAttribute, superAttributeId) in config.product.super_attributes">
                    <x-rapidez::label v-bind:for="'super_attribute_'+superAttributeId">@{{ superAttribute.label }}</x-rapidez::label>
                    <x-rapidez::select required label="" v-bind:id="'super_attribute_'+superAttributeId" v-bind:name="superAttributeId" v-model="options[superAttributeId]" class="mb-3 block w-64">
                        <option disabled selected hidden :value="undefined">@lang('Select') @{{ superAttribute.label.toLowerCase() }}</option>
                        <option
                            v-for="option in Object.values(config.product['super_'+superAttribute.code]).sort((a, b) => a.sort_order - b.sort_order)"
                            v-text="option.label"
                            :value="option.value"
                            :disabled="disabledOptions['super_'+superAttribute.code].includes(option.value)"
                        />
                    </x-rapidez::select>
                </div>
            </div>
            @include('rapidez::product.partials.options')
            <div class="mt-6 flex flex-col gap-6" v-blur>
                <div class="flex gap-4 items-center">
                    <div>
                        <div class="text-2xl font-bold text-neutral" v-text="$options.filters.price(specialPrice || price)">
                            {{ price($product->special_price ?: $product->price) }}
                        </div>
                        <div class="text-lg text-neutral line-through" v-if="specialPrice" v-text="$options.filters.price(price)">
                            {{ $product->special_price ? price($product->price) : '' }}
                        </div>
                    </div>
                    <x-rapidez::select
                        class="w-auto"
                        name="qty"
                        label="Quantity"
                        v-model="addToCartSlotProps.qty"
                        labelClass="flex items-center sr-only"
                        wrapperClass="flex"
                    >
                        @for ($i = $product->qty_increments; $i <= $product->qty_increments * 10; $i += $product->qty_increments)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </x-rapidez::select>
                </div>
                <x-rapidez-tut::button.primary type="submit" class="flex items-center max-w-sm" dusk="add-to-cart">
                    <x-heroicon-o-shopping-cart class="mr-2 h-5 w-5" v-if="!adding && !added" />
                    <x-heroicon-o-arrow-path class="mr-2 h-5 w-5 animate-spin" v-if="adding" />
                    <x-heroicon-o-check class="mr-2 h-5 w-5" v-if="added" />
                    <span v-if="!adding && !added">@lang('Add to cart')</span>
                    <span v-if="adding" v-cloak>@lang('Adding')...</span>
                    <span v-if="added" v-cloak>@lang('Added')</span>
                </x-rapidez-tut::button.primary>
            </div>
        @endif
    </form>
</add-to-cart>
