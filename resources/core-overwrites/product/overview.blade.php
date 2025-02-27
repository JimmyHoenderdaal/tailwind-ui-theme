@extends('rapidez::layouts.app')

@section('title', $product->meta_title ?: $product->name)
@section('description', $product->meta_description)
@section('canonical', url($product->url))
@include('rapidez::layouts.partials.head.hreflang', ['alternates' => $product->alternates])

@section('content')
    <div class="container">
        @include('rapidez::product.partials.breadcrumbs')
        <div itemtype="https://schema.org/Product" itemscope>
            @include('rapidez::product.partials.microdata')
            @include('rapidez::product.partials.opengraph')
            <div class="relative flex gap-8 max-sm:flex-col">
                <div class="flex-1">
                    <div class="sticky top-5">
                        @include('rapidez::product.partials.images')
                    </div>
                </div>
                <div class="flex flex-1 flex-col gap-5">
                    @include('rapidez::product.partials.addtocart')
                    <div>
                        <div class="border-t pt-5 text-lg font-bold">@lang('Description')</div>
                        <div class="prose text-inactive" itemprop="description">
                            {!! $product->description !!}
                        </div>
                    </div>
                    <div>
                        <div class="mb-2 border-t pt-5 text-lg font-bold">@lang('Specifications')</div>
                        <dl class="flex flex-col text-inactive [&>dd]:rounded [&>dd]:p-2 odd:[&>dd]:bg-highlight odd:[&>dd]:font-semibold odd:[&>dd]:text-neutral even:[&>dd]:pl-4">
                            <dd>ID</dd>
                            <dd>{{ $product->entity_id }}</dd>
                            <dd>SKU</dd>
                            <dd>{{ $product->sku }}</dd>
                            @foreach (config('rapidez.models.attribute')::getCachedWhere(fn($a) => $a['productpage']) as $attribute)
                                @if (($value = $product->{$attribute['code']}) && !is_object($value))
                                    <dd>{{ $attribute['name'] }}</dd>
                                    <dd>
                                        @php $output = is_array($value) ? implode(', ', $value) : $value @endphp
                                        {!! $attribute['html'] ? $output : e($output) !!}
                                    </dd>
                                @endif
                            @endforeach
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <x-rapidez::productlist title="Related products" field="id" :value="$product->relation_ids" />
        <x-rapidez::productlist title="We found other products you might like!" field="id" :value="$product->upsell_ids" />
    </div>
    @if (App::providerIsLoaded('Rapidez\Reviews\ReviewsServiceProvider'))
        <div class="my-5 min-h-[515px] bg-highlight py-8">
            <div class="container grid w-full grid-cols-1 gap-5 p-5 md:grid-cols-3">
                @include('rapidez-reviews::form', ['sku' => $product->sku])
                <div class="md:col-span-2">
                    @include('rapidez-reviews::reviews', [
                        'sku' => $product->sku,
                        'reviews_count' => $product->reviews_count,
                        'reviews_score' => $product->reviews_score,
                    ])
                </div>
            </div>
        </div>
    @endif
@endsection
