<div id="divToPrint">


    {{-- print styling --}}
    <style>
        @page {
            {{--  size: 58mm 200mm;  --}}
            {{--  size: 58mm 250mm;  --}}
            margin: 0;
          }
        @media print {
            *{
                font-family: monospace;
            }

            .top-print,
            .cpm-det,
            .divToPrint,
            .dev,
            table {
                font-size: 11px;
            }

            .company-name {
                font-size: 15px;
            }

            .rest {
                font-size: 12px;
            }
            .re-no{
                padding-right: 35px;
            }

        }
    </style>


    <div style="display: inline" class="top-print">
        <div class="">{{ date('d/m/y h:i:s') }}</div>
        <div style="float: right" class="re-no">Receipt#: {{ !empty($orderRecord_) ? $orderRecord_['id'] : '' }}
        </div>
    </div><br>
    

    <div style="text-align: center" class="company-name text-capitalize">
        {{ !empty($orderRecord_) ? $orderRecord_['company_details']['shop_name'] : '' }}</div>
    <div style="text-align: center; font-size:11px" class="">
        {{ !empty($orderRecord_) ? $orderRecord_['company_details']['shop_location'] : '' }}</div>
    <div style="text-align: center" class="rest">
        {{ !empty($orderRecord_) ? $orderRecord_['company_details']['shop_number'] : '' }}</div>

    <div class="table-responsive">
        <table class="table align-items-center table-flush" style="width: 100%; font-size: 11px;">
            <thead class="thead-light">
                <tr style="text-align: left;">
                    <th style="width: 40%">Item</th>
                    <th style="width: 10%">Qty</th>
                    <th style="width: 20%">Unit Price</th>
                    <th style="width: 30%">Total</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($orderRecord_))
                @foreach ($orderRecord_['get_order_detail'] as $orderRecord_item)
                <tr>
                    <td>{{ $orderRecord_item['product_details']['product_name'] }}</td>
                    <td>{{ isset($orderRecord_item['product_quantity']) ?
                        $orderRecord_item['product_quantity'] . 'x' : '' }}
                    </td>
                    <td>{{ isset($orderRecord_item['product_price']) ?
                        $orderRecord_item['product_price'] : '' }}
                    </td>
                    <td>{{ isset($orderRecord_item['sub_total']) ? $orderRecord_item['sub_total'] :
                        '' }}
                    </td>


                </tr>
                @endforeach

                @endif
            </tbody>
        </table>
    </div>
    <hr>

    <div class="rest">
        <div style="float: right">Subtotal: GH₵
            {{ !empty($orderRecord_) ? $orderRecord_['sub_total'] : '' }}</div><br>
        <div style="float: right">Tax: GH₵ {{ !empty($orderRecord_) ? $orderRecord_['vat'] : '' }}
        </div><br>
        <div style="float: right">Discount: GH₵
            {{ !empty($orderRecord_) ? $orderRecord_['discount'] : '' }}</div><br>
        <div style="float: right">RECEIPT TOTAL: GH₵
            {{ !empty($orderRecord_) ? number_format($orderRecord_['total'], 2) : '' }}</div><br>
        <br>
        <div>Amount Tendered: GH₵ {{ !empty($orderRecord_) ? $orderRecord_['pay'] : '' }}</div>
        <div>Change: GH₵ {{ !empty($orderRecord_) ? $orderRecord_['due'] : '' }}</div><br>
    </div>
    <hr>

    <div style="text-align: center;" class="rest"><b>

            Thank You And We hope To See You Again Soon</b></div>
    <br>

    <div style="text-align: center;" class="rest"><b>ITEMS BOUGHT IN GOOD CONDITIONS
            AINT RETURNABLE!!</b>
        <div style="text-align: center;"><b>#SystemsMadeByZaid</b>
            0240040834

        </div>


    </div>


</div>

<button id="print-me" class="text-white btn btn-sm bg-primary">
    <i class="mdi mdi-printer-alert" style="font-size:20px"></i>
</button>
