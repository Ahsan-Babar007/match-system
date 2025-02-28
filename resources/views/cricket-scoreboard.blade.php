<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $data['match_title'] ?? 'Cricket Scoreboard' }}</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #2c3e50;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        .scoreboard {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        /* Video Background */
        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1; /* Ensure video stays behind the content */
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 20px;
            background: rgb(248, 41, 41);
            border-bottom: 2px solid #ffcc00;
            z-index: 1; /* Ensure header stays above the video */
        }

        .team-box {
            text-align: center;
            padding: 15px;
            width: 200px;
            background: linear-gradient(145deg, #1e3c72, #2a5298);
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .team-box:hover {
            transform: scale(1.05);
        }

        .team-box h2 {
            font-size: 22px;
            margin-bottom: 10px;
            color: #ffcc00;
        }

        .score {
            font-size: 28px;
            font-weight: bold;
            color: #ffffff;
        }

        .overs {
            background: rgba(148, 0, 0, 0.89);
            width: 30%;
            max-width: 90vw; /* Ensures it doesn’t get too wide */
            height: auto; /* Adjusts based on content */
            padding: 20px 50px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            margin: 20px 0; /* Adds margin above and below */
        }

        .overs h3 {
            font-size: 50px;
            color: rgb(255, 255, 255);
        }

        .run-rate {
            font-size: 24px;
            color: #ffffff;
            margin: 10px 0;
        }

        .ball-tracker {
            display: flex;
            width: 90vw; /* Use viewport width to make sure it spreads properly */
            max-width: 1400px; /* Prevent it from getting too large on big screens */
            margin: 20px auto; /* Center it */
            padding: 15px;
            justify-content: center;
            align-items: center;
            background: rgb(222, 239, 61);
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            z-index: 2;
        }

        .ball {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 5px;
            font-weight: bold;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            transition: transform 0.2s ease;
        }

        .match-status {
            background-color:rgb(255, 18, 49);
            color:rgb(255, 255, 255);
            padding: 15px 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            font-size: 28px;
            font-weight: bold;
            margin-top: 0px;
        }

        .ball:hover {
            transform: scale(1.1);
        }

        .ball-run { background: #ffffff; color: #000000; }
        .ball-four { background: #ff4444; color: #ffffff; }
        .ball-six { background: #00c851; color: #ffffff; }
        .ball-wicket { background: #000000; color: #ffffff; }

        .players {
            display: flex;
            justify-content: space-around;
            width: 100%;
            height: 200px;
            position: absolute;
            bottom: 0;
            left: 0;
            padding: 20px;
            background: rgb(25, 176, 247);
            border-radius: 15px 15px 0 0;
            box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.3);
            z-index: 1; /* Ensure players section stays above the video */
        }

        .player-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            background: linear-gradient(145deg, #1e3c72, #2a5298);
            border-radius: 15px;
            width: 22%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
            position: relative; /* Required for absolute positioning of the image */
        }

        .player-card:hover {
            transform: scale(1.05);
        }

       .player-card img {
    width: 170px; /* Increased size */
    height: 170px; /* Increased size */
    border-radius: 50%;
    object-fit: cover;
    position: absolute; /* Position the image outside the box */
    top: -120px; /* Adjusted to move the image further above the box */
    left: 20%; /* Center the image horizontally */
    transform: translateX(-50%); /* Center the image horizontally */
    border: 3px solid #ffcc00; /* Add a border for better visibility */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Add shadow for depth */
}

        .player-card h4 {
            font-size: 28px;
            color: #ffcc00;
            margin-bottom: 5px;
            margin-top: 40px; /* Add margin to accommodate the image */
        }

        .player-card p {
            font-size: 23px;
            color: #ffffff;
            text-align: center;
        }
    </style>
</head>
<body>

@if(isset($error))
    <h2 style="color: red;">Error: {{ $error }}</h2>
@else
    <div class="scoreboard">
        <!-- Video Background -->
        <iframe class="video-background" width="100%" height="100%" 
            src="https://www.youtube.com/embed/7PFbfsveanE?autoplay=1&mute=1&loop=1&playlist=7PFbfsveanE" 
            frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
        </iframe>

        <div class="header">
            <div class="team-box">
                <h2>{{ $data['team1'] ?? 'Team 1' }}</h2>
                <p class="score">{{ $data['score'] ?? '0/0' }}</p>
            </div>
            <div class="overs">
                <h3>Overs: {{ $data['score'] ?? '0' }}</h3>
                <!-- Current Run Rate (CRR) -->
                <p class="run-rate">CRR: {{ $data['crr'] ?? '0.00' }}</p>
                <!-- Required Run Rate (RRR) -->
                <p class="run-rate">RRR: {{ $data['rrr'] ?? '0.00' }}</p>
            </div>
            <div class="team-box">
                <h2>{{ $data['team2'] ?? 'Team 2' }}</h2>
                <p class="score">{{ $data['score'] ?? '0/0' }}</p>
            </div>
        </div>
        

       <div id="ball-tracker" class="ball-tracker">
    @php 
        $recentOvers = json_decode($data['recent_overs'] ?? '[]', true);
    @endphp

    @foreach($recentOvers as $ball)
        <div class="ball 
            @if($ball == 'W') 
                ball-wicket 
            @elseif($ball == '4') 
                ball-four 
            @elseif($ball == '6') 
                ball-six 
            @else 
                ball-run 
            @endif
        ">
            {{ $ball }}
        </div>
    @endforeach
</div>

<div class="match-status">
            {{ $data['match_status'] ?? 'Match Status Not Available' }}
        </div>


        <div class="players">
            @php
                $batter1 = json_decode($data['batters1'] ?? '{}', true);
                $batter2 = json_decode($data['batters2'] ?? '{}', true);
                $bowler1 = json_decode($data['bowlers1'] ?? '{}', true);
                $bowler2 = json_decode($data['bowlers2'] ?? '{}', true);
            @endphp

            <div class="player-card">
                <img src="{{ $batter1['image'] ?? 'https://th.bing.com/th/id/OIP.hoqz7oI4vtbnqNI_0Hz2lwHaI4?rs=1&pid=ImgDetMain' }}" alt="Batsman 1">
                <h4>{{ $batter1['name'] ?? 'Batsman 1' }}</h4>
                <p>{{ $batter1['runs'] ?? 0 }} runs ({{ $batter1['balls'] ?? 0 }} balls)</p>
            </div>

            <div class="player-card">
    <img src="{{ $batter2['image'] ?? 'https://th.bing.com/th/id/OIP.hoqz7oI4vtbnqNI_0Hz2lwHaI4?rs=1&pid=ImgDetMain' }}" alt="Batsman 2">
    <h4>{{ $batter2['name'] ?? 'Batsman 2' }}</h4>
    <p>{{ $batter2['runs'] ?? 0 }} runs ({{ $batter2['balls'] ?? 0 }} balls)</p>
</div>


            <div class="player-card">
                <img src="{{ $bowler1['image'] ?? 'https://th.bing.com/th/id/OIP.hoqz7oI4vtbnqNI_0Hz2lwHaI4?rs=1&pid=ImgDetMain' }}" alt="Bowler 1">
                <h4>{{ $bowler1['name'] ?? 'Bowler 1' }}</h4>
                <p>{{ $bowler1['overs'] ?? 0 }} overs, {{ $bowler1['wickets'] ?? 0 }} wickets</p>
            </div>

            <div class="player-card">
                <img src="{{ $bowler2['image'] ?? 'https://th.bing.com/th/id/OIP.hoqz7oI4vtbnqNI_0Hz2lwHaI4?rs=1&pid=ImgDetMain' }}" alt="Bowler 2">
                <h4>{{ $bowler2['name'] ?? 'Bowler 2' }}</h4>
                <p>{{ $bowler2['overs'] ?? 0 }} overs, {{ $bowler2['wickets'] ?? 0 }} wickets</p>
            </div>
        </div>
    </div>
@endif


<script>
    
    function fetchLiveScore() {
    $.ajax({
        url: "/cricket-live-data", // Ensure this route is returning JSON data
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.data) {
                const data = response.data;

                // Ensure batters and bowlers data are parsed JSON objects
                const batter1 = typeof data.batters1 === "string" ? JSON.parse(data.batters1) : data.batters1;
                const batter2 = typeof data.batters2 === "string" ? JSON.parse(data.batters2) : data.batters2;
                const bowler1 = typeof data.bowlers1 === "string" ? JSON.parse(data.bowlers1) : data.bowlers1;
                const bowler2 = typeof data.bowlers2 === "string" ? JSON.parse(data.bowlers2) : data.bowlers2;

                // Update Team Names
                $(".team-box:first h2").text(data.team1 || "Team 1");
                $(".team-box:last h2").text(data.team2 || "Team 2");

                // Update Scores
                $(".team-box:first .score").text(data.score1 || "0/0");
                $(".team-box:last .score").text(data.score2 || "0/0");

                // Update Overs & Run Rates
                $(".overs h3").text("Overs: " + (data.score || "0"));
                $(".run-rate:first").text("CRR: " + (data.crr || "0.00"));
                $(".run-rate:last").text("RRR: " + (data.rrr || "0.00"));

                // Update Ball Tracker
                let ballTrackerHtml = "";
                const recentOvers = JSON.parse(data.recent_overs || "[]");
                recentOvers.forEach(ball => {
                    let ballClass = ball === "W" ? "ball-wicket" : (ball === "4" ? "ball-four" : (ball === "6" ? "ball-six" : "ball-run"));
                    ballTrackerHtml += `<div class="ball ${ballClass}">${ball}</div>`;
                });
                $("#ball-tracker").html(ballTrackerHtml);

                 const matchStatus = data.match_status || "Match Status Not Available"; // Default message if no match status
                $(".match-status").text(matchStatus);

                // Update Player Stats
                $(".player-card:eq(0) h4").text(batter1.name || "Batsman 1");
                $(".player-card:eq(0) p").text(`${batter1.runs || 0} runs (${batter1.balls || 0} balls)`);
               

                $(".player-card:eq(1) h4").text(batter2.name || "Batsman 2");
                $(".player-card:eq(1) p").text(`${batter2.runs || 0} runs (${batter2.balls || 0} balls)`);
            

                $(".player-card:eq(2) h4").text(bowler1.name || "Bowler 1");
                $(".player-card:eq(2) p").text(`${bowler1.overs || 0} overs, ${bowler1.wickets || 0} wickets`);
            

                $(".player-card:eq(3) h4").text(bowler2.name || "Bowler 2");
                $(".player-card:eq(3) p").text(`${bowler2.overs || 0} overs, ${bowler2.wickets || 0} wickets`);
              
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching live score:", error);
        }
    });
}

// Call function every second
setInterval(fetchLiveScore, 1000);

    

</script>




</body>
</html>