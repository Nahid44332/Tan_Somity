<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>সমিতি ম্যানেজমেন্ট ড্যাশবোর্ড</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 font-sans text-slate-800 relative">

    <!-- Top Navigation -->
    <nav class="bg-blue-600 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold"><i class="fas fa-users mr-2"></i> আমাদের সমিতি</h1>
            <div class="flex items-center space-x-4">
                <!-- Add Member Button -->
                <button onclick="openModal('addMemberModal')" class="bg-blue-800 hover:bg-blue-900 px-4 py-2 rounded shadow transition text-sm font-medium">
                    <i class="fas fa-user-plus mr-1"></i> নতুন মেম্বার
                </button>
                <span class="font-medium ml-4 border-l pl-4 border-blue-400">
                    <i class="fas fa-user-circle text-xl mr-1"></i> এডমিন
                </span>
            </div>
        </div>
    </nav>

    <!-- Main Dashboard Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <h3 class="text-slate-500 text-sm font-semibold mb-1">মোট সদস্য</h3>
                <p class="text-3xl font-bold">২১ জন</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <h3 class="text-slate-500 text-sm font-semibold mb-1">আজকের টার্গেট</h3>
                <p class="text-3xl font-bold">২,১০০ ৳</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                <h3 class="text-slate-500 text-sm font-semibold mb-1">আজকের জমা</h3>
                <p class="text-3xl font-bold text-green-600">১,৫০০ ৳</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                <h3 class="text-slate-500 text-sm font-semibold mb-1">পরবর্তী লটারি</h3>
                <p class="text-3xl font-bold">আর ২ দিন</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Today's Collection Table (Left Side) -->
           <div class="lg:col-span-2 bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
        <h2 class="text-lg font-bold text-slate-700">চলমান ১০ দিনের চাঁদা কালেকশন সাইকেল</h2>
        <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded font-semibold">ফান্ড টার্গেট: ২১,০০০ ৳</span>
    </div>
    <div class="p-0 overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-slate-100 text-slate-600">
                    <th class="py-3 px-4 border">সদস্যের নাম</th>
                    <!-- ১০ দিনের হেডার লুপ -->
                    @for($i = 1; $i <= 10; $i++)
                        <th class="py-3 px-2 border text-center">দিন {{ $i }}</th>
                    @endfor
                    <th class="py-3 px-4 border text-center">মোট জমা</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-3 px-4 border font-medium text-slate-800">{{ $member->name }}</td>
                        
                        <!-- ১০ দিনের কালেকশন স্ট্যাটাস চেক (লুপ দিয়ে) -->
                        @for($i = 1; $i <= 10; $i++)
                            <td class="py-3 px-2 border text-center">
                                <!-- যদি টাকা জমা দিয়ে থাকে সবুজ টিক, না হলে প্লাস বা ফাঁকা -->
                                <button class="text-slate-300 hover:text-green-600 transition" title="টাকা জমা নিন">
                                    <i class="fas fa-check-circle text-base"></i>
                                </button>
                            </td>
                        @endfor
                        
                        <td class="py-3 px-4 border text-center font-bold text-blue-600">১,০০০ ৳</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
            <!-- Lottery Section (Right Side) -->
            <div class="space-y-6">
                <!-- Draw Winner Box -->
                <div class="bg-gradient-to-br from-purple-600 to-blue-600 rounded-lg shadow-lg p-6 text-center text-white">
                    <h2 class="text-xl font-bold mb-2">লটারি প্যানেল</h2>
                    <p class="text-purple-100 text-sm mb-6">ফান্ডে জমা আছে: ২১,০০০ ৳</p>
                    
                    <div class="flex flex-col space-y-3">
                        <button class="bg-yellow-400 hover:bg-yellow-500 text-slate-900 font-bold py-2 px-4 rounded shadow-lg transition">
                            <i class="fas fa-dice mr-2"></i> অটো ড্র করুন
                        </button>
                        <button onclick="openModal('manualDrawModal')" class="bg-white/20 hover:bg-white/30 text-white font-medium py-2 px-4 rounded transition border border-white/40">
                            <i class="fas fa-edit mr-2"></i> ম্যানুয়াল এন্ট্রি দিন
                        </button>
                    </div>
                </div>

                <!-- Recent Winners -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-bold text-slate-700">বিগত লটারি বিজয়ী</h2>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-4">
                            <li class="flex justify-between items-center border-b pb-2">
                                <div>
                                    <p class="font-bold text-slate-800">১ম ড্র</p>
                                    <p class="text-xs text-slate-500">১৭ আগস্ট, ২০২৬</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-blue-600">মেহেদী হাসান</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 1. ADD MEMBER MODAL -->
    <!-- ========================================== -->
    <div id="addMemberModal" class="fixed inset-0 bg-slate-900 bg-opacity-50 hidden flex items-center justify-center z-50 transition-opacity">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 overflow-hidden">
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800">নতুন মেম্বার রেজিস্ট্রেশন</h3>
                <button onclick="closeModal('addMemberModal')" class="text-slate-400 hover:text-red-500 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form action="{{ route('members.store') }}" method="POST" class="p-6">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">মেম্বারের নাম *</label>
                    <input type="text" name="name" required placeholder="যেমন: নাহিদ হাসান" class="w-full border border-slate-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-1">মোবাইল নাম্বার</label>
                    <input type="text" name="phone" placeholder="017XXXXXXXX" class="w-full border border-slate-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('addMemberModal')" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded font-medium transition">বাতিল</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-medium transition shadow">সেভ করুন</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 2. MANUAL LOTTERY ENTRY MODAL -->
    <!-- ========================================== -->
    <div id="manualDrawModal" class="fixed inset-0 bg-slate-900 bg-opacity-50 hidden flex items-center justify-center z-50 transition-opacity">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 overflow-hidden">
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800">ম্যানুয়াল লটারি বিজয়ী নির্বাচন</h3>
                <button onclick="closeModal('manualDrawModal')" class="text-slate-400 hover:text-red-500 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form action="" method="POST" class="p-6">
                <!-- @csrf -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">বিজয়ী সদস্য সিলেক্ট করুন *</label>
                    <select name="member_id" required class="w-full border border-slate-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option value="">-- সদস্য নির্বাচন করুন --</option>
                        <!-- লারাভেল ডাটা লুপ দিয়ে আসবে -->
                        <option value="1">নাহিদ হাসান</option>
                        <option value="2">নুসরাত জাহান</option>
                        <option value="3">মেহেদী হাসান</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">লটারির তারিখ *</label>
                    <input type="date" name="draw_date" value="{{ date('Y-m-d') }}" required class="w-full border border-slate-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-1">মোট টাকার পরিমাণ *</label>
                    <input type="number" name="amount" value="21000" required class="w-full border border-slate-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-100" readonly>
                    <p class="text-xs text-slate-500 mt-1">লটারির ফিক্সড অ্যামাউন্ট</p>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('manualDrawModal')" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded font-medium transition">বাতিল</button>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded font-medium transition shadow">বিজয়ী সেভ করুন</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Modal Toggle -->
    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Close modal when clicking outside of the modal content
        window.onclick = function(event) {
            const modals = ['addMemberModal', 'manualDrawModal'];
            modals.forEach(id => {
                const modal = document.getElementById(id);
                if (event.target === modal) {
                    closeModal(id);
                }
            });
        }
    </script>
</body>
</html>