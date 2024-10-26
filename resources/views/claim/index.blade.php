@extends('layouts.app')
@section('page-title')
    {{__('Claim')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Claim')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @if(Gate::check('create claim'))
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="lg"
           data-url="{{ route('claim.create') }}"
           data-title="{{__('Create Claim')}}"> <i class="ti-plus mr-5"></i>{{__('Create Claim')}}</a>
    @endif
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="display dataTable cell-border datatbl-advance">
                        <thead>
                        <tr>
                            <th>{{__('ID')}}</th>
                            <th>{{__('Claim Date')}}</th>
                            <th>{{__('Customer')}}</th>
                            <th>{{__('Insurance')}}</th>
                            <th>{{__('Status')}}</th>
                            @if(Gate::check('edit claim') || Gate::check('delete claim'))
                                <th>{{__('Action')}}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($claims as $claim)
                            <tr>
                                <td>{{ claimPrefix().$claim->claim_id }} </td>
                                <td>{{ dateFormat($claim->date) }} </td>
                                <td>{{ !empty($claim->customers)?$claim->customers->name:'-' }} </td>
                                <td>
                                    <a href="{{route('insurance.show',\Illuminate\Support\Facades\Crypt::encrypt($claim->insurances->id))}}">{{ !empty($claim->insurances)?insurancePrefix().$claim->insurances->insurance_id:'-' }} </a>
                                </td>
                                <td>
                                    @if($claim->status=='submitted')
                                        <span
                                            class="badge badge-primary">{{\App\Models\Claim::$status[$claim->status]}}</span>
                                    @elseif($claim->status=='acknowledged')
                                        <span
                                            class="badge badge-info">{{\App\Models\Claim::$status[$claim->status]}}</span>
                                    @elseif($claim->status=='approved')
                                        <span
                                            class="badge badge-success">{{\App\Models\Claim::$status[$claim->status]}}</span>
                                    @elseif($claim->status=='under_review')
                                        <span
                                            class="badge badge-warning">{{\App\Models\Claim::$status[$claim->status]}}</span>
                                    @else
                                        <span
                                            class="badge badge-danger">{{\App\Models\Claim::$status[$claim->status]}}</span>
                                    @endif
                                </td>
                                @if(Gate::check('edit claim') || Gate::check('delete claim'))
                                    <td>
                                        <div class="cart-action">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['claim.destroy', $claim->id]]) !!}
                                            @if(Gate::check('show claim'))
                                                <a class="text-warning" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Details')}}" href="{{ route('claim.show',\Illuminate\Support\Facades\Crypt::encrypt($claim->id)) }}"> <i data-feather="eye"></i></a>
                                            @endcan
                                            @if(Gate::check('edit claim'))
                                                <a class="text-success customModal" data-bs-toggle="tooltip" data-size="lg"
                                                   data-bs-original-title="{{__('Edit')}}" href="#"
                                                   data-url="{{ route('claim.edit',$claim->id) }}"
                                                   data-title="{{__('Edit Claim')}}"> <i data-feather="edit"></i></a>
                                            @endcan
                                            @if(Gate::check('delete claim'))
                                                <a class=" text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Detete')}}" href="#"> <i
                                                        data-feather="trash-2"></i></a>
                                            @endcan
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

