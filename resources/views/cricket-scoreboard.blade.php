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
            top: -20;
            left: 0;
            width: 100%;
            height: 120%;
           
            z-index: -1; /* Ensure video stays behind the content */
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 0px 40px;
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

        .team-box-2 {
            text-align: center;
            padding: 15px;
            width: 200px;
            background: linear-gradient(145deg,rgb(6, 152, 6),rgb(45, 139, 14));
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .team-box:hover {
            transform: scale(1.05);
        }

        .team-box h2 {
            font-size: 19px;
            margin-bottom: 10px;
            margin-top: 10px;
            color: #ffcc00;
        }

        .score {
            font-size: 13px;
            font-weight: bold;
            color: #ffffff;
        }

        .overs {
            background: rgba(9, 115, 167, 0.54);
            width: 30%;
            max-width: 90vw; /* Ensures it doesn’t get too wide */
            height: auto; /* Adjusts based on content */
            padding: 10px 50px;
            border-radius: 15px;
            border: #ffffff;
            text-align: center;
            box-shadow: 0 4px 10px rgba(255, 254, 254, 0.3);
            margin: 20px 0; /* Adds margin above and below */
        }

        .overs h3 {
            font-size: 18px;
            color: rgb(255, 255, 255);
        }

        .run-rate {
            font-size: 13px;
            color: #ffffff;
            margin: 10px 0;
        }

        .ball-tracker {
            display: flex;
            width: 90vw; /* Use viewport width to make sure it spreads properly */
            max-width: 1200px; /* Prevent it from getting too large on big screens */
            margin: 5px auto; /* Center it */
            padding: 10px;
            justify-content: center;
            align-items: center;
            background: rgb(222, 239, 61);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            z-index: 1;
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
            font-size: 12px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            transition: transform 0.2s ease;
        }

        .match-status {
            background-color:rgb(62, 18, 255);
            color:rgb(255, 255, 255);
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            font-size: 35px;
            font-weight: bold;
            margin-top: 0px;
        }

        .ball:hover {
            transform: scale(1.1);
        }

        .ball-run { background: #ffffff; color: #000000; }
        .ball-four { background: #ff4444; color: #ffffff; }
        .ball-six { background: #00c851; color: #ffffff; }
        .ball-space{ background:rgb(1, 149, 255); color:rgb(0, 0, 0); }
        .ball-wicket { background: #000000; color: #ffffff; }

        .players {
            display: flex;
            justify-content: space-around;
            width: 100%;
            height: 180px;
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
            background: linear-gradient(145deg,rgb(0, 0, 0), #2a5298);
            border-radius: 15px;
            width: 22%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
            position: relative; /* Required for absolute positioning of the image */
        }

        .player-card-2 {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            background: linear-gradient(145deg,rgb(196, 255, 69),rgb(65, 255, 2));
            border-radius: 15px;
            width: 22%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
            position: relative; /* Required for absolute positioning of the image */
        }

         .player-card-boller {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            background: linear-gradient(145deg,rgb(0, 0, 0), #2a5298);
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
            width: 100px; /* Increased size */
            height: 100px; /* Increased size */
            border-radius: 50%;
            object-fit: cover;
            position: absolute; /* Position the image outside the box */
            top: -50px; /* Adjusted to move the image further above the box */
            left: 10%; /* Center the image horizontally */
            transform: translateX(-50%); /* Center the image horizontally */
            border: 3px solid #ffcc00; /* Add a border for better visibility */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Add shadow for depth */
        }

        .player-card h4 {
            font-size: 22px;
            color: #ffcc00;
            margin-bottom: 5px;
            margin-top: 30px; /* Add margin to accommodate the image */
        }

        .player-card-2 h4 {
            font-size: 22px;
            color:rgb(15, 15, 15);
            margin-bottom: 5px;
            margin-top: 30px; /* Add margin to accommodate the image */
        }


        .player-card-2 img {
            width: 100px; /* Increased size */
            height: 100px; /* Increased size */
            border-radius: 50%;
            object-fit: cover;
            position: absolute; /* Position the image outside the box */
            top: -50px; /* Adjusted to move the image further above the box */
            left: 10%; /* Center the image horizontally */
            transform: translateX(-50%); /* Center the image horizontally */
            border: 3px solid #ffcc00; /* Add a border for better visibility */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Add shadow for depth */
        }

         .player-card-boller {
            font-size: 16px;
            color: #ffcc00;
            margin-bottom: 5px;
            margin-top: 40px; /* Add margin to accommodate the image */
        }

        .player-card-2 p {
            font-size: 16px;
            color:rgb(0, 0, 0);
            text-align: center;
        }
          .batting-now {
        position: absolute;
        top: -10px;
        right: -30px;
        background-color:rgb(243, 64, 64); /* Orange-red color */
        color: white;
        padding: 8px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
    }
     .bowling-now {
        position: absolute;
        top: -10px;
        right: -30px;
        background-color:rgb(243, 64, 64); /* Orange-red color */
        color: white;
        padding: 8px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
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
                src="https://www.youtube.com/embed/nVWtemAz9L0?autoplay=1&mute=1&loop=1" 
                frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
            </iframe>

            <div class="header">
                <div class="team-box">
                    <h2>{{ $data['team1'] ?? 'Team 1' }}</h2>
                </div>
                <div class="overs">
                    <h3> {{ $data['score'] ?? '0' }}</h3>
                    <p class="run-rate">Current Run Rate: {{ $data['crr'] ?? '0.00' }}</p>
                    <p class="run-rate">Require Run Rate: {{ $data['rrr'] ?? '0.00' }}</p>
                </div>
                <div class="team-box-2">
                    <h2>{{ $data['team2'] ?? 'Team 2' }}</h2>
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
                        @elseif($ball == '|') 
                            ball-space 
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

                <div class="player-card batter1-card">
                    @if ($batter1!=null)
                        <div class="batting-now">Batting</div>
                    @endif
                    <img src="{{ $batter1['image'] ?? 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjOeYcIMwn9x_WHID51PNZI6kiQuQjkL-x7_Kru9VXbFiNe_UG5v842bZ5cv8WV2yuWiDIdN9Io1X5nTss1qAvWuIbCnZWFzHY94L_LQY4UYTZHDRD-IdMF_cWp8QSzq3ZpqmkyXk_mPiqjDDsxmaAjId2wA2jIvUlufkk2anTBAmntMLU7_UnMxFVkL8c/s320-rw/WhatsApp%20Image%202025-02-28%20at%207.57.54%20PM.jpeg' }}" alt="Batsman 1">
                    <h4>{{ $batter1['name'] ?? 'Batsman 1' }}</h4>
                    <p>{{ $batter1['runs'] ?? 0 }} runs ({{ $batter1['balls'] ?? 0 }} balls)</p>
                </div>
                
                <div class="player-card batter2-card">
                    <img src="{{ $batter2['image'] ?? 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjOeYcIMwn9x_WHID51PNZI6kiQuQjkL-x7_Kru9VXbFiNe_UG5v842bZ5cv8WV2yuWiDIdN9Io1X5nTss1qAvWuIbCnZWFzHY94L_LQY4UYTZHDRD-IdMF_cWp8QSzq3ZpqmkyXk_mPiqjDDsxmaAjId2wA2jIvUlufkk2anTBAmntMLU7_UnMxFVkL8c/s320-rw/WhatsApp%20Image%202025-02-28%20at%207.57.54%20PM.jpeg' }}" alt="Batsman 2">
                    <h4>{{ $batter2['name'] ?? 'Batsman 2' }}</h4>
                    <p>{{ $batter2['runs'] ?? 0 }} runs ({{ $batter2['balls'] ?? 0 }} balls)</p>
                </div>

                <div class="player-card-2 bowler1-card">
                    @if ($bowler1!=null)
                        <div class="bowling-now">Bowling Now</div>
                    @endif
                    <img src="{{ $bowler1['image'] ?? 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEghKZ1A6gbbmpXIOiqkWoUfgqae-N0zwJsufaeesmis8IBhkDVcjwmyIL1yCMFI1IATPFr3l_pf_J05MlKyKbQm73CFuJxnfGg35K_1FNpY0_ntEOvUUiZmYTuEhYw1xm4FNS7KiP6l4T35cKTS2EFCmy2V1-EaGG5fzNZp3ylp-3W-3QqbDQHGju0jGcU/s320-rw/WhatsApp%20Image%202025-02-28%20at%208.05.16%20PM.jpeg' }}" alt="Bowler 1">
                    <h4>{{ $bowler1['name'] ?? 'Bowler 1' }}</h4>
                    <p>{{ $bowler1['overs'] ?? 0 }} overs, {{ $bowler1['wickets'] ?? 0 }} wickets</p>
                </div>
            </div>
        </div>
    @endif

    <script>
    // Store previous player data for comparison
    let previousBatter1 = null;
    let previousBatter2 = null;
    let previousBowler1 = null;
    let previousBowler2 = null;

    function fetchLiveScore() {
        $.ajax({
            url: "api/cricket-live-data",
            type: "GET",
            dataType: "json",
            success: function (response) {
                if (response.data) {
                    const data = response.data;

                    // Update Team Names
                    $(".team-box h2").first().text(data.team1 || "Team 1");
                    $(".team-box-2 h2").text(data.team2 || "Team 2");

                    // Update Scores
                    $(".overs h3").text(data.score || "0");
                    $(".run-rate:first").text("Currnt Run Rate: " + (data.crr || "0.00"));
                    $(".run-rate:last").text("Require Run Rate: " + (data.rrr || "0.00"));

                    // Update Ball Tracker
                    let ballTrackerHtml = "";
                    const recentOvers = typeof data.recent_overs === 'string' ? JSON.parse(data.recent_overs || "[]") : data.recent_overs || [];
                    recentOvers.forEach(ball => {
                        let ballClass = ball === "|" ? "ball-space" : 
                            (ball === "W" ? "ball-wicket" : 
                            (ball === "4" ? "ball-four" : 
                            (ball === "6" ? "ball-six" : "ball-run")));
                        ballTrackerHtml += `<div class="ball ${ballClass}">${ball}</div>`;
                    });
                    $("#ball-tracker").html(ballTrackerHtml);

                    // Update Match Status
                    const matchStatus = data.match_status || "Match Status Not Available";
                    $(".match-status").text(matchStatus);

                    // Get current player data
                    const batter1 = typeof data.batters1 === "string" ? JSON.parse(data.batters1) : data.batters1;
                    const batter2 = typeof data.batters2 === "string" ? JSON.parse(data.batters2) : data.batters2;
                    const bowler1 = typeof data.bowlers1 === "string" ? JSON.parse(data.bowlers1) : data.bowlers1;
                    const bowler2 = typeof data.bowlers2 === "string" ? JSON.parse(data.bowlers2) : data.bowlers2;

                    // Check if players have changed
                    const battersChanged = previousBatter1 && previousBatter2 && batter1 && batter2 && 
                        (batter1.name !== previousBatter1.name || batter2.name !== previousBatter2.name);
                    
                    const bowlersChanged = previousBowler1 && bowler1 && 
                        (bowler1.name !== previousBowler1.name);

                    // Trigger animations if needed
                    if (battersChanged) {
                        flipBatters();
                    }
                    if (bowlersChanged) {
                        flipBowler();
                    }

                    // Always update cards (with or without animation)
                    updateBatterCards(batter1, batter2);
                    updateBowlerCards(bowler1);

                    // Store current players for next comparison
                    previousBatter1 = {...batter1};
                    previousBatter2 = {...batter2};
                    previousBowler1 = {...bowler1};
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching live score:", error);
            }
        });
    }

    function updateBatterCards(batter1, batter2) {
        // Update batter 1 card (left position)
        const batter1Card = $(".batter1-card");
        batter1Card.find("img").attr("src", batter1.image || 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjOeYcIMwn9x_WHID51PNZI6kiQuQjkL-x7_Kru9VXbFiNe_UG5v842bZ5cv8WV2yuWiDIdN9Io1X5nTss1qAvWuIbCnZWFzHY94L_LQY4UYTZHDRD-IdMF_cWp8QSzq3ZpqmkyXk_mPiqjDDsxmaAjId2wA2jIvUlufkk2anTBAmntMLU7_UnMxFVkL8c/s320-rw/WhatsApp%20Image%202025-02-28%20at%207.57.54%20PM.jpeg');
        batter1Card.find("h4").text(batter1.name || "Batsman 1");
        batter1Card.find("p").text(`${batter1.runs || 0} runs (${batter1.balls || 0} balls)`);
        
        // Show batting indicator only if batter exists
        if (batter1.name) {
            batter1Card.find(".batting-now").show();
        } else {
            batter1Card.find(".batting-now").hide();
        }

        // Update batter 2 card (right position)
        const batter2Card = $(".batter2-card");
        batter2Card.find("img").attr("src", batter2.image || 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjOeYcIMwn9x_WHID51PNZI6kiQuQjkL-x7_Kru9VXbFiNe_UG5v842bZ5cv8WV2yuWiDIdN9Io1X5nTss1qAvWuIbCnZWFzHY94L_LQY4UYTZHDRD-IdMF_cWp8QSzq3ZpqmkyXk_mPiqjDDsxmaAjId2wA2jIvUlufkk2anTBAmntMLU7_UnMxFVkL8c/s320-rw/WhatsApp%20Image%202025-02-28%20at%207.57.54%20PM.jpeg');
        batter2Card.find("h4").text(batter2.name || "Batsman 2");
        batter2Card.find("p").text(`${batter2.runs || 0} runs (${batter2.balls || 0} balls)`);
        
        // Ensure no batting indicator on batter2 card
        batter2Card.find(".batting-now").hide();
    }

    function updateBowlerCards(bowler1) {
        const bowler1Card = $(".bowler1-card");
        bowler1Card.find("img").attr("src", bowler1.image || 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEghKZ1A6gbbmpXIOiqkWoUfgqae-N0zwJsufaeesmis8IBhkDVcjwmyIL1yCMFI1IATPFr3l_pf_J05MlKyKbQm73CFuJxnfGg35K_1FNpY0_ntEOvUUiZmYTuEhYw1xm4FNS7KiP6l4T35cKTS2EFCmy2V1-EaGG5fzNZp3ylp-3W-3QqbDQHGju0jGcU/s320-rw/WhatsApp%20Image%202025-02-28%20at%208.05.16%20PM.jpeg');
        bowler1Card.find("h4").text(bowler1.name || "Bowler 1");
        bowler1Card.find("p").text(`${bowler1.overs || 0} overs, ${bowler1.wickets || 0} wickets`);
        
        // Show bowling indicator only if bowler exists
        if (bowler1.name) {
            bowler1Card.find(".bowling-now").show();
        } else {
            bowler1Card.find(".bowling-now").hide();
        }
    }

    function flipBatters() {
        const batterCards = $(".player-card");
        
        // Add flip class to trigger animation
        batterCards.addClass("flip");
        
        // Remove flip class after animation completes
        setTimeout(() => {
            batterCards.removeClass("flip");
        }, 500);
    }

    function flipBowler() {
        const bowlerCard = $(".bowler1-card");
        
        // Add flip class to trigger animation
        bowlerCard.addClass("flip");
        
        // Remove flip class after animation completes
        setTimeout(() => {
            bowlerCard.removeClass("flip");
        }, 500);
    }

    // Call function every 5 seconds
    setInterval(fetchLiveScore, 5000);

    // Initial load
    fetchLiveScore();
    </script>

    <style>
    /* Add these styles to your existing CSS */
    .player-card, .player-card-2 {
        transition: transform 0.5s ease;
        position: relative;
    }

    .player-card.flip, .player-card-2.flip {
        transform: rotateY(180deg);
    }
    
    /* Ensure indicators stay on correct cards */
    .batter1-card .batting-now {
        display: block !important;
    }
    
    .batter2-card .batting-now {
        display: none !important;
    }
    
    .bowler1-card .bowling-now {
        display: block !important;
    }
    </style>
</body>
</html>