<!-- ======= How to Use Section ======= -->
<section id="procedure" class="procedure">
    <div class="container">

        <div class="section-title">
            <h2>{{ __('messages.procedure.title') }}</h2>
            <p>{{ __('messages.procedure.description') }}</p>
        </div>
        <div class="row">

            <div class="col-lg-3 col-md-6">
                <div class="box featured">
                    <div class="step-number">01</div>
                    <h3 class="first-col">
                        <div class="step-icon">
                            <i class="bi bi-envelope-paper"></i>
                        </div>
                        {{ __('messages.procedure.step_01.title') }}
                    </h3>
                    <ul>
                        <li>{!! __('messages.procedure.step_01.description') !!}</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mt-4 mt-md-0">
                <div class="box featured">
                    <div class="step-number">02</div>
                    <h3 class="second-col">
                        <div class="step-icon">
                            <i class="bi bi-phone"></i>
                        </div>
                        {{ __('messages.procedure.step_02.title') }}
                    </h3>
                    <ul>
                        <li>{!! __('messages.procedure.step_02.description') !!}</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mt-4 mt-lg-0">
                <div class="box featured">
                    <div class="step-number">03</div>
                    <h3 class="third-col">
                        <div class="step-icon">
                            <i class="bi bi-p-circle"></i>
                        </div>
                        {{ __('messages.procedure.step_03.title') }}
                    </h3>
                    <ul>
                        <li>{{ __('messages.procedure.step_03.description') }}</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mt-4 mt-lg-0">
                <div class="box featured">
                    <div class="step-number">04</div>
                    <h3 class="fourth-col">
                        <div class="step-icon">
                            <i class="bi bi-car-front"></i>
                        </div>
                        {{ __('messages.procedure.step_04.title') }}
                    </h3>
                    <ul>
                        <li>{{ __('messages.procedure.step_04.description') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
