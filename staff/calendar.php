<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<?php


if (!isset($_SESSION["username"])) {
    header("Location: ../index.php");
    exit();
}
?>



<?php 
function build_calendar($month, $year) {
    $daysofWeekNames = array('Sunday', 'Monday', 'Tuesday','Wednesday','Thursday','Friday','Saturday');

    $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

    $numberDays = date('t',$firstDayOfMonth);

    $dateComponents = getdate($firstDayOfMonth);

    $monthName = $dateComponents['month'];

    $firstDayOfWeek = $dateComponents['wday'];

    $dateToday = date('Y-m-d');

    include("../querys/db_config.php");
    $holidayDates = array();
    $sql = "SELECT date FROM tbl_holidays";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $holidayDates[] = $row['date'];
    }

    $scheduleDates = array();
    $slots = array();
    $sql = "SELECT date_schedule, slots FROM tbl_schedule";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $scheduleDates[] = $row['date_schedule'];
        $slots[] = $row['slots'];
    }

    $calendar = "<table class='table table-bordered'>";
    $calendar .= "<center><h2>$monthName $year</h2></center>";
    $calendar .= "<tr>";

    foreach ($daysofWeekNames as $index => $day) {
        if ($index >= 1 && $index <= 5) {
            $calendar .= "<th class='header weekday'>$day</th>";
        } else {
            $calendar .= "<th class='header'>$day</th>";
        }
    }
    
    $calendar .= "</tr><tr>";

    if ($firstDayOfWeek > 0) {
        for ($k = 0; $k < $firstDayOfWeek; $k++) {
            $calendar .= "<td></td>";
        }
    }

    $currentday = 1;
    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentday <= $numberDays) {
        if ($firstDayOfWeek == 7) {
            $firstDayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }

        $currentDayRel = str_pad($currentday, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";

        $isToday = ($date == $dateToday);

        if ($isToday) {
            $calendar .= "<td class='today'>";
        } else {
            $calendar .= "<td>";
        }

        $calendar .= "<h4>$currentday</h4>";

        if (in_array($date, $holidayDates)) {
            $calendar .= "<div class='holiday-box'><span class='iconssss'><i class='bx bxs-calendar'></i></span></div>";
        } elseif (in_array($date, $scheduleDates)) {
            $key = array_search($date, $scheduleDates);
            $slot = $slots[$key];
            if (strtotime($date) < strtotime(date("Y-m-d"))) {
                $calendar .= "<div class='weekday-box'><span class='iconssss'><i class='bx bx-x-circle'></i></span><div class='top-right-badge'>0</div></div>";
            } elseif ($slot == 0) {
                $calendar .= "<div class='fullbook-box'><span class='iconssss'><i class='bx bx-lock'></i></span></div>";
            } else {
                $calendar .= "<div class='schedule-box' onclick='openModal($currentday, $month, $year)' style='cursor: pointer;'><span class='iconssss'><i class='bx bx-check-circle'></i></span><div class='top-right-badge'>$slot</div></div>";
            }
        }
         elseif ($firstDayOfWeek >= 1 && $firstDayOfWeek <= 5) {
            $calendar .= "<div class='weekday-box'><span class='iconssss'><i class='bx bx-x-circle'></i></span><div class='top-right-badge'>0</div></div>";
        }

        $calendar .= "</td>";

        $currentday++;
        $firstDayOfWeek++;
    }

    if ($firstDayOfWeek != 7) {
        $remainingDays = 7 - $firstDayOfWeek;
        for ($i = 0; $i < $remainingDays; $i++) {
            $calendar .= "<td></td>";
        }
    }

    $calendar .= "</tr>";
    $calendar .= "</table>";

    return $calendar;
}

$dateComponents = getdate();
$month = $dateComponents['mon'];
$year = $dateComponents['year'];

if (isset($_GET['month']) && isset($_GET['year'])) {
    $month = $_GET['month'];
    $year = $_GET['year'];
}

echo "<a href='?month=" . (($month == 1) ? 12 : ($month - 1)) . "&year=" . (($month == 1) ? ($year - 1) : $year) . "' style='float: left;'>Previous</a>";
echo "<a href='?month=" . (($month == 12) ? 1 : ($month + 1)) . "&year=" . (($month == 12) ? ($year + 1) : $year) . "' style='float: right;'>Next</a>";

echo build_calendar($month, $year);
?>

<script>
    function openModal(day, month, year) {
        // Format day and month as two digits
        var formattedDay = String(day).padStart(2, '0');
        var formattedMonth = String(month).padStart(2, '0');
        
        var modalDate = year + '-' + formattedMonth + '-' + formattedDay; 
        document.getElementById('modalDate').textContent = modalDate; 
        
      
        fetch('../querys/get_date_id.php?date=' + modalDate)
            .then(response => response.text())
            .then(data => {
                document.getElementById('id_date').value = data; 
            })
            .catch(error => {
                console.error('Error fetching ID:', error); 
            });

        $('#bookSchedule').modal('show'); 
    }
</script>



<script>
  
    flatpickr("#time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i K",
        time_24hr: false,
        minTime: "08:00",
        maxTime: "16:00",
        disable: [
            function(date) {
                // Disable times after 4:00 PM
                return (date.getHours() >= 16);
            },
            function(date) {
                // Disable times before 8:00 AM
                return (date.getHours() < 8);
            }
        ]
    });
 
</script>






<style>
table {
    table-layout: fixed;
    overflow-x: auto;
}

td {
    width: 33%;
    height: 130px;
    position: relative; 
    
}

.header.weekday {
    width: 180px;
}


.holiday-box {
    margin-top: 5px;
    width: 100%; 
    height: 70px; 
    background-color: purple;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    border-radius: 10px;
}

.weekday-box {
    margin-top: 5px; 
    width: 100%; 
    height: 70px; 
    background-color: blue;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    border-radius: 10px;
}

.schedule-box {
    margin-top: 5px; 
    width: 100%; 
    height: 70px; 
    background-color: green; /* Change background color to green */
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    border-radius: 10px;
}

.iconssss {
    color: white; 
    font-size: 50px;
}

.top-right-badge {
    position: absolute;
    top: -10px;
    right: -5px;
    background-color: yellow;
    padding: 5px;
    border-radius: 5px;
    color: black;
    font-size: 10px;
}

.weekday-box .top-right-badge {
    background-color: red; /* Change the background color to dark red */
}

.schedule-box .top-right-badge {
    background-color: red; /* Change the background color to dark red */
}

.today {
    background-color: yellow; /* Highlight today's date in yellow */
}

.fullbook-box {
    margin-top: 5px; 
    width: 100%; 
    height: 70px; 
    background-color: red; /* Change background color to red */
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    border-radius: 10px;
}

</style>