@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Your Company/Institution') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('companyStore') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="companyname" class="col-md-4 col-form-label text-md-right">{{ __('Company Name') }}</label>
                            <div class="col-md-6">
                                <input id="companyname" type="text" class="form-control{{ $errors->has('companyname') ? ' is-invalid' : '' }}" name="companyname" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('companyname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="companysector" class="col-md-4 col-form-label text-md-right">{{ __('Sector') }}</label>
                            <div class="col-md-6">
                            <select class="form-control {{ $errors->has('companyname') ? ' is-invalid' : '' }}" id="companysector" name="companysector">
                                <optgroup>
                                    @foreach($sectors as $sector)
                                        <option value="{{$sector->id}}">{{$sector->name}}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup>
                                        <option disabled>──────────</option>
                                        <option value="21">Fintech Association</option>
                                        <option value="22">Univesity/Education Institute</option>
                                </optgroup>
                            </select>
                                @if ($errors->has('companysector'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('companysector') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="companyaddress" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>
                            <div class="col-md-6">
                                <input id="companyaddress" type="text" class="form-control{{ $errors->has('companyaddress') ? ' is-invalid' : '' }}" name="companyaddress" required>
                                @if ($errors->has('companyaddress'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('companyaddress') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>
                            <div class="col-md-6">
                            <select class="form-control {{ $errors->has('companyname') ? ' is-invalid' : '' }}" id="country" name="country">
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                                    <option value="30">Other</option>
                            </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="companyphone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>
                            <div class="col-md-6">
                                <input id="companyphone" type="text" class="form-control{{ $errors->has('companyphone') ? ' is-invalid' : '' }}" name="companyphone" required>
                                @if ($errors->has('companyphone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('companyphone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="companywebsite" class="col-md-4 col-form-label text-md-right">{{ __('Company Website') }}</label>
                            <div class="col-md-6">
                                <input id="companywebsite" type="text" class="form-control{{ $errors->has('companywebsite') ? ' is-invalid' : '' }}" name="companywebsite" required>
                                @if ($errors->has('companywebsite'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('companywebsite') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
