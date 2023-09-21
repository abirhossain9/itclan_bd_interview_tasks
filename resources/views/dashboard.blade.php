<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>ItClanBd</title>
</head>

<body style="padding: 2%; border: 2px solid black; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); margin: 4%;">
    @include('layouts.nav')
    <div class="text-center">
        Running Tournaments
    </div>
    <div id="tournaments-container">
        <table class="table table-bordered text-center">
            <thead>
            <tr>
                <th>Tournament ID</th>
                <th>Phase</th>
                <th>Countdown</th>
            </tr>
            </thead>
            <tbody id="tournament-table-body">

            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script>

        function calculateTimeLeft(start_time, end_time) {
            const startTime = new Date(start_time);
            const endTime = new Date(end_time);
            const now = new Date();
            if (now >= endTime) {
                return 'Ended';
            } else if (now < startTime) {
                const diff = Math.floor((startTime - now) / 1000);
                const minutes = Math.floor(diff / 60);
                const seconds = diff % 60;
                return `${minutes} min ${seconds} sec`;
            } else {
                const diff = Math.floor((endTime - now) / 1000);
                const minutes = Math.floor(diff / 60);
                const seconds = diff % 60;
                return `${minutes} min ${seconds} sec`;
            }
        }

        function fetchCurrentTournaments() {
            fetch('/current-tournaments')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('tournament-table-body');
                    tableBody.innerHTML = '';
                    data.tournaments.forEach(tournament => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                    <td>${tournament.id}</td>
                    <td>${tournament.phase}</td>
                    <td>${calculateTimeLeft(tournament.start_time, tournament.end_time)}</td>
                `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error fetching current tournaments:', error);
                });
        }

        window.addEventListener('load', fetchCurrentTournaments);

        setInterval(fetchCurrentTournaments, 2000);


    </script>
</body>

</html>
