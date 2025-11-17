 <div>
     <x-slot name="header">
         {{ __('Dashboard') }}
     </x-slot>
     <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6">Welcome to the Dashboard</h1>
     <!-- Card Grid -->
     <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
         <!-- Example Card 1 -->
         <div class="d-card bg-dark">
             <h3 class="text-xl font-semibold text-indigo-600 mb-2">Total Users</h3>
             <p class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</p>

             <p
                 class="text-sm mt-1
             {{ $rateOfChangeLastMonthPercentageOfUsers > 0 ? 'text-green-500' : 'text-red-500' }}
             flex items-center">
                 @if ($rateOfChangeLastMonthPercentageOfUsers > 0)
                     <x-heroicon-s-arrow-up class="w-4 h-4 mr-1" />
                 @else
                     <x-heroicon-s-arrow-down class="w-4 h-4 mr-1" />
                 @endif
                 {{ $rateOfChangeLastMonthPercentageOfUsers }}% since last month
             </p>
         </div>
         <!-- Example Card 2 -->
         <div class="d-card">
             <h3 class="text-xl font-semibold text-indigo-600 mb-2">Total Courses</h3>
             <p class="text-3xl font-bold text-gray-800">{{ $totalCourses }}</p>
             <p class="text-sm text-red-500 mt-1 flex items-center">
                 <x-heroicon-s-arrow-down class="w-4 h-4 mr-1" />
                 -5% since last month
             </p>
         </div>
         <!-- Example Card 3 -->
         <div class="d-card">
             <h3 class="text-xl font-semibold text-indigo-600 mb-2">Total Video Views</h3>
             <p class="text-3xl font-bold text-gray-800">{{ $totalVideoViews }}</p>
             <p class="text-sm text-gray-500 mt-1">
                 Up-to-date count
             </p>
         </div>
     </div>

     <!-- Placeholder content to force scrolling -->
     <div class="mt-12 space-y-4">
         <div class="h-64 bg-white p-6 rounded-xl shadow-md border border-gray-200">
             <h4 class="text-lg font-semibold mb-2 text-gray-800">Recent Activity Log</h4>
             <p class="text-gray-500">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod
                 tempor incididunt ut labore et dolore magna aliqua...</p>
         </div>
         <div class="h-64 bg-white p-6 rounded-xl shadow-md border border-gray-200">
             <h4 class="text-lg font-semibold mb-2 text-gray-800">Performance Metrics</h4>
             <p class="text-gray-500">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                 aliquip ex ea commodo consequat...</p>
         </div>
     </div>
 </div>
