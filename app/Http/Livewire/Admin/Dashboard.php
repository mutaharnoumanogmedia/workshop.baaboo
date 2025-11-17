<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Course;
use App\Models\VideoViewer;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $header = 'Dashboard';
    public $totalUsers;
    public $totalCourses;
    public $totalVideoViews;
    public $rateOfChangeLastMonthPercentageOfUsers;

    public function mount()
    {
        $this->totalUsers =  User::nonadmin()->count();
        $this->totalCourses = Course::count();
        $this->totalVideoViews = VideoViewer::count();

        // Calculate the rate of change for users
        $this->rateOfChangeLastMonthPercentageOfUsers = $this->calculateRateOfChange();
    }

    private function calculateRateOfChange()
    {
        $lastMonth = Carbon::now()->subDays(32);
        $currentMonth = Carbon::now();
        $lastMonthValue = User::nonadmin()
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        $currentValue =  User::nonadmin()->whereMonth('created_at', '=',  $currentMonth->month)
            ->whereYear('created_at', '=', $currentMonth->year)
            ->count();

        if ($lastMonthValue == 0) {
            return $currentValue > 0 ? 100 : 0;
        }

        return round((($currentValue - $lastMonthValue) / $lastMonthValue) * 100, 2);
    }



    public function render()
    {

        return view('admin.dashboard')->layout("layouts.admin-layout");
    }
}
