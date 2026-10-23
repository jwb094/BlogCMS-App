@extends('layouts.backend-layout')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h1 class="h3 mb-1">Dashboard</h1>
        <p class="text-muted mb-0">Welcome, {{ auth()->user()->first_name ?: auth()->user()->name }}.</p>
    </div>

    @if ($globalStats)
        <section class="mb-5" aria-labelledby="site-overview-heading">
            <h2 id="site-overview-heading" class="h5 mb-3">Site Overview</h2>
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-xl-4">
                    <x-backend.stat-card title="Users" :value="$globalStats['users']" icon="bi-people-fill" color="primary" />
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <x-backend.stat-card title="Total Posts" :value="$globalStats['posts']" icon="bi-file-earmark-text-fill" color="success" />
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <x-backend.stat-card title="Categories" :value="$globalStats['categories']" icon="bi-bookmarks-fill" color="info" />
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <x-backend.stat-card title="Comments" :value="$globalStats['comments']" icon="bi-chat-left-text-fill" color="warning" />
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <x-backend.stat-card title="Tags" :value="$globalStats['tags']" icon="bi-tags-fill" color="secondary" />
                </div>
            </div>

        </section>

        <section class="mb-5" aria-labelledby="post-activity-heading">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 id="post-activity-heading" class="h5">Posts Created in the Last 3 Months</h2>
                    <p class="text-muted small">Monthly total, including the current month.</p>
                    @php($maxMonthlyPosts = max(array_column($monthlyPosts, 'count') ?: [0]))
                    <div class="row g-3 align-items-end pt-3" role="img" aria-label="Monthly post counts for the last three months">
                        @foreach ($monthlyPosts as $month)
                            @php($barHeight = $month['count'] === 0 ? 2 : max(12, (int) round(($month['count'] / max($maxMonthlyPosts, 1)) * 180)))
                            <div class="col text-center">
                                <div class="fw-semibold mb-2">{{ number_format($month['count']) }}</div>
                                <div class="d-flex align-items-end justify-content-center bg-body-secondary rounded" style="height: 190px;">
                                    <div class="bg-primary rounded-top w-75" style="height: {{ $barHeight }}px;"></div>
                                </div>
                                <div class="small text-muted mt-2">{{ $month['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-5" aria-labelledby="popular-categories-heading">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 id="popular-categories-heading" class="h5">Most Popular Categories in the Last Quarter</h2>
                    <p class="text-muted small">Ranked by posts created in the past three months.</p>

                    @if ($popularCategories->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Rank</th>
                                        <th scope="col">Category</th>
                                        <th scope="col" class="text-end">Posts</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($popularCategories as $category)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $category->name }}</td>
                                            <td class="text-end">{{ number_format($category->posts_count) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">No posts were created during this period.</p>
                    @endif
                </div>
            </div>
        </section>
    @endif

    @if (auth()->user()->isAuthor())
        <section aria-labelledby="personal-overview-heading">
            <h2 id="personal-overview-heading" class="h5 mb-3">Your Activity</h2>
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-xl-3">
                    <x-backend.stat-card title="Your Posts" :value="$personalStats['posts']" icon="bi-file-earmark-text" color="success" />
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <x-backend.stat-card title="Comments on Your Posts" :value="$personalStats['comments']" icon="bi-chat-left-text" color="info" />
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <a href="{{ route('admin.comments.index') }}" class="text-decoration-none">
                        <x-backend.stat-card title="Pending Comments" :value="$personalStats['pendingComments']" icon="bi-hourglass-split" color="warning" />
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <x-backend.stat-card title="Your Media Uploads" :value="$personalStats['media']" icon="bi-images" color="secondary" />
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <h3 class="h5">Your Content Produced in the Last Quarter</h3>
                    <p class="text-muted small">Posts created month by month over the past three months.</p>
                    @php($maxAuthorMonthlyPosts = max(array_column($authorMonthlyPosts, 'count') ?: [0]))
                    <div class="row g-3 align-items-end pt-3" role="img" aria-label="Your monthly post counts for the last three months">
                        @foreach ($authorMonthlyPosts as $month)
                            @php($barHeight = $month['count'] === 0 ? 2 : max(12, (int) round(($month['count'] / max($maxAuthorMonthlyPosts, 1)) * 180)))
                            <div class="col text-center">
                                <div class="fw-semibold mb-2">{{ number_format($month['count']) }}</div>
                                <div class="d-flex align-items-end justify-content-center bg-body-secondary rounded" style="height: 190px;">
                                    <div class="bg-success rounded-top w-75" style="height: {{ $barHeight }}px;"></div>
                                </div>
                                <div class="small text-muted mt-2">{{ $month['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>
@endsection
