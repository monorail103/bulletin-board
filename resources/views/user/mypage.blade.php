
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('My Page') }}</div>

                <div class="card-body">
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
            </div>
        </div>
    </div>
</div>
@endsection