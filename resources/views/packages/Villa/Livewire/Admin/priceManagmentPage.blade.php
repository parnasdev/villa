<div>
    {{--@dd($calenderData)--}}
    @if(session()->has('message'))
        {{ session('message')['title'] }}
    @endif
    <div class="calender" x-data="{
        calenders: @entangle('calenderData'),
        month: @entangle('currentMonth'),
        year: @entangle('currentYear'),
        dayIn: null,
        dayOut: null,
        isLoading: false,
        datesSelected: @entangle('datesSelected'),
        selectType:@entangle('selectType'),
        init() {
            this.getCa()
        },
        checkReservedInDates()
    {
    if (this.dayOut.dateEn < this.dayIn.dateEn) {
    alert('تاریخ انتخابی نامعتبر است.');
    this.dayIn = null;
    this.dayOut = null;
    }else {
        for (let i=this.findListItemIndex(this.dayIn);i<= this.findListItemIndex(this.dayOut);i++) {

            this.dayOut = this.calenders.dates[i];

           }
        }

    },
        getCa() {
        this.isLoading = true;
            $wire.getCalender($wire.calendarRequest).then(result  => {
                this.calenders = JSON.parse(result) ;
                console.log(JSON.parse(result))
                this.month = this.calenders.month;
                this.year = this.calenders.year;
                this.isLoading = false;
            })
        },
        itemClicked(data) {
            $wire.itemClicked(JSON.stringify(data))
        },
        nextMonth() {
        $wire.nextMonth().then(result => this.getCa())},
        previousMonth() {
        $wire.previousMonth().then(result => this.getCa())
    },
    onItemClicked(dateItem = null) {
    if(this.selectType === '1') {
    this.datesSelected = [];
    if (!this.dayIn && !this.dayOut) {

    if (dateItem.data.length > 0 && dateItem.data[dateItem.data.length - 1].isReserved) {
       alert('این تاریخ رزرو شده است');
    }else {
    this.dayIn = dateItem
    }

    }else if (this.dayIn && !this.dayOut) {
        this.dayOut = dateItem;
{{--        this.checkReservedInDates();--}}
        $wire.getDates(this.dayIn , this.dayOut).then(result => {
        this.datesSelected = JSON.parse(result);
        });
    }else {
        this.dayIn = dateItem;
        this.dayOut = null;
   }
    }else {
$wire.addDateToList(dateItem).then(result => {
        this.datesSelected = JSON.parse(result);
}
)
    }

   },getDates(e) {
        this.calenders = JSON.parse(e.detail);
   },
   isItemExistToSelected(item) {
           return this.datesSelected.filter(x => x.dateEn === item.dateEn)

   },findListItemIndex(item) {
      return this.calenders.dates.findIndex(x => x.dateEn === item.dateEn);
   },
   getIsDaysGone(dateItem) {
    return dateItem.status === 'Disabled' || dateItem.status === 'Hidden'
        }
   }
" @send-data.window="getDates">
        <select class="select-pricemangemt-top" name="" id="" wire:model="selectType">
            <option value="1">به صورت بازه</option>
            <option value="2">به صورت تکی</option>
        </select>

        <div class="calenders">
            <section>
                <div class="calender">
                    <div class="loading" x-show="isLoading">
                        <div>
                            <div class="spinner-loading"></div>
                            <h2 class="h2">صبرکنید ...</h2>
                        </div>
                    </div>
                    <div class="header-calender">
                        <div class="month-prev" @click="previousMonth()">
                            <svg id="Outline" viewBox="0 0 24 24" width="22" height="22">
                                <path
                                    d="M7,24a1,1,0,0,1-.71-.29,1,1,0,0,1,0-1.42l8.17-8.17a3,3,0,0,0,0-4.24L6.29,1.71A1,1,0,0,1,7.71.29l8.17,8.17a5,5,0,0,1,0,7.08L7.71,23.71A1,1,0,0,1,7,24Z"/>
                            </svg>
                            <span class="text-month-prev" >ماه قبل</span>
                        </div>
                        <div class="date-header">
                            <strong>{{ $months->firstWhere('id' , $currentMonth ?? 1)['text'] }}</strong>
                            <strong class="years"> {{$currentYear}}</strong>
                        </div>
                        <div class="month-next" @click="nextMonth()">
                            <a class="text-month-next" >ماه بعد</a>
                            <svg id="Outline" viewBox="0 0 24 24" width="22" height="22">
                                <path
                                    d="M7,24a1,1,0,0,1-.71-.29,1,1,0,0,1,0-1.42l8.17-8.17a3,3,0,0,0,0-4.24L6.29,1.71A1,1,0,0,1,7.71.29l8.17,8.17a5,5,0,0,1,0,7.08L7.71,23.71A1,1,0,0,1,7,24Z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="body-calender">
                        <div class="week-header">
                            <label for="">شنبه</label>
                            <label for="">یکشنبه</label>
                            <label for="">دوشنبه</label>
                            <label for="">سه شنبه</label>
                            <label for="">چهار شنبه</label>
                            <label for="">پنج شنبه</label>
                            <label for="">جمعه</label>
                        </div>
                        <div class="week-body">

                            <template x-for="(x , index) in calenders?.dates">
                                <div class="item-number-day"
                                     :class="{
                             'date-selected' : isItemExistToSelected(x).length > 0,
                             'date-dayIn' : dayIn === x,
                             'date-dayOut':dayOut === x,
                             'date-disabled': getIsDaysGone(x),
                             'not-set-price':(x.data.length === 0 || !x.data[x.data.length - 1].price) && !getIsDaysGone(x)
                             }"

                                     @click="(getIsDaysGone(x)) ? onItemClicked(null) :onItemClicked(x)">
                                    <template x-if="x.isToday">
                                        <label class="active-day" for="">امروز</label>
                                    </template>

                                    <template x-if="x.data.length > 0 && x.data[x.data.length - 1].isReserved && !getIsDaysGone(x)">
                                        <label class="reserved" for="">رزرو</label>
                                    </template>
                                    {{--                                                        <template x-if="x.data.length > 0 && !x.data[x.data.length - 1].isReserved && !getIsDaysGone(x)">--}}
                                    {{--                                                            <label class="not-reserved" for="">رزرو نشده</label>--}}
                                    {{--                                                        </template>--}}

                                    <h1 class="number" :class="{ 'text-danger' : x.isHolyDay  }"
                                        x-text="x.dateFa.split('-')[2]"></h1>
{{--                                                                <small style="font-size: 12px">رزرو شده</small>--}}
                                    <div class="price-day">
                                        <template x-if="x.data.length > 0 && x.data[x.data.length - 1].price && !getIsDaysGone(x)">

                                            <span x-text="(x.data[x.data.length - 1].price / 1000) + ' ' + 'ت'"></span>
                                        </template>
                                        <template
                                            x-if="(x.data.length === 0 || !x.data[x.data.length - 1].price) && (x.status !== 'Disabled' && x.status !== 'Hidden')">
                                            <span>قیمت ندارد</span>
                                        </template>
                                    </div>
{{--                                                                <template x-if="x.data.length > 0 && x.data[x.data.length - 1].isReserved">--}}

{{--                                                                    <span x-text="'رزرو شده'"></span>--}}
{{--                                                                </template>--}}
                                    {{--                            <template x-if="x.data.length === 0 || !x.data[x.data.length - 1].isReserved">--}}

                                    {{--                                <small x-text="'رزرو نشده'"></small>--}}
                                    {{--                            </template>--}}
                                    <template x-if="x.status === 'Disabled' || x.status === 'Hidden'">
                                        <div class="disable-day">
                                            <div class="linear-disable"></div>

                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>
    <div class="day-selected">
        <span>روزهای انتخابی</span>
    </div>
    @foreach(($datesSelected) as $dateItem)
        <div class="price-day">
            <span>{{$dateItem['dateFa']}}</span>

                {{--                                        <strong>تومان</strong>--}}

        </div>
    @endforeach
    <form wire:submit.prevent="submit">

        <input class="inp-admin-style" type="text" wire:model="price" placeholder="قیمت خود را وارد کنید">
        <button class="btn-submit-price" type="submit">ثبت قیمت</button>
    </form>


</div>
