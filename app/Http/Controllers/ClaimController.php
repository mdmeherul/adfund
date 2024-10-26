<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\ClaimDocument;
use App\Models\DocumentType;
use App\Models\Insurance;
use App\Models\InsuranceDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ClaimController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage claim')) {
            $claims = Claim::where('parent_id', parentId())->get();
            return view('claim.index', compact('claims'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if (\Auth::user()->can('create claim')) {

            $customer = User::where('parent_id', parentId())->where('type', 'customer')->get()->pluck('name', 'id');
            $customer->prepend(__('Select Customer'), '');

            $claimNumber = $this->claimNumber();
            $status = Claim::$status;
            return view('claim.create', compact('claimNumber', 'customer', 'status'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create claim')) {
            $validator = \Validator::make(
                $request->all(), [
                    'customer' => 'required',
                    'insurance' => 'required',
                    'date' => 'required',
                    'status' => 'required',
                    'reason' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first())->withInput();
            }

            $claim = new Claim();
            $claim->claim_id = $this->claimNumber();
            $claim->customer = $request->customer;
            $claim->insurance = $request->insurance;
            $claim->date = $request->date;
            $claim->status = $request->status;
            $claim->reason = $request->reason;
            $claim->notes = $request->notes;
            $claim->parent_id = parentId();
            $claim->save();

            return redirect()->route('claim.show', Crypt::encrypt($claim->id))->with('success', __('Claim successfully created.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show($ids)
    {
        if (\Auth::user()->can('show claim')) {
            $id = Crypt::decrypt($ids);
            $claim = Claim::find($id);
            $insurance=$claim->insurances;
            return view('claim.show', compact('claim','insurance'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function edit(Claim $claim)
    {
        if (\Auth::user()->can('edit claim')) {

            $customer = User::where('parent_id', parentId())->where('type', 'customer')->get()->pluck('name', 'id');
            $customer->prepend(__('Select Customer'), '');

            $status = Claim::$status;
            return view('claim.edit', compact('customer', 'status','claim'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit claim')) {
            $validator = \Validator::make(
                $request->all(), [
                    'customer' => 'required',
                    'insurance' => 'required',
                    'date' => 'required',
                    'status' => 'required',
                    'reason' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first())->withInput();
            }

            $claim = Claim::find($id);
            $claim->customer = $request->customer;
            $claim->insurance = $request->insurance;
            $claim->date = $request->date;
            $claim->status = $request->status;
            $claim->reason = $request->reason;
            $claim->notes = $request->notes;
            $claim->save();

            return redirect()->route('claim.index')->with('success', __('Claim successfully updated.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy(Claim $claim)
    {
        if (\Auth::user()->can('delete claim')) {
            $id=$claim->id;
            ClaimDocument::where('claim',$id)->delete();
            $claim->delete();
            return redirect()->back()->with('success', 'Claim successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function claimNumber()
    {
        $latestClaim = Claim::where('parent_id', parentId())->latest()->first();
        if ($latestClaim == null) {
            return 1;
        } else {
            return $latestClaim->claim_id + 1;
        }
    }

    public function getInsurance(Request $request)
    {
        $insurances = Insurance::where('customer', $request->customer)->orderBy('id','desc')->get();
        $response=[];
        foreach ($insurances as $insurance) {
            $response[$insurance->id]=insurancePrefix().$insurance->insurance_id;
        }

        return response()->json($response);
    }

    public function documentCreate($claimId)
    {
        $claim=Claim::find($claimId);
        $insurance=Insurance::find($claim->insurance);
        $docTypes=!empty($insurance->policies)?explode(',',$insurance->policies->claim_required_document):[];
        $documentType=DocumentType::whereIn('id',$docTypes)->get()->pluck('title','id');
        $documentType->prepend(__('Select Document'),'');

        $status=Insurance::$docStatus;
        return view('claim.document_create', compact('claimId','status','documentType'));
    }

    public function documentStore(Request $request, $claimId)
    {
        if (\Auth::user()->can('create document')) {
            $validator = \Validator::make(
                $request->all(), [
                    'document_type' => 'required',
                    'document' => 'required',
                    'status' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first())->withInput();
            }

            $document = new ClaimDocument();
            $document->claim = $claimId;
            $document->document_type = $request->document_type;
            $document->status = $request->status;

            if (!empty($request->document)) {
                $documentFilenameWithExt = $request->file('document')->getClientOriginalName();
                $documentFilename = pathinfo($documentFilenameWithExt, PATHINFO_FILENAME);
                $documentExtension = $request->file('document')->getClientOriginalExtension();
                $documentFileName = $documentFilename . '_' . time() . '.' . $documentExtension;
                $directory = storage_path('upload/document');
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }
                $request->file('document')->storeAs('upload/document/', $documentFileName);
                $document->document = $documentFileName;
            }

            $document->save();
            return redirect()->back()->with('success', __('Document successfully added.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function documentDestroy($claimId,$documentId)
    {
        if (\Auth::user()->can('delete document')) {
            $document=ClaimDocument::find($documentId);
            $document->delete();
            return redirect()->back()->with('success', 'Document successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
