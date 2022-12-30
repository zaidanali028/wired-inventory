<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Hello there [{{!empty($admin_details['name'])?$admin_details['name']:''}}], Welcome to {{ !empty($shop_details)?$shop_details['shop_name']:''}}</h3>
                <h6 class="font-weight-normal mb-0">All systems are running smoothly!  <span class="text-primary"> do have a great day!</span></h6>
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                        <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                          @php
                          $date_today=date('d/m/y')
                          @endphp
                            <i class="mdi mdi-calendar"></i> ({{  $date_today }})
                        </button>



         @php
         $current_page=!empty($current_page)?$current_page:'';
         @endphp
                        @if($current_page=='orders')
         <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
            <a wire:click.prevent="get_orders('1','3')" class="dropdown-item" >January - March</a>
            <a wire:click.prevent="get_orders('3','5')" class="dropdown-item" href="#">March - May</a>
            <a  wire:click.prevent="get_orders('5','7')" class="dropdown-item" href="#">May - July</a>
            <a wire:click.prevent="get_orders('7','9')" class="dropdown-item" href="#">July - September</a>
            <a wire:click.prevent="get_orders('9','11')" class="dropdown-item" href="#">September - November</a>
            <a wire:click.prevent="get_orders('11','12')" class="dropdown-item" href="#">November - December</a>
        </div>
         @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
