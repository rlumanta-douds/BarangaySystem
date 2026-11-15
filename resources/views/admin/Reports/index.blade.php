@extends('layouts.app')

@section('content')
<style>
    .container-fluid { padding: 20px 30px; }
    .page-header { margin-bottom: 25px; }
    .page-header h1 { font-size: 1.75rem; font-weight: 700; color: #1e293b; margin: 0; }
    .page-header p { color: #64748b; font-size: 0.9rem; margin-top: 4px; margin-bottom: 0; }

    /* Report Section Cards */
    .report-card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .report-info h4 { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0 0 5px 0; display: flex; align-items: center; gap: 10px; }
    .report-info p { color: #64748b; font-size: 0.85rem; margin: 0; }
    
    .badge-total { background-color: #dcfce7; color: #15803d; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
    
    .btn-pdf { background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; padding: 8px 14px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; transition: background 0.2s; }
    .btn-pdf:hover { background-color: #e2e8f0; }

    /* Table Breakdown */
    .table-container { background: white; border-radius: 12px; border: 1px solid #e2e8f0; margin-top: 30px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .table-header-title { padding: 20px; font-size: 1.1rem; font-weight: 700; color: #1e293b; border-bottom: 1px solid #e2e8f0; }
    table { width: 100%; border-collapse: collapse; text-align: left; }
    th { background-color: #f8fafc; padding: 14px 20px; font-size: 0.8rem; text-transform: uppercase; color: #64748b; font-weight: 600; border-bottom: 1px solid #e2e8f0; }
    td { padding: 16px 20px; font-size: 0.9rem; color: #334155; border-bottom: 1px solid #f1f5f9; }
    tr:last-child td { border-bottom: none; }
</style>

<div class="container-fluid">
    <div class="page-header">
        <h1>Reports & System Analytics</h1>
        <p>Generate, review, and export operational summaries for your barangay records.</p>
    </div>

    <!-- Certificate Report Card -->
    <div class="report-card">
        <div class="report-info">
            <h4>Certificates & Clearances <span class="badge-total">{{ $totalCertificates }} Total</span></h4>
            <p>Breakdown of requested, pending, and approved barangay clearances and indigencies.</p>
        </div>
        <button onclick="window.print()" class="btn-pdf"><i class="fa-solid fa-file-pdf"></i> Print / PDF</button>
    </div>

    <!-- Blotter Report Card -->
    <div class="report-card">
        <div class="report-info">
            <h4>Blotters & Incidents <span class="badge-total">{{ $totalBlotters }} Total</span></h4>
            <p>Summary of reported incidents, active disputes, and resolved mediation cases.</p>
        </div>
        <button onclick="window.print()" class="btn-pdf"><i class="fa-solid fa-file-pdf"></i> Print / PDF</button>
    </div>

    <!-- Announcements Report Card -->
    <div class="report-card">
        <div class="report-info">
            <h4>Public Notices & Updates <span class="badge-total">{{ $totalAnnouncements }} Total</span></h4>
            <p>Log of published community updates, advisories, and public notifications.</p>
        </div>
        <button onclick="window.print()" class="btn-pdf"><i class="fa-solid fa-file-pdf"></i> Print / PDF</button>
    </div>

    <!-- System Report Summary Breakdown Table -->
    <div class="table-container">
        <div class="table-header-title">System Report Summary Breakdown</div>
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Report Category</th>
                        <th>Total Recorded</th>
                        <th>Active / Approved</th>
                        <th>Pending / Ongoing</th>
                        <th>Last Updated</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Residents Demographic</strong></td>
                        <td>{{ $totalResidents }}</td>
                        <td><span style="color: #16a34a; font-weight: 600;">Active</span></td>
                        <td>0</td>
                        <td>Today</td>
                    </tr>
                    <tr>
                        <td><strong>Certificates & Permits</strong></td>
                        <td>{{ $totalCertificates }}</td>
                        <td>{{ $approvedCertificates }} Approved</td>
                        <td>{{ $pendingCertificates }} Pending</td>
                        <td>Today</td>
                    </tr>
                    <tr>
                        <td><strong>Blotter Cases</strong></td>
                        <td>{{ $totalBlotters }}</td>
                        <td>{{ $resolvedBlotters }} Resolved</td>
                        <td>{{ $ongoingBlotters }} Ongoing</td>
                        <td>Today</td>
                    </tr>
                    <tr>
                        <td><strong>Announcements</strong></td>
                        <td>{{ $totalAnnouncements }}</td>
                        <td>{{ $totalAnnouncements }} Published</td>
                        <td>0 Drafts</td>
                        <td>Today</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection