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
                <button onclick="openModal('addMemberModal')"
                    class="bg-blue-800 hover:bg-blue-900 px-4 py-2 rounded shadow transition text-sm font-medium">
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
                <p class="text-3xl font-bold">{{ $members->count() }} জন</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <h3 class="text-slate-500 text-sm font-semibold mb-1">আজকের টার্গেট</h3>
                <p class="text-3xl font-bold">২,১০০ ৳</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                <h3 class="text-slate-500 text-sm font-semibold mb-1">আজকের জমা</h3>
                <p class="text-3xl font-bold text-green-600">{{ $todayCollection ?? 0 }} ৳</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                <h3 class="text-slate-500 text-sm font-semibold mb-1">পরবর্তী লটারি</h3>
                <p class="text-3xl font-bold">আর ২ দিন</p>
            </div>
        </div>

        <!-- Date Filter Form Section -->
        <div class="mb-6 bg-white p-4 rounded-lg shadow flex items-center">
            <form action="{{ route('home') }}" method="GET" class="flex flex-wrap items-center gap-4 w-full">
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">শুরুর তারিখ (Start Date):</label>
                    <input type="date" name="start_date" value="{{ $startDate }}"
                        class="border border-slate-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">শেষের তারিখ (End Date):</label>
                    <input type="date" name="end_date" value="{{ $endDate }}"
                        class="border border-slate-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="pt-5">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded text-sm font-medium transition shadow">
                        <i class="fas fa-filter mr-1"></i> সাইকেল লোড করুন
                    </button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- 10 Days Collection Table (Left Side) -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-slate-700">১০ দিনের চাঁদা কালেকশন সাইকেল</h2>
                    <div class="flex items-center gap-3">
                        <span class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded font-semibold">
                            মোট জমা: {{ $totalCycleCollection ?? 0 }} ৳
                        </span>
                        <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded font-semibold">
                            টার্মিনাল টার্গেট: ২১,০০০ ৳
                        </span>
                    </div>
                </div>
                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-100 text-slate-600">
                                <th class="py-3 px-4 border sticky left-0 bg-slate-100 z-10">সদস্যের নাম</th>

                                @php
                                    $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
                                @endphp
                                @foreach ($period as $date)
                                    <th class="py-3 px-2 border text-center">{{ $date->format('d M') }}</th>
                                @endforeach

                                <th class="py-3 px-4 border text-center">মোট জমা</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $member)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3 px-4 border font-medium text-slate-800 sticky left-0 bg-white">
                                        {{ $member->name }}
                                    </td>

                                    @php $totalPaid = 0; @endphp
                                    @foreach ($period as $date)
                                        @php
                                            $dateStr = $date->toDateString();
                                            $key = $member->id . '_' . $dateStr;
                                            $isPaid = isset($collections[$key]) && $collections[$key]->first()->is_paid;
                                            if ($isPaid) {
                                                $totalPaid += 100;
                                            }
                                        @endphp

                                        <td class="py-3 px-2 border text-center">
                                            <form action="{{ route('collections.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="member_id" value="{{ $member->id }}">
                                                <input type="hidden" name="collection_date"
                                                    value="{{ $dateStr }}">
                                                <input type="hidden" name="amount" value="100">
                                                <input type="hidden" name="is_paid" value="{{ $isPaid ? 0 : 1 }}">

                                                @if ($isPaid)
                                                    <button type="submit"
                                                        class="text-green-600 hover:text-red-500 transition"
                                                        title="বাতিল করুন">
                                                        <i class="fas fa-check-circle text-lg"></i>
                                                    </button>
                                                @else
                                                    <button type="submit"
                                                        class="text-slate-300 hover:text-blue-600 transition"
                                                        title="টাকা জমা নিন">
                                                        <i class="fas fa-plus-circle text-lg"></i>
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                    @endforeach

                                    <td class="py-3 px-4 border text-center font-bold text-blue-600">
                                        {{ $totalPaid }} ৳
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="py-4 text-center text-slate-500">কোনো মেম্বার পাওয়া
                                        যায়নি। আগে মেম্বার যোগ করুন।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Lottery Section (Right Side) -->
            <div class="space-y-6">
                <!-- Draw Winner Box -->
                <div
                    class="bg-gradient-to-br from-purple-600 to-blue-600 rounded-lg shadow-lg p-6 text-center text-white">
                    <h2 class="text-xl font-bold mb-2">লটারি প্যানেল</h2>
                    <p class="text-purple-100 text-sm mb-6">ফান্ডে জমা আছে: ২১,০০০ ৳</p>

                    <div class="flex flex-col space-y-3">
                        <form action="{{ route('lotteries.auto-draw') }}" method="POST"
                            onsubmit="return confirm('আপনি কি নিশ্চিতভাবে অটো ড্র শুরু করতে চান?');">
                            @csrf
                            <button type="submit"
                                class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-6 py-3 rounded-lg font-bold shadow-lg transition transform active:scale-95 flex items-center gap-2">
                                <i class="fas fa-dice text-xl"></i> অটো লটারি ড্র করুন (Auto Draw)
                            </button>
                            <!-- অটো ড্র উইনার কনফার্মেশন পপআপ -->
                            @if (session('pendingWinner'))
                                <div id="winnerPopup"
                                    class="fixed inset-0 bg-slate-900 bg-opacity-60 flex items-center justify-center z-50">
                                    <div
                                        class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden transform transition-all scale-100">
                                        <div
                                            class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4 text-white text-center">
                                            <h3 class="text-xl font-bold">🎉 লটারি ড্র ফলাফল! 🎉</h3>
                                            <p class="text-xs text-purple-200 mt-1">{{ session('drawNumber') }}ম ড্র
                                                এর সম্ভাব্য বিজয়ী</p>
                                        </div>

                                        <div class="p-8 text-center">
                                            <div
                                                class="w-20 h-20 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl shadow-inner">
                                                <i class="fas fa-trophy"></i>
                                            </div>
                                            <h4 class="text-2xl font-extrabold text-slate-800 mb-1">
                                                {{ session('pendingWinner')->name }}
                                            </h4>
                                            <p class="text-sm text-slate-500 mb-6">মোবাইল:
                                                {{ session('pendingWinner')->phone ?? 'প্রযোজ্য নয়' }}</p>

                                            <!-- কনফার্মেশন ফর্ম -->
                                            <form action="{{ route('lotteries.confirm') }}" method="POST"
                                                class="flex justify-center space-x-4">
                                                @csrf
                                                <input type="hidden" name="member_id"
                                                    value="{{ session('pendingWinner')->id }}">
                                                <input type="hidden" name="draw_number"
                                                    value="{{ session('drawNumber') }}">

                                                <button type="button" onclick="closeWinnerPopup()"
                                                    class="w-1/2 bg-slate-200 hover:bg-slate-300 text-slate-700 py-2.5 rounded-xl font-bold transition">
                                                    বাতিল
                                                </button>

                                                <button type="submit"
                                                    class="w-1/2 bg-purple-600 hover:bg-purple-700 text-white py-2.5 rounded-xl font-bold transition shadow-lg">
                                                    কনফার্ম
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function closeWinnerPopup() {
                                        document.getElementById('winnerPopup').style.display = 'none';
                                    }
                                </script>
                            @endif
                        </form>
                        <button onclick="openModal('manualDrawModal')"
                            class="bg-white/20 hover:bg-white/30 text-white font-medium py-2 px-4 rounded transition border border-white/40">
                            <i class="fas fa-edit mr-2"></i> ম্যানুয়াল এন্ট্রি দিন
                        </button>
                    </div>
                </div>

                <!-- Recent Winners -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-bold text-slate-700">বিগত লটারি বিজয়ী</h2>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-4">
                            @forelse($lotteries as $lottery)
                                <li class="flex justify-between items-center border-b pb-2">
                                    <div>
                                        <p class="font-bold text-slate-800">
                                            {{ $lottery->draw_number ? $lottery->draw_number . ' ড্র' : 'ড্র রেকর্ড' }}
                                        </p>
                                        <!-- তারিখ সুন্দর ফরম্যাটে দেখানোর জন্য -->
                                        <p class="text-xs text-slate-500">
                                            {{ \Carbon\Carbon::parse($lottery->draw_date)->format('d M, Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <!-- মেম্বার মডেলের সাথে রিলেশন থাকার কারণে নাম চলে আসবে -->
                                        <p class="font-medium text-blue-600">
                                            {{ $lottery->member->name ?? 'অজ্ঞাত সদস্য' }}</p>
                                        <p class="text-xs text-slate-400">টাকা: {{ number_format($lottery->amount) }}
                                        </p>
                                    </div>
                                </li>
                            @empty
                                <li class="text-center text-slate-400 py-2 text-sm">কোনো লটারির ইতিহাস পাওয়া যায়নি।
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 1. ADD MEMBER MODAL -->
    <div id="addMemberModal"
        class="fixed inset-0 bg-slate-900 bg-opacity-50 hidden flex items-center justify-center z-50 transition-opacity">
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
                    <input type="text" name="name" required placeholder="যেমন: নাহিদ হাসান"
                        class="w-full border border-slate-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-1">মোবাইল নাম্বার</label>
                    <input type="text" name="phone" placeholder="017XXXXXXXX"
                        class="w-full border border-slate-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('addMemberModal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded font-medium transition">বাতিল</button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-medium transition shadow">সেভ
                        করুন</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. MANUAL LOTTERY ENTRY MODAL -->
    <div id="manualDrawModal"
        class="fixed inset-0 bg-slate-900 bg-opacity-50 hidden flex items-center justify-center z-50 transition-opacity">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 overflow-hidden">
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800">ম্যানুয়াল লটারি বিজয়ী নির্বাচন</h3>
                <button onclick="closeModal('manualDrawModal')" class="text-slate-400 hover:text-red-500 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form action="{{ route('lotteries.store') }}" method="POST" class="p-6">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">বিজয়ী সদস্য সিলেক্ট করুন *</label>
                    <select name="member_id" required
                        class="w-full border border-slate-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option value="">-- সদস্য নির্বাচন করুন --</option>

                        @foreach ($members as $m)
                            {{-- চেক করা হচ্ছে মেম্বার ইতিমধ্যে লটারি জিতেছে কি না --}}
                            @if (!in_array($m->id, $previousWinnerIds))
                                <option value="{{ $m->id }}">{{ $m->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <!-- কততম ড্র বা লটারি সেটি ট্র্যাক করার জন্য একটি ফিল্ড রাখতে পারো (ঐচ্ছিক) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">ড্র নম্বর (যেমন: ১৩ তম ড্র)</label>
                    <input type="number" name="draw_number" placeholder="যেমন: ১৩"
                        class="w-full border border-slate-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">লটারির তারিখ *</label>
                    <input type="date" name="draw_date" value="{{ date('Y-m-d') }}" required
                        class="w-full border border-slate-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-1">মোট টাকার পরিমাণ *</label>
                    <input type="number" name="amount" value="21000" required
                        class="w-full border border-slate-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-100"
                        readonly>
                    <p class="text-xs text-slate-500 mt-1">লটারির ফিক্সড অ্যামাউন্ট</p>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('manualDrawModal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded font-medium transition">বাতিল</button>
                    <button type="submit"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded font-medium transition shadow">বিজয়ী
                        সেভ করুন</button>
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
