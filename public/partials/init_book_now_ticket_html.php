<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       venues-booking-engine
 * @since      1.0.0
 *
 * @package    Venues_Booking_Engine
 * @subpackage Venues_Booking_Engine/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<style>
    /**
 * Invoice Style Sheet
 *
 * Contains styling specific to the view invoice page.
 *
 * @project   WHMCS
 * @version   1.0
 * @author    WHMCS Limited <development@whmcs.com>
 * @copyright Copyright (c) WHMCS Limited 2005-2015
 * @license   http://www.whmcs.com/license/
 * @link      http://www.whmcs.com/
 */

    body {
        background-color: #efefef;
    }

    /* Container Responsive Behaviour */

    @media print {

        html,
        body {
            width: 750px;
        }
    }

    .invoice-container {
        margin: 15px auto;
        padding: 70px;
        max-width: 850px;
        background-color: #fff;
        border: 1px solid #ccc;
        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        -o-border-radius: 6px;
        border-radius: 6px;
    }

    @media (max-width: 895px) {
        .invoice-container {
            margin: 15px;
        }
    }

    @media (max-width: 767px) {
        .invoice-container {
            padding: 45px 45px 70px 45px;
        }
    }

    @media (max-width: 499px) {
        .invoice-header {
            text-align: center;
        }
    }

    .invoice-col {
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }

    @media (min-width: 500px) {
        .invoice-col {
            float: left;
            width: 50%;
        }

        .invoice-col.right {
            float: right;
            text-align: right;
        }
    }

    /* Invoice Status Formatting */

    .invoice-container .invoice-status {
        margin: 20px 0 0 0;
        text-transform: uppercase;
        font-size: 24px;
        font-weight: bold;
    }

    /* Invoice Status Colors */

    .draft {
        color: #888;
    }

    .unpaid {
        color: #cc0000;
    }

    .paid {
        color: #779500;
    }

    .refunded {
        color: #224488;
    }

    .cancelled {
        color: #888;
    }

    .collections {
        color: #ffcc00;
    }

    /* Payment Button Formatting */

    .invoice-container .payment-btn-container {
        margin-top: 5px;
        text-align: center;
    }

    .invoice-container .payment-btn-container table {
        margin: 0 auto;
    }

    /* Text Formatting */

    .invoice-container .small-text {
        font-size: 0.9em;
    }

    /* Invoice Items Table Formatting */

    .invoice-container td.total-row {
        background-color: #f8f8f8;
    }

    .invoice-container td.no-line {
        border: 0;
    }
</style>

<div class="container-fluid invoice-container">


    <div class="row invoice-header">
        <div class="invoice-col">

            <p><img src="files/logo.png" title="WhoGoHost"></p>
            <h3>Invoice #82641</h3>

        </div>
        <div class="invoice-col text-center">

            <div class="invoice-status">
                <span class="paid">Paid</span>
            </div>


        </div>
    </div>

    <hr>


    <div class="row">
        <div class="invoice-col right">
            <strong>Pay To</strong>
            <address class="small-text">
                Account Name: WhoGoHost Limited<br>
                Account No/Bank: 0114023729 (GTBank)<br>
                Account No/Bank: 1013173318 (Zenith)<br>
                Account No/Bank: 0039691957 (Union)<br>
                TIN: 12001705-0001
            </address>
        </div>
        <div class="invoice-col">
            <strong>Invoiced To</strong>
            <address class="small-text">
                Versaplus Solutions and Services Limited<br> Gbolahan Oshonubi<br>
                Lagos, Lagos<br>
                Lagos, Lagos, 110001<br>
                Nigeria
            </address>
        </div>
    </div>

    <div class="row">
        <div class="invoice-col right">
            <strong>Payment Method</strong><br>
            <span class="small-text">
                Bank Payment Details
            </span>
            <br><br>
        </div>
        <div class="invoice-col">
            <strong>Invoice Date</strong><br>
            <span class="small-text">
                30/09/2015<br><br>
            </span>
        </div>
    </div>

    <br>



    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Invoice Items</strong></h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <td><strong>Description</strong></td>
                            <td width="20%" class="text-center"><strong>Amount</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Aspire (1GB) - versaplusltd.com (30/09/2015 - 29/09/2016) *</td>
                            <td class="text-center">N3,000.00</td>
                        </tr>
                        <tr>
                            <td>Domain Registration - versaplusltd.com - 1 Year/s (30/09/2015 - 29/09/2016) *</td>
                            <td class="text-center">N2,400.00</td>
                        </tr>
                        <tr>
                            <td class="total-row text-right"><strong>Sub Total</strong></td>
                            <td class="total-row text-center">N5,142.86</td>
                        </tr>
                        <tr>
                            <td class="total-row text-right"><strong>5.00% VAT</strong></td>
                            <td class="total-row text-center">N257.14</td>
                        </tr>
                        <tr>
                            <td class="total-row text-right"><strong>Credit</strong></td>
                            <td class="total-row text-center">N0.00</td>
                        </tr>
                        <tr>
                            <td class="total-row text-right"><strong>Total</strong></td>
                            <td class="total-row text-center">N5,400.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <p>* Indicates a taxed item.</p>

    <div class="transactions-container small-text">
        <div class="table-responsive">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <td class="text-center"><strong>Transaction Date</strong></td>
                        <td class="text-center"><strong>Gateway</strong></td>
                        <td class="text-center"><strong>Transaction ID</strong></td>
                        <td class="text-center"><strong>Amount</strong></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">30/09/2015</td>
                        <td class="text-center">Bank Payment Details</td>
                        <td class="text-center">ZEN 2100432</td>
                        <td class="text-center">N5,400.00</td>
                    </tr>
                    <tr>
                        <td class="text-right" colspan="3"><strong>Balance</strong></td>
                        <td class="text-center">N0.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="pull-right btn-group btn-group-sm hidden-print">
        <a href="javascript:window.print()" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
        <a href="https://www.whogohost.com/host/dl.php?type=i&amp;id=82641" class="btn btn-default"><i class="fas fa-download"></i> Download</a>
    </div>


</div>