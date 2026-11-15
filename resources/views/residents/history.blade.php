@extends('layouts.app')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h1 class="resident-title" style="font-size: 1.75rem; font-weight: 700; color: #1e293b; margin-bottom: 4px;">My Request History</h1>
            <p class="resident-muted" style="color: #64748b; font-size: 0.9rem;">View your certificate request records and monitor their processing status.</p>
        </div>
        <a href="{{ route('resident.certificates') }}" style="background-color: #16a34a; color: white; padding: 10px 16px; border-radius: 8px; font-size: 0.88rem; font-weight: 600; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: background-color 0.2s;">
            <i class="fa-solid fa-plus" style="margin-right: 6px;"></i> Request a Certificate
        </a>
    </div>

    <div class="resident-table-wrap" style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
        <table class="resident-table" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
            <thead>
                <tr style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; color: #475569;">
                    <th style="padding: 14px 18px; font-weight: 600;">Reference ID</th>
                    <th style="padding: 14px 18px; font-weight: 600;">Certificate Type</th>
                    <th style="padding: 14px 18px; font-weight: 600;">Purpose</th>
                    <th style="padding: 14px 18px; font-weight: 600;">Date Requested</th>
                    <th style="padding: 14px 18px; font-weight: 600;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests ?? [] as $req)
                    <tr style="border-bottom: 1px solid #f1f5f9; color: #334155;">
                        <td style="padding: 14px 18px; font-weight: 600; color: #16a34a;">#REQ-{{ $req->id ?? '000' }}</td>
                        <td style="padding: 14px 18px; font-weight: 600;">{{ $req->certificate_type ?? 'Barangay Clearance' }}</td>
                        <td style="padding: 14px 18px; color: #64748b;">{{ Str::limit($req->purpose ?? 'N/A', 40) }}</td>
                        <td style="padding: 14px 18px;">{{ $req->created_at ? $req->created_at->format('M d, Y') : 'Oct 16, 2026' }}</td>
                        <td style="padding: 14px 18px;">
                            @php
                                $status = $req->status ?? 'Pending';
                                $bg = '#fef3c7'; $color = '#b45309';
                                if($status == 'Approved' || $status == 'Released') { $bg = '#dcfce7'; $color = '#15803d'; }
                                elseif($status == 'Rejected') { $bg = '#fee2e2'; $color = '#991b1b'; }
                            @endphp
                            <span style="background-color: {{ $bg }}; color: {{ $color }}; font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 12px;">
                                {{ $status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #64748b; padding: 35px; font-size: 0.9rem;">
                            <div style="margin-bottom: 8px;"><i class="fa-solid fa-folder-open" style="font-size: 1.5rem; color: #cbd5e1;"></i></div>
                            No certificate requests found in your history yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection