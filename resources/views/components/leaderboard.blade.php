@if ($shouldRenderLeaderboard && $shouldRenderGlobalLeaderboard)
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
                    <ul style="padding: 0px;">
                        @foreach($globalLeaderboard as $leaderboard)
                            @foreach($leaderboard as $leaderboardEntry)
                                <li class="courseRanking__rankItem"
                                    style="display: flex; flex-direction: row; padding: 10px;">
                                    <div class="position"
                                         style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                        {{ $leaderboardEntry->place }}
                                    </div>
                                    <div class="info">
                                        <div style="font-size: 16px;">
                                            @if ($leaderboardEntry->user->id == Auth::id())
                                                <b>{{ $leaderboardEntry->user->name }}</b>
                                            @else
                                                {{ $leaderboardEntry->user->name }}
                                            @endif
                                        </div>
                                        <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                            {{ $leaderboardEntry->total_score }} PTS
                                            @if ((($userScore - $leaderboardEntry->total_score) * -1) > 0)
                                                (+{{ ($userScore - $leaderboardEntry->total_score) * -1 }})
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            <hr>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <h4>You are ranked <b>{{ $currentLeaderboardPosition }}</b> Worldwide</h4>
                    <ul style="padding: 0px;">
                        @foreach($countryLeaderboard as $leaderboard)
                            @foreach($leaderboard as $leaderboardEntry)
                                <li class="courseRanking__rankItem"
                                    style="display: flex; flex-direction: row; padding: 10px;">
                                    <div class="position"
                                         style="font-size: 28px; color: rgb(132, 132, 132); text-align: right; width: 80px; padding-right: 10px;">
                                        {{ $leaderboardEntry->place }}
                                    </div>
                                    <div class="info">
                                        <div style="font-size: 16px;">
                                            @if ($leaderboardEntry->user->id == Auth::id())
                                                <b>{{ $leaderboardEntry->user->name }}</b>
                                            @else
                                                {{ $leaderboardEntry->user->name }}
                                            @endif
                                        </div>
                                        <div class="score" style="font-size: 10px; color: rgb(132, 132, 132);">
                                            {{ $leaderboardEntry->total_score }} PTS
                                            @if ((($userScore - $leaderboardEntry->total_score) * -1) > 0)
                                                (+{{ ($userScore - $leaderboardEntry->total_score) * -1 }})
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            <hr>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
