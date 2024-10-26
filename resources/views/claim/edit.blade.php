{{Form::model($claim, array('route' => array('claim.update', $claim->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('claim_id',__('Claim Number'),array('class'=>'form-label'))}}
            <div class="input-group">
                <span class="input-group-text ">
                  {{claimPrefix()}}
                </span>
                {{Form::text('claim_id',$claim->claim_id,array('class'=>'form-control','placeholder'=>__('Enter claim number')))}}
            </div>
        </div>
        <div class="form-group  col-md-6 col-lg-6">
            {{Form::label('date',__('Date'),array('class'=>'form-label'))}}
            {{Form::date('date',date('Y-m-d'),array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{ Form::label('customer', __('Customer'),['class'=>'form-label']) }}
            {!! Form::select('customer', $customer, null,array('class' => 'form-control basic-select','required'=>'required')) !!}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            <input type="hidden" id="edit_insurance" value="{{$claim->insurance}}">
            {{Form::label('insurance',__('Insurance'),array('class'=>'form-label'))}}
            <div class="insurance_div">
                <select class="form-control hidesearch insurance" id="insurance"
                        name="insurance">
                    <option value="">{{__('Select Insurance')}}</option>
                </select>
            </div>
        </div>

        <div class="form-group  col-md-6 col-lg-6">
            {{Form::label('reason',__('Reason'),array('class'=>'form-label'))}}
            {{Form::textarea('reason',null,array('class'=>'form-control','placeholder'=>__('Enter reason'),'rows'=>2,'required'=>'required'))}}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{ Form::label('status', __('Status'),['class'=>'form-label']) }}
            {!! Form::select('status', $status, null,array('class' => 'form-control hidesearch','required'=>'required')) !!}
        </div>
        <div class="form-group  col-md-12">
            {{Form::label('notes',__('Note'),array('class'=>'form-label'))}}
            {{Form::textarea('notes',null,array('class'=>'form-control','placeholder'=>__('Enter notes'),'rows'=>2))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    {{Form::submit(__('Update'),array('class'=>'btn btn-primary btn-rounded'))}}
</div>
{{ Form::close() }}


<script>
    $('#customer').on('change', function () {
        "use strict";
        var customer = $(this).val();
        var url = '{{ route("customer.insurance") }}';
        $.ajax({
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                customer: customer,
            },
            type: 'POST',
            success: function (data) {
                var edit_insurance= $('#edit_insurance').val();
                $('.insurance').empty();
                var insurance = `<select class="form-control hidesearch insurance" id="insurance" name="insurance"></select>`;
                $('.insurance_div').html(insurance);
                $.each(data, function (key, value) {
                    if(key==edit_insurance){
                        $('.insurance').append('<option selected value="' + key + '">' + value +'</option>');
                    }else{
                        $('.insurance').append('<option value="' + key + '">' + value + '</option>');
                    }
                });
                $('.hidesearch').select2({
                    minimumResultsForSearch: -1
                });
            },
        });
    });
    $('#customer').trigger('change');
</script>
