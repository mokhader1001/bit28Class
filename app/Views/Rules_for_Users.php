<?php
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('defaultFont', 'DejaVu Sans');
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

$policy = $policy ?? [
    'max_books' => 0,
    'max_days_allowed' => 0,
    'penalty_per_day' => 0,
    'suspend_after_days' => 0,
    'minor_damage_fee' => 0,
    'major_damage_fee' => 0,
    'lost_book_fee' => 0,
];

// Use your actual logo path
$logoUrl = base_url('public/uploads/logo.png');

$html = '
<html>
<head>
  <style>
    @page {
      margin: 0.75in;
      @top-center {
        content: "Dhobale Library - Borrowing Policy";
        font-size: 10px;
        color: #666;
      }
      @bottom-center {
        content: "Page " counter(page) " of " counter(pages);
        font-size: 10px;
        color: #666;
      }
    }
    
    body {
      font-family: "DejaVu Sans", Arial, sans-serif;
      line-height: 1.6;
      color: #2c3e50;
      margin: 0;
      padding: 0;
      font-size: 11pt;
    }
    
    .document-header {
      text-align: center;
      margin-bottom: 30px;
      padding-bottom: 20px;
      border-bottom: 3px solid #3498db;
    }
    
    .logo {
      margin-bottom: 15px;
    }
    
    .logo img {
      width: 120px;
      height: auto;
    }
    
    .document-title {
      font-size: 24pt;
      font-weight: bold;
      color: #2c3e50;
      margin: 15px 0 10px 0;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    
    .document-subtitle {
      font-size: 14pt;
      color: #7f8c8d;
      margin-bottom: 20px;
      font-style: italic;
    }
    
    .section-header {
      font-size: 16pt;
      font-weight: bold;
      color: #2c3e50;
      margin: 25px 0 15px 0;
      padding: 10px 0;
      border-bottom: 2px solid #ecf0f1;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    
    .welcome-section {
      background-color: #f8f9fa;
      padding: 20px;
      border-left: 4px solid #3498db;
      margin: 20px 0;
      border-radius: 0 5px 5px 0;
    }
    
    .policy-intro {
      font-size: 12pt;
      line-height: 1.7;
      text-align: justify;
      margin-bottom: 15px;
      color: #34495e;
    }
    
    .policy-summary {
      background-color: #fff;
      padding: 20px;
      border: 1px solid #bdc3c7;
      border-radius: 5px;
      margin: 20px 0;
    }
    
    .policy-item {
      margin: 12px 0;
      padding: 8px 0;
      border-bottom: 1px dotted #ecf0f1;
    }
    
    .policy-item:last-child {
      border-bottom: none;
    }
    
    .policy-label {
      font-weight: bold;
      color: #2c3e50;
      display: inline-block;
      min-width: 120px;
    }
    
    .policy-value {
      color: #e74c3c;
      font-weight: bold;
      font-size: 12pt;
    }
    
    .policy-table {
      width: 100%;
      margin: 25px 0;
      border-collapse: collapse;
      font-size: 11pt;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      border-radius: 8px;
      overflow: hidden;
    }
    
    .policy-table thead {
      background: linear-gradient(135deg, #3498db, #2980b9);
      color: white;
    }
    
    .policy-table th {
      padding: 15px 12px;
      text-align: center;
      font-weight: bold;
      font-size: 12pt;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    
    .policy-table tbody tr:nth-child(even) {
      background-color: #f8f9fa;
    }
    
    .policy-table tbody tr:nth-child(odd) {
      background-color: #ffffff;
    }
    
    .policy-table tbody tr:hover {
      background-color: #e3f2fd;
    }
    
    .policy-table td {
      padding: 12px;
      border-bottom: 1px solid #ecf0f1;
      vertical-align: middle;
    }
    
    .policy-table td:first-child {
      font-weight: 600;
      color: #2c3e50;
      background-color: #f1f2f6;
      border-right: 2px solid #3498db;
    }
    
    .policy-table td:last-child {
      text-align: center;
      font-weight: bold;
      color: #e74c3c;
      font-size: 11.5pt;
    }
    
    .highlight-box {
      background: linear-gradient(135deg, #fff3cd, #ffeaa7);
      border: 1px solid #ffc107;
      border-radius: 5px;
      padding: 15px;
      margin: 20px 0;
      border-left: 4px solid #f39c12;
    }
    
    .highlight-title {
      font-weight: bold;
      color: #856404;
      margin-bottom: 8px;
      font-size: 12pt;
    }
    
    .footer-note {
      margin-top: 30px;
      padding: 15px;
      background-color: #ecf0f1;
      border-radius: 5px;
      font-size: 10pt;
      color: #7f8c8d;
      text-align: center;
      font-style: italic;
    }
    
    .divider {
      height: 2px;
      background: linear-gradient(to right, #3498db, #2980b9, #3498db);
      margin: 25px 0;
      border-radius: 1px;
    }
    
    .emphasis {
      color: #e74c3c;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="document-header">
  <div class="logo">
    <img src="' . $logoUrl . '" alt="Dhobale Library Logo">
  </div>
  <h1 class="document-title">Dhobale Library</h1>
  <div class="document-subtitle">Official Borrowing Policy & Guidelines</div>
</div>

<div class="welcome-section">
  <h2 class="section-header">Welcome to Our Library Community</h2>
  <p class="policy-intro">
    We are honored to welcome you as a valued member of the Dhobale Library community. Our mission is to provide exceptional library services while maintaining an organized, fair, and accessible lending system for all patrons. This document outlines our comprehensive borrowing policies, return procedures, and guidelines for book care and maintenance.
  </p>
  <p class="policy-intro">
    Please take a moment to carefully review all policies outlined in this document. Your understanding and compliance with these guidelines ensures that our library resources remain available and well-maintained for the entire community.
  </p>
</div>
<br> <br> <br> <br>

<div class="divider"></div>

<h2 class="section-header">Policy Overview & Quick Reference</h2>

<div class="policy-summary">
  <div class="policy-item">
    <span class="policy-label">Borrowing Limit:</span> 
    Users may borrow up to <span class="policy-value">' . $policy['max_books'] . ' books</span> simultaneously
  </div>
  
  <div class="policy-item">
    <span class="policy-label">Loan Period:</span> 
    Each book may be borrowed for a maximum of <span class="policy-value">' . $policy['max_days_allowed'] . ' days</span>
  </div>
  
  <div class="policy-item">
    <span class="policy-label">Late Return Fee:</span> 
    <span class="policy-value">$' . number_format($policy['penalty_per_day'], 2) . '</span> per day for overdue materials
  </div>
  
  <div class="policy-item">
    <span class="policy-label">Suspension Trigger:</span> 
    Account privileges suspended after <span class="policy-value">' . $policy['suspend_after_days'] . ' days</span> overdue
  </div>
</div>

<div class="highlight-box">
  <div class="highlight-title">⚠️ Important Notice</div>
  <p style="margin: 0; color: #856404;">
    All damage and loss fees are calculated as a percentage of the book\'s current market value. 
    Please handle all library materials with care to avoid additional charges.
  </p>
</div>

<h2 class="section-header">Detailed Policy Schedule</h2>

<table class="policy-table">
  <thead>
    <tr>
      <th style="width: 60%;">Policy Description</th>
      <th style="width: 40%;">Applicable Rule</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Maximum Books Per User</td>
      <td>' . $policy['max_books'] . ' books</td>
    </tr>
    <tr>
      <td>Maximum Loan Period Per Book</td>
      <td>' . $policy['max_days_allowed'] . ' days</td>
    </tr>
    <tr>
      <td>Daily Late Return Penalty</td>
      <td>$' . number_format($policy['penalty_per_day'], 2) . ' per day</td>
    </tr>
    <tr>
      <td>Account Suspension Threshold</td>
      <td>After ' . $policy['suspend_after_days'] . ' days overdue</td>
    </tr>
    <tr>
      <td>Minor Damage Fee</td>
      <td>' . $policy['minor_damage_fee'] . '% of book value</td>
    </tr>
    <tr>
      <td>Major Damage Fee</td>
      <td>' . $policy['major_damage_fee'] . '% of book value</td>
    </tr>
    <tr>
      <td>Lost Book Replacement Fee</td>
      <td>' . $policy['lost_book_fee'] . '% of book value</td>
    </tr>
  </tbody>
</table>

<div class="divider"></div>

<h2 class="section-header">Terms & Conditions</h2>

<div style="background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0;">
  <p style="margin: 0 0 10px 0; font-size: 11pt; line-height: 1.6;">
    <strong>1. Borrowing Responsibilities:</strong> By borrowing materials from Dhobale Library, you agree to return them in the same condition and within the specified timeframe.
  </p>
  
  <p style="margin: 10px 0; font-size: 11pt; line-height: 1.6;">
    <strong>2. Renewal Policy:</strong> Books may be renewed if no other patron has placed a hold on the item and your account is in good standing.
  </p>
  
  <p style="margin: 10px 0; font-size: 11pt; line-height: 1.6;">
    <strong>3. Damage Assessment:</strong> Library staff will assess damage levels and apply appropriate fees based on the established percentage rates.
  </p>
  
  <p style="margin: 10px 0 0 0; font-size: 11pt; line-height: 1.6;">
    <strong>4. Account Suspension:</strong> Suspended accounts cannot borrow materials until all overdue items are returned and outstanding fees are paid.
  </p>
</div>

<div class="footer-note">
  This document serves as your official guide to Dhobale Library policies. 
  For questions or clarifications, please contact our library staff.
  <br><br>
  <strong>Document Generated:</strong> ' . date('F j, Y \a\t g:i A') . '
</div>

</body>
</html>
';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('library_policy.pdf', ['Attachment' => false]); // show in browser
exit();