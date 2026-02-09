@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content ">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h1 class="title1 ">Active Clients Trades</h1>
                </div>
                <x-danger-alert />
                <x-success-alert />
                <div class="col-12 card shadow p-4 ">
                    <div class="table-responsive" data-example-id="hoverable-table">
                        <table id="ShipTable" class="table table-hover ">
                            <thead>
  <tr>
    <th>Client name</th>
    <th>Plan</th>
    <th>Amount Invested</th>
    <th>Duration</th>
    <th>ROI</th>
    <th>Start Date</th>
    <th>Expiration Date</th>
    <th>Remaining Days</th>
    <th></th>
  </tr>
</thead>

                    <tbody>
@foreach ($plans as $plan)
  @php
    $currency = $plan->puser->currency ?? '$';

    // Remaining days (never show negative)
    $remainingDays = $plan->expire_date
        ? max(0, \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($plan->expire_date), false))
        : null;

    // ROI display (choose the right one for your system)
    // Option A: profit_earned if it exists on the Investment row
    $roiValue = isset($plan->profit_earned) ? $plan->profit_earned : 0;

    // Option B (if your Investment table has "roi" column instead)
    // $roiValue = isset($plan->roi) ? $plan->roi : 0;
  @endphp

  <tr>
    <td>{{ $plan->puser->name ?? 'User deleted' }}</td>

    <td>{{ $plan->uplan->name ?? 'Plan deleted' }}</td>

    <td>{{ $currency }}{{ number_format($plan->amount ?? 0, 2) }}</td>

    {{-- Duration should be inv_duration (e.g. "5 days") --}}
    <td>{{ $plan->inv_duration ?? '-' }}</td>

    {{-- ROI should be ROI amount (profit) or ROI field --}}
    <td>{{ $currency }}{{ number_format($roiValue ?? 0, 2) }}</td>

    <td>{{ \Carbon\Carbon::parse($plan->created_at)->toDayDateTimeString() }}</td>

    <td>
      {{ $plan->expire_date ? \Carbon\Carbon::parse($plan->expire_date)->toDayDateTimeString() : '-' }}
    </td>

    <td>
      @if($remainingDays === null)
        -
      @elseif($remainingDays == 0)
        <span class="badge badge-danger">Expired</span>
      @else
        <span class="badge badge-success">{{ $remainingDays }} day(s)</span>
      @endif
    </td>

    <td>
      @if(!empty($plan->puser))
        <a href="{{ route('user.investments', $plan->puser->id) }}" class="btn btn-sm btn-primary">
         Manage
        </a>
      @endif
    </td>
  </tr>
@endforeach
</tbody>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
