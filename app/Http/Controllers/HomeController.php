<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use App\Models\Custom;
use App\Models\Insurance;
use App\Models\InsurancePayment;
use App\Models\NoticeBoard;
use App\Models\PackageTransaction;
use App\Models\Policy;
use App\Models\Subscription;
use App\Models\Support;
use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        if (\Auth::check()) {
            if (\Auth::user()->type == 'super admin') {
                $result['totalOrganization'] = User::where('type', 'owner')->count();
                $result['totalSubscription'] = Subscription::count();
                $result['totalTransaction'] = PackageTransaction::count();
                $result['totalIncome'] = PackageTransaction::sum('amount');
                $result['totalNote'] = NoticeBoard::where('parent_id', parentId())->count();
                $result['totalContact'] = Contact::where('parent_id', parentId())->count();

                $result['organizationByMonth'] = $this->organizationByMonth();
                $result['paymentByMonth'] = $this->paymentByMonth();

                return view('dashboard.super_admin', compact('result'));
            } else {
                $result['totalCustomer'] = User::where('parent_id', parentId())->where('type','customer')->count();
                $result['totalAgent'] = User::where('parent_id', parentId())->where('type','agent')->count();
                $result['totalPolicy'] = Policy::where('parent_id', parentId())->count();
                $result['totalInsurance'] =Insurance::where('parent_id', parentId())->count();
                $result['paymentOverview'] = $this->paymentOverview();
                $result['settings']=settings();


                return view('dashboard.index', compact('result'));
            }
        } else {
            if (!file_exists(setup())) {
                header('location:install');
                die;
            } else {
                $landingPage=getSettingsValByName('landing_page');
                if($landingPage=='on'){
                    $subscriptions=Subscription::get();
                    return view('layouts.landing',compact('subscriptions'));
                }else{
                    return redirect()->route('login');
                }
            }

        }

    }

    public function organizationByMonth()
    {
        $start = strtotime(date('Y-01'));
        $end = strtotime(date('Y-12'));

        $currentdate = $start;

        $organization = [];
        while ($currentdate <= $end) {
            $organization['label'][] = date('M-Y', $currentdate);

            $month = date('m', $currentdate);
            $year = date('Y', $currentdate);
            $organization['data'][] = User::where('type', 'owner')->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
            $currentdate = strtotime('+1 month', $currentdate);
        }


        return $organization;

    }

    public function paymentByMonth()
    {
        $start = strtotime(date('Y-01'));
        $end = strtotime(date('Y-12'));

        $currentdate = $start;

        $payment = [];
        while ($currentdate <= $end) {
            $payment['label'][] = date('M-Y', $currentdate);

            $month = date('m', $currentdate);
            $year = date('Y', $currentdate);
            $payment['data'][] = PackageTransaction::whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('amount');
            $currentdate = strtotime('+1 month', $currentdate);
        }

        return $payment;

    }

    public function paymentOverview()
    {
        $start = strtotime(date('Y-01'));
        $end = strtotime(date('Y-12'));

        $currentdate = $start;

        $payment = [];
        while ($currentdate <= $end) {
            $payment['label'][] = date('M-Y', $currentdate);

            $month = date('m', $currentdate);
            $year = date('Y', $currentdate);
            $payment['payment'][] = InsurancePayment::where('parent_id', parentId())->whereMonth('payment_date', $month)->whereYear('payment_date', $year)->sum('amount');
            $currentdate = strtotime('+1 month', $currentdate);
        }

        return $payment;

    }

}
