<!-- ======= Pricing Section ======= -->
<section id="cenovnik" class="pricing">
    <div class="container">
        <div class="section-title">
            <h2>{{ __('messages.pricing.title') }}</h2>
            <p>{!! __('messages.pricing.description') !!}</p>
        </div>

        <!-- Pricing Table -->
        <div class="pricing-table-container">
            <div class="table-responsive">
                <table class="pricing-table">
                    <thead>
                    <tr>
                        <th class="first-col">1-7 {{ __('messages.pricing.days') }}</th>
                        <th class="second-col">8-14 {{ __('messages.pricing.days') }}</th>
                        <th class="third-col">15-21 {{ __('messages.pricing.day') }}</th>
                        <th class="fourth-col">22-28 {{ __('messages.pricing.days') }}</th>
                        <th class="fifth-col">29-35 {{ __('messages.pricing.days') }}</th>
                        <th class="sixth-col">36-40 {{ __('messages.pricing.days') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for ($row = 1; $row <= 7; $row++)
                        <tr>
                            @for ($col = 0; $col <= 5; $col++)
                                @php($day = $col * 7 + $row)
                                @if ($day <= 40)
                                    <td class="pricing-cell" data-days="{{ $day }}" data-price="{{ $prices[$day] }}">
                                        <span class="days">{{ $day }} {{ ($day % 10 === 1 && $day !== 11) ? __('messages.pricing.day') : __('messages.pricing.days') }}</span>
                                        <span class="price">{{ $prices[$day] }} {{ __('messages.pricing.rsd') }}</span>
                                    </td>
                                @elseif ($day === 41)
                                    <td class="pricing-cell long-term" data-days="41" data-price="{{ $extraDayRate * 41 }}">
                                        <span class="days">{{ __('messages.pricing.long_term') }}</span>
                                        <span class="price">{{ __('messages.pricing.per_day') }}</span>
                                    </td>
                                @else
                                    <td class="pricing-cell info-cell">
                                        <span class="info-text">{{ __('messages.pricing.click_price') }}</span>
                                    </td>
                                @endif
                            @endfor
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
    // Format all pricing cells to decimal notation with RSD currency
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.pricing-cell .price').forEach(function (el) {
            var price = el.closest('.pricing-cell').dataset.price;
            if (price && !isNaN(price)) {
                var formatted = new Intl.NumberFormat('sr-RS', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(parseFloat(price));
                el.textContent = formatted + ' RSD';
            }
        });
    });
</script>
