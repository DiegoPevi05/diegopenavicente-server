@push('styles')
    <style>
        @keyframes fadeInAnimation {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-notification {
            animation: fadeInAnimation 800ms ease-in-out;
        }

        #calendar {
            margin-top: 20px;
        }
        #calendar .day {
            border: 1px solid #ddd;
            padding: 10px;
            min-height: 60px;
        }

        .day:hover{
            animation: colorChange 1s linear;
            cursor: pointer;
        }

        @keyframes colorChange {
            0% {
                background-color: #f2f2f2;
            }
            50% {
                background-color: #e6e6e6;
            }
            100% {
                background-color: #f2f2f2;
            }
        }
    </style>


@endpush
@push('scripts')
    <script>
        const billingDates = {!! json_encode($billing_dates) !!};
        console.log(billingDates)
        // Get reference to calendar div
        const calendarDiv = document.getElementById('calendar');
        
        // Function to generate calendar
        function generateCalendar(year, month) {
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const firstDayOfMonth = new Date(year, month, 1).getDay();
            
            let html = '';
            let day = 1;
            
            // Generate calendar rows
            for (let i = 0; i < 6; i++) {
                html += '<div class="row">';
                // Generate calendar columns
                for (let j = 0; j < 7; j++) {
                    if ((i === 0 && j < firstDayOfMonth) || day > daysInMonth) {
                        html += '<div class="col day h-6"></div>';
                    }else {
                        if(day === new Date().getDate() && year === new Date().getFullYear() && month === new Date().getMonth()){
                            html += `<div class="col day h-6" data-day="${day}" style="background-color: #f2f2f2">${day}</div>`;
                        } else {
                            html += `<div class="col day h-6" data-day="${day}">${day}</div>`;  
                        }
                        day++;
                    }
                }
                html += '</div>';
            }
            
            calendarDiv.innerHTML = html;
            
            // Add billing info
            billingDates.forEach(billingDate => {
                const dayDiv = calendarDiv.querySelector(`[data-day="${new Date(billingDate.date).getDate()}"]`);
                if (dayDiv) {
                    const billingInfoSpan = document.createElement('span');
                    if(billingDate.type === 'CiclePayment'){
                        billingInfoSpan.classList.add('badge', 'bg-indigo', 'my-1', 'rounded-pill');
                    }else{
                        billingInfoSpan.classList.add('badge', 'bg-green', 'my-1', 'rounded-pill');
                    }
                    
                    billingInfoSpan.textContent = `${billingDate.user}`;
                    billingInfoSpan.setAttribute('data-toggle', 'tooltip'); // Add tooltip attribute
                    billingInfoSpan.setAttribute('title', `${billingDate.gross_amount} PEN`); // Set tooltip text
                    dayDiv.appendChild(billingInfoSpan);
                }
            });
        }

        // Get current date and month from the params
        const urlParams = new URLSearchParams(window.location.search);
        let year = urlParams.get('year');
        const month = urlParams.get('month') - 1;
        let currentDate = new Date();
        if( year && !isNaN(year) && !isNaN(month) && month < 12 && month >= 0) {
            year = parseInt(year);
            currentDate = new Date(year, month);
        }
        let currentYear = currentDate.getFullYear();
        let currentMonth = currentDate.getMonth();
        console.log(currentYear, currentMonth);
        const currentMonthSpan = document.getElementById('currentMonth');
        const prevMonthButton = document.getElementById('prevMonth');
        const nextMonthButton = document.getElementById('nextMonth');

        // Initial calendar generation
        generateCalendar(currentYear, currentMonth);
        currentMonthSpan.textContent = `${currentMonth + 1}/${currentYear}`;

        // Event listener for previous month button
        prevMonthButton.addEventListener('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            updateCalendar(currentYear, currentMonth);
        });

        // Event listener for next month button
        nextMonthButton.addEventListener('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            updateCalendar(currentYear, currentMonth);
        });

        function updateCalendar(year, month) {

            // Redirect to home page with month and year as parameters
            window.location.href = `{{ route('home.index') }}?year=${year}&month=${month + 1}`;
        }

        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
@endpush