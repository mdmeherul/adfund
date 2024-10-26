@extends('layouts.app')
@section('page-title')
    {{__('Customer Create')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('customer.index')}}">{{__('Customer')}}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Create')}}</a>
        </li>
    </ul>
@endsection
@section('content')
    {{ Form::open(array('url' => 'customer', 'method' => 'post')) }}
    <div class="row">
        <div class="col-xl-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>{{customerPrefix().$customerNumber}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6 col-lg-6">
                            {{Form::label('name',__('Name'),array('class'=>'form-label')) }}
                            {{Form::text('name', old('name'),array('class'=>'form-control','placeholder'=>__('Enter Name'),'required'=>'required'))}}
                        </div>
                        <div class="form-group col-md-6 col-lg-6">
                            {{Form::label('email',__('Email'),array('class'=>'form-label'))}}
                            {{Form::text('email', old('email'),array('class'=>'form-control','placeholder'=>__('Enter email'),'required'=>'required'))}}
                        </div>
                        <div class="form-group col-md-6 col-lg-6">
                            {{Form::label('phone_number',__('Phone Number'),array('class'=>'form-label')) }}
                            {{Form::text('phone_number', old('phone_number'),array('class'=>'form-control','placeholder'=>__('Enter phone number'),'required'=>'required'))}}
                        </div>
                        <div class="form-group col-md-6 col-lg-6">
                            {{ Form::label('gender', __('Gender'), array('class' => 'form-label')) }}
                            {!! Form::select('gender', $gender, old('gender'), array('class' => 'form-control  basic-select hidesearch', 'required' => 'required')) !!}
                        </div>

                        <div class="form-group col-md-6 col-lg-6">
                            {{Form::label('city',__('City'),array('class'=>'form-label')) }}
                            {{Form::text('city', old('city'),array('class'=>'form-control','placeholder'=>__('Enter city'),'required'=>'required'))}}
                        </div>
                        <div class="form-group col-md-6 col-lg-6">
                            {{Form::label('state',__('State'),array('class'=>'form-label')) }}
                            {{Form::text('state', old('state'),array('class'=>'form-control','placeholder'=>__('Enter state'),'required'=>'required'))}}
                        </div>
                        <div class="form-group col-md-6 col-lg-6">
                            {{Form::label('country',__('Country'),array('class'=>'form-label')) }}
                            {{Form::text('country', old('country'),array('class'=>'form-control','placeholder'=>__('Enter country'),'required'=>'required'))}}
                        </div>
                        <div class="form-group col-md-6 col-lg-6">
                            {{Form::label('zip_code',__('Zip Code'),array('class'=>'form-label')) }}
                            {{Form::text('zip_code', old('zip_code'),array('class'=>'form-control','placeholder'=>__('Enter zip code'),'required'=>'required'))}}
                        </div>
                        <div class="form-group col-md-12 col-lg-12">
                            {{Form::label('address',__('Address'),array('class'=>'form-label')) }}
                            {{Form::textarea('address', old('address'),array('class'=>'form-control','placeholder'=>__('Enter address'),'rows'=>2,'required'=>'required'))}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>{{__('Additional Detail')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6 col-lg-6">
                            {{Form::label('company',__('Company'),array('class'=>'form-label')) }}
                            {{Form::text('company',old('company'),array('class'=>'form-control','placeholder'=>__('Enter company')))}}
                        </div>
                        <div class="form-group col-md-6 col-lg-6">
                            {{Form::label('tax_number',__('Tax number'),array('class'=>'form-label')) }}
                            {{Form::text('tax_number',old('tax_number'),array('class'=>'form-control','placeholder'=>__('Enter tax/vat number')))}}
                        </div>
                        <div class="form-group col-md-6 col-lg-6">
                            {{Form::label('dob',__('Date of Birth'),array('class'=>'form-label')) }}
                            {{Form::date('dob',old('dob'),array('class'=>'form-control'))}}
                        </div>
                        <div class="form-group col-md-6 col-lg-6">
                            {{Form::label('age',__('Age'),array('class'=>'form-label')) }}
                            {{Form::number('age',old('age'),array('class'=>'form-control','placeholder'=>__('Enter age')))}}
                        </div>
                        <div class="form-group col-md-6 col-lg-6">
                            {{ Form::label('marital_status', __('Marital Status'), array('class' => 'form-label')) }}
                            {!! Form::select('marital_status', $maritalStatus, old('marital_status'), array('class' => 'form-control  basic-select hidesearch')) !!}
                        </div>
                        <div class="form-group col-md-6 col-lg-6">
                            {{Form::label('blood_group',__('Blood Group'),array('class'=>'form-label')) }}
                            {{Form::text('blood_group',old('blood_group'),array('class'=>'form-control','placeholder'=>__('Enter blood group')))}}
                        </div>
                        <div class="form-group col-md-6 col-lg-6">
                            {{Form::label('height',__('Height'),array('class'=>'form-label')) }}
                            {{Form::number('height',old('height'),array('class'=>'form-control','placeholder'=>__('Enter height')))}}
                        </div>
                        <div class="form-group col-md-6 col-lg-6">
                            {{Form::label('weight',__('Weight'),array('class'=>'form-label')) }}
                            {{Form::number('weight',old('weight'),array('class'=>'form-control','placeholder'=>__('Enter weight')))}}
                        </div>
                        <div class="form-group col-md-12 col-lg-12">
                            {{Form::label('notes',__('Note'),array('class'=>'form-label')) }}
                            {{Form::textarea('notes', old('notes'),array('class'=>'form-control','placeholder'=>__('Enter notes'),'rows'=>2))}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="form-group text-end">
            {{ Form::submit(__('Create'), array('class' => 'btn btn-primary ml-10')) }}
        </div>
    </div>
    {{ Form::close() }}

@endsection
