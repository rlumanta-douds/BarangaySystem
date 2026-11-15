@extends('layouts.app')

@section('content')
    <h1 class="resident-title" style="font-size: 1.75rem; font-weight: 700; color: #1e293b; margin-bottom: 4px;">Contact the Barangay</h1>
    <p class="resident-muted" style="color: #64748b; margin-bottom: 25px; font-size: 0.9rem;">Send your concern, feedback, or general inquiry directly to the barangay office.</p>

    <!-- Success Message -->
    @if(session('success'))
        <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem;">
            <i class="fa-solid fa-circle-check" style="margin-right: 6px;"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="resident-alert" style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem;">
            <p style="font-weight: 600; margin-bottom: 6px;"><i class="fa-solid fa-triangle-exclamation" style="margin-right: 6px;"></i> Please check the form and correct any errors:</p>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 25px; align-items: start;">
        
        <!-- Contact Information Sidebar -->
        <div style="background: white; padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 16px;">Barangay Hall Info</h3>
            
            <div style="display: flex; gap: 12px; margin-bottom: 14px;">
                <i class="fa-solid fa-location-dot" style="color: #16a34a; font-size: 1.1rem; margin-top: 3px;"></i>
                <div>
                    <strong style="display: block; font-size: 0.85rem; color: #1e293b;">Address</strong>
                    <span style="color: #475569; font-size: 0.88rem;">Barangay Hall, Main Street, Surigao City</span>
                </div>
            </div>

            <div style="display: flex; gap: 12px; margin-bottom: 14px;">
                <i class="fa-solid fa-phone" style="color: #16a34a; font-size: 1.1rem; margin-top: 3px;"></i>
                <div>
                    <strong style="display: block; font-size: 0.85rem; color: #1e293b;">Hotline</strong>
                    <span style="color: #475569; font-size: 0.88rem;">(086) 812-3456 / 0912-345-6789</span>
                </div>
            </div>

            <div style="display: flex; gap: 12px;">
                <i class="fa-solid fa-envelope" style="color: #16a34a; font-size: 1.1rem; margin-top: 3px;"></i>
                <div>
                    <strong style="display: block; font-size: 0.85rem; color: #1e293b;">Email</strong>
                    <span style="color: #475569; font-size: 0.88rem;">contact@barangay.gov.ph</span>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <form class="resident-form" method="POST" action="{{ route('resident.contact.submit') }}" style="background: white; padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            @csrf

            <div style="margin-bottom: 18px;">
                <label for="email" style="display: block; font-weight: 600; font-size: 0.88rem; color: #334155; margin-bottom: 6px;">Your Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; background-color: #f8fafc; color: #1e293b; outline: none;">
            </div>

            <div style="margin-bottom: 18px;">
                <label for="subject" style="display: block; font-weight: 600; font-size: 0.88rem; color: #334155; margin-bottom: 6px;">Subject</label>
                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required placeholder="Enter the subject of your inquiry" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; background-color: #f8fafc; color: #1e293b; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="message" style="display: block; font-weight: 600; font-size: 0.88rem; color: #334155; margin-bottom: 6px;">Message or Concern</label>
                <textarea id="message" name="message" required placeholder="Type your message, complaint, or inquiry here..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; background-color: #f8fafc; color: #1e293b; height: 120px; outline: none; resize: vertical;">{{ old('message') }}</textarea>
            </div>

            <button class="resident-button" type="submit" style="background-color: #16a34a; color: white; border: none; padding: 10px 20px; font-size: 0.9rem; font-weight: 600; border-radius: 8px; cursor: pointer; transition: background-color 0.2s;">
                <i class="fa-solid fa-paper-plane" style="margin-right: 6px;"></i> Send Message
            </button>
        </form>

    </div>
@endsection