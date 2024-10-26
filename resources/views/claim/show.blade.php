@extends('layouts.app')
@section('page-title')
    {{claimPrefix().$claim->claim_id}} {{__('Detail')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('claim.index')}}">{{__('Claim')}}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">  {{claimPrefix().$claim->claim_id}} {{__('Detail')}}</a>
        </li>
    </ul>
@endsection
@push('script-page')
    <script>
        $(document).on('click', '.print', function () {
            var printContents = document.getElementById('insurance-print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        });
    </script>
@endpush
@section('card-action-btn')
    <div class="right-breadcrumb">
        <ul>
            @can('create document')
                <a class="btn btn-primary float-end me-2 customModal" href="#" data-size="md"
                   data-url="{{ route('claim.document.create',[$claim->id,$insurance->id]) }}"
                   data-title="{{__('Add Document')}}"> {{__('Add Document')}}</a>
            @endcan
            <a class="btn btn-warning float-end print" href="javascript:void(0);"> {{__('Print')}}</a>
        </ul>
    </div>
@endsection
@section('content')

    <div id="insurance-print">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{claimPrefix().$claim->claim_id}} </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Insurance')}}</h6>
                                    <p class="mb-20">{{insurancePrefix().$insurance->insurance_id}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Claim Date')}}</h6>
                                    <p class="mb-20">{{dateFormat($claim->date)}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Status')}}</h6>
                                    <p class="mb-20">
                                        @if($claim->status=='submitted')
                                            <span
                                                class="badge badge-primary"></span>
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
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Created At')}}</h6>
                                    <p class="mb-20">{{dateFormat($claim->created_at)}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Reason')}}</h6>
                                    <p class="mb-20">{{$claim->reason}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Note')}}</h6>
                                    <p class="mb-20">{{$claim->notes}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-12">
                <div class="card">

                    <div class="card-header">
                        <h4>{{__('Policy Holder Detail')}} </h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Customer ID')}}</h6>
                                    <p class="mb-20">{{!empty($insurance->customers)?customerPrefix().$insurance->customers->customer->customer_id:'-'}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Name')}}</h6>
                                    <p class="mb-20">{{!empty($insurance->customers)?$insurance->customers->name:'-'}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Email')}}</h6>
                                    <p class="mb-20">{{!empty($insurance->customers)?$insurance->customers->email:'-'}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Phone Number')}}</h6>
                                    <p class="mb-20">{{!empty($insurance->customers)?$insurance->customers->phone_number:'-'}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Company')}}</h6>
                                    <p class="mb-20">{{!empty($insurance->customers)?$insurance->customers->customer->company:'-'}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Date of Birth')}}</h6>
                                    <p class="mb-20">{{!empty($insurance->customers)?$insurance->customers->customer->dob:'-'}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Age')}}</h6>
                                    <p class="mb-20">{{!empty($insurance->customers)?$insurance->customers->customer->age:'-'}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Gender')}}</h6>
                                    <p class="mb-20">{{!empty($insurance->customers)?$insurance->customers->customer->gender:'-'}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Marital Status')}}</h6>
                                    <p class="mb-20">{{!empty($insurance->customers)?$insurance->customers->customer->marital_status:'-'}}</p>
                                </div>
                            </div>

                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Blood Group')}}</h6>
                                    <p class="mb-20">{{!empty($insurance->customers)?$insurance->customers->customer->blood_group:'-'}}</p>
                                </div>
                            </div>

                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Height')}}</h6>
                                    <p class="mb-20">{{!empty($insurance->customers)?$insurance->customers->customer->height:'-'}}</p>
                                </div>
                            </div>

                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Weight')}}</h6>
                                    <p class="mb-20">{{!empty($insurance->customers)?$insurance->customers->customer->weight:'-'}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Tax Number')}}</h6>
                                    <p class="mb-20">{{!empty($insurance->customers)?$insurance->customers->customer->tax_number:'-'}}</p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <div class="detail-group">
                                    <h6>{{__('Address')}}</h6>
                                    <p class="mb-20">
                                        {{!empty($insurance->customers)?$insurance->customers->customer->address:'-'}}
                                        <br>
                                        {{!empty($insurance->customers)?$insurance->customers->customer->city:'-'}}
                                        {{!empty($insurance->customers)?$insurance->customers->customer->zip_code:'-'}}
                                        <br>
                                        {{!empty($insurance->customers)?$insurance->customers->customer->state:'-'}}
                                        {{!empty($insurance->customers)?$insurance->customers->customer->country:'-'}}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @if(count($insurance->insureds)>0)
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4> {{__('Insured Detail') }} </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('DOB')}}</th>
                                        <th>{{__('Age')}}</th>
                                        <th>{{__('Gender')}}</th>
                                        <th>{{__('Blood Group')}}</th>
                                        <th>{{__('Height')}}</th>
                                        <th>{{__('Weight')}}</th>
                                        <th>{{__('Relation')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($insurance->insureds as $insureds)

                                        <tr>
                                            <td>{{$insureds->name}}</td>
                                            <td>{{dateFormat($insureds->dob)}}</td>
                                            <td>{{$insureds->age}}</td>
                                            <td>{{$insureds->gender}}</td>
                                            <td>{{$insureds->blood_group}}</td>
                                            <td>{{$insureds->height}}</td>
                                            <td>{{$insureds->weight}}</td>
                                            <td>{{$insureds->relation}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(count($insurance->nominees)>0)
                <div class="col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4> {{__('Nominee Detail') }} </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('DOB')}}</th>
                                        <th>{{__('Relation')}}</th>
                                        <th>{{__('Percentage')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($insurance->nominees as $nominees)

                                        <tr>
                                            <td>{{$nominees->name}}</td>
                                            <td>{{dateFormat($nominees->dob)}}</td>
                                            <td>{{$nominees->relation}}</td>
                                            <td>{{$nominees->percentage}}%</td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(count($claim->documents)>0)
                <div class="col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4> {{__('Document Detail') }} </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{{__('Type')}}</th>
                                        <th>{{__('Document')}}</th>
                                        <th>{{__('Status')}}</th>
                                        @if(Gate::check('delete document'))
                                            <th class="action">{{__('Action')}}</th>
                                        @endcan
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($claim->documents as $document)
                                        <tr>
                                            <td>{{!empty($document->types)?$document->types->title:'-'}}</td>
                                            <td><a href="{{asset('/storage/upload/document/'.$document->document)}}"
                                                   target="_blank">{{!empty($document->types)?$document->types->title:'-'}}</a>
                                            </td>
                                            <td>
                                                {{\App\Models\Insurance::$docStatus[$document->status]}}
                                            </td>
                                            @if(Gate::check('delete document'))
                                                <td class="action">
                                                    <div class="cart-action">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['claim.document.destroy', [$claim->id,$document->id]]]) !!}
                                                        <a class=" text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                           data-bs-original-title="{{__('Detete')}}" href="#"> <i
                                                                data-feather="trash-2"></i></a>

                                                        {!! Form::close() !!}
                                                    </div>
                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(!empty($insurance->agents)>0)
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4> {{__('Agent Detail') }} </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4 col-md-3 col-lg-3">
                                    <div class="detail-group">
                                        <h6>{{__('Agent ID')}}</h6>
                                        <p class="mb-20">{{!empty($insurance->agents)?agentPrefix().$insurance->agents->agent->agent_id:'-'}}</p>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-3 col-lg-3">
                                    <div class="detail-group">
                                        <h6>{{__('Name')}}</h6>
                                        <p class="mb-20">{{!empty($insurance->agents)?$insurance->agents->name:'-'}}</p>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-3 col-lg-3">
                                    <div class="detail-group">
                                        <h6>{{__('Email')}}</h6>
                                        <p class="mb-20">{{!empty($insurance->agents)?$insurance->agents->email:'-'}}</p>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-3 col-lg-3">
                                    <div class="detail-group">
                                        <h6>{{__('Phone Number')}}</h6>
                                        <p class="mb-20">{{!empty($insurance->agents)?$insurance->agents->phone_number:'-'}}</p>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-3 col-lg-3">
                                    <div class="detail-group">
                                        <h6>{{__('Company')}}</h6>
                                        <p class="mb-20">{{!empty($insurance->agents)?$insurance->agents->agent->company:'-'}}</p>
                                    </div>
                                </div>

                                <div class="col-sm-4 col-md-3 col-lg-3">
                                    <div class="detail-group">
                                        <h6>{{__('Address')}}</h6>
                                        <p class="mb-20">
                                            {{!empty($insurance->agents)?$insurance->agents->agent->address:'-'}}
                                            <br>
                                            {{!empty($insurance->agents)?$insurance->agents->agent->city:'-'}}
                                            {{!empty($insurance->agents)?$insurance->agents->agent->zip_code:'-'}}
                                            <br>
                                            {{!empty($insurance->agents)?$insurance->agents->agent->state:'-'}}
                                            {{!empty($insurance->agents)?$insurance->agents->agent->country:'-'}}
                                        </p>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4> {{__('Policy Description')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xxl-12 cdx-xxl-100 mt-10">
                                {!! $insurance->policies->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4> {{__('Policy Terms & Condition')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xxl-12 cdx-xxl-100 mt-10">
                                {!! $insurance->policies->terms_conditions !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

