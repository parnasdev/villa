<div>
    @if(session()->has('message'))
        {{ session('message')['title'] }}
    @endif
<div x-data="{
        calenders: @entangle('calenderData'),
        month: @entangle('currentMonth'),
        year: @entangle('currentYear'),
        dayIn: null,
        dayOut: null,
        isLoading: false,
        datesSelected: @entangle('datesSelected'),
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
              if (this.calenders.dates[i].data.length > 0 && !this.calenders.dates[i].data[0].isReserved) {
             } else {
            this.dayOut = this.calenders.dates[i];
            alert('بین روزهای انتخابی شما روز غیرقابل رزرو وجود دارد.')
            break;
           }
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
   if (dateItem) {
    this.datesSelected = [];
    if (!this.dayIn && !this.dayOut) {

    if (dateItem.data[0].isReserved) {
       alert('این تاریخ رزرو شده است');
    }else {
    this.dayIn = dateItem
    }

    }else if (this.dayIn && !this.dayOut) {
        this.dayOut = dateItem;
        this.checkReservedInDates();
        $wire.getDates(this.dayIn , this.dayOut).then(result => {
        this.datesSelected = JSON.parse(result);
        });
    }else {
        this.dayIn = dateItem;
        this.dayOut = null;
   }
   }else {
   alert('امکان رزرو در این تاریخ وجود ندارد.');
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
    <!--? section 1 -->

    <section class="vila">
        <div class="prs-responsive">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 m-auto-x parent-vila">
                        <div class="right-box">
                            <div class="gallery">
                                <div class="right-gallery">
                                    <img src="{{$files->first()?->url}}" alt="">
                                </div>
                                <div class="left-gallery">
                                    @foreach($files as $key => $file)
                                        @if($key <= 1)
                                            <img src="{{$file->url}}" alt="">
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="s-vila">
                                <div class="title-vila">
                                    <div class="label-vila">
                                        <h2>{{$residence->title}}(کد:{{$residence->id}})</h2>
                                    </div>
                                    <div class="city-vila">
                                        <label for="">
                                            {{isset($city->first()->title)}} - {{isset($province->first()->title)}}
                                        </label>
                                    </div>
                                </div>
                                <div class="description-vila">
                                    <span>توضیحات :</span>
                                    <p>{{$residence->description}}
                                    </p>
                                </div>
                            </div>
                            <div class="box-details">
                                <div class="item">
                                    <label for="">مساحت زمین:</label>
                                    <span>{{$residence->land_area}}</span>
                                </div>
                                <div class="item">
                                    <label for="">نوع ساختمان:</label>
                                    <span>{{collect(config('vila.types'))->firstWhere('id',$residence->specifications['type']??0)['title']??'ندارد'}}</span>
                                </div>
                                <div class="item">
                                    <label for="">چشم انداز :</label>
                                    <span>{{collect(config('vila.views'))->firstWhere('id',$residence->specifications['view']??0)['title']??'ندارد'}}</span>
                                </div>

                                <div class="item">
                                    <label for="">تعداد اتاق:</label>
                                    <span>{{$residence->room_count}}</span>
                                </div>
                                <div class="item">
                                    <label for="">مساحت بنا:</label>
                                    <span>{{$residence->building_area}}</span>
                                </div>
                                <div class="item">
                                    <label for="">ظرفیت:</label>
                                    <span>{{$residence->max}}</span>
                                </div>
                                <div class="item">
                                    <label for="">تعداد تشک:</label>
                                    <span>{{$residence->mattress}}</span>
                                </div>
                                <div class="item">
                                    <label for="">تخت ۱ نفره:</label>
                                    <span>{{$residence->singleBed}}</span>
                                </div>
                                <div class="item">
                                    <label for="">تخت ۲ نفره:</label>
                                    <span>{{$residence->twinBed}}</span>
                                </div>
                            </div>
                            <div class="map">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12953.497785600752!2d51.538474434353056!3d35.74160024927906!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f8e1d0522761f97%3A0x1698faeefccf4d06!2sEast%20Tehran%20Pars%2C%20District%204%2C%20Tehran%2C%20Tehran%20Province%2C%20Iran!5e0!3m2!1sen!2s!4v1649244509578!5m2!1sen!2s"
                                        style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                    @if($residence->rules)
                                <div class="Rules">
                                    <div class="title-Rules">
                                        <h2>قوانین</h2>
                                    </div>
                                </div>
                                <span class="list-rules">
                           {{$residence->rules['text']??''}}
                            </span>
                            @endif
                        </div>
                        <div class="left-box">
                            <div class="title-reserve-vila">
                                <h2>رزرو ویلا</h2>
                            </div>
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
                             'not-set-price':(x.data.length === 0 || !x.data[0].price) && !getIsDaysGone(x)
                             }"

                                                         @click="(getIsDaysGone(x) || x.data.length === 0) ? onItemClicked(null) :onItemClicked(x)">
                                                        <template x-if="x.isToday">
                                                            <label class="active-day" for="">امروز</label>
                                                        </template>

                                                        <template x-if="x.data.length > 0 && x.data[0].isReserved && !getIsDaysGone(x)">
                                                            <label class="reserved" for="">رزرو</label>
                                                        </template>
{{--                                                        <template x-if="x.data.length > 0 && !x.data[0].isReserved && !getIsDaysGone(x)">--}}
{{--                                                            <label class="not-reserved" for="">رزرو نشده</label>--}}
{{--                                                        </template>--}}

                                                        <h1 class="number" :class="{ 'text-danger' : x.isHolyDay  }"
                                                            x-text="x.dateFa.split('-')[2]"></h1>
                                                        {{--                            <small style="font-size: 12px">رزرو شده</small>--}}
                                                        <div class="price-day">
                                                            <template x-if="x.data.length > 0 && x.data[0].price && !getIsDaysGone(x)">

                                                                <span x-text="(x.data[0].price / 1000) + ' ' + 'ت'"></span>
                                                            </template>
                                                            <template
                                                                x-if="(x.data.length === 0 || !x.data[0].price) && (x.status !== 'Disabled' && x.status !== 'Hidden')">
                                                                <span>قیمت ندارد</span>
                                                            </template>
                                                        </div>
                                                        {{--                            <template x-if="x.data.length > 0 && x.data[0].isReserved">--}}

                                                        {{--                                <span x-text="'رزرو شده'"></span>--}}
                                                        {{--                            </template>--}}
                                                        {{--                            <template x-if="x.data.length === 0 || !x.data[0].isReserved">--}}

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
                            <div class="date-vila">
                                <div class="date-start">
                                    <span>تاریخ شروع</span>
                                    <span>{{count($datesSelected) > 0?$datesSelected[0]['dateFa'] : '---'}}</span>
                                </div>
                                <div class="date-exit">
                                    <span>تاریخ خروج</span>
                                    <span>{{count($datesSelected) > 0?$datesSelected[count($datesSelected)-1]['dateFa'] : '---'}}</span>
                                </div>
                            </div>
                            <div class="day-selected">
                                <h2>روزهای انتخابی</h2>
                            </div>
                            @foreach(($datesSelected) as $dateItem)
                                <div class="price-day">
                                    <span>{{$dateItem['dateFa']}}</span>
                                    @if($loop->index === count($datesSelected)-1)
                                        <span>روز خروج</span>
                                    @else
                                        <strong>{{number_format(count($dateItem['data'])>0?$dateItem['data'][0]['price']:0 ) . 'تومان'}}</strong>
{{--                                        <strong>تومان</strong>--}}
                                    @endif
                                </div>
                            @endforeach
                            <div class="total-price">
                                <span>جمع کل</span>
                                <strong>{{$this->getTotalPrice()}}</strong>
                            </div>
                            <form>
                                <div class="form-group">
                                    <label for="name">نام سرپرست</label>
                                    <input type="text" wire:model.defer="name" class="form-control" id="name">
                                </div>
                                <div class="form-group">
                                    <label for="family">نام خانوادگی سرپرست</label>
                                    <input type="text" wire:model.defer="family" class="form-control" id="family">
                                </div>
                                <div class="form-group">
                                    <label for="phone">شماره همراه</label>
                                    <input type="text" wire:model.defer="phone" class="form-control" id="phone">
                                </div>
                                <div class="form-group">
                                    <label for="phone">تعداد افراد</label>
                                    <select name="" wire:model.defer="count">
                                        <option value="1">۱ نفر</option>
                                        <option value="2">۲ نفر</option>
                                        <option value="3">۳ نفر</option>
                                        <option value="4">۴ نفر</option>
                                        <option value="5">۵ نفر</option>
                                        <option value="6">۶ نفر</option>
                                        <option value="7">۷ نفر</option>
                                        <option value="8">۸ نفر</option>
                                        <option value="9">۹ نفر</option>
                                        <option value="10">۱۰ نفر</option>
                                    </select>
                                </div>
                            </form>
                            <button class="btn-reserve" wire:click="submit">
                                درخواست رزرو
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



</div>
</div>
