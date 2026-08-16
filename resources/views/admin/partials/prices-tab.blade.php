<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h5 mb-0">Prices per number of days (RSD)</h2>
    <div>
        <button type="button" id="reset-prices-btn" class="btn btn-outline-danger btn-sm">Reset to Default</button>
        <button type="button" id="save-prices-btn" class="btn btn-primary btn-sm">Save Changes</button>
    </div>
</div>

<div id="price-form">
    <div class="row g-2" id="price-inputs">
        @foreach ($prices as $days => $price)
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <label class="form-label small mb-1" for="price-day-{{ $days }}">Day {{ $days }}</label>
                <input
                    type="number"
                    min="0"
                    step="1"
                    class="form-control form-control-sm price-input"
                    id="price-day-{{ $days }}"
                    data-days="{{ $days }}"
                    data-original="{{ $price }}"
                    value="{{ $price }}"
                >
            </div>
        @endforeach
    </div>

    <div class="row g-2 mt-3">
        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
            <label class="form-label small mb-1" for="extra-day-rate">Extra day rate (41+ days)</label>
            <input
                type="number"
                min="0"
                step="1"
                class="form-control form-control-sm"
                id="extra-day-rate"
                data-original="{{ $extraDayRate }}"
                value="{{ $extraDayRate }}"
            >
        </div>
    </div>
</div>
