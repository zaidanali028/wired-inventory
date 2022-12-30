<?php

namespace App\Http\Livewire\Admin;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Models\Admin as AdminModel;
use App\Models\Expense as ExpenseModel;
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
    protected $today_expense;
    protected $expense_pct_change;
    protected $total_customers;
    protected $customer_pct_change;
    // protected $stock_out_products;
    protected $product_img_path = 'product_imgs';
    public  $quotes= [
        "Prophet Muhammad" => "To give thanks to Allah is to recognize the blessings He has bestowed upon you.",
        "Imam Ali" => "The best of deeds are those that are consistent, even if they are few.",
        "Imam al-Ghazali" => "Knowledge is the most powerful weapon a person can possess.",
        "Imam al-Shafi'i" => "Seek knowledge, even if it takes you to China.",
        "Imam Abu Hanifa" => "The best form of worship is to benefit others.",
        "Imam al-Bukhari" => "The best of people are those who bring most benefit to the rest of mankind.",
        "Imam al-Tirmidhi" => "The most beloved of actions to Allah are those that are consistent, even if they are few.",
        "Albert Einstein" => "Imagination is more important than knowledge.",
        "Neil Armstrong" => "That's one small step for a man, one giant leap for mankind.",
        "William Shakespeare" => "To be, or not to be, that is the question.",
        "Mark Twain" => "Good friends, good books, and a sleepy conscience: this is the ideal life.",
        "Mahatma Gandhi" => "Be the change that you wish to see in the world.",
        "Steve Jobs" => "Your work is going to fill a large part of your life, and the only way to be truly satisfied is to do what you believe is great work. And the only way to do great work is to love what you do. If you haven't found it yet, keep looking. Don't settle. As with all matters of the heart, you'll know when you find it.",
        "Henry Ford" => "Whether you think you can, or you think you can't--you're right.",
        "John F. Kennedy" => "Ask not what your country can do for you--ask what you can do for your country.",
        "Nelson Mandela" => "Education is the most powerful weapon which you can use to change the world.",
        "Aristotle" => "Pleasure in the job puts perfection in the work.",
        "Plato" => "At the touch of love everyone becomes a poet.",
        "Marie Curie" => "Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less.",
        "Leo Tolstoy" => "Everyone thinks of changing the world, but no one thinks of changing himself.",
        "Ralph Waldo Emerson" => "To be yourself in a world that is constantly trying to make you something else is the greatest accomplishment.",
        "Thomas Edison" => "I have not failed. I've just found 10,000 ways that won't work.",
        "Abraham Lincoln" => "Nearly all men can stand adversity, but if you want to test a man's character, give him power.",
        "Eleanor Roosevelt" => "No one can make you feel inferior without your consent.",
        "Confucius" => "The man who asks a question is a fool for a minute, the man who does not ask is a fool for life.",
        "Carl Sagan" => "Somewhere, something incredible is waiting to be known.",
        "Frederick Douglass" => "It is easier to build strong children than to repair broken men.",
        "Vincent van Gogh" => "I dream my painting and then I paint my dream.",
        "John D. Rockefeller" => "I do not think that there is any other quality so essential to success of any kind as the quality of perseverance. It overcomes almost everything, even nature.",
        "Henry David Thoreau" => "Go confidently in the direction of your dreams. Live the life you have imagined.",
        "Warren Buffet" => "The most important investment you can make is in yourself.",
  "Richard Branson" => "Screw it, let's do it.",
  "Jeff Bezos" => "The most dangerous phrase in the language is, 'We've always done it this way.'",
  "Tim Cook" => "Innovation distinguishes between a leader and a follower.",
  "Bill Gates" => "Success is a lousy teacher. It seduces smart people into thinking they can't lose.",
  "Steve Jobs" => "Your work is going to fill a large part of your life, and the only way to be truly satisfied is to do what you believe is great work. And the only way to do great work is to love what you do.",
  "Larry Page" => "Innovation is the one thing that can't be copied.",
  "Ariana Huffington" => "Fearlessness is like a muscle. I know from my own life that the more I exercise it, the more natural it becomes to not let my fears run me.",
  "Sam Walton" => "The secret of successful retailing is to give your customers what they want. And really, if you think about it from your point of view as a customer, you want everything: a wide assortment of good-quality merchandise; the lowest possible prices; guaranteed satisfaction with what you buy.",
  "Charles Schwab" => "The biggest enemy of success is insecurity.",
  "John D. Rockefeller" => "The ability to deal with people is as purchasable a commodity as sugar or coffee.",
  "J.P. Morgan" => "I don't want a lawyer to tell me what I cannot do. I hire him to tell me how to do what I want to do.",
  "Andrew Carnegie" => "Concentration is my motto -- first honesty, then industry, then concentration.",
  "Henry Ford" => "Thinking is the hardest work there is, which is probably the reason why so few engage in it.",
  "J.K. Rowling" => "Hardship often prepares an ordinary person for an extraordinary destiny.",
  "Sara Blakely" => "Don't be intimidated by what you don't know. That can be your greatest strength and ensure that you do things differently from everyone else.",
  "Trevor Noah" => "Success is not a destination, it is a journey.",
  "Drew Houston" => "Don't worry about being successful but work toward being significant and the success will naturally follow.",
  "Tony Hsieh" => "Chase the vision, not the money, the money will end up following you.",
  "Daymond John" => "I’ve learned that it doesn’t matter how many times you failed. You only have to be right once. I tried to sell powdered milk. I was an idiot lots of times, and I learned from them all.",
  "Barbara Corcoran" => "The difference between successful people and really successful people is that really"


    ];
public $random_bg=[1,2,3,4,5,6,7,8,9,10,11,12,13,14];
    // public function getWeather()
    // {
    //     // // Set the API endpoint and your API key
    //     // $apiEndpoint = 'https://api.openweathermap.org/data/2.5/weather';
    //     // $apiKey = env('API_KEY');

    //     // // Set the location for which you want to get the weather data
    //     // $latitude = 37.7749;
    //     // $longitude = -122.4194;

    //     // // Create a new Guzzle HTTP client
    //     $client = new Client();

    //     try {
    //         $response = $client->get('https://geoip.maxmind.com/geoip/v2.1/city/me', [
    //             'query' => [
    //                 'api_key' => env('MAXMIND_API_KEY'),
    //             ],
    //         ]);

    //         $location = json_decode($response->getBody(), true);

    //         $latitude = $location['location']['latitude'];
    //         $longitude = $location['location']['longitude'];


    //     //     // Make a request to the API endpoint using the GET method
    //     //     $response = $client->request('GET', $apiEndpoint, [
    //     //         'query' => [
    //     //             'lat' => $latitude,
    //     //             'lon' => $longitude,
    //     //             'appid' => $apiKey,
    //     //         ],
    //     //     ]);

    //     //     // Get the response body as a JSON object
    //     //     $weatherData = json_decode($response->getBody());

    //     //     // Use the weather data as needed
    //     //     // For example, you can access the current temperature like this:
    //     //     $temperature = $weatherData->main->temp;

    //         // Return the weather data to the view
    //         // return view('weather', ['weatherData' => $weatherData]);
    //     } catch (GuzzleException $e) {
    //         // Handle any errors that occurred during the request
    //         // return view('error', ['error' => $e->getMessage()]);
    //     }
    // }


    public function get_order_monthly_rate_diff($column_name)
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

    public function get_expense_monthly_rate_diff($column_name)
    {
        // this function aids in getting percentage difference between
        // this month and last month
        $startOfLastMonth = Carbon::now()->subMonths(1)->startOfMonth()->toDateTimeString();
        $endOfLastMonth = Carbon::now()->subMonths(1)->endOfMonth()->toDateTimeString();

        $startOfThisMonth = Carbon::now()->startOfMonth()->toDateTimeString();
        $endOfThisMonth = Carbon::now()->endOfMonth()->toDateTimeString();

        $lastMonthRecord = ExpenseModel::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->sum($column_name);
        $thisMonthRecord = ExpenseModel::whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])->sum($column_name);

        $rate_pct = $lastMonthRecord != 0 ? ($thisMonthRecord / $lastMonthRecord) * 100 : 0;
       $rate_pct = number_format($rate_pct, 2);
       return $this->number_to_kmb($rate_pct);

    }

    public function get_customers_data(){
        $startOfLastMonth = Carbon::now()->subMonths(1)->startOfMonth()->toDateTimeString();
        $endOfLastMonth = Carbon::now()->subMonths(1)->endOfMonth()->toDateTimeString();

        $startOfThisMonth = Carbon::now()->startOfMonth()->toDateTimeString();
        $endOfThisMonth = Carbon::now()->endOfMonth()->toDateTimeString();

        $lastMonthRecord = CustomersModel::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $thisMonthRecord = CustomersModel::whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])->count();
        return [$this->number_to_kmb(($thisMonthRecord)),$this->number_to_kmb($lastMonthRecord)];

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
    public function get_annual_record($column)
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
        $this-> paginate_val+=20;
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
        $this_mnth_customers=$this->get_customers_data()[0];
        $last_mnth_customers=$this->get_customers_data()[1];
        $quote=(object) $this->quotes;
        $random_key = array_rand($this->quotes);
        $random_item = $quote->$random_key;




        $this->today_expense =$this->number_to_kmb (ExpenseModel::where('expense_date', date('d/m/Y'))->sum('amount'));
        $this->expense_pct_change=$this->get_expense_monthly_rate_diff('amount');

        // these attributes will be re-requested for more than once
        // by the client and as a result,it must be gotten anytime a user hits
        // the backend inorder to prevent nulltype error
        $this->monthly_sell_records = $this->get_annual_record('total');
        $this->today_sell = $this->number_to_kmb(OrdersModel::where('order_date', date('d/m/Y'))->sum('total'));
        $this->sell_pct_change = $this->get_order_monthly_rate_diff('total');


        $this->today_due =$this->number_to_kmb (OrdersModel::where('order_date', date('d/m/Y'))->sum('due'));
        $this->due_pct_change = $this->get_order_monthly_rate_diff('due');

        $this->monthly_income_records =$this->get_annual_record('pay');
        $this->today_income =$this->number_to_kmb( OrdersModel::where('order_date', date('d/m/Y'))->sum('pay'));
        $this->income_pct_change = $this->get_order_monthly_rate_diff('pay');

        $this->total_customers = $this->number_to_kmb(CustomersModel::count());
        $this->customer_pct_change = $this->get_monthly_customer_RateDiff();

        $this->categories = CategoriesModel::where(['status' => 1])->latest()->get()->toArray();

        $stock_out_products = $this->get_stock_count();
        // dd(strVal($random_bg));


        $this->admin_details = AdminModel::where('email', Auth::guard('admin')->user()->email)->first()->toArray();

        return view('livewire.admin.dash-board-wired', [
            // 'random_bg'=>$random_bg,
            'this_mnth_customers'=>$this_mnth_customers,
            'last_mnth_customers'=>$last_mnth_customers,
            'random_key'=>$random_key,
            'random_item'=>$random_item,
            'admin_details' => $this->admin_details,
            'today_sell' => $this->today_sell,
            'today_income' => $this->today_income,
            'today_due' => $this->today_due,
            'today_expense'=>$this->today_expense,
            'expense_pct_change'=>$this->expense_pct_change,
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
