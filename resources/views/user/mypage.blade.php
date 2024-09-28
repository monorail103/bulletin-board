<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/style_index.css') }}">
    <title>{{Auth::user()->name}}さんのマイページ</title>
</head>
<body>
    <div class="header">
        <p>{{Auth::user()->name}}さんのマイページ</p>
        <a href="{{ route('logout') }}">ログアウト</a>
        <a href="{{ route('threads.index') }}">スレッドに戻る</a>
    </div>
    <div class="profile">
        {{ __('こんにちは、 ') . Auth::user()->name . 'さん' }}
        <br>
        @php
            use App\Models\UserPostsCount;
            use Carbon\Carbon;

            $today = Carbon::today()->toDateString();
            $postCount = UserPostsCount::where('user_id', Auth::id())
                ->where('date', $today)
                ->first();
        @endphp
        {{ __('今日の投稿数: ') . ($postCount ? $postCount->post_count : 0) }}
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="chart-container">
                <canvas id="postsChart"></canvas>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('postsChart').getContext('2d');
            var postCounts = @json($postCounts);

            postCounts.sort(function(a, b) {
                return new Date(a.date) - new Date(b.date);
            });

            var dates = postCounts.map(function(postCount) {
                return postCount.date;
            });
            var counts = postCounts.map(function(postCount) {
                return postCount.post_count;
            });

            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: '書き込み数',
                        data: counts,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
