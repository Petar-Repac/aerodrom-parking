@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <ul class="nav nav-tabs mb-4" id="admin-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="prices-tab-btn" data-bs-toggle="tab" data-bs-target="#prices" type="button" role="tab">Prices</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="admins-tab-btn" data-bs-toggle="tab" data-bs-target="#admins" type="button" role="tab">Admins</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="audit-log-tab-btn" data-bs-toggle="tab" data-bs-target="#audit-log" type="button" role="tab">Audit Log</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="account-tab-btn" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab">Account</button>
        </li>
    </ul>

    <div class="tab-content" id="admin-tabs-content">
        <div class="tab-pane fade show active" id="prices" role="tabpanel">
            @include('admin.partials.prices-tab')
        </div>
        <div class="tab-pane fade" id="admins" role="tabpanel">
            @include('admin.partials.admins-tab')
        </div>
        <div class="tab-pane fade" id="audit-log" role="tabpanel">
            @include('admin.partials.audit-log-tab')
        </div>
        <div class="tab-pane fade" id="account" role="tabpanel">
            @include('admin.partials.account-tab')
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/admin.js') . '?' . env('APP_VERSION') }}" type="module"></script>
@endsection
