<img class="card-img-top dashboard-product-popup" src="{{ $product->getFeaturedImage() }}" alt="{{ $product->name }}">
<div class="card-body">
    <h5 class="card-title">{{ $product->name }}</h5>
    <p class="card-text">
    <table>
        <tr>
            <th>{{ __('Price') }}:</th>
            <td>{{ $product->getFormattedPrice() }}</td>
        </tr>
        <tr>
            <th>{{ __('Details') }}</th>
            <td>{{ $product->details }}</td>
        </tr>
    </table>
    </p>
</div>
