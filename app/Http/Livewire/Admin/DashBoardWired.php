<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin as AdminModel;
use App\Models\Customers as CustomersModel;
use App\Models\Orders as OrdersModel;
use App\Models\Products as ProductsModel;
use App\Models\Categories as CategoriesModel;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;



class DashBoardWired extends Component
{
    use WithPagination;
    use WithFileUploads;



    protected $admin_details;
    protected $categories;
    protected $today_sell;
    protected $paginationTheme = 'bootstrap';
    protected $paginate_val=20;



    protected $monthly_sell_records = [];
    protected $monthly_income_records = [];
    protected $sell_pct_change;
    protected $income_pct_change;
    protected $due_pct_change;
    protected $today_income;
    protected $today_due;
    protected $total_customers;
    protected $customer_pct_change;
    // protected $stock_out_products;
    protected $product_img_path = 'product_imgs';




    public function get_monthly_rate_diff($column_name)
    {
        // this function aids in getting percentage difference between
        // this month and last month
        $startOfLastMonth = Carbon::now()->subMonths(1)->startOfMonth()->toDateTimeString();
        $endOfLastMonth = Carbon::now()->subMonths(1)->endOfMonth()->toDateTimeString();

        $startOfThisMonth = Carbon::now()->startOfMonth()->toDateTimeString();
        $endOfThisMonth = Carbon::now()->endOfMonth()->toDateTimeString();

        $lastMonthRecord = OrdersModel::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->sum($column_name);
        $thisMonthRecord = OrdersModel::whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])->sum($column_name);

        $rate_pct = $lastMonthRecord != 0 ? ($thisMonthRecord / $lastMonthRecord) * 100 : 0;
       $rate_pct = number_format($rate_pct, 2);
       return $this->number_to_kmb($rate_pct);

    }
    public function get_monthly_customer_RateDiff()
    {
        $CurrentCustomerCount = CustomersModel::whereMonth('created_at', '=', now()->month)->count();
        $LastCustomerCount = CustomersModel::whereMonth('created_at', '=', now()->subMonth()->month)->count();
        $rate_pct = $LastCustomerCount != 0 ? $CurrentCustomerCount / $LastCustomerCount * 100 : 0;
        return $this->number_to_kmb($rate_pct = number_format($rate_pct, 2));

    }
    function number_to_kmb($number) {
        $number=intVal($number);
        if ($number >= 1000000000) {
            return round($number / 1000000000, 1) . "B";
        } elseif ($number >= 1000000) {
            return round($number / 1000000, 1) . "M";
        } elseif ($number >= 1000) {
            return round($number / 1000, 1) . "K";
        } else {
            return $number;
        }
    }
    public function get_monthly_record($column)
    {
        // A FUNCTION FOR GETTING MONTHLY RECORD FROM THE
        // ORDERS TABLE BASED ON A SPECIFIC MONTH(1-12)
        $final_monthy_records = [];
        // AN ARRAY TO BE RETURNED(IN THE FUTURE)
        for ($i = 0; $i < 12; $i++) {
            // LOOPING FROM 0-11
            $month = $i + 1;
            // ADDING ONE INORDER TO GET A SPECIFIC MONTH,0 IS
            // EVIDENTTLY NOT A MONTH
            $start_date = Carbon::now()->startOfMonth()->month(intVal($month))->toDateTimeString();
            // GET THE FIRST DATE OF A SPECIFIC MONTH

            $end_date = Carbon::now()->endOfMonth()->month(intVal($month))->toDateTimeString();
            // GET THE LAST DATE OF A SPECIFIC MONTH

            $final_monthy_records[$month] = OrdersModel::whereBetween(
                'created_at', [$start_date, $end_date]
            )->sum($column);
            // STORE CURRENTLY GOTTEN MOHTH'S DATA INTO THE DEFINE
            // ARRAY[ $final_monthy_records] AND USING ITS NUMERIC VALUE AS KEY
        }

        // RETURN ARRAY
        return $final_monthy_records;

    }
    public function load_more(){
        $this-> paginate_val+=1;
       $this->dispatchBrowserEvent('refreshCharts');
    }

    public function get_stock_count()
    {
        return ProductsModel::where('product_quantity', '<=', 1)->latest()->paginate($this-> paginate_val);
    }

    public function mount()
    {
    //   works just one (not ideal for this use case cus client may
    // resend a request aghain to this endpoint during pagintion)




    }

    public function render()
    {
        // these attributes will be re-requested for more than once
        // by the client and as a result,it must be gotten anytime a user hits
        // the backend inorder to prevent nulltype error
        $this->monthly_sell_records = $this->get_monthly_record('total');
        $this->today_sell = $this->number_to_kmb(OrdersModel::where('order_date', date('d/m/Y'))->sum('total'));
        $this->sell_pct_change = $this->get_monthly_rate_diff('total');


        $this->today_due =$this->number_to_kmb (OrdersModel::where('order_date', date('d/m/Y'))->sum('due'));
        $this->due_pct_change = $this->get_monthly_rate_diff('due');

        $this->monthly_income_records =$this->get_monthly_record('pay');
        $this->today_income =$this->number_to_kmb( OrdersModel::where('order_date', date('d/m/Y'))->sum('pay'));
        $this->income_pct_change = $this->get_monthly_rate_diff('pay');
// $this->total_customers  is fake,yoo!
        $this->total_customers = $this->number_to_kmb(CustomersModel::count()+43546576);
        $this->customer_pct_change = $this->get_monthly_customer_RateDiff();

        $this->categories = CategoriesModel::where(['status' => 1])->latest()->get()->toArray();

        $stock_out_products = $this->get_stock_count();



        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();

        return view('livewire.admin.dash-board-wired', [
            'admin_details' => $this->admin_details,
            'today_sell' => $this->today_sell,
            'today_income' => $this->today_income,
            'today_due' => $this->today_due,
            'sell_pct_change' => $this->sell_pct_change,
            'income_pct_change' => $this->income_pct_change,
            'due_pct_change' => $this->due_pct_change,
            'customer_pct_change' => $this->customer_pct_change,
            'total_customers' => $this->total_customers,
            'monthly_sell_records' => $this->monthly_sell_records,
            'monthly_income_records' => $this->monthly_income_records,
            'stock_out_products' => $stock_out_products,
            'product_img_path'=>$this->product_img_path,


        ]);
    }
}
