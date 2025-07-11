<div>
    <div x-data="{
        datePickerOpen: true,
        datePickerValue: '',
        datePickerFormat: 'M d, Y',
        datePickerMonth: '',
        datePickerYear: '',
        datePickerDay: '',
        datePickerDaysInMonth: [],
        datePickerBlankDaysInMonth: [],
        datePickerMonthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datePickerDays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        datePickerDayClicked(day) {
            let selectedDate = new Date(this.datePickerYear, this.datePickerMonth, day);
            this.datePickerDay = day;
            this.datePickerValue = this.datePickerFormatDate(selectedDate);
            this.datePickerIsSelectedDate(day);
            this.datePickerOpen = false;
        },
        datePickerPreviousMonth() {
            if (this.datePickerMonth == 0) {
                this.datePickerYear--;
                this.datePickerMonth = 12;
            }
            this.datePickerMonth--;
            this.datePickerCalculateDays();
        },
        datePickerNextMonth() {
            if (this.datePickerMonth == 11) {
                this.datePickerMonth = 0;
                this.datePickerYear++;
            } else {
                this.datePickerMonth++;
            }
            this.datePickerCalculateDays();
        },
        datePickerIsSelectedDate(day) {
            const d = new Date(this.datePickerYear, this.datePickerMonth, day);
            return this.datePickerValue === this.datePickerFormatDate(d) ? true : false;
        },
        datePickerIsToday(day) {
            const today = new Date();
            const d = new Date(this.datePickerYear, this.datePickerMonth, day);
            return today.toDateString() === d.toDateString() ? true : false;
        },
        datePickerCalculateDays() {
            let daysInMonth = new Date(this.datePickerYear, this.datePickerMonth + 1, 0).getDate();
            // find where to start calendar day of week
            let dayOfWeek = new Date(this.datePickerYear, this.datePickerMonth).getDay();
            let blankdaysArray = [];
            for (var i = 1; i <= dayOfWeek; i++) {
                blankdaysArray.push(i);
            }
            let daysArray = [];
            for (var i = 1; i <= daysInMonth; i++) {
                daysArray.push(i);
            }
            this.datePickerBlankDaysInMonth = blankdaysArray;
            this.datePickerDaysInMonth = daysArray;
        },
        datePickerFormatDate(date) {
            let formattedDay = this.datePickerDays[date.getDay()];
            let formattedDate = ('0' + date.getDate()).slice(-2); // appends 0 (zero) in single digit date
            let formattedMonth = this.datePickerMonthNames[date.getMonth()];
            let formattedMonthShortName = this.datePickerMonthNames[date.getMonth()].substring(0, 3);
            let formattedMonthInNumber = ('0' + (parseInt(date.getMonth()) + 1)).slice(-2);
            let formattedYear = date.getFullYear();
    
            if (this.datePickerFormat === 'M d, Y') {
                return `${formattedMonthShortName} ${formattedDate}, ${formattedYear}`;
            }
            if (this.datePickerFormat === 'MM-DD-YYYY') {
                return `${formattedMonthInNumber}-${formattedDate}-${formattedYear}`;
            }
            if (this.datePickerFormat === 'DD-MM-YYYY') {
                return `${formattedDate}-${formattedMonthInNumber}-${formattedYear}`;
            }
            if (this.datePickerFormat === 'YYYY-MM-DD') {
                return `${formattedYear}-${formattedMonthInNumber}-${formattedDate}`;
            }
            if (this.datePickerFormat === 'D d M, Y') {
                return `${formattedDay} ${formattedDate} ${formattedMonthShortName} ${formattedYear}`;
            }
    
            return `${formattedMonth} ${formattedDate}, ${formattedYear}`;
        },
    }" x-init="currentDate = new Date();
    if (datePickerValue) {
        currentDate = new Date(Date.parse(datePickerValue));
    }
    datePickerMonth = currentDate.getMonth();
    datePickerYear = currentDate.getFullYear();
    datePickerDay = currentDate.getDay();
    datePickerValue = datePickerFormatDate(currentDate);
    datePickerCalculateDays();" x-cloak>
        <div class="container py-2">
            <div class="w-full mb-5">
                <div class="p-4 antialiased bg-white border rounded-lg shadow border-neutral-200/70">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <span x-text="datePickerMonthNames[datePickerMonth]"
                                class="text-lg font-bold text-gray-800"></span>
                            <span x-text="datePickerYear" class="ml-1 text-lg font-normal text-gray-600"></span>
                        </div>
                        <div>
                            <button @click="datePickerPreviousMonth()" type="button"
                                class="inline-flex p-1 transition duration-100 ease-in-out rounded-full cursor-pointer focus:outline-none focus:shadow-outline hover:bg-gray-100">
                                <svg class="inline-flex w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d=" M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button @click="datePickerNextMonth()" type="button"
                                class="inline-flex p-1 transition duration-100 ease-in-out rounded-full cursor-pointer focus:outline-none focus:shadow-outline hover:bg-gray-100">
                                <svg class="inline-flex w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-7 mb-3">
                        <template x-for="(day, index) in datePickerDays" :key="index">
                            <div class="px-0.5">
                                <div x-text="day" class="text-xs font-medium text-center text-gray-800"></div>
                            </div>
                        </template>
                    </div>
                    <div class="grid grid-cols-7 w-full">
                        <template x-for="blankDay in datePickerBlankDaysInMonth">
                            <div class="p-1 text-sm text-center border border-transparent"></div>
                        </template>
                        <template x-for="(day, dayIndex) in datePickerDaysInMonth" :key="dayIndex">
                            <div class="px-0.5 mb-1 aspect-square w-full max-w-full">
                                <div x-text="day" @click="datePickerDayClicked(day)"
                                    :class="{
                                        'bg-ecstasy': datePickerIsToday(day) == true,
                                        'text-gray-600 hover:bg-neutral-200': datePickerIsToday(day) == false &&
                                            datePickerIsSelectedDate(day) == false,
                                        'bg-gray-500 text-white hover:bg-opacity-75': datePickerIsSelectedDate(
                                            day) == true
                                    }"
                                    class="flex items-center justify-center text-sm leading-none text-center rounded-lg cursor-pointer h-9 w-9">
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
