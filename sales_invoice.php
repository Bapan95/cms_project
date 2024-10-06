<?php
$this->load->view('layout/header');
$user_session = $this->session->userdata('userRole');
?>
<style>
    table,
    tr,
    td,
    th {
        border: 1px solid #ccc;
        padding: 8px;
    }

    table {
        width: 100%;
        font-size: 16px;
    }

    @media screen and (max-width: 768px) {
        table {
            font-size: 10px;
        }
    }
</style>
<?php
function convertAmountToWords($amount)
{
    $words = array(
        '',
        'one',
        'two',
        'three',
        'four',
        'five',
        'six',
        'seven',
        'eight',
        'nine',
        'ten',
        'eleven',
        'twelve',
        'thirteen',
        'fourteen',
        'fifteen',
        'sixteen',
        'seventeen',
        'eighteen',
        'nineteen',
        'twenty',
        'twenty-one',
        'twenty-two',
        'twenty-three',
        'twenty-four',
        'twenty-five',
        'twenty-six',
        'twenty-seven',
        'twenty-eight',
        'twenty-nine',
        'thirty',
        'thirty-one',
        'thirty-two',
        'thirty-three',
        'thirty-four',
        'thirty-five',
        'thirty-six',
        'thirty-seven',
        'thirty-eight',
        'thirty-nine',
        'forty',
        'forty-one',
        'forty-two',
        'forty-three',
        'forty-four',
        'forty-five',
        'forty-six',
        'forty-seven',
        'forty-eight',
        'forty-nine',
        'fifty',
        'fifty-one',
        'fifty-two',
        'fifty-three',
        'fifty-four',
        'fifty-five',
        'fifty-six',
        'fifty-seven',
        'fifty-eight',
        'fifty-nine',
        'sixty',
        'sixty-one',
        'sixty-two',
        'sixty-three',
        'sixty-four',
        'sixty-five',
        'sixty-six',
        'sixty-seven',
        'sixty-eight',
        'sixty-nine',
        'seventy',
        'seventy-one',
        'seventy-two',
        'seventy-three',
        'seventy-four',
        'seventy-five',
        'seventy-six',
        'seventy-seven',
        'seventy-eight',
        'seventy-nine',
        'eighty',
        'eighty-one',
        'eighty-two',
        'eighty-three',
        'eighty-four',
        'eighty-five',
        'eighty-six',
        'eighty-seven',
        'eighty-eight',
        'eighty-nine',
        'ninety',
        'ninety-one',
        'ninety-two',
        'ninety-three',
        'ninety-four',
        'ninety-five',
        'ninety-six',
        'ninety-seven',
        'ninety-eight',
        'ninety-nine'
    );

    // Handling negative numbers
    if ($amount < 0) {
        return "negative " . convertAmountToWords(abs($amount));
    }

    // Split the amount into integer and fractional parts
    $integerPart = floor($amount);
    $fractionPart = $amount - $integerPart;

    $wordsString = "";

    // Convert the integer part into words
    if ($integerPart < 100) {
        $wordsString .= $words[$integerPart];
    } elseif ($integerPart < 1000) {
        $tens = floor($integerPart / 100);
        $remainder = $integerPart % 100;
        $wordsString .= $words[$tens] . ' hundred ' . convertAmountToWords($remainder);
    } elseif ($integerPart < 1000000) {
        $thousands = floor($integerPart / 1000);
        $remainder = $integerPart % 1000;
        $wordsString .= convertAmountToWords($thousands) . ' thousand ' . convertAmountToWords($remainder);
    } elseif ($integerPart < 1000000000) {
        $millions = floor($integerPart / 1000000);
        $remainder = $integerPart % 1000000;
        $wordsString .= convertAmountToWords($millions) . ' million ' . convertAmountToWords($remainder);
    } elseif ($integerPart < 1000000000000) {
        $billions = floor($integerPart / 1000000000);
        $remainder = $integerPart % 1000000000;
        $wordsString .= convertAmountToWords($billions) . ' billion ' . convertAmountToWords($remainder);
    }

    // Convert the fractional part into words
    if ($fractionPart > 0) {
        $wordsString .= " point ";
        $fractionWords = "";
        $fractionPart *= 100; // Consider only two decimal places
        $fractionPart = (int)$fractionPart; // Convert to integer
        if ($fractionPart < 100) {
            $fractionWords .= $words[$fractionPart];
        } elseif ($fractionPart < 1000) {
            $tens = floor($fractionPart / 100);
            $remainder = $fractionPart % 100;
            $fractionWords .= $words[$tens] . ' hundred ' . $words[$remainder];
        }
        $wordsString .= $fractionWords;
    }

    return $wordsString;
}
?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content" style="overflow-x: auto;">
        <button id="download-pdf" class="btn btn-primary" style="margin-left: 971px;
    margin-bottom: 5px;">Download PDF</button>
        <!-- Default box -->
        <!---Top Section Start-->
        <div class="box box-default" id="invoice">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <table style="width: 100%;" id="invoiceTable_1">
                            <tr>
                                <td colspan="13" style="text-align: center; font-size: 24px; font-weight: bold;">
                                    GST BILLING INVOICE
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" style="text-align: center;">
                                    <strong>Company/Seller Name (<?php if (isset($country->name)) {
                                                                        echo $country->name;
                                                                    } ?>)</strong>
                                </td>
                                <td colspan="6" style="text-align: right;">
                                    <strong>Invoice No: <?php if (isset($customer[0]['reference_no'])) {
                                                            echo $customer[0]['reference_no'];
                                                        } ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    Address:
                                    <?php if (isset($country->street)) {
                                        echo $country->street;
                                    } ?>, <?php if (isset($country->city_name)) {
                                                echo $country->city_name;
                                            } ?> <br>
                                    <?php if (isset($country->country_name)) {
                                        echo $country->country_name;
                                    } ?>, <?php if (isset($country->zip_code)) {
                                                echo $country->zip_code;
                                            } ?>
                                </td>
                                <td colspan="6">
                                    Phone No: <?php if (isset($country->phone)) {
                                                    echo $country->phone;
                                                } ?> <br>
                                    Email ID: <?php if (isset($country->email)) {
                                                    echo $country->email;
                                                } ?> <br>
                                    GSTIN: <?php if (isset($country->gstin)) {
                                                echo $country->gstin;
                                            } ?> <br>
                                    State: <?php if (isset($country->state_name)) {
                                                echo $country->state_name;
                                            } ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <strong>Bill To:</strong> <br>
                                    Name: <?php if (isset($customer[0]['name'])) {
                                                echo $customer[0]['name'];
                                            } ?> <br>
                                    Address: <?php if (isset($customer[0]['customer_street'])) {
                                                    echo $customer[0]['customer_street'];
                                                } ?>, <?php if (isset($customer[0]['city'])) {
                                                            echo $customer[0]['city'];
                                                        } ?>, <?php if (isset($customer[0]['zip_code'])) {
                                                                    echo $customer[0]['zip_code'];
                                                                } ?>, <?php if (isset($customer[0]['country'])) {
                                                                            echo $customer[0]['country'];
                                                                        } ?>
                                </td>
                                <td colspan="6">
                                    <strong>Shipping To:</strong> <br>
                                    <?php echo $quotation_order[0]->shipping_address ?>, <?php if (isset($shipping[0]['shipping_street']) && ($shipping[0]['shipping_street'] != '')) {
                                                                                                echo $shipping[0]['shipping_street'] . ',';
                                                                                            } ?> <?php if (isset($shipping[0]['shipping_city']) && ($shipping[0]['shipping_city'] != '')) {
                                                                                                        echo $shipping[0]['shipping_city']  . ',';
                                                                                                    } ?> <?php if (isset($shipping[0]['shipping_zipcode']) && ($shipping[0]['shipping_zipcode'] != '')) {
                                                                                                                echo $shipping[0]['shipping_zipcode']  . ',';
                                                                                                            } ?> <?php if (isset($shipping[0]['shipping_country']) && ($shipping[0]['shipping_country'] != '')) {
                                                                                                                        echo $shipping[0]['shipping_country']  . ',';
                                                                                                                    } ?> <?php if (isset($shipping[0]['shipping_state']) && ($shipping[0]['shipping_state'] != '')) {
                                                                                                                                echo $shipping[0]['shipping_state'];
                                                                                                                            } ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    Contact No: <?php if (isset($customer[0]['phone'])) {
                                                    echo $customer[0]['phone'];
                                                } ?> <br>
                                    GSTIN No: <?php if (isset($customer[0]['gstin'])) {
                                                    echo $customer[0]['gstin'];
                                                } ?> <br>
                                    State: <?php if (isset($customer[0]['state'])) {
                                                echo $customer[0]['state'];
                                            } ?>
                                </td>
                                <td colspan="6">
                                    <strong>Date: <?php if (isset($customer[0]['date'])) {
                                                        echo $customer[0]['date'];
                                                    } ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="13" style="height: 25px;"></td>
                            </tr>
                            <tr>
                                <td colspan="13" style="background: #009fb5; color: #fff; text-align: center; font-size: 34px; font-weight: 700;">
                                    Tax Invoice
                                </td>
                            </tr>
                            <tr>
                                <td colspan="13" style="height: 25px;"></td>
                            </tr>
                            <tr>
                                <td rowspan="2">Sl No</td>
                                <td rowspan="2">Item Name</td>
                                <td rowspan="2" style="width: 15%;">HSN/SAC Code</td>
                                <td rowspan="2">QTY</td>
                                <td rowspan="2">Price/Unit</td>
                                <td rowspan="2">Disc</td>
                                <td rowspan="2" style="width: 15%;">Taxable Value</td>
                                <td colspan="2">CGST</td>
                                <td colspan="2">SGST</td>
                                <td colspan="2">IGST</td>
                            </tr>
                            <tr>
                                <td>Rate</td>
                                <td>Amount</td>
                                <td>Rate</td>
                                <td>Amount</td>
                                <td>Rate</td>
                                <td>Amount</td>
                            </tr>
                            <?php
                            $qty_total = 0;
                            $sub_total = 0;
                            $total_price = 0;
                            $total_discount = 0;
                            $total_taxablevalue = 0;
                            $total_sgst = 0;
                            $total_cgst = 0;
                            $total_igst = 0;
                            $i = 0;
                            foreach ($quotation_order as $value) {
                                $net = $value->qty * $value->rate;
                                $dis = $net * $value->discount / 100;
                                $taxable_value = $net - $dis;
                                $total_discount += $dis;
                                $total_price += $net;
                                $total_taxablevalue += $taxable_value;
                                $sgst = $cgst = $igst = $sgst_percent = $cgst_percent = $igst_percent = 0;
                                if ($country->state_id == $s->state_id) {
                                    $sgst = $cgst = $value->tax_amount / 2;
                                    $sgst_percent = $cgst_percent = $value->tax_value / 2;
                                } else {
                                    $igst = $value->tax_amount;
                                    $igst_percent = $value->tax_value;
                                }
                                $item_gst = $sgst + $cgst + $igst;
                                $total_sgst += $sgst;
                                $total_cgst += $cgst;
                                $total_igst += $igst;
                                $total_item_gst = $total_cgst + $total_sgst + $total_igst;
                                $qty_total += $value->qty;
                                $sub_total += $value->amount;
                            ?>
                                <tr>
                                    <td style="width: 30px; padding: 0 5px;"><?php echo $i + 1; ?></td>
                                    <td style="width: 30%;" class="text-left"><?php if (isset($value->item_name)) {
                                                                                    echo $value->item_name;
                                                                                } ?></td>
                                    <td class="text-right"><?php if (isset($value->hsn_code)) {
                                                                echo $value->hsn_code;
                                                            } ?></td>
                                    <td class="text-right"><?php if (isset($value->qty)) {
                                                                echo $value->qty;
                                                            } ?></td>
                                    <td class="text-right"><?php if (isset($value->rate)) {
                                                                echo $value->rate;
                                                            } ?></td>
                                    <td class="text-right"><?php if (isset($dis)) {
                                                                echo $dis;
                                                            } ?> (<?php if (isset($value->discount)) {
                                                                        echo $value->discount;
                                                                    } ?>%)</td>
                                    <td class="text-right"><?php if (isset($taxable_value)) {
                                                                echo $taxable_value;
                                                            } ?></td>
                                    <td class="text-right"><?php echo $cgst_percent; ?>%</td>
                                    <td class="text-right"><?php echo $cgst; ?></td>
                                    <td class="text-right"><?php echo $sgst_percent; ?>%</td>
                                    <td class="text-right"><?php echo $sgst; ?></td>
                                    <td class="text-right"><?php echo $igst_percent; ?>%</td>
                                    <td class="text-right"><?php echo $igst; ?></td>
                                </tr>
                            <?php $i++;
                            } ?>
                            <tr>
                                <td colspan="3" style="text-align: right; font-weight: bold;"><?php echo $this->lang->line('lbl_quotation_total'); ?></td>
                                <td class="text-right"><?php echo isset($qty_total) ? $qty_total : '0'; ?></td>
                                <td></td>
                                <td class="text-right"><?php echo isset($total_discount) ? $total_discount : '0'; ?></td>
                                <td class="text-right"><?php echo isset($total_taxablevalue) ? $total_taxablevalue : '0'; ?></td>
                                <td></td>
                                <td class="text-right"><?php echo isset($total_cgst) ? $total_cgst : '0'; ?></td>
                                <td></td>
                                <td class="text-right"><?php echo isset($total_sgst) ? $total_sgst : '0'; ?></td>
                                <td></td>
                                <td class="text-right"><?php echo isset($total_igst) ? $total_igst : '0'; ?></td>
                                <!-- <td class="text-right"><?php //if (isset($value->amount)) {
                                                            //echo $value->amount;
                                                            // }
                                                            ?></td> -->
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: center; font-weight: bold;">Invoice Value(in word)</td>
                                <td colspan="8" style="text-align: right; font-weight: bold;">Total Amount</td>
                                <td colspan="2" class="text-right"><?php echo isset($value->total_amount) ? $value->total_amount : '0'; ?></td>
                            </tr>

                            <tr>
                                <td colspan="3" rowspan="3" style="text-align: center;"><?php echo convertAmountToWords(isset($value->total_amount) ? $value->total_amount : 0); ?> only.</td>
                            </tr>
                            <!-- <tr>
                                <td colspan="2">SGST</td>
                                <td class="text-right"><?php //echo isset($total_sgst) ? $total_sgst : '0';
                                                        ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2">CGST</td>
                                <td class="text-right"><?php //echo isset($total_cgst) ? $total_cgst : '0';
                                                        ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2">IGST</td>
                                <td class="text-right"><?php //echo isset($total_igst) ? $total_igst : '0';
                                                        ?></td>
                                <td></td>
                                <td></td>
                            </tr> -->
                            <?php $total_payment_amount = 0;
                            foreach ($payment as $payments) {
                                $total_payment_amount = $total_payment_amount + $payments->amount;
                            } ?>
                            <tr>
                                <td colspan="7">Received</td>
                                <td colspan="6" style="height: 25px; text-align:right;"><?php echo isset($total_payment_amount) ? $total_payment_amount : '0'; ?></td>
                            </tr>
                            <tr>
                                <td colspan="7">Balance</td>
                                <td colspan="6" style="height: 25px; text-align:right;"><?php echo isset($payments->outstanding) ? $payments->outstanding : $value->total_amount; ?></td>
                            </tr>
                        </table>
                        <!-- <tr>
                                <td> -->
                        <table id="invoiceTable_2">
                            <tr>
                                <td>
                                    <p><strong>Bank Details:</strong><br>

                                        Account Name: <?php if (isset($country->bank_account_name)) {
                                                            echo $country->bank_account_name;
                                                        } ?><br>
                                        Account Number: <?php if (isset($country->bank_account_number)) {
                                                            echo $country->bank_account_number;
                                                        } ?><br>
                                        IFSC Code: <?php if (isset($country->bank_ifsc_code)) {
                                                        echo $country->bank_ifsc_code;
                                                    } ?><br>
                                        Bank Name: <?php if (isset($country->bank_name)) {
                                                        echo $country->bank_name;
                                                    } ?>
                                    </p>
                                </td>
                                <td style="text-align: right;">
                                    <p><strong>Authorized Signature:</strong><br>

                                        For <?php if (isset($country->name)) {
                                                echo $country->name;
                                            } ?>
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <!-- </td>
                            </tr> -->
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
<!-- Include jsPDF and autoTable scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>

<script>
    document.getElementById('download-pdf').addEventListener('click', function() {
        const {
            jsPDF
        } = window.jspdf;

        // Create a jsPDF instance with A4 portrait size
        const doc = new jsPDF({
            orientation: 'portrait', // Portrait orientation
            unit: 'mm', // Units in millimeters
            format: 'a4' // A4 size
        });

        const bottomMargin = 10; // Define the bottom margin
        // Add the first section of your table with invoice details
        doc.autoTable({
            startY: 20, // Start the first table 20mm from the top of the page
            html: '#invoiceTable_1',
            // theme: 'grid',
            styles: {
                fontSize: 10,
                cellPadding: 2,
                valign: 'middle', // Vertical alignment
                halign: 'center', // Horizontal alignment
                font: 'Source Sans Pro', // Corrected font definition
            },
            columnStyles: {
                0: {
                    cellWidth: 'auto'
                }, // Let columns adjust width automatically
                1: {
                    cellWidth: 'auto'
                },
                2: {
                    cellWidth: 'auto'
                },
                3: {
                    cellWidth: 'auto'
                },
                4: {
                    cellWidth: 'auto'
                },
                5: {
                    cellWidth: 'auto'
                },
                6: {
                    cellWidth: 'auto'
                },
                7: {
                    cellWidth: 'auto'
                },
                8: {
                    cellWidth: 'auto'
                },
                9: {
                    cellWidth: 'auto'
                }
            },
            headStyles: {
                fontSize: 10, // Adjust header font size
                fillColor: [52, 58, 64], // Dark background color for headers
                textColor: [255, 255, 255] // White text color for headers
            },
            bodyStyles: {
                fontSize: 8, // Smaller font for body cells
            },
            theme: 'striped', // Use striped theme for alternate row colors
            showHead: 'everyPage', // Show the header on every page
            margin: {
                top: 20
            }, // Add margin to avoid text overlap
            pageBreak: 'auto',
            didParseCell: function(data) {
                // Increase font size and boldness for the first row (header)
                if (data.row.index === 0) {
                    data.cell.styles.fontSize = 20; // Larger font size for the header row
                    data.cell.styles.fontStyle = 'bold'; // Bold text for the header row
                }
                if (data.row.index === 1) {
                    data.cell.styles.fontSize = 10; // Larger font size for the header row
                    data.cell.styles.fontStyle = 'bold'; // Bold text for the header row
                }
                if (data.row.index === 2) {
                    data.cell.styles.fontSize = 10; // Custom font size for the entire row at index 4
                    const equalWidth = doc.internal.pageSize.getWidth() / data.table.columns.length - 20; // Adjust based on margins
                    data.cell.styles.cellWidth = equalWidth;
                    if (data.column.index === 0) {
                        data.cell.styles.halign = 'left'; // Left align this specific cell in column 0
                    } else {
                        data.cell.styles.halign = 'left'; // Right align this specific cell in column 1
                    }
                }
                if (data.row.index === 6) {
                    data.cell.styles.fontSize = 20; // Larger font size for the header row
                    data.cell.styles.fontStyle = 'bold'; // Bold text for the header row
                    data.cell.styles.fillColor = [0, 0, 255]; // Blue background for the header row
                    data.cell.styles.textColor = [255, 255, 255]; // White text color
                }
                if (data.row.index === 3) {
                    data.cell.styles.fontSize = 10; // Custom font size for the entire row at index 4
                    const equalWidth = doc.internal.pageSize.getWidth() / data.table.columns.length - 20; // Adjust based on margins
                    data.cell.styles.cellWidth = equalWidth;
                    if (data.column.index === 0) {
                        data.cell.styles.halign = 'left'; // Left align this specific cell in column 0
                    } else {
                        data.cell.styles.halign = 'left'; // Right align this specific cell in column 1
                    }
                }
                if (data.row.index === 4) {
                    data.cell.styles.fontSize = 10; // Custom font size for the entire row at index 4
                    if (data.column.index === 0) {
                        data.cell.styles.halign = 'left'; // Left align this specific cell in column 0
                    } else {
                        data.cell.styles.halign = 'right'; // Right align this specific cell in column 1
                    }
                }
            }
        });
        // Add the second table
        doc.autoTable({
            startY: doc.lastAutoTable.finalY,
            html: '#invoiceTable_2',
            theme: 'grid',
            styles: {
                fontSize: 10,
                cellPadding: 2,
                valign: 'middle',
                halign: 'center',
                font: 'Source Sans Pro', // Corrected font definition
                fontStyle: 'normal', // Add this if the font isn't bold
            },
            columnStyles: {
                0: {
                    halign: 'left', // First column left-aligned
                    cellWidth: 'auto',
                },
                1: {
                    halign: 'right', // Second column right-aligned
                    cellWidth: 'auto',
                    valign: 'bottom', // Align the content slightly lower
                },
            },
            theme: 'striped', // Use striped theme for alternate row colors
            showHead: 'everyPage', // Show the header on every page
            margin: {
                top: 20
            }, // Add margin to avoid text overlap
            pageBreak: 'auto',
        });

        // Check if the content exceeds the page height
        if (doc.lastAutoTable.finalY > (doc.internal.pageSize.getHeight() - bottomMargin)) {
            // You can handle overflow here, e.g., add a new page, shrink content, etc.
            console.log("Content exceeds one page");
        }

        // Save the PDF
        doc.save('invoice.pdf');
    });
</script>

<?php
$this->load->view('layout/footer');
$this->load->view('layout/validation');
?>