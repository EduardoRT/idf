<?php
/**
 * @var \App\CourseEnrollmentn $enrollment
 */
?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h2 class="card-header">Lessons</h2>
                    <div class="card-body">
                        <ol>
                            @foreach($enrollment->course->lessons as $lesson)
                                <li>{{ $lesson->title }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>

                <div class="card mt-4">
                    <h2 class="card-header">Statistics</h2>
                    <div class="card-body">

                        <p>
                            Your rankings improve every time you answer a question correctly.
                            Keep learning and earning course points to become one of our top learners!
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <h4>You are ranked <b>{{ $currentGlobalLeaderboardPosition }}</b> in {{ auth()->user()->country->name }}</h4>
                                {{--Replace this stub markup by your code--}}
                                <ul style="padding: 0px;">
                                    @foreach($topGlobalLeaderboard as $position => $leaderboardItem)
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            {{ $position + 1 }}
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                @if ($leaderboardItem->user->id == Auth::id())
                                                    <b>{{ $leaderboardItem->user->name }}</b>
                                                @else
                                                    {{ $leaderboardItem->user->name }}
                                                @endif
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                {{ $leaderboardItem->total_score }} PTS
                                                @if ((($userScore - $leaderboardItem->total_score) * -1) > 0)
                                                    (+{{ ($userScore - $leaderboardItem->total_score) * -1 }})
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                    <hr>
                                    @foreach($middleGlobalLeaderboard as $position => $leaderboardItem)
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            {{ $position + 1 }}
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                @if ($leaderboardItem->user->id == Auth::id())
                                                    <b>{{ $leaderboardItem->user->name }}</b>
                                                @else
                                                    {{ $leaderboardItem->user->name }}
                                                @endif
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                {{ $leaderboardItem->total_score }} PTS
                                                @if ((($userScore - $leaderboardItem->total_score) * -1) > 0)
                                                    (+{{ ($userScore - $leaderboardItem->total_score) * -1 }})
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                    <hr>
                                    @foreach($lastGlobalLeaderboard as $position => $leaderboardItem)
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            {{ $position + 1 }}
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                @if ($leaderboardItem->user->id == Auth::id())
                                                    <b>{{ $leaderboardItem->user->name }}</b>
                                                @else
                                                    {{ $leaderboardItem->user->name }}
                                                @endif
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                {{ $leaderboardItem->total_score }} PTS
                                                @if ((($userScore - $leaderboardItem->total_score) * -1) > 0)
                                                    (+{{ ($userScore - $leaderboardItem->total_score) * -1 }})
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                    <hr>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h4>You are ranked <b>{{ $currentLeaderboardPosition }}</b> Worldwide</h4>
                                {{--Replace this stub markup by your code--}}
                                <ul style="padding: 0px;">
                                    @foreach($topLeaderboard as $position => $leaderboardItem)
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            {{ $position + 1 }}
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                @if ($leaderboardItem->user->id == Auth::id())
                                                    <b>{{ $leaderboardItem->user->name }}</b>
                                                @else
                                                    {{ $leaderboardItem->user->name }}
                                                @endif
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                {{ $leaderboardItem->total_score }} PTS
                                                @if ((($userScore - $leaderboardItem->total_score) * -1) > 0)
                                                    (+{{ ($userScore - $leaderboardItem->total_score) * -1 }})
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                    <hr>
                                    @foreach($middleLeaderboard as $position => $leaderboardItem)
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            {{ $position + 1 }}
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                @if ($leaderboardItem->user->id == Auth::id())
                                                    <b>{{ $leaderboardItem->user->name }}</b>
                                                @else
                                                    {{ $leaderboardItem->user->name }}
                                                @endif
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                {{ $leaderboardItem->total_score }} PTS
                                                @if ((($userScore - $leaderboardItem->total_score) * -1) > 0)
                                                    (+{{ ($userScore - $leaderboardItem->total_score) * -1 }})
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                    <hr>
                                    @foreach($lastLeaderboard as $position => $leaderboardItem)
                                    <li class="courseRanking__rankItem"
                                        style="display: flex; flex-direction: row; padding: 10px;">
                                        <div class="position"
                                             style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                            {{ $position + 1 }}
                                        </div>
                                        <div class="info">
                                            <div style="font-size: 16px;">
                                                @if ($leaderboardItem->user->id == Auth::id())
                                                    <b>{{ $leaderboardItem->user->name }}</b>
                                                @else
                                                    {{ $leaderboardItem->user->name }}
                                                @endif
                                            </div>
                                            <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                                {{ $leaderboardItem->total_score }} PTS
                                                @if ((($userScore - $leaderboardItem->total_score) * -1) > 0)
                                                    (+{{ ($userScore - $leaderboardItem->total_score) * -1 }})
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                    <hr>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
