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

                @component('components.leaderboard', [
                    'globalLeaderboard' => [$topGlobalLeaderboard, $middleGlobalLeaderboard, $lastGlobalLeaderboard],
                    'countryLeaderboard' => [$topLeaderboard, $middleLeaderboard, $lastLeaderboard],
                    'currentLeaderboardPosition' => $currentLeaderboardPosition,
                    'currentGlobalLeaderboardPosition' => $currentGlobalLeaderboardPosition,
                    'userScore' => $userScore,
                    ])
                @endcomponent
            </div>
        </div>
    </div>
@endsection
